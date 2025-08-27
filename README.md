# 🏫 College Expenditure Monitoring & UC Generator

A comprehensive web application for colleges to manage expenditures, handle multi-level approvals, and generate utilization certificates.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![Node.js](https://img.shields.io/badge/Node.js-18+-green.svg)

## 🚀 Quick Start

**👆 For complete setup instructions, see [SETUP_GUIDE.md](SETUP_GUIDE.md)**

## ✨ Features

- **Multi-Role System**: Admin, Principal, Finance Officer, Department Head, Faculty
- **Multi-Level Approval Workflow**: Faculty → HoD → Admin approval process
- **Expenditure Management**: Add, track, and categorize expenses
- **UC Generation**: Create utilization certificates for approved expenditures
- **Reports & Analytics**: View spending patterns and generate reports
- **Modern UI**: Built with Tailwind CSS and DaisyUI
- **Responsive Design**: Works on desktop, tablet, and mobile

## 🏗️ System Architecture

### User Roles & Permissions

| Role | Permissions |
|------|-------------|
| **Faculty** | Submit expenditures for approval |
| **Department Head** | Approve/reject expenditures from their department |
| **Admin/Principal/Finance** | Final approval, generate UCs, view all data |

### Approval Workflow

```
Faculty Submission → HoD Approval → Admin Final Approval → UC Generation
```

## 🛠️ Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templates, Tailwind CSS, DaisyUI
- **Database**: SQLite (development) / MySQL (production)
- **Build Tools**: Vite, NPM
- **PHP Version**: 8.2+

## 📱 Application Screenshots

### Dashboard
- Overview of total expenditures
- Pending approvals count
- Quick action buttons
- Recent activity feed

### Expenditure Management
- Add new expenditures with categories
- Track approval status
- View expenditure history
- Multi-level approval interface

### UC Generation
- Select approved expenditures
- Generate utilization certificates
- Download as PDF (coming soon)
- Track UC history

## 🔧 Development Setup

### Prerequisites
- XAMPP (PHP 8.2+ & MySQL)
- Node.js 18+
- Composer

### Installation
```bash
# Clone repository
git clone <repository-url>
cd College-expenditure

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run build

# Start development server
php artisan serve
```

## 📊 Database Schema

### Key Tables
- **users**: System users with roles and departments
- **expenditures**: Expense records with approval tracking
- **utilisation_certificates**: UC documents
- **uc_expenditures**: Links UCs to expenditures

### Relationships
- One-to-Many: User → Expenditures
- Many-to-Many: UCs ↔ Expenditures
- Foreign Keys: Approval tracking references

## 🔐 Security Features

- **Authentication**: Laravel Sanctum
- **Authorization**: Role-based access control
- **CSRF Protection**: Built-in Laravel protection
- **Input Validation**: Server-side validation for all forms
- **Database Security**: Prepared statements, proper escaping

## 📈 Performance Features

- **Database Indexing**: Optimized queries
- **Asset Compilation**: Minified CSS/JS
- **Caching**: Laravel cache for improved performance
- **Lazy Loading**: Efficient data loading

## 🧪 Testing

```bash
# Run tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

## 📖 API Documentation

### Key Endpoints
- `GET /` - Dashboard
- `GET /expenditures` - Expenditure list
- `POST /expenditures` - Create expenditure
- `PATCH /expenditures/{id}/approve` - Approve expenditure
- `GET /uc` - UC management
- `POST /uc/generate` - Generate UC

## 🚀 Deployment

### Production Setup
1. Use MySQL instead of SQLite
2. Set `APP_ENV=production` in `.env`
3. Run `php artisan config:cache`
4. Set up proper web server (Apache/Nginx)
5. Configure SSL certificates

### Environment Variables
```env
APP_NAME="College Expenditure Monitoring & UC Generator"
APP_ENV=production
APP_URL=https://yourdomain.com
DB_CONNECTION=mysql
DB_DATABASE=college_expense_tracker
```

## 📞 Support & Documentation

- **Setup Guide**: [SETUP_GUIDE.md](SETUP_GUIDE.md)
- **User Manual**: Available in application under "Guide"
- **API Documentation**: Coming soon

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Development Team** - Initial work and ongoing maintenance

## 🙏 Acknowledgments

- Laravel Framework team
- Tailwind CSS team
- DaisyUI components
- PHP community

---

**🎯 Ready to get started? Check out the [SETUP_GUIDE.md](SETUP_GUIDE.md) for complete installation instructions!**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
