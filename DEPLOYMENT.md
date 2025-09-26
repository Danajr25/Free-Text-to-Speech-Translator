# Deployment Guide for Text-to-Speech Translator

This guide provides instructions for deploying your Laravel text-to-speech translation app to a production server.

## Prerequisites

- PHP 8.0+ with required extensions (mbstring, xml, fileinfo, curl, etc.)
- MySQL 5.7+ or MariaDB 10.2+
- Composer
- Web server (Apache or Nginx)
- HTTPS certificate (recommended for Web Speech API)

## 1. Choose a Hosting Provider

Free options for deployment:

- **InfinityFree**: Free PHP/MySQL hosting
- **000webhost**: Free hosting with PHP/MySQL
- **Heroku**: Free tier (with limitations)

Paid options (better performance and reliability):
- DigitalOcean ($5/mo)
- AWS EC2 (t2.micro can be free tier eligible)
- Linode ($5/mo)

## 2. Prepare Your Application for Production

### Optimize Laravel for Production

Run these commands locally before deploying:

```bash
# Install production dependencies only
composer install --optimize-autoloader --no-dev

# Optimize configuration loading
php artisan config:cache

# Optimize route loading
php artisan route:cache

# Compile all Blade templates
php artisan view:cache
```

### Configure Environment Variables

Create a proper `.env` file with production settings:
- Set `APP_ENV=production`
- Set `APP_DEBUG=false`
- Set a strong `APP_KEY` (use `php artisan key:generate`)
- Configure database connection details
- Set proper CORS settings if needed

## 3. Database Migration

After setting up your database on the production server:

```bash
php artisan migrate
```

## 4. File Permissions

Make sure these directories are writable by the web server:

```bash
chmod -R 775 storage bootstrap/cache
```

## 5. Web Server Configuration

### Apache

Create a `.htaccess` file in the public directory (Laravel includes this by default):

```
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

### Nginx

Create a configuration file:

```
server {
    listen 80;
    server_name your-domain.com;
    root /path/to/your/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 6. Setup HTTPS (Important for Web Speech API)

Many browsers require HTTPS for Web Speech API to work properly. You can:

- Use Let's Encrypt for free SSL certificates
- Configure your web server to use the SSL certificates
- Update your application URL in `.env` to use HTTPS: `APP_URL=https://your-domain.com`

## 7. Deployment Steps

### Manual Deployment

1. Upload your files to the server (exclude `/vendor`, `/node_modules`, and `.git`)
2. SSH into your server
3. Navigate to your project directory
4. Run `composer install --optimize-autoloader --no-dev`
5. Create/update `.env` file with production settings
6. Run `php artisan migrate`
7. Set proper file permissions
8. Configure your web server

### Using Git

1. SSH into your server
2. Clone your repository: `git clone https://github.com/yourusername/speech-translator.git`
3. Navigate to your project directory
4. Follow steps 4-8 from manual deployment

## 8. Post-Deployment Checks

- Visit your site to ensure it loads properly
- Test the translation and text-to-speech functionality
- Check that your database migrations ran successfully
- Monitor error logs for any issues

## 9. Troubleshooting

- Check Laravel logs: `storage/logs/laravel.log`
- Check web server error logs
- Verify file permissions
- Ensure environment variables are set correctly

Remember that LibreTranslate's public instances may have rate limits. For a production application, consider hosting your own instance or using a paid API service for translation.