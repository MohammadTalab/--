<?php
require_once 'connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 تسجيل الدخول - متجر خير بلادك</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="images/logo.png" alt="شعار المتجر" class="logo-img" onerror="this.style.display='none'">
            <a href="index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">🏠 الرئيسية</a></li>
                <li><a href="products.php">🛍️ المنتجات</a></li>
                <li><a href="about.php">ℹ️ من نحن</a></li>
                <li><a href="register.php">📝 إنشاء حساب</a></li>
            </ul>
        </nav>
    </header>
    
       <main>
           <div class="form-container">
               <h2>🔐 تسجيل الدخول</h2>
               
               <?php
               if(isset($_POST['login'])){
                   $email = mysqli_real_escape_string($conn, $_POST['email']);
                   $password = mysqli_real_escape_string($conn, $_POST['password']);
                   
                   $sql = "SELECT * FROM `user` WHERE `email` = '$email' AND `password` = '$password'";
                   $result = mysqli_query($conn, $sql);
                   
                   if(mysqli_num_rows($result) > 0){
                       $user = mysqli_fetch_assoc($result);
                       $_SESSION['user_id'] = $user['u_id'];
                       $_SESSION['user_name'] = $user['name'];
                       $_SESSION['user_email'] = $user['email'];
                       echo '<div style="color: green; text-align: center; margin-bottom: 20px;">تم تسجيل الدخول بنجاح! <a href="index.php">العودة للرئيسية</a></div>';
                   } else {
                       echo '<div style="color: red; text-align: center; margin-bottom: 20px;">البريد الإلكتروني أو كلمة المرور غير صحيحة</div>';
                   }
               }
               ?>
               
               <form action="" method="post">
                   <div class="form-group">
                       <label for="email">البريد الإلكتروني</label>
                       <input type="email" id="email" name="email" required>
                   </div>
                   <div class="form-group">
                       <label for="password">كلمة المرور</label>
                       <input type="password" id="password" name="password" required>
                   </div>
                   <button type="submit" name="login" class="btn" style="width: 100%;">تسجيل الدخول</button>
                   <div class="form-footer">
                       <p>ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a></p>
                   </div>
               </form>
           </div>
       </main>
    
        </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك 🇵🇸</p>
    </footer>
</body>
</html>