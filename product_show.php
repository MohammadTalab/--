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
include_once('header.php');
include_once('menu.php');
require_once('connect.php');


$sql = "SELECT * FROM `category` ORDER BY `name`";
$res_category = mysqli_query($coon, $sql);

<?php
include_once('header.php');
include_once('menu.php');
require_once('connect.php');


$sql = "SELECT name, description, img, price FROM product ORDER BY id DESC";
$res = mysqli_query($coon, $sql);


if (mysqli_num_rows($res) > 0) {
    echo '<table>';
    echo '<caption>عرض المنتجات</caption>';
    echo '<tr><th>اسم المنتج</th><th>الوصف</th><th>الصورة</th><th>السعر</th></tr>';

    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . nl2br(htmlspecialchars($row['description'])) . '</td>';
        echo '<td><img src="../uploads/' . htmlspecialchars($row['img']) . '" alt="صورة المنتج"></td>';
        echo '<td>' . number_format($row['price'], 2) . ' $</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p style="text-align:center; margin-top:20px;">لا توجد منتجات لعرضها حالياً.</p>';
}
?>
</body>
</html>
