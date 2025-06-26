<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دخول المسؤول</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $sql = "SELECT * FROM `admin` WHERE `username` = '$user' AND `password` = '$pass'";
    $res = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_array($res)){
        $_SESSION['name'] = $row['name'];
        $_SESSION['role'] = 'admin';
    }else{
        echo 'خطأ باسم المستخدم او كلمة المرور';
    }
}

?>
<form method="post" action="admin_login.php">
    اسم المستخدم: <input type="text" name="user" ><br>
    كلمة المرور: <input type="password" name="pass"><br>
    <input type="submit" value="دخول">
</form>
    
</body>
</html>