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
// include('include/header.php');
// include('include/menu.php');
?>
    <form action="product_insert.php" method="post" enctype="multipart/form-data">
        <table class="form">
            <caption>إضافة منتج</caption>
            <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name"></td>
            </tr>
            <tr>
                <td><label for="img">الصور:</label></td>
                <td><input type="file" name="img" id="img"></td>
            </tr>
            <tr>
                <td><label for="description">الوصف:</label></td>
                <td><textarea name="description" id="description" cols="40" rows="4"></textarea></td>
            </tr>
            <tr>
                <td><label for="price">السعر:</label></td>
                <td><input type="number" step="0.1" name="price" id="price"></td>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="إضافة"></td>
            </tr>
        </table>
    </form>
<?php
// include('include/footer.php');
?>
</body>
</html>