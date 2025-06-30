<?php
$page_title = 'تسجيل جديد - متجر خير بلادك';
$current_page = 'register';
require_once 'connect.php';

$message = '';

if ($_POST) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($password !== $confirm_password) {
        $message = '<div class="message error">كلمات المرور غير متطابقة</div>';
    } else {
        // التحقق من وجود الإيميل
        $check_sql = "SELECT u_id FROM user WHERE email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $message = '<div class="message error">هذا الإيميل مسجل مسبقاً</div>';
        } else {
            // استخدام كلمة المرور كما هي لتتوافق مع طريقة التحقق في صفحة تسجيل الدخول
            $sql = "INSERT INTO user (name, email, password, role) VALUES ('$name', '$email', '$password', 'user')";
            
            if (mysqli_query($conn, $sql)) {
                $user_id = mysqli_insert_id($conn);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['role'] = 'user';
                $_SESSION['message'] = 'تم إنشاء الحساب بنجاح!';
                header('Location: index.php');
                exit();
            } else {
                $message = '<div class="message error">حدث خطأ في التسجيل: ' . mysqli_error($conn) . '</div>';
            }
        }
    }
}

include 'header.php';
?>


    <main>
        <div class="form-container">
            <h2>إنشاء حساب جديد</h2>
            
            <?php echo $message; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="name">الاسم الكامل:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">البريد الإلكتروني:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">كلمة المرور:</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">تأكيد كلمة المرور:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>
                
                <button type="submit" class="btn">📝 إنشاء الحساب</button>
            </form>
            
            <div class="form-links">
                <p>لديك حساب بالفعل؟ <a href="login.php">🔐 سجل دخولك هنا</a></p>
            </div>
        </div>
    </main>

<?php include 'footer.php'; ?>
