<?php
require_once 'connect.php';
session_start();
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>السلة - متجر خير بلادك</title>
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
                <li><a href="cart.php" class="active">السلة</a></li>
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
        <div class="cart-container">
            <h2>🛒 محتويات السلة</h2>

            <?php if (empty($cart)): ?>
                <div class="empty-cart">
                    <p>السلة فارغة حالياً</p>
                    <a href="products.php" class="btn">تصفح المنتجات</a>
                </div>
            <?php else: ?>
                <div class="cart-table-container">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>المجموع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($cart as $id => $item):
                                $sql = "SELECT * FROM `product` WHERE p_id = $id";
                                $res = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_assoc($res);
                                $subtotal = $row['price'] * $item['quantity'];
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo (int)$item['quantity']; ?></td>
                                <td><?php echo number_format($row['price'], 2); ?> شيكل</td>
                                <td><?php echo number_format($subtotal, 2); ?> شيكل</td>
                                <td>
                                    <a href="remove_cart.php?id=<?php echo (int)$id; ?>" class="btn-remove">حذف</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3"><strong>المجموع الكلي</strong></td>
                                <td colspan="2"><strong><?php echo number_format($total, 2); ?> شيكل</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="cart-actions">
                    <a href="products.php" class="btn btn-secondary">متابعة التسوق</a>
                    <a href="checkout.php" class="btn btn-primary">إتمام الطلب</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/JavaScript.js"></script>
</body>
</html>
