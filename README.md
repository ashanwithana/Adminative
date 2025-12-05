# Laravel 12 Admin Panel with Custom OTP Authentication

A comprehensive admin panel built with Laravel 12, featuring custom OTP-based authentication, role-based access control (RBAC), and modern UI with TailwindCSS.

## ✨ Features

- **Custom OTP Authentication** - Login/Register with Email or SMS OTP
- **Role-Based Access Control** - Dynamic permissions using Spatie Permission
- **Clean Architecture** - Repositories, Services, Actions, DTOs pattern
- **Activity Logging** - Track all admin actions with Spatie Activity Log
- **Laravel Telescope** - Monitor requests, queries, exceptions
- **Modern UI** - TailwindCSS with responsive design
- **Security** - CSRF protection, rate limiting, encryption

## 🚀 Quick Start

### Installation

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database (SQLite is default)
touch database/database.sqlite

# Run migrations and seed
php artisan migrate:fresh --seed

# Build assets
npm run build

# Start server
php artisan serve
```

Visit: http://localhost:8000

### Default Users

| Role | Email | Phone | Password |
|------|-------|-------|----------|
| **Admin** | admin@example.com | +1234567890 | password |
| **Manager** | manager@example.com | +1234567891 | password |
| **User** | user@example.com | +1234567892 | password |

**Note**: OTP codes are logged to `storage/logs/laravel.log` during development.

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite/MySQL/PostgreSQL

## 🏗️ Architecture

```
Clean Architecture Pattern:
- Controllers → Handle HTTP requests
- Services → Business logic
- Repositories → Data access
- Actions → Single-responsibility operations
- DTOs → Data transfer between layers
- Interfaces → Dependency contracts
```

## 🔐 OTP Authentication Flow

1. **Request OTP**: Enter email or phone → OTP sent
2. **Verify OTP**: Enter 6-digit code → Authenticated
3. **Security**: Hashed storage, 10-min expiry, 3 attempt limit

## 📁 Project Structure

```
app/
├── Actions/Auth/          # Login, Register, SendOtp actions
├── Contracts/             # Interfaces for Repositories & Services
├── DTOs/                  # Data Transfer Objects
├── Http/Controllers/
│   ├── Admin/             # Dashboard, Users, Roles, Logs
│   └── Auth/              # OTP Authentication
├── Repositories/          # Data access layer
├── Services/              # Business services (OTP, User, SMS)
└── Models/                # User, Otp

resources/views/
├── layouts/               # App, Guest layouts with Sidebar/Navbar
├── auth/                  # Login, Verify, Register
└── admin/                 # Dashboard, Users, Roles, Logs
```

## 🛡️ Permissions

**User Management**: view, create, edit, delete users
**Role Management**: view, create, edit, delete roles
**System**: view activity logs, access telescope

## 🧪 Testing

```bash
php artisan test
```

## 📝 Configuration

### Email (for OTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### SMS via Twilio (Optional)
```env
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_FROM=+1234567890
```

If Twilio not configured, SMS uses mock service (logs to Laravel log).

## 🔧 Commands

```bash
# Clear caches
php artisan optimize:clear

# Run queue worker
php artisan queue:work

# Code formatting
./vendor/bin/pint

# Cleanup expired OTPs (add to scheduler)
php artisan app:cleanup-otps
```

## 📱 Routes

### Authentication
- `GET /auth/login` - Login form
- `POST /auth/otp/send` - Send OTP
- `POST /auth/otp/verify` - Verify & login
- `GET /auth/register` - Registration
- `POST /auth/logout` - Logout

### Admin Panel
- `GET /admin/dashboard` - Dashboard
- `resource /admin/users` - User CRUD
- `resource /admin/roles` - Role CRUD
- `GET /admin/activity-logs` - Activity logs
- `GET /telescope` - System monitoring

## 🔒 Security Features

- ✅ CSRF protection on all forms
- ✅ Rate limiting (5 attempts/min on OTP)
- ✅ OTP hashing (SHA-256)
- ✅ Password hashing (Bcrypt)
- ✅ Session-based auth
- ✅ Middleware protection (auth, role, permission)
- ✅ Input validation (Form Requests)

## 🛠️ Troubleshooting

**OTP not received?**
- Check `storage/logs/laravel.log` for OTP codes
- Verify mail/SMS configuration in `.env`

**Permission errors?**
```bash
php artisan cache:clear
php artisan config:clear
```

**Reset database?**
```bash
php artisan migrate:fresh --seed
```

## 📦 Technologies

- Laravel 12
- Vite
- TailwindCSS
- Spatie Laravel Permission
- Spatie Laravel Activity Log
- Laravel Telescope
- Twilio SDK

## 📄 License

MIT License

---

**Author**: Built with ❤️ using Laravel 12
**Date**: November 2025
