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

    $requiredCommandForms = @(
        'dv-suite-live-search-index-rebuild',
        'dv-suite-service-cache-clear'
    )

    $missingForms = @()

    foreach ($form in $requiredCommandForms) {
        if (-not (Test-TextInTheme -Needle $form)) {
            $missingForms += $form
        }
    }

    if ($missingForms.Count -gt 0) {
        throw "Command palette forms not found: $($missingForms -join ', ')"
    }
} finally {
    Pop-Location
}

Write-Host "OK: smoke checks passed."
