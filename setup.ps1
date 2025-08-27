# 🚀 College Expenditure System - Automated Setup Script
# This script will automatically install and configure everything needed to run the application

# Set execution policy for this session
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser -Force

Write-Host "🏫 College Expenditure Monitoring & UC Generator - Auto Setup" -ForegroundColor Green
Write-Host "================================================================" -ForegroundColor Cyan
Write-Host ""

# Function to check if running as administrator
function Test-Admin {
    $currentUser = [Security.Principal.WindowsIdentity]::GetCurrent()
    $principal = New-Object Security.Principal.WindowsPrincipal($currentUser)
    return $principal.IsInRole([Security.Principal.WindowsBuiltInRole]::Administrator)
}

# Function to install software via winget
function Install-Software {
    param($Name, $Id, $Description)
    
    Write-Host "📦 Installing $Description..." -ForegroundColor Yellow
    try {
        $result = winget install $Id --accept-package-agreements --accept-source-agreements --silent
        if ($LASTEXITCODE -eq 0) {
            Write-Host "✅ $Name installed successfully!" -ForegroundColor Green
        } else {
            Write-Host "⚠️  $Name might already be installed or installation had issues" -ForegroundColor Yellow
        }
    } catch {
        Write-Host "❌ Failed to install $Name" -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
    }
    Write-Host ""
}

# Function to download file
function Download-File {
    param($Url, $OutputPath, $Description)
    
    Write-Host "⬇️  Downloading $Description..." -ForegroundColor Yellow
    try {
        Invoke-WebRequest -Uri $Url -OutFile $OutputPath -UseBasicParsing
        Write-Host "✅ $Description downloaded successfully!" -ForegroundColor Green
    } catch {
        Write-Host "❌ Failed to download $Description" -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
    }
}

# Function to run command with error handling
function Run-Command {
    param($Command, $Description, $WorkingDirectory = $null)
    
    Write-Host "🔧 $Description..." -ForegroundColor Yellow
    try {
        if ($WorkingDirectory) {
            $result = Invoke-Expression "& { Set-Location '$WorkingDirectory'; $Command }"
        } else {
            $result = Invoke-Expression $Command
        }
        Write-Host "✅ $Description completed!" -ForegroundColor Green
        return $true
    } catch {
        Write-Host "❌ Failed: $Description" -ForegroundColor Red
        Write-Host $_.Exception.Message -ForegroundColor Red
        return $false
    }
}

# Start setup process
Write-Host "🚀 Starting automated setup..." -ForegroundColor Cyan
Write-Host ""

# Check if winget is available
Write-Host "🔍 Checking for Windows Package Manager..." -ForegroundColor Yellow
try {
    winget --version | Out-Null
    Write-Host "✅ Windows Package Manager is available!" -ForegroundColor Green
} catch {
    Write-Host "❌ Windows Package Manager not found. Please install it from Microsoft Store." -ForegroundColor Red
    Write-Host "   Search for 'App Installer' in Microsoft Store and install it." -ForegroundColor Yellow
    pause
    exit 1
}
Write-Host ""

# Step 1: Install XAMPP
Install-Software "XAMPP" "ApacheFriends.Xampp.8.2" "XAMPP (PHP + Apache + MySQL)"

# Step 2: Install Node.js
Install-Software "Node.js" "OpenJS.NodeJS" "Node.js (JavaScript runtime)"

# Step 3: Install Git
Install-Software "Git" "Git.Git" "Git (Version control)"

# Refresh environment variables
Write-Host "🔄 Refreshing environment variables..." -ForegroundColor Yellow
$env:Path = [System.Environment]::GetEnvironmentVariable("Path","Machine") + ";" + [System.Environment]::GetEnvironmentVariable("Path","User")
Write-Host "✅ Environment refreshed!" -ForegroundColor Green
Write-Host ""

# Step 4: Set up project directory
$ProjectPath = "$env:USERPROFILE\Desktop\College-expenditure"
Write-Host "📁 Setting up project directory at: $ProjectPath" -ForegroundColor Yellow

if (-not (Test-Path $ProjectPath)) {
    Write-Host "❌ Project directory not found!" -ForegroundColor Red
    Write-Host "Please extract the College-expenditure project to your Desktop first." -ForegroundColor Yellow
    Write-Host "Expected location: $ProjectPath" -ForegroundColor Yellow
    pause
    exit 1
}

Set-Location $ProjectPath
Write-Host "✅ Project directory found!" -ForegroundColor Green
Write-Host ""

# Step 5: Add PHP to PATH for this session
Write-Host "🔧 Setting up PHP path..." -ForegroundColor Yellow
$env:PATH += ";C:\xampp\php"
Write-Host "✅ PHP path configured!" -ForegroundColor Green
Write-Host ""

