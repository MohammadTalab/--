<?php
$page_title = 'الرئيسية - متجر خير بلادك';
$current_page = 'home';
require_once 'connect.php';
require_once 'functions.php';

include 'header.php';

// تم نقل وظيفة getAllProducts إلى ملف functions.php

function addToCart($user_id, $product_id, $price) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $price = mysqli_real_escape_string($conn, $price);
    
    $check_cart_sql = "SELECT O_id FROM `order` WHERE u_id = '$user_id' AND status = 'cart' LIMIT 1";
    $cart_result = mysqli_query($conn, $check_cart_sql);
    
    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        $cart_row = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart_row['O_id'];
    } else {
        $order_date = date('Y-m-d');
        $create_cart_sql = "INSERT INTO `order` (order_date, address, status, price, u_id) VALUES ('$order_date', '', 'cart', 0, '$user_id')";
        if (mysqli_query($conn, $create_cart_sql)) {
            $cart_id = mysqli_insert_id($conn);
        } else {
            return false;
        }
    }
    
    $check_product_sql = "SELECT count FROM order_product WHERE o_id = '$cart_id' AND p_id = '$product_id'";
    $product_result = mysqli_query($conn, $check_product_sql);
    
    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product_row = mysqli_fetch_assoc($product_result);
        $new_count = $product_row['count'] + 1;
        $update_sql = "UPDATE order_product SET count = '$new_count' WHERE o_id = '$cart_id' AND p_id = '$product_id'";
        return mysqli_query($conn, $update_sql);
    } else {
        $insert_sql = "INSERT INTO order_product (p_id, o_id, count, price) VALUES ('$product_id', '$cart_id', 1, '$price')";
        return mysqli_query($conn, $insert_sql);
    }
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        $message = '<div style="color: red; text-align: center; margin-bottom: 20px;">يجب تسجيل الدخول أولاً لإضافة المنتجات للسلة</div>';
    } else {
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];
        if (addToCart($_SESSION['user_id'], $product_id, $price)) {
            $message = '<div style="color: green; text-align: center; margin-bottom: 20px;">تم إضافة المنتج للسلة بنجاح</div>';
        } else {
            $message = '<div style="color: red; text-align: center; margin-bottom: 20px;">خطأ في إضافة المنتج للسلة</div>';
        }
    }
}

$products = getAllProducts();

$featuredProducts = array_slice($products, 0, 3);
?>
<?php
$page_title = "متجر خير بلادك";
$current_page = "home";
include 'header.php';
?>
                        <main>
        <div class="hero">
            <h1>مرحباً بكم في متجر خير بلادك</h1>
            <p>أفضل المنتجات المحلية والعالمية بأسعار منافسة وجودة عالية</p>
            <a href="products.php" class="btn">تصفح المنتجات</a>
        </div>

        <?php 
if (isset($_SESSION['message'])) {
    echo '<div class="message info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
echo $message; 
?>

        <section class="featured-products">
            <h2 class="section-title">منتجات مميزة</h2>
            <div class="products-grid">
                <?php foreach ($featuredProducts as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></div>
                        <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="product-price"><?php echo htmlspecialchars($product['price']); ?> شيكل</div>
                        <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                        <div class="product-actions">
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <button type="submit" name="add_to_cart" class="add-to-cart">إضافة للسلة</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="products.php" class="btn secondary">عرض جميع المنتجات</a>
            </div>
        </section>
    </main>

<?php include 'footer.php'; ?>
                
                if (isset($_SESSION['user_id'])): ?>
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
        <section class="hero">
            <h1>أهلاً بك في متجر خير بلادك</h1>
            <p>اكتشف أجود المنتجات المحلية بأسعار تنافسية وجودة عالية</p>
            <a href="products.php" class="btn">ابدأ التسوق الآن</a>
        </section>
        
        <?php echo $message; ?>
        
        <section class="featured-products">
            <h2>منتجات مميزة</h2>
            <div class="products-grid">
                <?php if (!empty($featuredProducts)): ?>
                    <?php foreach($featuredProducts as $product): ?>
                        <div class="product-card">
                            <img src="images/<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="price"><?php echo number_format($product['price'], 2); ?> شيكل</p>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- منتجات إضافية -->
                <div class="product-card">
                    <img src="images/1.PNG" alt="منتج مميز 1">
                    <h3>زيت زيتون فلسطيني</h3>
                    <p class="price">45.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="101">
                        <input type="hidden" name="price" value="45.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <div class="product-card">
                    <img src="images/3.jpg" alt="منتج مميز 2">
                    <h3>عسل طبيعي جبلي</h3>
                    <p class="price">85.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="102">
                        <input type="hidden" name="price" value="85.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <div class="product-card">
                    <img src="images/4.jpg" alt="منتج مميز 3">
                    <h3>تمر مجهول فاخر</h3>
                    <p class="price">35.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="103">
                        <input type="hidden" name="price" value="35.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>

                <div class="product-card">
                    <img src="images/6.jpg" alt="منتج مميز 4">
                    <h3>صابون زيت الزيتون</h3>
                    <p class="price">15.00 شيكل</p>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="product_id" value="104">
                        <input type="hidden" name="price" value="15.00">
                        <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    
<?php include 'footer.php'; ?>
