<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول المسؤول - متجر خير بلادك</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../images/LOGO.jpg" alt="شعار متجر خير بلادك" class="logo-img">
            <a href="../index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">الرئيسية</a></li>
                <li><a href="../products.php">المنتجات</a></li>
                <li><a href="../about.php">من نحن</a></li>
                <li><a href="admin_login.php" class="active">دخول الإدارة</a></li>
            </ul>
        </nav>
    </header>

    <main>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../connect.php');
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM `admin` WHERE `username` = '$user' AND `password` = '$pass'";
    $res = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_array($res)){
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = 'admin';
    }else{
        echo '<div class="error">خطأ باسم المستخدم او كلمة المرور</div>';
    }
}

?>
        <div class="form-container">
            <h2>تسجيل دخول المسؤول</h2>

            <form method="post" action="admin_login.php">
                <div class="form-group">
                    <label for="user">اسم المستخدم:</label>
                    <input type="text" id="user" name="user" required>
                </div>

                <div class="form-group">
                    <label for="pass">كلمة المرور:</label>
                    <input type="password" id="pass" name="pass" required>
                </div>

                <button type="submit" class="btn">دخول</button>
            </form>
        </div>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="../static/JavaScript.js"></script>
</body>
</html>