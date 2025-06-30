<?php
/**
 * Login Page
 * User authentication page
 */

// Page configuration
$page_title = 'تسجيل الدخول - ' . APP_NAME;
$page_description = 'تسجيل الدخول إلى حسابك في متجر خير بلادك';

// Include required files
require_once 'config/config.php';
require_once 'models/User.php';

// Redirect if already logged in
if (isLoggedIn()) {
    redirect('/');
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        setFlashMessage('error', 'خطأ في التحقق من الأمان');
        redirect('/login.php');
    }
    
    $email = cleanInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    // Validate input
    $errors = [];
    
    if (empty($email)) {
        $errors[] = 'البريد الإلكتروني مطلوب';
    } elseif (!validateEmail($email)) {
        $errors[] = 'البريد الإلكتروني غير صحيح';
    }
    
    if (empty($password)) {
        $errors[] = 'كلمة المرور مطلوبة';
    }
    
    if (empty($errors)) {
        try {
            $userModel = new User();
            
            if ($userModel->authenticate($email, $password)) {
                // Set remember me cookie if requested
                if ($remember) {
                    $token = generateRandomString(32);
                    setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 days
                }
                
                setFlashMessage('success', 'تم تسجيل الدخول بنجاح');
                
                // Redirect to intended page or home
                $redirect = $_GET['redirect'] ?? '/';
                redirect($redirect);
            } else {
                setFlashMessage('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
            }
        } catch (Exception $e) {
            setFlashMessage('error', $e->getMessage());
        }
    } else {
        setFlashMessage('error', implode('<br>', $errors));
    }
    
    redirect('/login.php');
}

// Include header
include 'includes/header.php';
?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <img src="/assets/images/logo.png" alt="<?php echo APP_NAME; ?>" class="auth-logo-img">
                <h1 class="auth-title">تسجيل الدخول</h1>
            </div>
            <p class="auth-subtitle">أدخل بياناتك للوصول إلى حسابك</p>
        </div>
        
        <form method="post" class="auth-form" data-validate>
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            
            <div class="form-group">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <div class="input-group">
                    <input type="email" id="email" name="email" class="form-input" 
                           placeholder="أدخل بريدك الإلكتروني" required
                           value="<?php echo e($_POST['email'] ?? ''); ?>">
                    <i class="fas fa-envelope input-icon"></i>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">كلمة المرور</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-input" 
                           placeholder="أدخل كلمة المرور" required>
                    <i class="fas fa-lock input-icon"></i>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" class="checkbox-input">
                    <span class="checkbox-custom"></span>
                    تذكرني
                </label>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg w-full">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل الدخول
                </button>
            </div>
        </form>
        
        <div class="auth-footer">
            <div class="auth-links">
                <a href="/forgot-password.php" class="auth-link">نسيت كلمة المرور؟</a>
                <span class="auth-divider">|</span>
                <a href="/register.php" class="auth-link">ليس لديك حساب؟ سجل الآن</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.parentNode.querySelector('.password-toggle i');
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        toggle.className = 'fas fa-eye';
    }
}
</script>

<?php include 'includes/footer.php'; ?>