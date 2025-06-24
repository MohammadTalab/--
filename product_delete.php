<!DOCTYPE html>
<html>
<head>
    <title>Delete Product</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
//include_once("include/header.php");
//include_once("include/conn.php");
//require_once("include/connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id != "") {
        $sql = "SELECT * FROM product WHERE p_id = '$id'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
?>

<form action="product_remove.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <table class="form">
        <caption>Are you sure you want to delete this product?</caption>
        <tr>
            <td>Product Name:</td>
            <td><?php echo $row['name']; ?></td>
        </tr>
        <tr>
            <td><input type="submit" class="yes" name="yes" value="Yes"></td>
            <td><input type="submit" class="no" name="no" value="No"></td>
        </tr>
    </table>
</form>

<?php
        } else {
            header("Location: product_show.php");
            exit();
        }
    } else {
        header("Location: product_show.php");
        exit();
    }
} else {
    header("Location: product_show.php");
    exit();
}
?>

<?php //include_once("include/footer.php"); ?>

</body>
</html>