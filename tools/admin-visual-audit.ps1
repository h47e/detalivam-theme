param(
    [string]$ThemePath = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
)

$ErrorActionPreference = 'Stop'

Write-Host "Detalivam admin visual audit"
Write-Host "Theme: $ThemePath"

function Test-TextInFile {
    param(
        [Parameter(Mandatory = $true)]
        [string]$RelativePath,

        [Parameter(Mandatory = $true)]
        [string]$Needle
    )

    $path = Join-Path $ThemePath $RelativePath

    if (-not (Test-Path $path)) {
        return $false
    }

    return [bool](Select-String -Path $path -SimpleMatch -Pattern $Needle -Quiet)
}

function Assert-TextInFile {
    param(
        [Parameter(Mandatory = $true)]
        [string]$RelativePath,

        [Parameter(Mandatory = $true)]
        [string]$Needle,

        [Parameter(Mandatory = $true)]
        [string]$Label
    )

    if (-not (Test-TextInFile -RelativePath $RelativePath -Needle $Needle)) {
        throw "$Label is missing in ${RelativePath}: ${Needle}"
    }
}

$pages = @(
    @{
        Name = 'Settings'
        File = 'inc/theme-options-admin.php'
        Slug = 'dv-theme-options'
        PageClass = 'dv-theme-options-page'
        Wrapper = 'wrap dv-suite-page'
    },
    @{
        Name = 'SEO'
        File = 'inc/seo-admin.php'
        Slug = 'dv-seo-tools'
        PageClass = 'dv-seo-tools'
        Wrapper = 'wrap dv-suite-page'
    },
    @{
        Name = 'Store'
        File = 'inc/store-admin.php'
        Slug = 'dv-store-settings'
        PageClass = 'dv-store-settings-page'
        Wrapper = 'wrap dv-suite-page'
    },
    @{
        Name = 'Content'
        File = 'inc/theme-content-admin.php'
        Slug = 'dv-theme-content'
        PageClass = 'dv-theme-content-page'
        Wrapper = 'wrap dv-suite-page'
    },
    @{
        Name = 'Files'
        File = 'inc/uploads-tools-admin.php'
        Slug = 'dv-uploads-tools'
        PageClass = 'dv-uploads-tools-page'
        Wrapper = 'wrap dv-suite-page'
    },
    @{
        Name = 'Slug'
        File = 'inc/slugs.php'
        Slug = 'dv-slug-tools'
        PageClass = 'dv-suite-card'
        Wrapper = 'wrap dv-suite dv-suite-page'
    }
)

foreach ($page in $pages) {
    Assert-TextInFile -RelativePath $page.File -Needle $page.Wrapper -Label "$($page.Name) wrapper"
    Assert-TextInFile -RelativePath $page.File -Needle $page.Slug -Label "$($page.Name) slug"
    Assert-TextInFile -RelativePath $page.File -Needle $page.PageClass -Label "$($page.Name) page class"
    Assert-TextInFile -RelativePath $page.File -Needle 'dv_render_admin_suite_header' -Label "$($page.Name) header"
    Assert-TextInFile -RelativePath $page.File -Needle 'dv_render_admin_suite_local_nav' -Label "$($page.Name) local nav"
    Assert-TextInFile -RelativePath $page.File -Needle 'dv_render_admin_suite_footer' -Label "$($page.Name) footer"
}

Assert-TextInFile -RelativePath 'inc/theme-options-admin.php' -Needle 'function dv_admin_suite_section_commands' -Label 'Suite section commands'
Assert-TextInFile -RelativePath 'inc/theme-options-admin.php' -Needle 'function dv_render_admin_suite_health_strip' -Label 'Suite health strip helper'
Assert-TextInFile -RelativePath 'inc/theme-options-admin.php' -Needle 'dv_render_admin_suite_health_strip( $current_page )' -Label 'Suite health strip render'
Assert-TextInFile -RelativePath 'inc/theme-options-admin.php' -Needle 'assets/css/admin-components.css' -Label 'Admin components enqueue'
Assert-TextInFile -RelativePath 'inc/store-admin.php' -Needle 'function dv_render_store_profile_preview' -Label 'Store profile preview'
Assert-TextInFile -RelativePath 'inc/store-admin.php' -Needle 'dv_render_store_profile_preview( $profile, $theme_options )' -Label 'Store profile preview render'

