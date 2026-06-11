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

$suiteCssParts = @(
    '--dv-admin-shell-width',
    'body.dv-suite-admin #wpcontent',
    'body.dv-suite-admin #wpfooter',
    'body.dv-suite-admin .wrap.dv-suite-page',
    'body.dv-suite-admin .dv-suite-header',
    'body.dv-suite-admin .dv-suite-tabs',
    'body.dv-suite-admin .dv-suite-page-nav',
    'body.dv-suite-admin .dv-suite-footer',
    '.dv-suite-command-panel',
    'body.dv-suite-admin .dv-suite-page-nav a',
    'body.dv-suite-admin .dv-suite-footer-nav a'
)

foreach ($part in $suiteCssParts) {
    Assert-TextInFile -RelativePath 'assets/css/theme-admin.css' -Needle $part -Label 'Suite visual CSS'
}

$pageCssParts = @(
    @{ File = 'assets/css/theme-options-admin.css'; Needle = '.dv-theme-options-page' },
    @{ File = 'assets/css/seo-admin.css'; Needle = '.dv-seo-tools' },
    @{ File = 'assets/css/store-admin.css'; Needle = '.dv-store-settings-page' },
    @{ File = 'assets/css/theme-content-admin.css'; Needle = '.dv-theme-content-page' },
    @{ File = 'assets/css/theme-admin.css'; Needle = '.dv-uploads-tools-page' },
    @{ File = 'assets/css/theme-admin.css'; Needle = '.dv-slug-tools-card' }
)

foreach ($part in $pageCssParts) {
    Assert-TextInFile -RelativePath $part.File -Needle $part.Needle -Label 'Page visual CSS'
}

Write-Host "OK: visual audit passed for 6 admin pages."
