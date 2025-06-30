<?php
session_start();
require_once 'connect.php';
require_once 'functions.php';

// تم نقل وظيفة getCartCount إلى ملف functions.php
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'متجر خير بلادك'; ?></title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="images/LOGO.jpg" alt="شعار متجر خير بلادك" class="logo-img">
            <a href="index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="index.php" <?php echo ($current_page == 'home') ? 'class="active"' : ''; ?>>الرئيسية</a></li>
                <li><a href="products.php" <?php echo ($current_page == 'products') ? 'class="active"' : ''; ?>>المنتجات</a></li>
                <li><a href="about.php" <?php echo ($current_page == 'about') ? 'class="active"' : ''; ?>>من نحن</a></li>
                <li>
                    <a href="cart.php" <?php echo ($current_page == 'cart') ? 'class="active"' : ''; ?>>السلة
                        <?php if (isset($_SESSION['user_id'])):
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; endif; ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="orders.php" <?php echo ($current_page == 'orders') ? 'class="active"' : ''; ?>>طلباتي</a></li>
                    <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php" <?php echo ($current_page == 'login') ? 'class="active"' : ''; ?>>تسجيل الدخول</a></li>
                    <li><a href="register.php" <?php echo ($current_page == 'register') ? 'class="active"' : ''; ?>>تسجيل جديد</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>