<?php
/**
 * Shared storage layout for uploads audits and file backups.
 */
defined( 'ABSPATH' ) || exit;

function dv_uploads_storage_root_name() {
    return 'detalivam-file-manager';
}

function dv_uploads_storage_root_dir() {
    $uploads = wp_get_upload_dir();
    $base_dir = untrailingslashit( wp_normalize_path( $uploads['basedir'] ?? '' ) );

    return '' !== $base_dir ? trailingslashit( $base_dir ) . dv_uploads_storage_root_name() : '';
}

function dv_uploads_storage_section_dir( $section ) {
    $section = sanitize_key( $section );

    if ( ! in_array( $section, array( 'audits', 'backups' ), true ) ) {
        return '';
    }

    $root_dir = dv_uploads_storage_root_dir();

    return '' !== $root_dir ? trailingslashit( $root_dir ) . $section : '';
}

function dv_uploads_storage_timestamp( $timestamp = null ) {
    $timestamp = null === $timestamp ? time() : absint( $timestamp );

    return function_exists( 'wp_date' )
        ? wp_date( 'Y-m-d_H-i-s', $timestamp )
        : gmdate( 'Y-m-d_H-i-s', $timestamp );
}

function dv_uploads_storage_operation_dir( $section, $type, $timestamp = null ) {
    $section_dir = dv_uploads_storage_section_dir( $section );
    $type = sanitize_key( $type );

    if ( '' === $section_dir || '' === $type ) {
        return '';
    }

    $parent = trailingslashit( $section_dir ) . $type;
    $name = dv_uploads_storage_timestamp( $timestamp );
    $path = trailingslashit( $parent ) . $name;
    $suffix = 2;

    while ( file_exists( $path ) ) {
        $path = trailingslashit( $parent ) . $name . '-' . $suffix;
        ++$suffix;
    }

    return untrailingslashit( wp_normalize_path( $path ) );
}

function dv_uploads_storage_path_starts_with( $path, $base ) {
    $path = untrailingslashit( wp_normalize_path( (string) $path ) );
    $base = untrailingslashit( wp_normalize_path( (string) $base ) );

    return '' !== $path && '' !== $base && ( $path === $base || 0 === strpos( $path, trailingslashit( $base ) ) );
}

function dv_uploads_storage_parse_operation_dir( $dir ) {
    $root_dir = untrailingslashit( wp_normalize_path( dv_uploads_storage_root_dir() ) );
    $dir = untrailingslashit( wp_normalize_path( (string) $dir ) );

    if ( '' === $root_dir || ! dv_uploads_storage_path_starts_with( $dir, $root_dir ) || $dir === $root_dir ) {
        return array();
    }

    $relative = trim( substr( $dir, strlen( $root_dir ) ), '/' );
    $parts = explode( '/', $relative );

    if (
        3 !== count( $parts )
        || ! in_array( $parts[0], array( 'audits', 'backups' ), true )
        || sanitize_key( $parts[1] ) !== $parts[1]
        || ! preg_match( '/^\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}(?:-\d+)?$/', $parts[2] )
    ) {
        return array();
    }

    return array(
        'section' => $parts[0],
        'type'    => $parts[1],
        'date'    => $parts[2],
    );
}

function dv_uploads_storage_is_backup_operation_dir( $dir, $type = '' ) {
    $layout = dv_uploads_storage_parse_operation_dir( $dir );

    if ( empty( $layout ) || 'backups' !== $layout['section'] ) {
        return false;
    }

    return '' === $type || sanitize_key( $type ) === $layout['type'];
}
