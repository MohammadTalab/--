<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php
include_once("include/header.php");
include_once("include/conn.php");
require_once("include/connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id != "") {
        $sql = "SELECT * FROM product WHERE p_id = '$id'";
        $res_product = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res_product) > 0) {
            $row_product = mysqli_fetch_assoc($res_product);
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

<form action="product_update.php" method="post">
    <input type="hidden" name="p_id" value="<?php echo $id; ?>">
    <table class="form">
        <caption>Edit Product</caption>

        <tr>
            <td><label for="name">Name</label></td>
            <td><input type="text" name="name" id="name" value="<?php echo $row_product['name']; ?>"></td>
        </tr>

        <tr>
            <td><label for="description">Description</label></td>
            <td><textarea name="description" id="description" rows="3"><?php echo $row_product['description']; ?></textarea></td>
        </tr>

        <tr>
            <td><label for="img">Image File Name</label></td>
            <td><input type="text" name="img" id="img" value="<?php echo $row_product['img']; ?>"></td>
        </tr>

        <tr>
            <td><label for="price">Price</label></td>
            <td><input type="number" step="0.01" name="price" id="price" value="<?php echo $row_product['price']; ?>"></td>
        </tr>

        <tr>
            <td><label for="c_id">Category ID</label></td>
            <td><input type="number" name="c_id" id="c_id" value="<?php echo $row_product['c_id']; ?>"></td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" name="submit" value="Update"></td>
        </tr>
    </table>
</form>

</body>
</html>

