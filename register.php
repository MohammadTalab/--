<?php
require_once 'db.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - متجر إلكتروني</title>
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
        
        input[type="text"],
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
            color: rgb(68, 0, 0);
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
                <li><a href="login.php">تسجيل الدخول</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="form-container">
            <h2 style="text-align: center; margin-bottom: 20px;">إنشاء حساب جديد</h2>
            
            <?php
            if(isset($_POST['register'])){
                $name = mysqli_real_escape_string($conn, $_POST['name']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
                
                if($password !== $confirm_password) {
                    echo '<div style="color: red; text-align: center; margin-bottom: 20px;">كلمة المرور غير مشابهة</div>';
                } else {
                    $check_email = "SELECT * FROM `user` WHERE `email` = '$email'";
                    $result = mysqli_query($conn, $check_email);
                    
                    if(mysqli_num_rows($result) > 0) {
                        echo '<div style="color: red; text-align: center; margin-bottom: 20px;">البريد الإلكتروني مستخدم من قبل</div>';
                    } else {
                        $sql = "INSERT INTO `user`(`name`, `email`, `password`) VALUES('$name','$email','$password')";
                        if(mysqli_query($conn, $sql)) {
                            echo '<div style="color: green; text-align: center; margin-bottom: 20px;">تم إنشاء الحساب ! <a href="login.php">تسجيل الدخول</a></div>';
                        } else {
                            echo '<div style="color: red; text-align: center; margin-bottom: 20px;">خطأ في إنشاء الحساب</div>';
                        }
                    }
                }
            }
            ?>
            
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">الاسم الكامل</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">تأكيد كلمة المرور</label>
                    <input type="password" id="confirm-password" name="confirm_password" required>
                </div>
                <button type="submit" name="register" class="btn" style="width: 100%;">إنشاء حساب</button>
                <div class="form-footer">
                    <p>لديك حساب بالفعل؟ <a href="login.php">تسجيل الدخول</a></p>
                </div>
            </form>
        </div>
    </main>
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 متجرنا الإلكتروني</p>
    </footer>
</body>
</html>