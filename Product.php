<?php
require_once 'connect.php';
session_start();

$message = '';
if (isset($_POST['add_cart'])) {
    $message = '<div class="notification">✓ تم إضافة المنتج للسلة بنجاح!</div>';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جميع المنتجات - متجر خير بلادك</title>
    <link rel="stylesheet" href="style/style.css">
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
                <li><a href="Product.php" class="active">جميع المنتجات</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li>
                    <a href="cart.php">السلة
                        <?php if (isset($_SESSION['user_id'])):
                            require_once 'functions.php';
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; endif; ?>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="orders.php">طلباتي</a></li>
                    <li><a href="logout.php">تسجيل خروج</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="register.php">تسجيل جديد</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="hero">
            <h1>جميع المنتجات</h1>
            <p>اكتشف مجموعتنا الكاملة من المنتجات المحلية عالية الجودة</p>
        </div>

        <?php echo $message; ?>

        <div class="table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>الصورة</th>
                        <th>الوصف</th>
                        <th>السعر</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM product";
                    $res_product = mysqli_query($conn, $sql);
                    $i = 1;
                    while($row = mysqli_fetch_assoc($res_product)):
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td>
                            <img src="images/<?php echo $row['img']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="product-img-small">
                        </td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo number_format($row['price'], 2); ?> شيكل</td>
                        <td>
                            <a href="add_cart.php?id=<?php echo $row['p_id']; ?>" class="btn btn-small">إضافة للسلة</a>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/JavaScript.js"></script>
</body>
</html>
