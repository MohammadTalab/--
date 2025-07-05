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
    <title>إضافة صنف</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
include_once('../../menu.php');
?>    
<?php
require_once('../connect.php');
$sql = "SELECT * FROM category WHERE c_id = '" . $_GET['id']."'";;
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $description = $row_cat['description'];
    $img = $row_cat['img'];

// include('include/header.php');
// include('include/../menu.php');
?>
    <form action="category_remove.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <table class="form">
            <caption>حذف صنف</caption>
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
<?php
}
// include('include/footer.php');
?>
</body>
</html>