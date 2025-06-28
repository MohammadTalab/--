<?php
require_once 'connect.php';
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
    <title>متجر خير بلادك - المنتجات</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo-container">
                <img src="images/logo.png" alt="شعار متجر خير بلادك" class="logo-img">
                <span class="logo-text">متجر خير بلادك</span>
            </div>
            
            <nav>
                <ul>
                    <li><a href="index.php">الرئيسية</a></li>
                    <li><a href="product.php" class="active">المنتجات</a></li>
                    <li><a href="about.php">من نحن</a></li>
                    <li>
                        <a href="cart.php">السلة
                            <span class="cart-count">0</span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="logout.php">تسجيل الخروج</a></li>
                    <?php else: ?>
                        <li><a href="login.php">تسجيل الدخول</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero-section">
            <h1>جميع المنتجات</h1>
            <p>اكتشف مجموعتنا الكاملة من المنتجات المحلية عالية الجودة</p>
        </section>
       
        <?php
        require_once("connect.php");
        $sql = "SELECT * FROM product";
        $res_product = mysqli_query($conn, $sql);
            $i = 1;
            while($row = mysqli_fetch_assoc($res_product)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><img src='images/" . $row['img'] . "' width='50'></td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo '<td>';
                echo '<a href="add_cart.php?id='.$row['p_id'].'">Add to Cart</a> ';
                echo '</td>';
                echo "</tr>";
                $i++;
            }
        ?>
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/script.js"></script>
</body>
</html>
