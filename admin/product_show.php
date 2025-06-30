<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>📋 عرض المنتجات - متجر خير بلادك</title>
    <link rel="stylesheet" href="../static/styles.css"/>
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../images/LOGO.jpg" alt="شعار متجر خير بلادك" class="logo-img">
            <a href="index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">الرئيسية</a></li>
                <li><a href="../products.php">المنتجات</a></li>
                <li><a href="product_show.php" class="active">عرض المنتجات (إدارة)</a></li>
                <li><a href="../about.php">من نحن</a></li>
                <li><a href="admin.php">لوحة الإدارة</a></li>
            </ul>
        </nav>
    </header>

    <main>
<?php
//include_once('header.php');
//include_once('menu.php');
require_once('../connect.php');


$sql = "SELECT name, description, img, price FROM product";
$res = mysqli_query($conn, $sql);



    echo '<div class="products-section">';
    echo '<h2>📋 جميع المنتجات المتوفرة</h2>';
    echo '<div class="table-container">';
    echo '<table class="products-table">';
    echo '<thead>';
    echo '<tr><th>🏷️ اسم المنتج</th><th>📝 الوصف</th><th>🖼️ الصورة</th><th>💰 السعر</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td><strong>' .$row['name'] . '</strong></td>';
        echo '<td>' .$row['description'] . '</td>';
        echo '<td><img src="images/' . $row['img'] . '" alt="صورة المنتج" class="product-img"></td>';
        echo '<td><span class="price-tag">' . number_format($row['price'], 2) . ' شيكل</span></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
?>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك 🇵🇸</p>
    </footer>
</body>
</html>
