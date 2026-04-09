# One-time / repeatable: stable Gradle + Flutter Android builds on Windows.
# Run in PowerShell:  Set-ExecutionPolicy -Scope CurrentUser RemoteSigned -Force
#                      .\scripts\setup-windows-gradle.ps1
# For Defender exclusions, run an elevated PowerShell (Run as administrator).

$ErrorActionPreference = "Stop"

$gradleHome = "C:\gradle_user_home"
$gradleTmp  = "C:\gradle_tmp"

Write-Host "Creating directories..."
New-Item -ItemType Directory -Force -Path $gradleHome | Out-Null
New-Item -ItemType Directory -Force -Path $gradleTmp | Out-Null

Write-Host "Setting User environment variable GRADLE_USER_HOME=$gradleHome ..."
[System.Environment]::SetEnvironmentVariable("GRADLE_USER_HOME", $gradleHome, "User")
$env:GRADLE_USER_HOME = $gradleHome

Write-Host "Done. Open a NEW terminal so GRADLE_USER_HOME is picked up everywhere."

# Optional: Windows Defender exclusions (requires admin)
$isAdmin = ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
if (-not $isAdmin) {
    Write-Host ""
    Write-Host "INFO: Not running as Administrator - skipping Defender exclusions."
    Write-Host "      To add exclusions, open PowerShell as Admin and run:"
    Write-Host "      Add-MpPreference -ExclusionPath '$gradleHome'"
    Write-Host "      Add-MpPreference -ExclusionPath '$gradleTmp'"
    Write-Host "      Add-MpPreference -ExclusionPath '$env:USERPROFILE\.gradle'"
    Write-Host "      Add-MpPreference -ExclusionPath 'D:\src'"
    exit 0
}

try {
    Add-MpPreference -ExclusionPath $gradleHome -ErrorAction Stop
    Add-MpPreference -ExclusionPath $gradleTmp -ErrorAction Stop
    Add-MpPreference -ExclusionPath (Join-Path $env:USERPROFILE ".gradle") -ErrorAction Stop
    Add-MpPreference -ExclusionPath "D:\src" -ErrorAction Stop
    Write-Host "Windows Defender path exclusions added."
} catch {
    Write-Warning ("Could not add Defender exclusions: " + $_.Exception.Message)
}
