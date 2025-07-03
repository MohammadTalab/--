<?php
session_start();

if (!isset($_SESSION['rple'])) {
    header("Location: user_login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "لا تملك صلاحية الوصول لهذه الصفحة.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>إضافة مستخدم</title>
    <link rel="stylesheet" href="../style/style.css" />
</head>
<body>
    <form action="user_insert.php" method="post" enctype="multipart/form-data">
        <table class="form">
            <caption>إضافة مستخدم</caption>
            <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name" required></td>
            </tr>
            <tr>
                <td><label for="email">البريد الإلكتروني:</label></td>
                <td><input type="email" name="email" id="email" required></td>
            </tr>
            <tr>
                <td><label for="password">كلمة المرور:</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="إضافة"></td>
            </tr>
        </table>
    </form>
</body>
</html>
