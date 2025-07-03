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
    <title>حذف مدير</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
require_once('../connect.php');
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM `admin` WHERE a_id = $id";
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $username = $row_cat['username'];
    $password = $row_cat['password'];}
?>
    <form action="admin_remove.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <table class="form">
            <caption>حذف مدير</caption>
            <tr>
                <td>هل تريد بالتأكيد حذف <?php echo $name;?></td>
            <tr>
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