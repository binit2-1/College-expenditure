@echo off
title College Expenditure System
echo 🏫 College Expenditure System - Quick Start
echo ============================================
echo.

REM Check if we're in the right directory
if not exist "artisan" (
    echo ❌ Error: Not in the correct directory!
    echo Please run this script from the College-expenditure folder.
    pause
    exit /b 1
)

echo 🔧 Setting up environment...
set PATH=%PATH%;C:\xampp\php

echo 🚀 Starting Laravel development server...
echo.
echo Your application will be available at: http://127.0.0.1:8000
echo.
echo 👤 Login Credentials:
echo Admin: admin@college.edu / password
echo HoD: cshead@college.edu / password  
echo Faculty: faculty@college.edu / password
echo.
echo Press Ctrl+C to stop the server
echo ============================================
echo.

php artisan serve

pause
