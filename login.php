<?php
require_once 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - متجر إلكتروني</title>
    <link rel="stylesheet" href="static/styles.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .form-footer {
            margin-top: 20px;
            text-align: center;
        }
        
        .form-footer a {
            color:rgb(68, 0, 0);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">متجرنا</div>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="products.php">المنتجات</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li><a href="cart.php">السلة</a></li>
                <li><a href="login.php" class="active">تسجيل الدخول</a></li>
            </ul>
        </nav>
    </header>
    
       <main>
           <div class="form-container">
               <h2 style="text-align: center; margin-bottom: 20px;">تسجيل الدخول</h2>
               
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
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025  متجرنا الإلكتروني</p>
    </footer>
</body>
</html>