<?php
/**
 * WP-CLI uploads audit command.
 */
defined( 'ABSPATH' ) || exit;

if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) || ! class_exists( 'WP_CLI' ) ) {
    return;
}

function dv_uploads_audit_normalize_relative_path( $path ) {
    $path = str_replace( '\\', '/', (string) $path );
    $path = preg_replace( '#/+#', '/', $path );
    $path = ltrim( $path, '/' );
    $path = preg_replace( '/[?#].*$/', '', $path );

    return trim( (string) $path );
}

function dv_uploads_audit_is_candidate_file( $relative_path, $extensions ) {
    $extension = strtolower( pathinfo( (string) $relative_path, PATHINFO_EXTENSION ) );

    return in_array( $extension, $extensions, true );
}

function dv_uploads_audit_file_row_data( $absolute_path ) {
    return array(
        'size_bytes' => is_file( $absolute_path ) ? (int) filesize( $absolute_path ) : 0,
        'modified'   => is_file( $absolute_path ) ? gmdate( 'c', (int) filemtime( $absolute_path ) ) : '',
    );
}

function dv_uploads_audit_scan_files( $base_dir, $extensions ) {
    $files = array();

    if ( ! is_dir( $base_dir ) ) {
        return $files;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator( $base_dir, FilesystemIterator::SKIP_DOTS )
    );

    foreach ( $iterator as $file ) {
        if ( ! $file instanceof SplFileInfo || ! $file->isFile() ) {
            continue;
        }

        $absolute = $file->getPathname();
        $relative = dv_uploads_audit_normalize_relative_path( substr( $absolute, strlen( $base_dir ) ) );

        if ( ! dv_uploads_audit_is_candidate_file( $relative, $extensions ) ) {
            continue;
        }

        $files[ $relative ] = array_merge(
            array( 'path' => $relative ),
            dv_uploads_audit_file_row_data( $absolute )
        );
    }

    ksort( $files );

    return $files;
}

function dv_uploads_audit_attachment_size_paths( $attached_file, $metadata ) {
    $paths = array();
    $attached_file = dv_uploads_audit_normalize_relative_path( $attached_file );

    if ( '' === $attached_file ) {
        return $paths;
    }

    $paths[] = $attached_file;
    $base_dir = trim( dirname( $attached_file ), '.\\/' );

    if ( is_string( $metadata ) ) {
        $metadata = maybe_unserialize( $metadata );
    }

    if ( is_array( $metadata ) && ! empty( $metadata['sizes'] ) && is_array( $metadata['sizes'] ) ) {
        foreach ( $metadata['sizes'] as $size ) {
            if ( empty( $size['file'] ) ) {
                continue;
            }

            $paths[] = dv_uploads_audit_normalize_relative_path(
                ( '' !== $base_dir ? $base_dir . '/' : '' ) . $size['file']
            );
        }
    }

    return array_values( array_unique( array_filter( $paths ) ) );
}

function dv_uploads_audit_get_attachments() {
    global $wpdb;

    $rows = $wpdb->get_results(
        "SELECT p.ID, p.post_title, filemeta.meta_value AS attached_file, datameta.meta_value AS attachment_metadata
        FROM {$wpdb->posts} p
        LEFT JOIN {$wpdb->postmeta} filemeta
            ON filemeta.post_id = p.ID AND filemeta.meta_key = '_wp_attached_file'
        LEFT JOIN {$wpdb->postmeta} datameta
            ON datameta.post_id = p.ID AND datameta.meta_key = '_wp_attachment_metadata'
        WHERE p.post_type = 'attachment'
            AND p.post_mime_type LIKE 'image/%'"
    );

    return is_array( $rows ) ? $rows : array();
}

function dv_uploads_audit_add_used_file( &$used_files, $relative_path, $reason ) {
    $relative_path = dv_uploads_audit_normalize_relative_path( $relative_path );
    $reason = trim( (string) $reason );

    if ( '' === $relative_path ) {
        return;
    }

    if ( ! isset( $used_files[ $relative_path ] ) ) {
        $used_files[ $relative_path ] = array();
    }

    if ( '' !== $reason ) {
        $used_files[ $relative_path ][ $reason ] = true;
    }
}

function dv_uploads_audit_add_attachment_usage( &$used_files, $attachment_files, $attachment_id, $reason ) {
    $attachment_id = absint( $attachment_id );

    if ( ! $attachment_id || empty( $attachment_files[ $attachment_id ] ) ) {
        return;
    }

    foreach ( $attachment_files[ $attachment_id ] as $relative_path ) {
        dv_uploads_audit_add_used_file(
            $used_files,
            $relative_path,
            'attachment #' . $attachment_id . ': ' . $reason
        );
    }
}

