# 🏫 College Expenditure Monitoring & UC Generator - Complete Setup Guide

## 📋 What This Application Does
This is a web application for colleges to:
- Track and manage expenditures (expenses)
- Handle multi-level approvals (Faculty → Department Head → Admin)
- Generate Utilization Certificates (UCs)
- Create reports and analytics
- Manage different user roles (Admin, HoD, Faculty)

---

## 🖥️ Complete Setup Instructions for Windows

### ⚠️ IMPORTANT: Follow these steps EXACTLY as written. Don't skip any step!

---

## 📂 Step 1: Download the Application

1. **Download this project** to your computer
2. **Extract/Unzip** the files to your Desktop
3. You should have a folder like `C:\Users\[YourName]\Desktop\College-expenditure`

---

## 🛠️ Step 2: Install Required Software

### 2.1 Install XAMPP (Includes PHP and Database)

1. **Open your web browser** and go to: https://www.apachefriends.org/
2. **Click "Download"** and download XAMPP for Windows
3. **Run the installer** and install with default settings
4. **Install to**: `C:\xampp` (default location)
5. **Check all components** during installation (Apache, MySQL, PHP)

### 2.2 Install Node.js (For Frontend)

1. **Go to**: https://nodejs.org/
2. **Download the LTS version** (the green button)
3. **Run the installer** with default settings
4. **Restart your computer** after installation

### 2.3 Install Git (For Version Control)

1. **Go to**: https://git-scm.com/download/win
2. **Download and install** with default settings

---

## 💻 Step 3: Open Command Prompt/PowerShell

1. **Press Windows Key + R**
2. **Type**: `powershell`
3. **Press Enter**
4. **Navigate to your project folder**:
   ```powershell
   cd "C:\Users\[YourName]\Desktop\College-expenditure"
   ```
   (Replace `[YourName]` with your actual username)

---

## 🔧 Step 4: Install Composer (PHP Package Manager)

**Copy and paste these commands one by one into PowerShell:**

```powershell
# Download Composer installer
Invoke-WebRequest -Uri https://getcomposer.org/installer -OutFile composer-setup.php

# Add PHP to PATH for this session
$env:PATH += ";C:\xampp\php"

# Install Composer
php composer-setup.php --install-dir=. --filename=composer

# Install PHP dependencies
php composer install
```

**Wait for each command to complete before running the next one!**

---

## 🗄️ Step 5: Database Setup

### 5.1 Start XAMPP

1. **Go to**: `C:\xampp`
2. **Double-click**: `xampp-control.exe`
3. **Click "Start"** next to Apache
4. **Click "Start"** next to MySQL
5. **Keep XAMPP Control Panel open**

### 5.2 Setup Application Database

**In your PowerShell window (make sure you're in the project folder), run:**

```powershell
# Generate application key
php artisan key:generate

# Create database file (we're using SQLite for simplicity)
New-Item -Path "database\database.sqlite" -ItemType File -Force

# Run database migrations
php artisan migrate

# Add sample users to database
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=TestUsersSeeder
```

---

## 🎨 Step 6: Install Frontend Dependencies

**In the same PowerShell window, run:**

```powershell
# Install Node.js packages
npm install

# Build frontend assets
npm run build
```

---

## 🚀 Step 7: Start the Application

**Run this command in PowerShell:**

```powershell
php artisan serve
```

**You should see**: `Server running on [http://127.0.0.1:8000]`

**🎉 Your application is now running!**

---

## 🌐 Step 8: Access Your Application

1. **Open your web browser**
2. **Go to**: http://127.0.0.1:8000
3. **You should see the login page**

---

## 👤 Step 9: Login Credentials

Use these credentials to login:

| Role | Email | Password | What they can do |
|------|-------|----------|------------------|
| **Admin** | admin@college.edu | password | Everything - approve all expenses, generate UCs |
| **Department Head** | cshead@college.edu | password | Approve expenses from their department |
| **Faculty** | faculty@college.edu | password | Submit expenses for approval |

---

## 📱 Step 10: Using the Application

### For Faculty:
1. **Login** with faculty credentials
2. **Click "Add Expenditure"** to submit new expenses
3. **View your submissions** on the dashboard

### For Department Heads:
1. **Login** with HoD credentials
2. **Review pending expenses** from your department
3. **Approve or reject** submissions

### For Admins:
1. **Login** with admin credentials
2. **See all expenses** across departments
3. **Generate UCs** for approved expenses
4. **View reports** and analytics

---

## 🔧 Troubleshooting

### Problem: "php is not recognized"
**Solution**: Run this command first:
```powershell
$env:PATH += ";C:\xampp\php"
```

### Problem: "Port 8000 is already in use"
**Solution**: Use a different port:
```powershell
php artisan serve --port=8001
```
Then go to: http://127.0.0.1:8001

### Problem: Database errors
**Solution**: Make sure XAMPP MySQL is running, then run:
```powershell
php artisan migrate:fresh --seed
```

### Problem: Frontend looks broken
**Solution**: Run:
```powershell
npm run build
```

### Problem: Can't login
**Solution**: Reset the database:
```powershell
php artisan migrate:fresh --seed
```

---

## 🔄 Daily Usage

### To Start the Application (After Setup):

1. **Open XAMPP Control Panel** → Start Apache & MySQL
2. **Open PowerShell** → Navigate to project folder
3. **Run**: 
   ```powershell
   $env:PATH += ";C:\xampp\php"
   php artisan serve
   ```
4. **Open browser** → Go to http://127.0.0.1:8000

### To Stop the Application:

1. **Press Ctrl+C** in PowerShell to stop the server
2. **Close XAMPP** or stop Apache & MySQL

---

## 📞 Support

If you encounter any issues:

1. **Make sure XAMPP is running** (Apache & MySQL should be green)
2. **Check the PowerShell window** for error messages
3. **Try the troubleshooting steps** above
4. **Restart your computer** and try again

---

## 🏗️ System Requirements

- **Windows 10 or 11**
- **At least 4GB RAM**
- **2GB free disk space**
- **Internet connection** (for initial setup only)

---

## 📊 Application Features

✅ **User Management** - Multiple roles and permissions  
✅ **Expense Tracking** - Add, edit, view expenses  
✅ **Multi-level Approval** - Faculty → HoD → Admin workflow  
✅ **UC Generation** - Create utilization certificates  
✅ **Reports & Analytics** - View spending patterns  
✅ **Modern Interface** - Clean, responsive design  

---

## 🔒 Security Notes

- **Change default passwords** in production
- **Keep XAMPP updated** for security
- **Backup your database** regularly
- **Don't expose this to the internet** without proper security setup

---

**🎯 That's it! You now have a fully functional College Expenditure Management System running on your Windows computer!**
