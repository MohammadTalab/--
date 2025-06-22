<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

function getCartItems($user_id) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    
    $sql = "SELECT o.O_id, op.p_id, op.count, op.price, p.name, p.img, p.description
            FROM `order` o
            JOIN order_product op ON o.O_id = op.o_id
            JOIN product p ON op.p_id = p.p_id
            WHERE o.u_id = '$user_id' AND o.status = 'cart'";
    
    $result = mysqli_query($conn, $sql);
    $cart_items = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
        }
    }
    return $cart_items;
}

function removeFromCart($user_id, $product_id) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $product_id = mysqli_real_escape_string($conn, $product_id);
    
    $sql = "DELETE op FROM order_product op
            JOIN `order` o ON op.o_id = o.O_id
            WHERE o.u_id = '$user_id' AND op.p_id = '$product_id' AND o.status = 'cart'";
    
    return mysqli_query($conn, $sql);
}

function updateCartQuantity($user_id, $product_id, $quantity) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $product_id = mysqli_real_escape_string($conn, $product_id);
    $quantity = mysqli_real_escape_string($conn, $quantity);
    
    $sql = "UPDATE order_product op
            JOIN `order` o ON op.o_id = o.O_id
            SET op.count = '$quantity'
            WHERE o.u_id = '$user_id' AND op.p_id = '$product_id' AND o.status = 'cart'";
    
    return mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['remove_item'])) {
        removeFromCart($_SESSION['user_id'], $_POST['product_id']);
    } elseif (isset($_POST['update_quantity'])) {
        updateCartQuantity($_SESSION['user_id'], $_POST['product_id'], $_POST['quantity']);
    }
    header('Location: cart.php');
    exit;
}

$cart_items = getCartItems($_SESSION['user_id']);
$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['count'];
}
$shipping = 20;
$tax = $subtotal * 0.15;
$total = $subtotal + $shipping + $tax;
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة التسوق - متجر إلكتروني </title>
    <link rel="stylesheet" href="static/styles.css">
    <style>
        .cart-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .cart-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .cart-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: right;
            border-bottom: 2px solid #ddd;
        }
        
        .cart-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #ddd;
        }
        
        .cart-table img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .quantity-input {
            width: 60px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .remove-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .cart-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        
        .cart-summary h2 {
            margin-bottom: 15px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .checkout-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color:rgb(68, 0, 0);
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        
        .checkout-btn:hover {
            background-color:rgb(68, 0, 0);
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">متجرنا</div>
        <nav>
            <ul>
                <li><a href="index.php">الرئيسية</a></li>
                <li><a href="products.php">المنتجات</a></li>
                <li><a href="about.php">من نحن</a></li>
                <li>
                    <a href="cart.php" class="active">السلة
                        <?php
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
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
        <div class="cart-container">
            <h1>سلة التسوق</h1>
            
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>الوصف</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>المجموع</th>
                        <th>إزالة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($cart_items)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px;">
                                السلة فارغة. <a href="products.php">تصفح المنتجات</a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                                <td><img src="images/<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($item['description']); ?></small>
                                </td>
                                <td><?php echo number_format($item['price'], 2); ?> شيكل</td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['p_id']; ?>">
                                        <input type="number" name="quantity" class="quantity-input" value="<?php echo $item['count']; ?>" min="1" onchange="this.form.submit()">
                                        <input type="hidden" name="update_quantity" value="1">
                                    </form>
                                </td>
                                <td><?php echo number_format($item['price'] * $item['count'], 2); ?> شيكل</td>
                                <td>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['p_id']; ?>">
                                        <button type="submit" name="remove_item" class="remove-btn">إزالة</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if (!empty($cart_items)): ?>
                <div class="cart-summary">
                    <h2>ملخص الطلب</h2>
                    <div class="summary-row">
                        <span>المجموع الفرعي:</span>
                        <span><?php echo number_format($subtotal, 2); ?> شيكل</span>
                    </div>
                    <div class="summary-row">
                        <span>الشحن:</span>
                        <span><?php echo number_format($shipping, 2); ?> شيكل</span>
                    </div>
                    <div class="summary-row">
                        <span>الضريبة (15%):</span>
                        <span><?php echo number_format($tax, 2); ?> شيكل</span>
                    </div>
                    <hr>
                    <div class="summary-row" style="font-weight: bold; margin-top: 15px;">
                        <span>المجموع الكلي:</span>
                        <span><?php echo number_format($total, 2); ?> شيكل</span>
                    </div>
                    
                    <a href="checkout.php" class="checkout-btn">إتمام الشراء</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجرنا الإلكتروني</p>
    </footer>
</body>
</html>