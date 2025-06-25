<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
// include('include/header.php');
// include('include/menu.php');
?>
    <form action="user_insert.php" method="post" enctype="multipart/form-data">
        <table class="form">
            <caption>إضافة مستخدم</caption>
            <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name"></td>
            </tr>
            <tr>
                <td><label for="email">البريد الإلكتروني:</label></td>
                <td><input type="email" name="email" id="email"></td>
            <tr>
                <td><label for="password">كلمة المرور:</label></td>
                <td><input type="password" name="password" id="password"></td>
            <tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="إضافة"></td>
            </tr>
        </table>
    </form>
</body>
</html>