function dv_uploads_audit_relative_from_upload_url( $url, $uploads ) {
    $url = html_entity_decode( trim( (string) $url ), ENT_QUOTES, 'UTF-8' );

    if ( '' === $url ) {
        return '';
    }

    $url = strtok( $url, '?#' );
    $base_url = rtrim( (string) ( $uploads['baseurl'] ?? '' ), '/' ) . '/';

    if ( 0 === strpos( $url, $base_url ) ) {
        return dv_uploads_audit_normalize_relative_path( substr( $url, strlen( $base_url ) ) );
    }

    $path = wp_parse_url( $url, PHP_URL_PATH );
    if ( ! is_string( $path ) || '' === $path ) {
        return '';
    }

    $needle = '/wp-content/uploads/';
    $pos = strpos( $path, $needle );
    if ( false === $pos ) {
        return '';
    }

    return dv_uploads_audit_normalize_relative_path( substr( $path, $pos + strlen( $needle ) ) );
}

function dv_uploads_audit_collect_urls_from_text( $text, $uploads ) {
    $text = (string) maybe_serialize( $text );
    $text = str_replace( '\/', '/', $text );
    $paths = array();

    if ( '' === $text ) {
        return $paths;
    }

    $patterns = array(
        '#https?://[^"\'\s<>)]+/wp-content/uploads/[^"\'\s<>)]+#i',
        '#/wp-content/uploads/[^"\'\s<>)]+#i',
    );

    foreach ( $patterns as $pattern ) {
        if ( ! preg_match_all( $pattern, $text, $matches ) ) {
            continue;
        }

        foreach ( $matches[0] as $url ) {
            $relative = dv_uploads_audit_relative_from_upload_url( $url, $uploads );
            if ( '' !== $relative ) {
                $paths[] = $relative;
            }
        }
    }

    return array_values( array_unique( array_filter( $paths ) ) );
}

function dv_uploads_audit_collect_attachment_ids_from_text( $text ) {
    $text = (string) maybe_serialize( $text );
    $ids = array();

    if ( '' === $text ) {
        return $ids;
    }

    $patterns = array(
        '/wp-image-([0-9]+)/',
        '/"id"\s*:\s*([0-9]+)/',
        '/"attachment_id"\s*:\s*([0-9]+)/',
        '/attachment[_-]?id["\']?\s*[:=]\s*["\']?([0-9]+)/i',
    );

    foreach ( $patterns as $pattern ) {
        if ( ! preg_match_all( $pattern, $text, $matches ) ) {
            continue;
        }

        foreach ( $matches[1] as $id ) {
            $ids[] = absint( $id );
        }
    }

    return array_values( array_unique( array_filter( $ids ) ) );
}

function dv_uploads_audit_collect_post_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $posts = $wpdb->get_results(
        "SELECT ID, post_type, post_title, post_content, post_excerpt
        FROM {$wpdb->posts}
        WHERE post_status NOT IN ('auto-draft', 'trash', 'inherit')"
    );

    foreach ( (array) $posts as $post ) {
        $label = $post->post_type . ' #' . (int) $post->ID . ' "' . wp_strip_all_tags( (string) $post->post_title ) . '"';
        $text = (string) $post->post_content . "\n" . (string) $post->post_excerpt;

        foreach ( dv_uploads_audit_collect_urls_from_text( $text, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $label . ' content URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $text ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $label . ' content ID' );
        }
    }
}

function dv_uploads_audit_collect_postmeta_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $rows = $wpdb->get_results(
        "SELECT post_id, meta_key, meta_value
        FROM {$wpdb->postmeta}
        WHERE meta_key IN ('_thumbnail_id', '_product_image_gallery')
            OR meta_value LIKE '%wp-content/uploads/%'
            OR meta_value LIKE '%wp-image-%'"
    );

    foreach ( (array) $rows as $row ) {
        $post_id = absint( $row->post_id );
        $meta_key = (string) $row->meta_key;
        $reason = 'postmeta ' . $meta_key . ' post #' . $post_id;

        if ( '_thumbnail_id' === $meta_key ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, (int) $row->meta_value, $reason );
            continue;
        }

        if ( '_product_image_gallery' === $meta_key ) {
            foreach ( wp_parse_id_list( $row->meta_value ) as $attachment_id ) {
                dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason );
            }
            continue;
        }

        foreach ( dv_uploads_audit_collect_urls_from_text( $row->meta_value, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $reason . ' URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $row->meta_value ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason . ' ID' );
        }
    }
}

