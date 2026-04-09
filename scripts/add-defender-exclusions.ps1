# Adds Microsoft Defender folder exclusions for Flutter/Gradle builds.
# Run PowerShell AS ADMINISTRATOR:  Right-click PowerShell -> Run as administrator
#   cd D:\src\waiterApp\scripts
#   .\add-defender-exclusions.ps1
#
# If Sophos is your active AV, Defender may be off — exclusions here may not help until
# Defender handles real-time protection again. Sophos exclusions must be set in Sophos UI.

$paths = @(
    'C:\gradle_user_home',
    'C:\gradle_tmp',
    'D:\src',
    'D:\src\waiterApp',
    (Join-Path $env:USERPROFILE '.gradle')
)

$isAdmin = ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole(
    [Security.Principal.WindowsBuiltInRole]::Administrator)
if (-not $isAdmin) {
    Write-Error "Run this script as Administrator (right-click PowerShell -> Run as administrator)."
    exit 1
}

try {
    $status = Get-MpComputerStatus -ErrorAction Stop
    Write-Host "Defender AMServiceEnabled=$($status.AMServiceEnabled) AntivirusEnabled=$($status.AntivirusEnabled) RealTimeProtectionEnabled=$($status.RealTimeProtectionEnabled)"
} catch {
    Write-Warning "Could not read Defender status: $_"
}

foreach ($p in $paths) {
    if (-not (Test-Path -LiteralPath $p)) {
        Write-Host "SKIP (path not found): $p"
        continue
    }
    try {
        Add-MpPreference -ExclusionPath $p -ErrorAction Stop
        Write-Host "OK: $p"
    } catch {
        Write-Warning "FAILED: $p -> $($_.Exception.Message)"
    }
}

try {
    Write-Host "`nCurrent ExclusionPath list:"
    (Get-MpPreference).ExclusionPath
} catch {
    Write-Warning "Could not list exclusions: $_"
}
