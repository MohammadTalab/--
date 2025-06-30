<?php
require_once 'connect.php';
session_start();

$message = '';

if ($_POST) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $message = '<div class="message error">❌ كلمات المرور غير متطابقة</div>';
    } else {
        // التحقق من وجود الإيميل
        $check_sql = "SELECT id FROM users WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $message = '<div class="message error">❌ هذا الإيميل مسجل مسبقاً</div>';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password, created_at) VALUES ('$name', '$email', '$hashed_password', NOW())";
            
            if (mysqli_query($conn, $sql)) {
                $user_id = mysqli_insert_id($conn);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                header('Location: index.php');
                exit();
            } else {
                $message = '<div class="message error">❌ حدث خطأ في التسجيل</div>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل جديد - متجر خير بلادك</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../images/LOGO.jpg" alt="شعار متجر خير بلادك" class="logo-img">
            <a href="index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">الرئيسية</a></li>
                <li><a href="../products.php">المنتجات</a></li>
                <li><a href="../about.php">من نحن</a></li>
                <li><a href="../login.php">تسجيل الدخول</a></li>
                <li><a href="register.php" class="active">تسجيل جديد (إدارة)</a></li>
                <li><a href="admin.php">لوحة الإدارة</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h2>📝 إنشاء حساب جديد</h2>
            
            <?php echo $message; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="name">👤 الاسم الكامل:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">📧 البريد الإلكتروني:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">🔒 كلمة المرور:</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">🔒 تأكيد كلمة المرور:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>
                
                <button type="submit" class="btn">📝 إنشاء الحساب</button>
            </form>
            
            <div class="form-links">
                <p>لديك حساب بالفعل؟ <a href="login.php">🔐 سجل دخولك هنا</a></p>
            </div>
        </div>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك 🇵🇸</p>
    </footer>

    <script src="static/script.js"></script>
</body>
</html>
