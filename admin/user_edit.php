<?php
session_start();

if (!isset($_SESSION['role'])) {
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
    <title>إضافة منتج</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
require_once('../connect.php');
$sql = "SELECT * FROM user WHERE u_id = " . $_GET['id'];
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $email = $row_cat['email'];
    $password = $row_cat['password'];
} else {
    echo "<p>المستخدم غير موجود.</p>";
}
?>
    <form action="user _update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <table class="form">
            <caption>تعديل مستخدم</caption>
            <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name" value="<?php echo $name;?>"></td>
            </tr>
            <tr>
                <td><label for="email">البريد الإلكتروني:</label></td>
                <td><input type="email" name="email" id="email" value="<?php echo $row_cat['email'];?>"></td>
            </tr>
            <tr>
                <td><label for="password">كلمة المرور:</label></td>
                <td><input type="password" name="password" id="password" value="<?php echo $row_cat['password'];?>"></td>
            </tr>
                <td colspan="2"><input type="submit" name="submit" value="تعديل"></td>
            </tr>
        </table>
    </form>
</body>
</html>