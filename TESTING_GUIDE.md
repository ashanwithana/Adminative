# 🧪 Testing Guide - Laravel Admin Panel

## Server Status ✅

**Server is running at:** http://127.0.0.1:8000

The application is now live and accessible!

## 🔐 Test User Credentials

Use these credentials to test the application:

### Admin User
- **Email:** admin@example.com
- **Phone:** +1234567890
- **Password:** password
- **Access:** Full system access

### Manager User
- **Email:** manager@example.com
- **Phone:** +1234567891  
- **Password:** password
- **Access:** User management, view roles

### Regular User
- **Email:** user@example.com
- **Phone:** +1234567892
- **Password:** password
- **Access:** Basic access

## 📋 Testing Checklist

### 1. OTP Authentication Flow

#### Test Login:
1. Visit http://127.0.0.1:8000
2. Enter: `admin@example.com` (or phone number)
3. Click "Send OTP"
4. Check `storage/logs/laravel.log` for the OTP code
5. Enter the 6-digit code
6. Should redirect to dashboard

**OTP Location:**
```bash
tail -f storage/logs/laravel.log
# Look for: "MOCK SMS" or OTP notification entries
```

#### Test Registration:
1. Visit http://127.0.0.1:8000/auth/register
2. Fill in the form
3. Request OTP for email
4. Check logs for OTP code
5. Enter OTP and complete registration

### 2. Admin Panel Features

#### Dashboard (http://127.0.0.1:8000/admin/dashboard)
- ✅ View user statistics
- ✅ View active users count
- ✅ View total roles
- ✅ See recent activity

#### User Management (http://127.0.0.1:8000/admin/users)
- ✅ List all users
- ✅ Search users
- ✅ Create new user
- ✅ Edit user
- ✅ Delete user
- ✅ View user details

#### Role Management (http://127.0.0.1:8000/admin/roles)
- ✅ List all roles
- ✅ View role permissions
- ✅ Create new role (Admin only)
- ✅ Edit role (Admin only)
- ✅ Delete role (Admin only)

#### Activity Logs (http://127.0.0.1:8000/admin/activity-logs)
- ✅ View all activities
- ✅ Filter by user
- ✅ Filter by date
- ✅ Search descriptions

### 3. Permission Testing

Login as different users to test permissions:

**As Admin:**
- Can access everything
- Can create/edit/delete users
- Can create/edit/delete roles
- Can access Telescope

**As Manager:**
- Can view/create/edit users
- Can view roles (cannot edit)
- Can view activity logs
- Cannot access Telescope

**As User:**
- Can only access dashboard
- Limited menu items
- Cannot manage users or roles

### 4. Security Features

#### Rate Limiting:
Try sending OTP 6+ times quickly:
- Should get rate limit error

#### OTP Expiration:
1. Request OTP
2. Wait 11+ minutes
3. Try to verify
4. Should fail (expired)

#### Invalid OTP:
Enter wrong code 4 times:
- Should lock after 3 attempts

#### Session Security:
1. Login
2. Delete cookies
3. Try to access admin panel
4. Should redirect to login

### 5. System Monitoring

#### Telescope (Admin only)
- Visit: http://127.0.0.1:8000/telescope
- View requests, queries, exceptions
- Monitor performance

#### Activity Logs
All actions should be logged:
- User login
- User creation
- Role assignment
- User updates
- User deletion

## 🐛 Common Issues & Solutions

### Issue: OTP Not Appearing in Logs
**Solution:**
```bash
# Check mail driver is set to 'log'
grep MAIL_MAILER .env
# Should show: MAIL_MAILER=log

# View logs
tail -100 storage/logs/laravel.log
```

### Issue: Permission Denied
**Solution:**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear

# Re-seed if needed
php artisan db:seed --class=RolePermissionSeeder
```

### Issue: Server Not Running
**Solution:**
```bash
# Check if running
lsof -i :8000

# Restart server
php artisan serve
```

### Issue: CSS Not Loading
**Solution:**
```bash
# Rebuild assets
npm run build

# Or for dev with hot reload
npm run dev
```

### Issue: Database Errors
**Solution:**
```bash
# Reset database
php artisan migrate:fresh --seed
```

## 📊 Expected Behavior

### On First Visit
1. Should redirect to `/auth/login`
2. Show clean login form
3. Accept email OR phone number

### After Login
1. Redirect to `/admin/dashboard`
2. Show sidebar with navigation
3. Display user stats
4. Show recent activity

### User Creation
1. Form validation works
2. Email/phone uniqueness enforced
3. Password hashed
4. Role assigned
5. Activity logged

### Logout
1. Click logout in navbar
2. Session destroyed
3. Redirect to login
4. Cannot access admin pages

## 🎯 Quick Test Script

Run these commands to verify everything:

```bash
# 1. Check server is running
curl -I http://127.0.0.1:8000

# 2. Verify routes exist
php artisan route:list | grep admin

# 3. Check database has data
php artisan tinker
>>> User::count()
>>> Role::count()
>>> Permission::count()

# 4. View latest activity
>>> Activity::latest()->first()

# 5. Check OTP table
>>> Otp::count()
```

## ✅ Success Criteria

The application is working correctly if:

1. ✅ Server responds at http://127.0.0.1:8000
2. ✅ Login page loads without errors
3. ✅ OTP can be sent and logged
4. ✅ Login with test credentials works
5. ✅ Dashboard displays correctly
6. ✅ Sidebar shows appropriate menu items
7. ✅ User list loads
8. ✅ Role list loads
9. ✅ Activity logs show entries
10. ✅ Logout works properly

## 🚀 Production Checklist

Before deploying to production:

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure real SMTP server
- [ ] Configure Twilio credentials
- [ ] Use MySQL/PostgreSQL instead of SQLite
- [ ] Set up queue worker for emails
- [ ] Configure session driver (redis/database)
- [ ] Set up proper logging
- [ ] Enable HTTPS
- [ ] Configure CORS if needed

## 📞 Support

If you encounter any issues:

1. Check `storage/logs/laravel.log` for errors
2. Run `php artisan optimize:clear`
3. Verify database is seeded: `php artisan db:seed`
4. Check routes: `php artisan route:list`

---

**Application Status:** ✅ RUNNING
**URL:** http://127.0.0.1:8000
**Status:** Ready for testing!
