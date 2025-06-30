<?php
/**
 * Application Configuration
 * Global settings and constants
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Application settings
define('APP_NAME', 'متجر خير بلادك');
define('APP_VERSION', '2.0.0');
define('APP_URL', 'http://localhost');
define('APP_ROOT', __DIR__ . '/..');

// Database settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'kheirbiladak');
define('DB_USER', 'root');
define('DB_PASS', '');

// Security settings
define('CSRF_TOKEN_NAME', 'csrf_token');
define('SESSION_TIMEOUT', 3600); // 1 hour
define('PASSWORD_MIN_LENGTH', 6);

// File upload settings
define('UPLOAD_DIR', APP_ROOT . '/uploads');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);

// Pagination settings
define('ITEMS_PER_PAGE', 12);

// Currency settings
define('CURRENCY', 'شيكل');
define('CURRENCY_SYMBOL', '₪');

// Email settings (if needed later)
define('SMTP_HOST', 'localhost');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', '');
define('SMTP_PASSWORD', '');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', APP_ROOT . '/logs/error.log');

// Timezone
date_default_timezone_set('Asia/Gaza');

// Include required files
require_once APP_ROOT . '/config/database.php';
require_once APP_ROOT . '/includes/functions.php';

// Create uploads directory if it doesn't exist
if (!file_exists(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0755, true);
}

// Create logs directory if it doesn't exist
if (!file_exists(APP_ROOT . '/logs')) {
    mkdir(APP_ROOT . '/logs', 0755, true);
} 