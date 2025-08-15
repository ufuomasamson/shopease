# 🚀 ShopEase MySQL Deployment Guide for cPanel

## ⚠️ **Important Notice**
This guide is specifically designed for cPanel hosting that **does NOT support Terminal or SSH access**.

## 🔍 **Why MySQL Instead of SQLite?**

Your hosting provider doesn't have SQLite PHP extension enabled, so we're switching to MySQL/MariaDB, which is:
- ✅ **Widely supported** by most hosting providers
- ✅ **More powerful** for ecommerce applications
- ✅ **Better performance** for multiple users
- ✅ **Standard** for shared hosting

## 📋 What You Need
- cPanel access with your hosting provider
- Domain name pointing to your hosting
- PHP 8.2+ support
- MySQL/MariaDB database access (usually included with cPanel)

## 🚀 **Step-by-Step Deployment (No Terminal Required)**

### **Step 1: Prepare Your Hosting**
1. **Login to cPanel**
2. **Check PHP Version**: Go to **Software** → **PHP Selector**
   - Select PHP 8.2 or higher
   - Enable these extensions: `fileinfo`, `openssl`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`

### **Step 2: Create MySQL Database**
1. **Go to cPanel** → **MySQL Databases**
2. **Create a new database**:
   - Database name: `shop_ease_db` (or your preferred name)
   - Click **Create Database**
3. **Create a database user**:
   - Username: `shop_ease_user` (or your preferred username)
   - Password: Create a strong password
   - Click **Create User**
4. **Add user to database**:
   - Select your database and user
   - Check **ALL PRIVILEGES**
   - Click **Add**
5. **Note down these details**:
   - Database name: `yourusername_shop_ease_db`
   - Username: `yourusername_shop_ease_user`
   - Password: `your_password`
   - Host: Usually `localhost`

### **Step 3: Import Database Structure**
1. **Go to cPanel** → **phpMyAdmin**
2. **Select your database** from the left sidebar
3. **Click the "SQL" tab**
4. **Copy and paste** the entire content of `database/shop_ease_mysql.sql`
5. **Click "Go"** to execute the SQL
6. **Verify** that all tables were created successfully

### **Step 4: Upload Files**
1. **Option A: File Manager**
   - Go to **Files** → **File Manager**
   - Navigate to your domain root (usually `public_html`)
   - Upload the extracted `deployment-package` folder
   - Rename it to your preferred name (e.g., `shop-ease`)

2. **Option B: FTP (Recommended)**
   - Use FileZilla or similar FTP client
   - Connect to your hosting via FTP
   - Upload the entire `deployment-package` folder
   - Rename it to your preferred name

### **Step 5: Configure Environment**
1. **Create .env File**
   - In File Manager, go to your project folder
   - Create a new file called `.env`
   - Copy this content and update with your details:

```env
APP_NAME="ShopEase"
APP_ENV=production
APP_KEY=base64:AbCdEfGhIjKlMnOpQrStUvWxYz1234567890=
APP_DEBUG=false
APP_URL=https://shop.ublive.online

# MySQL Database Configuration
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yourusername_shop_ease_db
DB_USERNAME=yourusername_shop_ease_user
DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

2. **Generate Application Key**
   - Visit: https://laravel-key-generator.com/
   - Generate a new key
   - Replace the example key in your .env file

### **Step 6: Set Permissions**
1. **Using File Manager**
   - Right-click on each folder and select **Change Permissions**
   - Set these permissions:
     - `storage/` → **755**
     - `bootstrap/cache/` → **755**
     - `storage/logs/` → **644**
     - `storage/framework/cache/` → **644**
     - `storage/framework/sessions/` → **644**
     - `storage/framework/views/` → **644**

### **Step 7: Handle Storage (Already Done!)**
**Great news!** The storage files are already set up:
- ✅ **Storage files already copied**: All product images are in `public/storage/products/`
- ✅ **46 product images ready**: Product photos are accessible via web
- ✅ **No manual copying needed**: Everything is already in place

### **Step 8: Test Your Application**
1. **Visit your domain**
2. **Check for errors** in browser console
3. **Test admin login** at `/login` with:
   - Email: `admin@shopease.com`
   - Password: `password`
4. **Verify mobile responsiveness** (should show 2-column grid)
5. **Check all features** work correctly

## 🔧 **Troubleshooting (No Terminal)**

### **500 Internal Server Error**
- Check file permissions via File Manager
- Verify .env file exists and is correct
- Check PHP version compatibility
- Review cPanel error logs

### **Database Connection Error**
- Verify database credentials in .env
- Check database exists in phpMyAdmin
- Ensure user has full privileges
- Verify database host is correct

### **File Upload Issues**
- Check storage directory permissions
- Verify storage folder exists in public/
- Check file size limits in PHP settings

### **CSS/JS Not Loading**
- Check file paths in views
- Verify all files uploaded correctly
- Check browser console for 404 errors

## 📱 **Mobile Features Included**

Your deployment package already includes:
- ✅ **2-column product grid on mobile** (Jumia-style)
- ✅ **Mobile-first responsive design**
- ✅ **Touch-friendly interface**
- ✅ **Optimized typography**

## 🎯 **Success Checklist**

- [ ] MySQL database created and user assigned
- [ ] Database structure imported via phpMyAdmin
- [ ] Files uploaded via File Manager or FTP
- [ ] .env file created with MySQL credentials
- [ ] Application key generated and set
- [ ] Permissions set via File Manager
- [ ] Website loads without errors
- [ ] Admin login works: admin@shopease.com / password
- [ ] Mobile shows 2-column product grid
- [ ] All features operational

## 🆘 **Need Help?**

1. **Check cPanel Error Logs**: **Logs** → **Error Logs**
2. **Verify File Permissions**: Use File Manager
3. **Check Database**: Use phpMyAdmin
4. **Contact Hosting Support**: Ask about Laravel + MySQL deployment
5. **Review Laravel Logs**: Check `storage/logs/laravel.log`

## 🎉 **You're Ready!**

Your ShopEase application is now configured for MySQL and will work perfectly on your hosting environment. The deployment package includes:

- **Pre-built caches** (no artisan commands needed)
- **MySQL database structure** with sample data
- **File Manager instructions** for every step
- **Manual permission setting** via cPanel
- **Complete ecommerce functionality**

## 💡 **Pro Tips for MySQL Setup**

- **Use phpMyAdmin** for database management
- **Test database connection** before proceeding
- **Backup your database** regularly
- **Use strong passwords** for database users
- **Check PHP extensions** in PHP Selector

**Happy deploying with MySQL! 🚀**
