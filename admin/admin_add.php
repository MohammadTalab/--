<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
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

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>إضافة مدير</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

    <form action="admin_insert.php" method="post" enctype="multipart/form-data">

        <table class="form">

            <caption>إضافة مدير</caption>

            <tr>

                <td><label for="name">الاسم</label></td>

                <td><input type="text" name="name" id="name"></td>

            <tr>



            <tr>

                <td><label for="username">اسم المستخدم</label></td>

                <td><input type="text" name="username" id="username"></td>

            <tr>

            

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