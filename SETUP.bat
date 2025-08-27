@echo off
echo 🏫 College Expenditure System - Auto Setup
echo ==========================================
echo.
echo This will automatically install and configure everything needed.
echo.
echo What will be installed:
echo - XAMPP (PHP + Apache + MySQL)
echo - Node.js
echo - Git
echo - All application dependencies
echo.
pause
echo.
echo 🚀 Starting automated setup...
echo.

REM Run the PowerShell script
powershell.exe -ExecutionPolicy Bypass -File "%~dp0setup.ps1"

echo.
echo Setup script completed!
pause
