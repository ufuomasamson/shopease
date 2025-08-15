# 🚀 ShopEase cPanel Deployment (No Terminal/SSH)

## ⚠️ **Important Notice**
This guide is specifically designed for cPanel hosting that **does NOT support Terminal or SSH access**.

## 📋 What You Need
- cPanel access with your hosting provider
- Domain name pointing to your hosting
- PHP 8.2+ support
- MySQL/MariaDB database access

## 🚀 **Step-by-Step Deployment (No Terminal Required)**

### **Step 1: Prepare Your Hosting**
1. **Login to cPanel**
2. **Check PHP Version**: Go to **Software** → **PHP Selector**
   - Select PHP 8.2 or higher
   - Enable these extensions: `fileinfo`, `openssl`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`

### **Step 2: Database Setup (SQLite - No Database Server Required!)**
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

### **Step 3: Upload Files**
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

### **Step 4: Configure Environment**
1. **Create .env File**
   - In File Manager, go to your project folder
   - Create a new file called `.env`
   - Copy this content and update with your details:

```env
APP_NAME="ShopEase"
APP_ENV=production
APP_KEY=base64:AbCdEfGhIjKlMnOpQrStUvWxYz1234567890=
APP_DEBUG=false
APP_URL=https://yourdomain.com

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
```

2. **Generate Application Key**
   - Visit: https://laravel-key-generator.com/
   - Generate a new key
   - Replace the example key in your .env file

### **Step 5: Database Setup (SQLite - Already Ready!)**
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

✅ **Storage files already copied**: All product images are in `public/storage/products/`
✅ **46 product images ready**: Product photos are accessible via web
✅ **No manual copying needed**: Everything is already in place

**What this means for you:**
- **No storage setup required**
- **Product images will display correctly**
- **File uploads will work immediately**
- **One less step to worry about**

### **Step 8: Test Your Application**
1. **Visit your domain**
2. **Check for errors** in browser console
3. **Test admin login** at `/login`
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

- [ ] Website loads without errors
- [ ] Database connection works
- [ ] Admin login functional
- [ ] Products display correctly
- [ ] Mobile shows 2 columns
- [ ] File uploads work
- [ ] All features operational

## 🆘 **Need Help?**

1. **Check cPanel Error Logs**: **Logs** → **Error Logs**
2. **Verify File Permissions**: Use File Manager
3. **Check Database**: Use phpMyAdmin
4. **Contact Hosting Support**: Ask about Laravel deployment
5. **Review Laravel Logs**: Check `storage/logs/laravel.log`

## 🎉 **You're Ready!**

Your ShopEase application is designed to work without Terminal/SSH access. All caches are pre-built, and the guide provides alternative methods for every step that normally requires command line access.

**Happy deploying! 🚀**
