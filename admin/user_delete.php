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
    $password = $row_cat['password'];}
?>
    <form action="user_remove.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <table class="form">
            <caption>حذف مستخدم</caption>
            <tr>
                <td>هل تريد بالتأكيد حذف <?php echo $name;?></td>
            <tr>
                <td colspan="2">
                    <input type="submit" name="yes" value="نعم">
                    <input type="submit" name="no" value="لا">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>