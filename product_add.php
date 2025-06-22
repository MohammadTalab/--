<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>إضافة منتج</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="../style/style.css"/>
</head>
<body>

<?php
// include_once('header.php');
// include_once('menu.php');
require_once('connect.php');


$sql = "SELECT * FROM `category` ORDER BY `name`";
$res_category = mysqli_query($conn, $sql);
?>

<form action="product_insert.php" method="post" enctype="multipart/form-data">
    <table class="form">
        <caption>إضافة منتج</caption>

        <tr>
            <td><label for="name">اسم المنتج:</label></td>
            <td><input type="text" name="name" id="name" required></td>
        </tr>

        <tr>
            <td><label for="category">التصنيف:</label></td>
            <td>
                <select name="category" id="category" required>
                    <option value="">اختر التصنيف </option>
                    <?php
                    while ($row = mysqli_fetch_assoc($res_category)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td><label for="description">الوصف:</label></td>
            <td><textarea name="description" id="description" rows="4" cols="30"></textarea></td>
        </tr>

        <tr>
            <td><label for="price">السعر:</label></td>
            <td><input type="number" name="price" id="price" step="0.01" required></td>
        </tr>

        <tr>
            <td><label for="img">صورة المنتج:</label></td>
            <td><input type="file" name="img" id="img" accept="image/*" required></td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" name="submit" value="إرسال">
            </td>
        </tr>
    </table>
</form>

</body>
</html>
