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
    <title>تعديل المدير </title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
include_once('../../menu.php');
?>
<?php
require_once('../connect.php');
$id = $_GET['id'];
$sql = "SELECT * FROM admin WHERE a_id = $id";
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $username = $row_cat['username'];
    $password = $row_cat['password'];
} else 
    echo "<p>المدير غير موجود.</p>";
?>
    <form action="admin _update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <table class="form">
    <caption>تعديل المدير </caption>
                <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name" value="<?php echo $name;?>"></td>
            </tr>
            <tr>
                <td><label for="username"></label></td>
                <td><input type="text" name="username" id="username" value="<?php echo $username;?>"></td>
            </tr>
            <tr>
                <td><label for="password">كلمة المرور:</label></td>
                <td><input type="password" name="password" id="password" value="<?php echo $password;?>"></td>
            </tr>
                <td colspan="2"><input type="submit" name="submit" value="تعديل"></td>
            </tr>
        </table>
    </form>
</body>
</html>