# Builds release APK with the same env Gradle expects (C: cache + temp).
# Usage:  powershell -ExecutionPolicy Bypass -File D:\src\waiterApp\scripts\build-release-apk.ps1

$ErrorActionPreference = "Stop"
# This script lives in <project>\scripts\
$projectRoot = Split-Path $PSScriptRoot -Parent
if (-not (Test-Path (Join-Path $projectRoot "pubspec.yaml"))) {
    $projectRoot = "D:\src\waiterApp"
}

$env:GRADLE_USER_HOME = "C:\gradle_user_home"
$env:TEMP = "C:\gradle_tmp"
$env:TMP = "C:\gradle_tmp"
New-Item -ItemType Directory -Force -Path $env:GRADLE_USER_HOME, "C:\gradle_tmp" | Out-Null

Set-Location $projectRoot
Write-Host "Project: $projectRoot"
flutter build apk --release @args
