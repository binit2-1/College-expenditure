# 🚀 Quick Reference Card

## 🎯 SUPER EASY SETUP & START

### � First Time Setup (Automated)
**Just double-click**: `SETUP.bat`
- This will install EVERYTHING automatically!
- No need to type any commands
- Installs XAMPP, Node.js, Git, and all dependencies
- Sets up database and builds the application

### 🚀 Daily Startup (After Setup)
**Just double-click**: `START.bat`
- This starts the application instantly!
- No need to remember commands
- Opens the server automatically

## 🔄 Manual Daily Startup (If you prefer commands)

1. **Open XAMPP Control Panel** → Start Apache & MySQL
2. **Open PowerShell** → Navigate to project folder:
   ```powershell
   cd "C:\Users\[YourName]\Desktop\College-expenditure"
   ```
3. **Set PHP Path**:
   ```powershell
   $env:PATH += ";C:\xampp\php"
   ```
4. **Start Server**:
   ```powershell
   php artisan serve
   ```
5. **Open Browser** → http://127.0.0.1:8000

## 👤 Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@college.edu | password |
| HoD | cshead@college.edu | password |
| Faculty | faculty@college.edu | password |

## 🛠️ Common Commands

### Database Reset
```powershell
php artisan migrate:fresh --seed
```

### Clear Cache
```powershell
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Rebuild Assets
```powershell
npm run build
```

### Different Port
```powershell
php artisan serve --port=8001
```

## 🔧 Troubleshooting

### "php is not recognized"
```powershell
$env:PATH += ";C:\xampp\php"
```

### Git Error with public/storage
```powershell
Remove-Item public/storage -Force
php artisan storage:link
```

### Database Issues
1. Check XAMPP MySQL is running (green)
2. Reset database: `php artisan migrate:fresh --seed`

### Frontend Issues
```powershell
npm install
npm run build
```

### Port Already in Use
```powershell
php artisan serve --port=8001
```

## 📁 Important Files

- **Environment**: `.env`
- **Routes**: `routes/web.php`
- **Database**: `database/database.sqlite`
- **Views**: `resources/views/`
- **Controllers**: `app/Http/Controllers/`

## 🚪 Application URLs

- **Home**: http://127.0.0.1:8000
- **Login**: http://127.0.0.1:8000/login
- **Expenditures**: http://127.0.0.1:8000/expenditures
- **UC Generator**: http://127.0.0.1:8000/uc
- **Reports**: http://127.0.0.1:8000/reports

## 🎯 Quick Actions by Role

### Faculty
1. Login → Dashboard
2. Click "Add Expenditure"
3. Fill form → Submit
4. Check approval status

### Department Head
1. Login → View pending approvals
2. Click expenditure → Review
3. Approve/Reject with notes

### Admin
1. Login → See all expenditures
2. Final approval on HoD-approved items
3. Generate UCs for approved expenses
4. View reports and analytics

## 🔄 Workflow

```
Faculty Submit → HoD Review → Admin Final → UC Generation
```

## 💾 Backup Important Data

**Database**:
```powershell
copy database\database.sqlite database\backup_database.sqlite
```

**Environment**:
```powershell
copy .env .env.backup
```

---

**💡 Tip**: Bookmark this page for quick reference!
