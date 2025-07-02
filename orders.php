<?php
require_once 'connect.php';
require_once 'functions.php';
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي - متجر خير بلادك</title>
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
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="products.php">المنتجات</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li>
                    <a href="cart.php">السلة
                        <?php if (isset($_SESSION['user_id'])):
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; endif; ?>
                    </a>
                </li>
                <li><a href="orders.php" class="active">طلباتي</a></li>
                <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="orders-container">
            <h2>طلباتي</h2>
            <div class="empty-orders">
                <p>لا توجد طلبات حالياً</p>
                <a href="products.php" class="btn">تصفح المنتجات</a>
            </div>
        </div>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/JavaScript.js"></script>
</body>
</html>
