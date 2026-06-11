param(
    [string]$ThemePath = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
)

$ErrorActionPreference = 'Stop'

Write-Host "Detalivam admin smoke check"
Write-Host "Theme: $ThemePath"

$phpFiles = @(
    'functions.php',
    'inc/search.php',
    'inc/theme-options-admin.php',
    'inc/seo-admin.php',
    'inc/store-admin.php',
    'inc/theme-content-admin.php',
    'inc/uploads-tools-admin.php',
    'inc/slugs.php'
)

function Test-TextInTheme {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Needle
    )

    $matches = Get-ChildItem -Path (Join-Path $ThemePath 'inc') -Recurse -File -Include '*.php' |
        Select-String -SimpleMatch -Pattern $Needle -Quiet

    return [bool]$matches
}

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

$php = Get-Command php -ErrorAction SilentlyContinue

if ($php) {
    foreach ($file in $phpFiles) {
        $path = Join-Path $ThemePath $file
        if (Test-Path $path) {
            & php -l $path | Write-Host
            if ($LASTEXITCODE -ne 0) {
                throw "PHP lint failed: $file"
            }
        }
    }
} else {
    Write-Warning "php is not available in PATH; PHP syntax check skipped."
}

Push-Location $ThemePath
try {
    git diff --check
    if ($LASTEXITCODE -ne 0) {
        throw "git diff --check failed"
    }

    $requiredPages = @(
        'dv-theme-options',
        'dv-seo-tools',
        'dv-store-settings',
        'dv-theme-content',
        'dv-uploads-tools',
        'dv-slug-tools'
    )

    $missing = @()

    foreach ($page in $requiredPages) {
        if (-not (Test-TextInTheme -Needle $page)) {
            $missing += $page
        }
    }

    if ($missing.Count -gt 0) {
        throw "Admin pages not found: $($missing -join ', ')"
    }

    $requiredActions = @(
        'admin_post_dv_dashboard_status_refresh',
        'admin_post_dv_theme_backup_export',
        'admin_post_dv_theme_backup_import',
        'admin_post_dv_theme_diagnostics_export',
        'admin_post_dv_theme_product_audit_refresh',
        'admin_post_dv_theme_service_cache_clear',
        'admin_post_dv_live_search_index_rebuild',
        'admin_post_dv_uploads_run_audit',
        'admin_post_dv_uploads_move_unused',
        'admin_post_dv_convert_existing_slugs'
    )

    $missingActions = @()

    foreach ($action in $requiredActions) {
        if (-not (Test-TextInTheme -Needle $action)) {
            $missingActions += $action
        }
    }

    if ($missingActions.Count -gt 0) {
        throw "Admin actions not found: $($missingActions -join ', ')"
    }

    $requiredCommandParts = @(
        'dv-suite-live-search-index-rebuild',
        'dv-suite-service-cache-clear',
        'dv_admin_suite_dashboard_task_commands'
    )

    $missingCommandParts = @()

    foreach ($part in $requiredCommandParts) {
        if (-not (Test-TextInTheme -Needle $part)) {
            $missingCommandParts += $part
        }
    }

    if ($missingCommandParts.Count -gt 0) {
        throw "Command palette parts not found: $($missingCommandParts -join ', ')"
    }

    $requiredSuiteShellPhp = @(
        'dv_theme_admin_body_class',
        'admin_body_class',
        'dv_render_admin_suite_header',
        'dv_render_admin_suite_footer',
        'dv-suite-admin'
    )

    $missingShellPhp = @()

    foreach ($part in $requiredSuiteShellPhp) {
        if (-not (Test-TextInTheme -Needle $part)) {
            $missingShellPhp += $part
        }
    }

    if ($missingShellPhp.Count -gt 0) {
        throw "Admin suite shell PHP parts not found: $($missingShellPhp -join ', ')"
    }

    $requiredSuiteShellCss = @(
        '--dv-admin-shell-width',
        'body.dv-suite-admin #wpcontent',
        'body.dv-suite-admin #wpfooter',
        'body.dv-suite-admin .wrap.dv-suite-page',
        'body.dv-suite-admin .dv-suite-footer',
        'body.dv-suite-admin .dv-suite-page-nav'
    )

    $missingShellCss = @()

    foreach ($part in $requiredSuiteShellCss) {
        if (-not (Test-TextInFile -RelativePath 'assets/css/theme-admin.css' -Needle $part)) {
            $missingShellCss += $part
        }
    }

    if ($missingShellCss.Count -gt 0) {
        throw "Admin suite shell CSS parts not found: $($missingShellCss -join ', ')"
    }

    $requiredKeyboardPhp = @(
        'aria-keyshortcuts="Control+K"',
        'role="combobox"',
        'role="listbox"',
        'role="option"'
    )

    $missingKeyboardPhp = @()

    foreach ($part in $requiredKeyboardPhp) {
        if (-not (Test-TextInTheme -Needle $part)) {
            $missingKeyboardPhp += $part
        }
    }

    if ($missingKeyboardPhp.Count -gt 0) {
        throw "Admin keyboard PHP parts not found: $($missingKeyboardPhp -join ', ')"
    }

    $requiredKeyboardJs = @(
        'ArrowDown',
        'ArrowUp',
        'Home',
        'End',
        'Escape',
        'aria-activedescendant',
        'aria-live',
        'aria-selected',
        'focus()'
    )

    $missingKeyboardJs = @()

    foreach ($part in $requiredKeyboardJs) {
        if (-not (Test-TextInFile -RelativePath 'assets/js/theme-admin.js' -Needle $part)) {
            $missingKeyboardJs += $part
        }
    }

    if ($missingKeyboardJs.Count -gt 0) {
        throw "Admin keyboard JS parts not found: $($missingKeyboardJs -join ', ')"
    }

    $requiredKeyboardCss = @(
        'focus-visible',
        '.dv-suite-command-item.is-active'
    )

    $missingKeyboardCss = @()

    foreach ($part in $requiredKeyboardCss) {
        if (-not (Test-TextInFile -RelativePath 'assets/css/theme-admin.css' -Needle $part)) {
            $missingKeyboardCss += $part
        }
    }

    if ($missingKeyboardCss.Count -gt 0) {
        throw "Admin keyboard CSS parts not found: $($missingKeyboardCss -join ', ')"
    }

    $visualAudit = Join-Path $ThemePath 'tools/admin-visual-audit.ps1'
    if (-not (Test-Path $visualAudit)) {
        throw "Admin visual audit script not found: $visualAudit"
    }

    & powershell -ExecutionPolicy Bypass -File $visualAudit -ThemePath $ThemePath | Write-Host
    if ($LASTEXITCODE -ne 0) {
        throw "Admin visual audit failed"
    }
} finally {
    Pop-Location
}

Write-Host "OK: smoke checks passed."
