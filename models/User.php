<?php
/**
 * User Model
 * Handles user-related database operations
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Register a new user
     */
    public function register($name, $email, $password) {
        // Validate input
        if (empty($name) || empty($email) || empty($password)) {
            throw new Exception('جميع الحقول مطلوبة');
        }
        
        if (!validateEmail($email)) {
            throw new Exception('البريد الإلكتروني غير صحيح');
        }
        
        if (!validatePassword($password)) {
            throw new Exception('كلمة المرور يجب أن تكون 6 أحرف على الأقل');
        }
        
        // Check if email already exists
        $existingUser = $this->db->fetchOne(
            "SELECT id FROM users WHERE email = ?",
            [$email]
        );
        
        if ($existingUser) {
            throw new Exception('البريد الإلكتروني مستخدم بالفعل');
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user
        $userId = $this->db->insert(
            "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())",
            [$name, $email, $hashedPassword]
        );
        
        if ($userId) {
            logActivity('user_register', "User registered: $email");
            return $userId;
        }
        
        throw new Exception('فشل في إنشاء الحساب');
    }
    
    /**
     * Login user
     */
    public function login($email, $password) {
        // Validate input
        if (empty($email) || empty($password)) {
            throw new Exception('البريد الإلكتروني وكلمة المرور مطلوبان');
        }
        
        // Get user by email
        $user = $this->db->fetchOne(
            "SELECT id, name, email, password FROM users WHERE email = ?",
            [$email]
        );
        
        if (!$user) {
            throw new Exception('البريد الإلكتروني أو كلمة المرور غير صحيحة');
        }
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            throw new Exception('البريد الإلكتروني أو كلمة المرور غير صحيحة');
        }
        
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['is_admin'] = false;
        
        logActivity('user_login', "User logged in: $email");
        return true;
    }
    
    /**
     * Login admin
     */
    public function loginAdmin($username, $password) {
        // Validate input
        if (empty($username) || empty($password)) {
            throw new Exception('اسم المستخدم وكلمة المرور مطلوبان');
        }
        
        // Get admin by username
        $admin = $this->db->fetchOne(
            "SELECT a_id, name, username, password FROM admin WHERE username = ?",
            [$username]
        );
        
        if (!$admin) {
            throw new Exception('اسم المستخدم أو كلمة المرور غير صحيحة');
        }
        
        // Verify password (assuming plain text for now, should be hashed)
        if ($password !== $admin['password']) {
            throw new Exception('اسم المستخدم أو كلمة المرور غير صحيحة');
        }
        
        // Set session
        $_SESSION['user_id'] = $admin['a_id'];
        $_SESSION['user_name'] = $admin['name'];
        $_SESSION['user_email'] = $admin['username'];
        $_SESSION['is_admin'] = true;
        
        logActivity('admin_login', "Admin logged in: $username");
        return true;
    }
    
    /**
     * Get user by ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM user WHERE u_id = ?";
        return $this->db->fetch($sql, [$id]);
    }
    
    /**
     * Get user by email
     */
    public function getByEmail($email) {
        $sql = "SELECT * FROM user WHERE email = ?";
        return $this->db->fetch($sql, [$email]);
    }
    
    /**
     * Update user profile
     */
    public function updateProfile($userId, $name, $email) {
        // Validate input
        if (empty($name) || empty($email)) {
            throw new Exception('الاسم والبريد الإلكتروني مطلوبان');
        }
        
        if (!validateEmail($email)) {
            throw new Exception('البريد الإلكتروني غير صحيح');
        }
        
        // Check if email is already used by another user
        $existingUser = $this->db->fetchOne(
            "SELECT id FROM users WHERE email = ? AND id != ?",
            [$email, $userId]
        );
        
        if ($existingUser) {
            throw new Exception('البريد الإلكتروني مستخدم بالفعل');
        }
        
        // Update user
        $result = $this->db->update(
            "UPDATE users SET name = ?, email = ? WHERE id = ?",
            [$name, $email, $userId]
        );
        
        if ($result) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            logActivity('profile_update', "User updated profile: $email");
            return true;
        }
        
        throw new Exception('فشل في تحديث الملف الشخصي');
    }
    
    /**
     * Change password
     */
    public function changePassword($userId, $currentPassword, $newPassword) {
        // Get current password
        $user = $this->db->fetchOne(
            "SELECT password FROM users WHERE id = ?",
            [$userId]
        );
        
        if (!$user) {
            throw new Exception('المستخدم غير موجود');
        }
        
        // Verify current password
        if (!password_verify($currentPassword, $user['password'])) {
            throw new Exception('كلمة المرور الحالية غير صحيحة');
        }
        
        // Validate new password
        if (!validatePassword($newPassword)) {
            throw new Exception('كلمة المرور الجديدة يجب أن تكون 6 أحرف على الأقل');
        }
        
        // Hash new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update password
        $result = $this->db->update(
            "UPDATE users SET password = ? WHERE id = ?",
            [$hashedPassword, $userId]
        );
        
        if ($result) {
            logActivity('password_change', "User changed password");
            return true;
        }
        
        throw new Exception('فشل في تغيير كلمة المرور');
    }
    
    /**
     * Get all users (admin only)
     */
    public function getAll($page = 1, $limit = ITEMS_PER_PAGE) {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT * FROM user ORDER BY u_id DESC LIMIT ? OFFSET ?";
        return $this->db->fetchAll($sql, [$limit, $offset]);
    }
    
    /**
     * Delete user (admin only)
     */
    public function delete($userId) {
        // Check if user exists
        $user = $this->getById($userId);
        if (!$user) {
            throw new Exception('المستخدم غير موجود');
        }
        
        // Delete user
        $result = $this->db->delete(
            "DELETE FROM users WHERE id = ?",
            [$userId]
        );
        
        if ($result) {
            logActivity('user_delete', "User deleted: {$user['email']}");
            return true;
        }
        
        throw new Exception('فشل في حذف المستخدم');
    }
    
    /**
     * Logout user
     */
    public function logout() {
        if (isset($_SESSION['user_email'])) {
            logActivity('logout', "User {$_SESSION['user_email']} logged out");
        }
        
        session_unset();
        session_destroy();
        return true;
    }
} 