# 🚀 ShopEase cPanel Deployment Guide

## 📋 Prerequisites
- cPanel access with your hosting provider
- Domain name pointing to your hosting
- PHP 8.2+ support
- MySQL/MariaDB database access
- **Note**: This guide is designed for cPanel without Terminal/SSH access

## 🔧 Step 1: Prepare Your Hosting Environment

### 1.1 Check PHP Version
- Login to cPanel
- Go to **Software** → **PHP Selector**
- Ensure PHP 8.2+ is selected
- Enable required extensions:
  - `fileinfo`
  - `openssl`
  - `pdo_mysql`
  - `mbstring`
  - `tokenizer`
  - `xml`
  - `ctype`
  - `json`

### 1.2 Database Setup (SQLite - No Database Server Required!)
**Great news!** ShopEase uses SQLite, which means:
- ✅ **No database server setup needed**
- ✅ **No MySQL/MariaDB required**
- ✅ **Database file is included in the package**
- ✅ **Much simpler deployment process**

**What you need to know:**
- The SQLite database file (`database.sqlite`) is already included
- It contains sample data: 4 users, 9 products, 86 categories, 38 brands
- Default admin login: `admin@shopease.com` / `password`
- Default user login: `user@shopease.com` / `password`

## 📁 Step 2: Upload Files to cPanel

