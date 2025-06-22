<?php
require_once 'db.php';
session_start();

function getAllProducts() {
    global $conn;
    $sql = "SELECT p.*, c.name as category_name FROM product p 
            LEFT JOIN category c ON p.c_id = c.c_id 
            ORDER BY p.p_id";
    $result = mysqli_query($conn, $sql);
    $products = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}

function getProductById($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT p.*, c.name as category_name FROM product p 
            LEFT JOIN category c ON p.c_id = c.c_id 
            WHERE p.p_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $product = null;
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
    return $product;
}

function getAllCategories() {
    global $conn;
    $sql = "SELECT * FROM category ORDER BY c_id";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}

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
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المنتجات - متجر إلكتروني</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <header>
        <div class="logo">متجرنا</div>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="products.php" class="active">المنتجات</a></li>
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
                <?php
                if (isset($_SESSION['user_id'])): ?>
                    <li><a href="orders.php">طلباتي</a></li>
                    <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">تسجيل الدخول</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main>
        <h1 style="text-align: center; margin-bottom: 30px;">جميع المنتجات</h1>
        
        <?php echo $message; ?>
        
        <div class="products-grid">
            <?php if (!empty($products)): ?>
                <?php foreach($products as $product): ?>
                    <div class="product-card" data-product-id="<?php echo $product['p_id']; ?>">
                        <img src="images/<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p style="color: #666; margin-bottom: 10px; font-size: 14px;"><?php echo htmlspecialchars($product['description']); ?></p>
                        <?php if (isset($product['category_name'])): ?>
                            <p style="color: #3498db; font-size: 12px; margin-bottom: 10px;">التصنيف: <?php echo htmlspecialchars($product['category_name']); ?></p>
                        <?php endif; ?>
                        <p class="price"><?php echo number_format($product['price'], 2); ?> شيكل</p>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="product_id" value="<?php echo $product['p_id']; ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            <button type="submit" name="add_to_cart" class="btn">إضافة للسلة</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; grid-column: 1 / -1;">لا توجد منتجات متاحة حالياً</p>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجرنا الإلكتروني</p>
    </footer>
    
    <script src="static/script.js"></script>
</body>
</html>

