<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>عرض المنتجات - متجر خير بلادك</title>
    <link rel="stylesheet" href="style/style.css"/>
</head>
<body>
<?php
include_once('menu.php');
?>    
    <header>
        <div class="logo-container">
            <img src="images/LOGO.jpg" alt="شعار متجر خير بلادك" class="logo-img">
            <a href="index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="products.php">المنتجات</a></li>
                <li><a href="product_show.php" class="active">عرض المنتجات</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li>
                    <a href="cart.php">السلة
                        <?php
                        session_start();
                        if (isset($_SESSION['user_id'])):
                            require_once 'functions.php';
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; endif; ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="orders.php">طلباتي</a></li>
                    <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="register.php">تسجيل جديد</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
<?php
//include_once('header.php');
//include_once('../menu.php');
require_once('connect.php');


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

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/JavaScript.js"></script>
</body>
</html>
