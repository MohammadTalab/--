# متجر خير بلادك - E-commerce Platform

A modern, secure, and scalable e-commerce platform built with PHP, featuring a clean architecture and comprehensive functionality.

## 🚀 Features

### Core Features
- **User Management**: Registration, login, profile management
- **Product Catalog**: Categories, products, search, filtering
- **Shopping Cart**: Add, update, remove items
- **Order Management**: Checkout, order tracking
- **Admin Panel**: Complete backend management
- **Responsive Design**: Mobile-first approach
- **Security**: CSRF protection, input validation, SQL injection prevention

### Technical Features
- **MVC Architecture**: Clean separation of concerns
- **PDO Database**: Secure database operations
- **Modern PHP**: Latest PHP practices and features
- **RESTful API**: Ready for mobile apps
- **Performance**: Optimized caching and compression
- **SEO Friendly**: Clean URLs and meta tags

## 📁 Project Structure

```
├── config/                 # Configuration files
│   ├── config.php         # Main application config
│   └── database.php       # Database connection
├── models/                # Data models
│   ├── User.php          # User management
│   ├── Product.php       # Product operations
│   ├── Category.php      # Category management
│   └── Cart.php          # Shopping cart
├── includes/              # Shared components
│   ├── header.php        # Site header
│   ├── footer.php        # Site footer
│   └── functions.php     # Utility functions
├── assets/               # Static assets
│   ├── css/             # Stylesheets
│   │   └── styles.css   # Main CSS file
│   ├── js/              # JavaScript files
│   │   └── main.js      # Main JS file
│   └── images/          # Images and icons
├── uploads/              # File uploads
│   ├── products/        # Product images
│   └── categories/      # Category images
├── logs/                # Application logs
├── admin/               # Admin panel (existing)
├── index.php            # Home page
├── login.php            # Login page
├── register.php         # Registration page
├── products.php         # Products listing
├── cart.php             # Shopping cart
├── checkout.php         # Checkout process
├── .htaccess           # Apache configuration
└── README.md           # This file
```

## 🛠️ Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- mod_rewrite enabled (Apache)

### Setup Instructions

1. **Clone or Download**
   ```bash
   git clone [repository-url]
   cd kheirbiladak
   ```

2. **Database Setup**
   - Create a MySQL database
   - Import `kheirbiladak.sql`
   - Update database credentials in `config/database.php`

3. **Configuration**
   - Copy `config/config.php.example` to `config/config.php`
   - Update settings in `config/config.php`
   - Set proper permissions for uploads and logs directories

4. **Web Server Configuration**
   - Point your web server to the project root
   - Ensure mod_rewrite is enabled (Apache)
   - Set proper file permissions

5. **File Permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 logs/
   chmod 644 .htaccess
   ```

## 🔧 Configuration

### Database Configuration
Edit `config/database.php`:
```php
$host = 'localhost';
$dbname = 'kheirbiladak';
$username = 'your_username';
$password = 'your_password';
```

### Application Settings
Edit `config/config.php`:
```php
define('APP_NAME', 'متجر خير بلادك');
define('APP_URL', 'http://yourdomain.com');
define('UPLOAD_DIR', '/path/to/uploads');
```

## 🎨 Customization

### Styling
- Main stylesheet: `assets/css/styles.css`
- Uses CSS custom properties for easy theming
- Responsive design with mobile-first approach
- RTL support for Arabic language

### JavaScript
- Main script: `assets/js/main.js`
- Modular functions for different features
- AJAX support for dynamic interactions
- Form validation and error handling

### Templates
- Header: `includes/header.php`
- Footer: `includes/footer.php`
- Reusable components throughout the site

## 🔒 Security Features

### Input Validation
- All user inputs are sanitized
- CSRF token protection
- SQL injection prevention with prepared statements
- XSS protection with output escaping

### File Upload Security
- File type validation
- Size limits
- Secure file naming
- Directory traversal prevention

### Session Security
- Secure session configuration
- CSRF protection
- Session timeout
- Secure cookie settings

## 📱 Responsive Design

The platform is fully responsive with:
- Mobile-first CSS approach
- Flexible grid system
- Touch-friendly interfaces
- Optimized for all screen sizes

## 🚀 Performance

### Optimization Features
- Gzip compression
- Browser caching
- Image optimization
- Minified CSS/JS
- Database query optimization

### Caching Strategy
- Static asset caching
- Database query caching
- Session management
- CDN ready

## 🔧 Development

### Code Standards
- PSR-4 autoloading
- PSR-12 coding standards
- Comprehensive error handling
- Detailed logging

### Debugging
- Error logging to `logs/` directory
- Development mode with detailed errors
- Database query logging
- Performance monitoring

## 📊 Database Schema

### Main Tables
- `user`: User accounts and profiles
- `product`: Product information
- `category`: Product categories
- `order`: Customer orders
- `order_product`: Order items
- `admin`: Admin accounts

### Relationships
- Products belong to categories
- Orders belong to users
- Order products link orders and products

## 🛡️ Security Best Practices

1. **Always use prepared statements**
2. **Validate and sanitize all inputs**
3. **Use CSRF tokens for forms**
4. **Implement proper session management**
5. **Regular security updates**
6. **HTTPS in production**
7. **Regular backups**

## 📈 Scalability

### Architecture Benefits
- Modular design for easy expansion
- Database optimization
- Caching strategies
- Load balancing ready
- API-first approach

### Future Enhancements
- Multi-language support
- Advanced search
- Payment gateway integration
- Inventory management
- Analytics dashboard

## 🐛 Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check file permissions
   - Verify .htaccess configuration
   - Check PHP error logs

2. **Database Connection Issues**
   - Verify database credentials
   - Check MySQL service status
   - Ensure database exists

3. **Upload Issues**
   - Check upload directory permissions
   - Verify PHP upload settings
   - Check file size limits

### Debug Mode
Enable debug mode in `config/config.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📞 Support

For support and questions:
- Check the documentation
- Review error logs
- Contact development team
- Submit issues on GitHub

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📝 Changelog

### Version 2.0.0
- Complete code reorganization
- New MVC architecture
- Enhanced security features
- Modern UI/UX design
- Performance optimizations
- Comprehensive documentation

### Version 1.0.0
- Initial release
- Basic e-commerce functionality
- Admin panel
- User management

---

**Built with ❤️ for the Palestinian e-commerce community** 