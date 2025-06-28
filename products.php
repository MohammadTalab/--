<?php
require_once 'connect.php';
session_start();

// معالجة إضافة المنتج للسلة
$message = '';
if (isset($_POST['add_to_cart'])) {
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
                    <li><a href="products.php" class="active">المنتجات</a></li>
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
        
        <?php echo $message; ?>
        
        <section class="products-section">
            <div class="products-grid">
                <!-- منتج 1 -->
                <div class="product-card">
                    <img src="images/1.PNG" alt="زيت زيتون فلسطيني">
                    <h3>زيت زيتون فلسطيني</h3>
                    <p style="color: var(--light-text); margin-bottom: 10px; font-size: 14px; line-height: 1.5;">زيت زيتون بكر ممتاز من أشجار فلسطين العريقة</p>
                    <p class="price">45.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="101">
                        <input type="hidden" name="price" value="45.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <!-- منتج 2 -->
                <div class="product-card">
                    <img src="images/3.jpg" alt="عسل طبيعي جبلي">
                    <h3>عسل طبيعي جبلي</h3>
                    <p style="color: var(--light-text); margin-bottom: 10px; font-size: 14px; line-height: 1.5;">عسل طبيعي 100% من جبال فلسطين</p>
                    <p class="price">85.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="102">
                        <input type="hidden" name="price" value="85.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <!-- منتج 3 -->
                <div class="product-card">
                    <img src="images/4.jpg" alt="تمر مجهول فاخر">
                    <h3>تمر مجهول فاخر</h3>
                    <p style="color: var(--light-text); margin-bottom: 10px; font-size: 14px; line-height: 1.5;">تمر مجهول طازج وعالي الجودة</p>
                    <p class="price">35.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="103">
                        <input type="hidden" name="price" value="35.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <!-- منتج 4 -->
                <div class="product-card">
                    <img src="images/6.jpg" alt="صابون زيت الزيتون">
                    <h3>صابون زيت الزيتون</h3>
                    <p style="color: var(--light-text); margin-bottom: 10px; font-size: 14px; line-height: 1.5;">صابون طبيعي مصنوع من زيت الزيتون الخالص</p>
                    <p class="price">15.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="104">
                        <input type="hidden" name="price" value="15.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <!-- منتج 5 -->
                <div class="product-card">
                    <img src="images/66.PNG" alt="منتج محلي مميز">
                    <h3>منتج محلي مميز</h3>
                    <p style="color: var(--light-text); margin-bottom: 10px; font-size: 14px; line-height: 1.5;">منتج محلي عالي الجودة من خير بلادنا</p>
                    <p class="price">25.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="105">
                        <input type="hidden" name="price" value="25.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <!-- منتج 6 -->
                <div class="product-card">
                    <img src="images/التقاط.PNG" alt="منتج تراثي">
                    <h3>منتج تراثي أصيل</h3>
                    <p style="color: var(--light-text); margin-bottom: 10px; font-size: 14px; line-height: 1.5;">منتج تراثي يحمل عبق التاريخ الفلسطيني</p>
                    <p class="price">55.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="106">
                        <input type="hidden" name="price" value="55.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/script.js"></script>
</body>
</html>
