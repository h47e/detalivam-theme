param(
    [string]$ThemePath = (Resolve-Path (Join-Path $PSScriptRoot '..')).Path
)

$ErrorActionPreference = 'Stop'

Write-Host "Detalivam admin smoke check"
Write-Host "Theme: $ThemePath"

$phpFiles = @(
    'functions.php',
    'inc/theme-options-admin.php',
    'inc/seo-admin.php',
    'inc/store-admin.php',
    'inc/theme-content-admin.php',
    'inc/uploads-tools-admin.php',
    'inc/slugs.php'
)

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
        $found = rg -q $page inc
        if ($LASTEXITCODE -ne 0) {
            $missing += $page
        }
    }

    if ($missing.Count -gt 0) {
        throw "Admin pages not found: $($missing -join ', ')"
    }
} finally {
    Pop-Location
}

Write-Host "OK: smoke checks passed."

