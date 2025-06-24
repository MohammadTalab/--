<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>إضافة منتج</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="../style/style.css"/>
    <style>
        body {
            background: #f7f7fa;
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 90%;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px #0001;
            border-collapse: collapse;
        }
        caption {
            font-size: 1.5em;
            color: #2d3e50;
            margin-bottom: 18px;
            font-weight: bold;
            padding: 16px 0 0 0;
        }
        th, td {
            padding: 14px 10px;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #4f8cff;
            color: #fff;
            font-weight: bold;
        }
        tr:last-child td {
            border-bottom: none;
        }
        img {
            max-width: 80px;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
        }
        p {
            color: #888;
            font-size: 1.1em;
        }
    </style>
</head>
<body>
<?php
//include_once('header.php');
//include_once('menu.php');
require_once('connect.php');


$sql = "SELECT name, description, img, price FROM product";
$res = mysqli_query($conn, $sql);


if (mysqli_num_rows($res) > 0) {
    echo '<table>';
    echo '<caption>عرض المنتجات</caption>';
    echo '<tr><th>اسم المنتج</th><th>الوصف</th><th>الصورة</th><th>السعر</th></tr>';

    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . nl2br(htmlspecialchars($row['description'])) . '</td>';
        echo '<td><img src="images/' . htmlspecialchars($row['img']) . '" alt="صورة المنتج"></td>';
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