function dv_uploads_audit_collect_termmeta_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $rows = $wpdb->get_results(
        "SELECT term_id, meta_key, meta_value
        FROM {$wpdb->termmeta}
        WHERE meta_key IN ('thumbnail_id')
            OR meta_value LIKE '%wp-content/uploads/%'
            OR meta_value LIKE '%wp-image-%'"
    );

    foreach ( (array) $rows as $row ) {
        $reason = 'termmeta ' . (string) $row->meta_key . ' term #' . absint( $row->term_id );

        if ( 'thumbnail_id' === (string) $row->meta_key ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, (int) $row->meta_value, $reason );
            continue;
        }

        foreach ( dv_uploads_audit_collect_urls_from_text( $row->meta_value, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $reason . ' URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $row->meta_value ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason . ' ID' );
        }
    }
}

function dv_uploads_audit_collect_option_references( &$used_files, $attachment_files, $uploads ) {
    global $wpdb;

    $known_options = array(
        'custom_logo',
        'theme_mods_' . get_option( 'stylesheet' ),
        'dv_store_profile',
        'dv_theme_content',
        'dv_theme_options',
    );

    $placeholders = implode( ',', array_fill( 0, count( $known_options ), '%s' ) );
    $sql = $wpdb->prepare(
        "SELECT option_name, option_value
        FROM {$wpdb->options}
        WHERE option_value LIKE %s
            OR option_value LIKE %s
            OR option_name IN ({$placeholders})",
        array_merge( array( '%wp-content/uploads/%', '%wp-image-%' ), $known_options )
    );

    $rows = $wpdb->get_results( $sql );

    foreach ( (array) $rows as $row ) {
        $option_name = (string) $row->option_name;
        $reason = 'option ' . $option_name;
        $value = maybe_unserialize( $row->option_value );

        if ( 'custom_logo' === $option_name ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, (int) $row->option_value, $reason );
        }

        foreach ( dv_uploads_audit_collect_urls_from_text( $value, $uploads ) as $relative_path ) {
            dv_uploads_audit_add_used_file( $used_files, $relative_path, $reason . ' URL' );
        }

        foreach ( dv_uploads_audit_collect_attachment_ids_from_text( $value ) as $attachment_id ) {
            dv_uploads_audit_add_attachment_usage( $used_files, $attachment_files, $attachment_id, $reason . ' ID' );
        }
    }
}

function dv_uploads_audit_build_report( $extensions ) {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );
    $files = dv_uploads_audit_scan_files( $base_dir, $extensions );
    $attachments = dv_uploads_audit_get_attachments();
    $attachment_files = array();
    $file_attachments = array();
    $missing_files = array();
    $used_files = array();

    foreach ( $attachments as $attachment ) {
        $attachment_id = absint( $attachment->ID );
        $paths = dv_uploads_audit_attachment_size_paths(
            $attachment->attached_file,
            $attachment->attachment_metadata
        );

        foreach ( $paths as $relative_path ) {
            if ( ! dv_uploads_audit_is_candidate_file( $relative_path, $extensions ) ) {
                continue;
            }

            $attachment_files[ $attachment_id ][] = $relative_path;
            $file_attachments[ $relative_path ][] = $attachment_id;

            if ( ! isset( $files[ $relative_path ] ) ) {
                $missing_files[] = array(
                    'path'          => $relative_path,
                    'attachment_id' => $attachment_id,
                    'title'         => $attachment->post_title,
                );
            }
        }

        if ( isset( $attachment_files[ $attachment_id ] ) ) {
            $attachment_files[ $attachment_id ] = array_values( array_unique( $attachment_files[ $attachment_id ] ) );
        }
    }

    dv_uploads_audit_collect_post_references( $used_files, $attachment_files, $uploads );
    dv_uploads_audit_collect_postmeta_references( $used_files, $attachment_files, $uploads );
    dv_uploads_audit_collect_termmeta_references( $used_files, $attachment_files, $uploads );
    dv_uploads_audit_collect_option_references( $used_files, $attachment_files, $uploads );

    $used_rows = array();
    $unused_rows = array();
    $orphan_rows = array();

    foreach ( $files as $relative_path => $file ) {
        $attachment_ids = array_values( array_unique( array_map( 'absint', $file_attachments[ $relative_path ] ?? array() ) ) );
        $reasons = array_keys( $used_files[ $relative_path ] ?? array() );
        $is_used = ! empty( $reasons );
        $is_orphan = empty( $attachment_ids );
        $row = array(
            'path'             => $relative_path,
            'size_bytes'       => $file['size_bytes'],
            'modified'         => $file['modified'],
            'attachment_ids'   => implode( ',', $attachment_ids ),
            'in_media_library' => $is_orphan ? 'no' : 'yes',
            'used'             => $is_used ? 'yes' : 'no',
            'reasons'          => implode( ' | ', $reasons ),
        );

        if ( $is_used ) {
            $used_rows[] = $row;
        } else {
            $unused_rows[] = $row;
        }

        if ( $is_orphan ) {
            $orphan_rows[] = $row;
        }
    }

    return array(
        'base_dir'      => $base_dir,
        'files'         => $files,
        'used'          => $used_rows,
        'unused'        => $unused_rows,
        'orphan'        => $orphan_rows,
        'missing'       => $missing_files,
        'summary'       => array(
            'scanned_files' => count( $files ),
            'attachments'   => count( $attachments ),
            'used_files'    => count( $used_rows ),
            'unused_files'  => count( $unused_rows ),
            'orphan_files'  => count( $orphan_rows ),
            'missing_files' => count( $missing_files ),
        ),
    );
}

