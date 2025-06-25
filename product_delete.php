<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
require_once('connect.php');
$sql = "SELECT * FROM `product` WHERE p_id = " . $_GET['id'];
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $description = $row_cat['description'];
    $img = $row_cat['img'];
    $price = $row_cat['price'];

// include('include/header.php');
// include('include/menu.php');
?>
    <form action="product_remove.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <table class="form">
            <caption>حذف منتج</caption>
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