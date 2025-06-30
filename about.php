<?php
require_once 'connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>من نحن - متجر خير بلادك</title>
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
                <li><a href="about.php" class="active">من نحن</a></li>
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
                    <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                    <li><a href="register.php">تسجيل جديد</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="about-section">
            <h2>مرحباً بكم في متجر خير بلادك</h2>
            
            <div class="about-content">
                <div class="mission-section">
                    <h3>رسالتنا</h3>
                    <p>نحن في متجر خير بلادك نسعى لتقديم أفضل المنتجات المحلية والعالمية بأسعار منافسة وجودة عالية. هدفنا هو خدمة عملائنا الكرام وتوفير تجربة تسوق مميزة ومريحة.</p>
                </div>

                <div class="vision-section">
                    <h3>رؤيتنا</h3>
                    <p>أن نكون المتجر الإلكتروني الرائد في المنطقة، ونساهم في دعم الاقتصاد المحلي من خلال تسويق المنتجات المحلية والحرفية التراثية.</p>
                </div>

                <div class="values-section">
                    <h3>قيمنا</h3>
                    <ul>
                        <li>الثقة والمصداقية في التعامل</li>
                        <li>الجودة العالية في جميع منتجاتنا</li>
                        <li>التوصيل السريع والآمن</li>
                        <li>الأسعار العادلة والمنافسة</li>
                        <li>خدمة العملاء المتميزة</li>
                    </ul>
                </div>

                <div class="contact-section">
                    <h3>تواصل معنا</h3>
                    <div class="contact-info">
                        <p>📧 البريد الإلكتروني: info@kheirbiladak.com</p>
                        <p>📱 الهاتف: +970-123-456-789</p>
                        <p>📍 العنوان: فلسطين - غزة</p>
                        <p>🕒 ساعات العمل: من السبت إلى الخميس، 9:00 ص - 6:00 م</p>
                    </div>
                </div>

                <div class="team-section">
                    <h3>👥 فريق العمل</h3>
                    <p>نحن فريق شاب ومتحمس، نعمل بجد لتقديم أفضل خدمة لعملائنا. نؤمن بأن النجاح يأتي من خلال العمل الجماعي والتفاني في الخدمة.</p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="static/JavaScript.js"></script>
</body>
</html>