### 2.1 Upload via File Manager
- Go to **Files** → **File Manager**
- Navigate to `public_html` (or your domain's root directory)
- **IMPORTANT**: Upload files to a subdirectory, NOT directly to public_html

### 2.2 Upload via FTP (Recommended)
- Use FileZilla or similar FTP client
- Connect to your hosting via FTP
- Upload the entire `deployment-package` folder to your domain root
- Rename it to your preferred name (e.g., `shop-ease`)

## ⚙️ Step 3: Configure Environment

### 3.1 Create .env File
Create a `.env` file in your project root with:

```env
APP_NAME="ShopEase"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# SQLite Database Configuration (Much Simpler!)
DB_CONNECTION=sqlite
# No need for DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# The SQLite file is already included in the package

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=your_mail_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 3.2 Generate Application Key
Since your cPanel doesn't support Terminal/SSH, you'll need to generate the key manually:

**Option 1: Use Online Generator**
- Visit: https://laravel-key-generator.com/
- Generate a 32-character random string
- Copy the generated key

**Option 2: Manual Generation**
- Create a random 32-character string using letters and numbers
- Example: `base64:AbCdEfGhIjKlMnOpQrStUvWxYz1234567890=`

**Option 3: Use Local Development**
- If you have Laravel installed locally, run: `php artisan key:generate`
- Copy the key from your local `.env` file

## 🗄️ Step 4: Database Setup (SQLite - Already Ready!)

### 4.1 Database Status
**Excellent news!** Your database is already set up:

✅ **Database file included**: `database/database.sqlite` (324KB)
✅ **Sample data ready**: 4 users, 9 products, 86 categories, 38 brands
✅ **No migrations needed**: All database structure is already created
✅ **No seeding required**: Sample data is already populated

**Default login credentials:**
- **Admin**: `admin@shopease.com` / `password`
- **User**: `user@shopease.com` / `password`

**What this means for you:**
- **No database setup required**
- **No MySQL/MariaDB needed**
- **No phpMyAdmin required**
- **Much simpler deployment process**

### 4.2 Seed Database (Optional)
**Not needed!** Your database is already seeded with sample data:

✅ **Sample data included**: 4 users, 9 products, 86 categories, 38 brands
✅ **Admin user ready**: `admin@shopease.com` / `password`
✅ **Test user ready**: `user@shopease.com` / `password`
✅ **Products ready**: 9 sample products with full attributes
✅ **Categories ready**: 86 product categories
✅ **Brands ready**: 38 product brands

**You can start using the application immediately!**

## 🔐 Step 5: Set Permissions

### 5.1 Set Directory Permissions
Set these permissions via cPanel File Manager:

**Using File Manager:**
1. Go to **Files** → **File Manager**
2. Navigate to your project folder
3. Right-click on each folder and select **Change Permissions**
4. Set these permissions:
   - `storage/` → **755** (rwxr-xr-x)
   - `bootstrap/cache/` → **755** (rwxr-xr-x)
   - `storage/logs/` → **644** (rw-r--r--)
   - `storage/framework/cache/` → **644** (rw-r--r--)
   - `storage/framework/sessions/` → **644** (rw-r--r--)
   - `storage/framework/views/` → **644** (rw-r--r--)

### 5.2 Storage Setup (Already Done!)
**Great news!** The storage files are already set up:

✅ **Storage files already copied**: All product images are in `public/storage/products/`
✅ **46 product images ready**: Product photos are accessible via web
✅ **No manual copying needed**: Everything is already in place

**What this means for you:**
- **No storage setup required**
- **Product images will display correctly**
- **File uploads will work immediately**
- **One less step to worry about**

## 🌐 Step 6: Configure Web Server

### 6.1 Create .htaccess in Root
Create `.htaccess` in your project root (not public folder):

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 6.2 Update public/.htaccess
Ensure your `public/.htaccess` contains:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 🚀 Step 7: Final Configuration

### 7.1 Clear Caches
Since you can't run artisan commands, the caches are already built into your deployment package:

✅ **Config Cache**: Already cached in `bootstrap/cache/config.php`
✅ **Route Cache**: Already cached in `bootstrap/cache/routes-v7.php`
✅ **View Cache**: Already cached in `bootstrap/cache/views/`

### 7.2 Set Production Mode
Your application is already configured for production:
- `APP_ENV=production` in your .env file
- `APP_DEBUG=false` for security
- All caches are pre-built and optimized

## 🔍 Step 8: Testing

### 8.1 Test Your Application
- Visit: `https://yourdomain.com`
- Test admin login: `https://yourdomain.com/login`
- Test product pages
- Check for any errors in browser console

### 8.2 Check Error Logs
- Check Laravel logs: `storage/logs/laravel.log`
- Check cPanel error logs
- Check browser console for JavaScript errors

## 🛠️ Troubleshooting

### Common Issues:

#### 1. 500 Internal Server Error
- Check file permissions
- Verify .env file exists
- Check PHP version compatibility
- Review error logs

#### 2. Database Connection Error
- Verify database credentials in .env
- Check database host (usually `localhost`)
- Ensure database exists and user has privileges

#### 3. File Upload Issues
- Check storage directory permissions
- Verify storage symlink exists
- Check file size limits in PHP settings

#### 4. CSS/JS Not Loading
- Check file paths in views
- Verify asset compilation
- Check browser console for 404 errors

## 📱 Mobile Responsiveness

Your application is already optimized for mobile with:
- **2-column product grid** on mobile (Jumia-style)
- **Mobile-first responsive design**
- **Touch-friendly interface**
- **Optimized typography for small screens**

## 🔒 Security Considerations

- Set `APP_DEBUG=false` in production
- Use HTTPS for all communications
- Regularly update dependencies
- Monitor error logs
- Use strong database passwords
- Enable firewall protection

## 📞 Support

If you encounter issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check cPanel error logs (in cPanel → **Logs** → **Error Logs**)
3. Verify all file permissions via File Manager
4. Ensure PHP version compatibility in PHP Selector
5. Test database connectivity in phpMyAdmin

## 🚫 **Important: No Terminal/SSH Access**

Since your cPanel doesn't support Terminal or SSH, remember:

### **What You CAN'T Do:**
- ❌ Run `php artisan` commands
- ❌ Use command line tools
- ❌ Execute shell scripts
- ❌ Use Git commands

### **What You CAN Do:**
- ✅ Use File Manager for file operations
- ✅ Use phpMyAdmin for database management
- ✅ Set permissions via File Manager
- ✅ Upload files via FTP or File Manager
- ✅ Configure PHP settings via PHP Selector
- ✅ Manage databases via MySQL Databases

### **Alternative Solutions:**
- **Database Setup**: Import existing database or create manually
- **Storage Symlink**: Copy files manually or contact hosting support
- **Permissions**: Set via File Manager right-click menu
- **Caching**: Already built into your deployment package

## 🎉 Success!

Once deployed, your ShopEase application will be:
- ✅ Fully responsive on all devices
- ✅ Mobile-optimized with 2-column product grid
- ✅ Professional admin dashboard
- ✅ Complete ecommerce functionality
- ✅ Secure and production-ready

**Happy selling with ShopEase! 🚀**
