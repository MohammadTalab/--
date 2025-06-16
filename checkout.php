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
    
    $sql = "SELECT o.O_id, op.p_id, op.count, op.price, p.name, p.img
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

$cart_items = getCartItems($_SESSION['user_id']);
$order_success = null;
$error_message = '';

if (empty($cart_items)) {
    header('Location: cart.php');
    exit;
}

$subtotal = 0;
foreach ($cart_items as $item) {
    $subtotal += $item['price'] * $item['count'];
}
$shipping = 20;
$tax = $subtotal * 0.15;
$total = $subtotal + $shipping + $tax;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    
    $full_address = $address . ', ' . $city . ', ' . $postal_code;
    $order_date = date('Y-m-d');
    $status = 'قيد المعالجة';
    
    $order_sql = "INSERT INTO `order` (order_date, address, status, price, u_id) VALUES ('$order_date', '$full_address', '$status', '$total', '$user_id')";
    
    if (mysqli_query($conn, $order_sql)) {
        $new_order_id = mysqli_insert_id($conn);
        
        $success = true;
        foreach ($cart_items as $item) {
            $item_sql = "INSERT INTO order_product (p_id, o_id, count, price) VALUES ('{$item['p_id']}', '$new_order_id', '{$item['count']}', '{$item['price']}')";
            if (!mysqli_query($conn, $item_sql)) {
                $success = false;
                break;
            }
        }
        
        if ($success) {
            mysqli_query($conn, "DELETE op FROM order_product op JOIN `order` o ON op.o_id = o.O_id WHERE o.u_id = '$user_id' AND o.status = 'cart'");
            mysqli_query($conn, "DELETE FROM `order` WHERE u_id = '$user_id' AND status = 'cart'");
            
            $order_success = true;
            $cart_items = [];
        } else {
            $order_success = false;
            $error_message = 'حدث خطأ في حفظ المنتجات';
        }
    } else {
        $order_success = false;
        $error_message = 'حدث خطأ في إنشاء الطلب';
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إتمام الشراء - متجر إلكتروني</title>
    <link rel="stylesheet" href="static/styles.css">
    <style>
        .checkout-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .checkout-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        @media (max-width: 768px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .order-total {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }
        
        .place-order-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #3498db;
            color: white;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
        }
        
        .place-order-btn:hover {
            background-color: #2980b9;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
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
                    <a href="cart.php">السلة
                        <?php
                            $cart_count = getCartCount($_SESSION['user_id']);
                            if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li><a href="orders.php">طلباتي</a></li>
                <li><a href="logout.php">تسجيل خروج (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="checkout-container">
            <h1>إتمام الشراء</h1>
            
            <?php if ($order_success === true): ?>
                <div class="success-message">
                    <h2>تم تأكيد طلبك بنجاح!</h2>
                    <p>شكراً لك على الشراء من متجرنا</p>
                    <a href="orders.php" class="btn">عرض طلباتي</a>
                    <a href="index.php" class="btn">العودة للرئيسية</a>
                </div>
            <?php elseif ($order_success === false): ?>
                <div class="error-message">
                    <h2>خطأ في معالجة الطلب</h2>
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($order_success !== true): ?>
            <div class="checkout-grid">
                <div class="checkout-form">
                    <form method="POST" action="checkout.php">
                        <div class="form-section">
                            <h2>معلومات الشحن</h2>
                            <div class="form-group">
                                <label for="name">الاسم الكامل</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">البريد الإلكتروني</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">رقم الهاتف</label>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="address">العنوان</label>
                                <input type="text" id="address" name="address" required>
                            </div>
                            <div class="form-group">
                                <label for="city">المدينة</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="postal_code">الرمز البريدي</label>
                                <input type="text" id="postal_code" name="postal_code" required>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h2>طريقة الدفع</h2>
                            <p>الدفع عند التوصيل</p>
                            <div style="background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin-top: 15px;">
                                <p style="margin: 0; color: #155724; font-size: 14px;">
                                    ✓ ادفع بكل راحة عند استلام طلبك
                                </p>
                            </div>
                        </div>
                        
                        <button type="submit" class="place-order-btn">تأكيد الطلب</button>
                    </form>
                </div>
                
                <div>
                    <div class="order-summary">
                        <h2>ملخص الطلب</h2>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="order-item">
                                <span><?php echo htmlspecialchars($item['name']); ?> (<?php echo $item['count']; ?>x)</span>
                                <span><?php echo number_format($item['price'] * $item['count'], 2); ?> شيكل</span>
                            </div>
                        <?php endforeach; ?>
                        <hr>
                        <div class="order-item">
                            <span>المجموع الفرعي</span>
                            <span><?php echo number_format($subtotal, 2); ?> شيكل</span>
                        </div>
                        <div class="order-item">
                            <span>الشحن</span>
                            <span><?php echo number_format($shipping, 2); ?> شيكل</span>
                        </div>
                        <div class="order-item">
                            <span>الضريبة (15%)</span>
                            <span><?php echo number_format($tax, 2); ?> شيكل</span>
                        </div>
                        <hr>
                        <div class="order-total">
                            <span>المجموع الكلي:</span>
                            <span><?php echo number_format($total, 2); ?> شيكل</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 متجرنا الإلكتروني</p>
    </footer>
</body>
</html>