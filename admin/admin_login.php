<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول المسؤول</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body>
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
<div class="login">
<form method="post" action="admin_login.php">
    <h1>تسجيل دخول المسؤول</h1>
    <div class="item">اسم المستخدم: <input type="text" name="user" ></div>
    <div class="item">كلمة المرور: <input type="password" name="pass"></div>
    <div class="btn"><input type="submit" value="دخول"></div>
</form>
</div>
</body>
</html>