# Step 6: Download and install Composer
Write-Host "📦 Installing Composer (PHP Package Manager)..." -ForegroundColor Yellow
Download-File "https://getcomposer.org/installer" "composer-setup.php" "Composer installer"

if (Test-Path "composer-setup.php") {
    Run-Command "php composer-setup.php --install-dir=. --filename=composer" "Installing Composer" $ProjectPath
    Remove-Item "composer-setup.php" -Force
}
Write-Host ""

# Step 7: Install PHP dependencies
Run-Command "php composer install --no-dev --optimize-autoloader" "Installing PHP dependencies" $ProjectPath

# Step 8: Install Node.js dependencies
Run-Command "npm install" "Installing Node.js dependencies" $ProjectPath

# Step 9: Generate Laravel key
Run-Command "php artisan key:generate" "Generating Laravel application key" $ProjectPath

# Step 10: Set up database
Write-Host "🗄️  Setting up database..." -ForegroundColor Yellow
$DatabasePath = "$ProjectPath\database\database.sqlite"
if (-not (Test-Path $DatabasePath)) {
    New-Item -Path $DatabasePath -ItemType File -Force | Out-Null
    Write-Host "✅ SQLite database file created!" -ForegroundColor Green
} else {
    Write-Host "✅ Database file already exists!" -ForegroundColor Green
}

# Step 11: Run migrations
Run-Command "php artisan migrate --force" "Running database migrations" $ProjectPath

# Step 12: Seed database
Run-Command "php artisan db:seed --class=UserSeeder --force" "Seeding user data" $ProjectPath
Run-Command "php artisan db:seed --class=TestUsersSeeder --force" "Seeding test users" $ProjectPath

# Step 13: Build frontend assets
Run-Command "npm run build" "Building frontend assets" $ProjectPath

# Step 14: Create storage link
Run-Command "php artisan storage:link" "Creating storage symbolic link" $ProjectPath

# Step 15: Start XAMPP services
Write-Host "🚀 Starting XAMPP services..." -ForegroundColor Yellow
if (Test-Path "C:\xampp\xampp_start.exe") {
    Start-Process "C:\xampp\xampp_start.exe" -NoNewWindow
    Write-Host "✅ XAMPP services started!" -ForegroundColor Green
} elseif (Test-Path "C:\xampp\xampp-control.exe") {
    Start-Process "C:\xampp\xampp-control.exe"
    Write-Host "⚠️  XAMPP Control Panel opened. Please start Apache and MySQL manually." -ForegroundColor Yellow
} else {
    Write-Host "⚠️  XAMPP not found in expected location. Please start it manually." -ForegroundColor Yellow
}
Write-Host ""

# Final setup completion
Write-Host "🎉 SETUP COMPLETED SUCCESSFULLY!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "🔧 Next Steps:" -ForegroundColor Yellow
Write-Host "1. If XAMPP Control Panel opened, start Apache and MySQL services" -ForegroundColor White
Write-Host "2. Open a new PowerShell window in the project folder" -ForegroundColor White
Write-Host "3. Run: " -NoNewline -ForegroundColor White
Write-Host "`$env:PATH += ';C:\xampp\php'; php artisan serve" -ForegroundColor Cyan
Write-Host "4. Open browser and go to: " -NoNewline -ForegroundColor White
Write-Host "http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host ""
Write-Host "👤 Login Credentials:" -ForegroundColor Yellow
Write-Host "Admin: admin@college.edu / password" -ForegroundColor White
Write-Host "HoD: cshead@college.edu / password" -ForegroundColor White
Write-Host "Faculty: faculty@college.edu / password" -ForegroundColor White
Write-Host ""
Write-Host "📚 Documentation:" -ForegroundColor Yellow
Write-Host "- Complete Guide: SETUP_GUIDE.md" -ForegroundColor White
Write-Host "- Quick Reference: QUICK_REFERENCE.md" -ForegroundColor White
Write-Host ""

# Ask if user wants to start the server now
$startNow = Read-Host "🚀 Would you like to start the Laravel server now? (y/N)"
if ($startNow -eq 'y' -or $startNow -eq 'Y') {
    Write-Host ""
    Write-Host "🌐 Starting Laravel development server..." -ForegroundColor Green
    Write-Host "Your application will be available at: http://127.0.0.1:8000" -ForegroundColor Cyan
    Write-Host "Press Ctrl+C to stop the server" -ForegroundColor Yellow
    Write-Host ""
    
    # Start the Laravel server
    php artisan serve
} else {
    Write-Host ""
    Write-Host "✅ Setup complete! Run the server manually when ready." -ForegroundColor Green
    Write-Host "Command: " -NoNewline -ForegroundColor White
    Write-Host "`$env:PATH += ';C:\xampp\php'; php artisan serve" -ForegroundColor Cyan
}

Write-Host ""
Write-Host "Thank you for using College Expenditure Monitoring System! 🎓" -ForegroundColor Green
