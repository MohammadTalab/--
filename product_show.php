<?php
$page_title = 'عرض المنتجات - متجر خير بلادك';
$current_page = 'product_show';
require_once 'connect.php';
require_once 'functions.php';

include 'header.php';
?>

    <main>
<?php


$sql = "SELECT name, description, img, price FROM product";
$res = mysqli_query($conn, $sql);



    echo '<div class="products-section">';
    echo '<h2>جميع المنتجات المتوفرة</h2>';
    echo '<div class="table-container">';
    echo '<table class="products-table">';
    echo '<thead>';
    echo '<tr><th>اسم المنتج</th><th>الوصف</th><th>الصورة</th><th>السعر</th></tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td><strong>' . htmlspecialchars($row['name']) . '</strong></td>';
        echo '<td>' . nl2br(htmlspecialchars($row['description'])) . '</td>';
        echo '<td><img src="images/' . htmlspecialchars($row['img']) . '" alt="صورة المنتج" class="product-img"></td>';
        echo '<td><span class="price-tag">' . number_format($row['price'], 2) . ' شيكل</span></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
?>
    </main>

<?php include 'footer.php'; ?>