$suiteCssParts = @(
    '--dv-admin-shell-width',
    '--dv-admin-surface',
    '--dv-admin-surface-soft',
    '--dv-admin-surface-muted',
    '--dv-admin-radius',
    '--dv-admin-radius-sm',
    '--dv-admin-shadow-soft',
    '--dv-admin-shadow-panel',
    'body.dv-suite-admin #wpcontent',
    'body.dv-suite-admin #wpfooter',
    'body.dv-suite-admin .wrap.dv-suite-page',
    'body.dv-suite-admin .dv-suite-header',
    'body.dv-suite-admin .dv-suite-tabs',
    'body.dv-suite-admin .dv-suite-tab.is-active',
    'body.dv-suite-admin .dv-suite-quick-actions a',
    'body.dv-suite-admin .dv-suite-page-nav',
    'body.dv-suite-admin .widefat',
    'body.dv-suite-admin .dv-suite-status',
    'body.dv-suite-admin .dv-suite-badge',
    'body.dv-suite-admin .button.dv-is-danger',
    'body.dv-suite-admin .dv-suite-footer',
    '.dv-suite-command-panel',
    'body.dv-suite-admin .dv-suite-page-nav a',
    'body.dv-suite-admin .dv-suite-footer-nav a'
)

foreach ($part in $suiteCssParts) {
    Assert-TextInFile -RelativePath 'assets/css/theme-admin.css' -Needle $part -Label 'Suite visual CSS'
}

$componentCssParts = @(
    'body.dv-suite-admin .dv-suite-health-strip',
    'body.dv-suite-admin .dv-suite-health-card',
    'body.dv-suite-admin.dv-suite-density-compact .widefat',
    'body.dv-suite-admin .dv-suite-toast',
    'body.dv-suite-admin .dv-suite-danger-zone',
    'body.dv-suite-admin .dv-suite-density-toggle:focus-visible'
)

foreach ($part in $componentCssParts) {
    Assert-TextInFile -RelativePath 'assets/css/admin-components.css' -Needle $part -Label 'Admin component CSS'
}

$componentJsParts = @(
    'setupDensityToggle();',
    'setupSaveFeedback();',
    'dvSuiteDensityMode',
    'dv-suite-toast',
    'settings-updated'
)

foreach ($part in $componentJsParts) {
    Assert-TextInFile -RelativePath 'assets/js/theme-admin.js' -Needle $part -Label 'Admin component JS'
}

$pageCssParts = @(
    @{ File = 'assets/css/theme-options-admin.css'; Needle = '.dv-theme-options-page' },
    @{ File = 'assets/css/seo-admin.css'; Needle = '.dv-seo-tools' },
    @{ File = 'assets/css/store-admin.css'; Needle = '.dv-store-settings-page' },
    @{ File = 'assets/css/store-admin.css'; Needle = '.dv-store-live-preview' },
    @{ File = 'assets/css/theme-content-admin.css'; Needle = '.dv-theme-content-page' },
    @{ File = 'assets/css/theme-admin.css'; Needle = '.dv-uploads-tools-page' },
    @{ File = 'assets/css/theme-admin.css'; Needle = '.dv-slug-tools-card' }
)

foreach ($part in $pageCssParts) {
    Assert-TextInFile -RelativePath $part.File -Needle $part.Needle -Label 'Page visual CSS'
}

Write-Host "OK: visual audit passed for 6 admin pages."
