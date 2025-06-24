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
//include_once('header.php');
//include_once('menu.php');
require_once('connect.php');


$sql = "SELECT name, description, img, FROM category";
$res = mysqli_query($conn, $sql);


if (mysqli_num_rows($res) > 0) {
    echo '<table>';
    echo '<caption>عرض الاصناف</caption>';
    echo '<tr><th>اسم الصنف</th><th>الوصف</th><th>الصورة</th><th>السعر</th></tr>';

    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . nl2br(htmlspecialchars($row['description'])) . '</td>';
        echo '<td><img src="images/' . htmlspecialchars($row['img']) . '" alt="صورة الصنف"></td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p style="text-align:center; margin-top:20px;">لا توجد اصناف لعرضها حالياً.</p>';
}
?>
</body>
</html>