function dv_uploads_audit_csv_cell( $value ) {
    $value = wp_strip_all_tags( (string) $value );
    $value = html_entity_decode( $value, ENT_QUOTES, 'UTF-8' );
    $value = preg_replace( '/\s+/', ' ', $value );
    $value = trim( (string) $value );

    if ( '' !== $value && preg_match( '/^[=+\-@]/', $value ) ) {
        $value = "'" . $value;
    }

    return $value;
}

function dv_uploads_audit_write_csv( $path, $headers, $rows ) {
    $handle = fopen( $path, 'w' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fopen

    if ( ! $handle ) {
        return false;
    }

    fwrite( $handle, "\xEF\xBB\xBF" ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fwrite
    fputcsv( $handle, $headers, ';' );

    foreach ( $rows as $row ) {
        $line = array();
        foreach ( $headers as $header ) {
            $line[] = dv_uploads_audit_csv_cell( $row[ $header ] ?? '' );
        }
        fputcsv( $handle, $line, ';' );
    }

    fclose( $handle ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose

    return true;
}

function dv_uploads_audit_write_reports( $report, $out_dir ) {
    wp_mkdir_p( $out_dir );

    $file_headers = array(
        'path',
        'size_bytes',
        'modified',
        'attachment_ids',
        'in_media_library',
        'used',
        'reasons',
    );

    dv_uploads_audit_write_csv( $out_dir . '/used-files.csv', $file_headers, $report['used'] );
    dv_uploads_audit_write_csv( $out_dir . '/unused-files.csv', $file_headers, $report['unused'] );
    dv_uploads_audit_write_csv( $out_dir . '/orphan-files.csv', $file_headers, $report['orphan'] );
    dv_uploads_audit_write_csv(
        $out_dir . '/missing-files.csv',
        array( 'path', 'attachment_id', 'title' ),
        $report['missing']
    );

    $summary = array_merge(
        array(
            'generated_at' => gmdate( 'c' ),
            'uploads_dir'  => $report['base_dir'],
        ),
        $report['summary']
    );

    file_put_contents( // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
        $out_dir . '/summary.json',
        wp_json_encode( $summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
    );
}

function dv_uploads_audit_cli_command( $args, $assoc_args ) {
    $default_extensions = array( 'jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg' );
    $extensions_arg = isset( $assoc_args['extensions'] ) ? (string) $assoc_args['extensions'] : '';
    $extensions = '' !== $extensions_arg
        ? array_filter( array_map( 'sanitize_key', explode( ',', $extensions_arg ) ) )
        : $default_extensions;

    $uploads = wp_get_upload_dir();
    $default_out = trailingslashit( $uploads['basedir'] ) . 'detalivam-uploads-audit-' . gmdate( 'Ymd-His' );
    $out_dir = isset( $assoc_args['out'] ) ? (string) $assoc_args['out'] : $default_out;
    $out_dir = untrailingslashit( wp_normalize_path( $out_dir ) );

    WP_CLI::log( 'Scanning uploads: ' . untrailingslashit( $uploads['basedir'] ) );
    WP_CLI::log( 'Extensions: ' . implode( ', ', $extensions ) );

    $report = dv_uploads_audit_build_report( $extensions );
    dv_uploads_audit_write_reports( $report, $out_dir );

    WP_CLI::success( 'Uploads audit report created: ' . $out_dir );
    WP_CLI::log( 'Scanned files: ' . $report['summary']['scanned_files'] );
    WP_CLI::log( 'Used files: ' . $report['summary']['used_files'] );
    WP_CLI::log( 'Unused candidates: ' . $report['summary']['unused_files'] );
    WP_CLI::log( 'Orphan files: ' . $report['summary']['orphan_files'] );
    WP_CLI::log( 'Missing files: ' . $report['summary']['missing_files'] );
}

WP_CLI::add_command(
    'dv uploads-audit',
    'dv_uploads_audit_cli_command',
    array(
        'shortdesc' => 'Audit wp-content/uploads image usage and write CSV reports.',
        'synopsis'  => array(
            array(
                'type'        => 'assoc',
                'name'        => 'out',
                'optional'    => true,
                'description' => 'Output directory for report files.',
            ),
            array(
                'type'        => 'assoc',
                'name'        => 'extensions',
                'optional'    => true,
                'description' => 'Comma-separated file extensions to scan.',
            ),
        ),
    )
);
