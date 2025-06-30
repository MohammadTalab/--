<?php
/**
 * Global Functions
 * Utility functions for the application
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

/**
 * Clean and validate input data
 */
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION[CSRF_TOKEN_NAME]) && hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Check if user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Check if user is admin
 */
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Redirect to URL
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Set flash message
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
        'timestamp' => time()
    ];
}

/**
 * Get and clear flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Format price
 */
function formatPrice($price) {
    return number_format($price, 2) . ' ₪';
}

/**
 * Escape HTML output
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Get file URL
 */
function getFileUrl($filename, $type = 'products') {
    if (empty($filename)) {
        return '/assets/images/placeholder.jpg';
    }
    
    $uploadPath = "/uploads/$type/";
    return $uploadPath . $filename;
}

/**
 * Upload file
 */
function uploadFile($file, $type = 'products') {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        throw new Exception('لم يتم رفع أي ملف');
    }
    
    $fileName = $file['name'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileError = $file['error'];
    
    // Check for upload errors
    if ($fileError !== UPLOAD_ERR_OK) {
        throw new Exception('خطأ في رفع الملف');
    }
    
    // Check file size
    if ($fileSize > MAX_FILE_SIZE) {
        throw new Exception('حجم الملف كبير جداً');
    }
    
    // Get file extension
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Check file type
    if (!in_array($fileExt, ALLOWED_IMAGE_TYPES)) {
        throw new Exception('نوع الملف غير مسموح به');
    }
    
    // Generate unique filename
    $newFileName = uniqid() . '.' . $fileExt;
    
    // Create directory if it doesn't exist
    $uploadDir = UPLOAD_DIR . "/$type/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    // Move uploaded file
    $destination = $uploadDir . $newFileName;
    if (!move_uploaded_file($fileTmp, $destination)) {
        throw new Exception('فشل في حفظ الملف');
    }
    
    return $newFileName;
}

/**
 * Delete file
 */
function deleteFile($filename, $type = 'products') {
    if (empty($filename)) {
        return false;
    }
    
    $filePath = UPLOAD_DIR . "/$type/$filename";
    if (file_exists($filePath)) {
        return unlink($filePath);
    }
    
    return false;
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate password strength
 */
function validatePassword($password) {
    return strlen($password) >= PASSWORD_MIN_LENGTH;
}

/**
 * Hash password
 */
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password
 */
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Generate random string
 */
function generateRandomString($length = 10) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Log activity
 */
function logActivity($action, $details = '') {
    $logFile = APP_ROOT . '/logs/activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $userId = $_SESSION['user_id'] ?? 'guest';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    
    $logEntry = "[$timestamp] User: $userId, IP: $ip, Action: $action, Details: $details\n";
    
    if (!file_exists(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    
    file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

/**
 * Get current page
 */
function getCurrentPage() {
    $script = $_SERVER['SCRIPT_NAME'];
    return basename($script, '.php');
}

/**
 * Check if current page is active
 */
function isActivePage($page) {
    return getCurrentPage() === $page;
}

/**
 * Pagination helper
 */
function getPagination($totalItems, $itemsPerPage, $currentPage) {
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $itemsPerPage;
    
    return [
        'current_page' => $currentPage,
        'total_pages' => $totalPages,
        'offset' => $offset,
        'limit' => $itemsPerPage,
        'has_previous' => $currentPage > 1,
        'has_next' => $currentPage < $totalPages,
        'previous_page' => $currentPage - 1,
        'next_page' => $currentPage + 1
    ];
} 