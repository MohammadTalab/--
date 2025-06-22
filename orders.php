<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
function getUserOrders($user_id) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    
    $sql = "SELECT * FROM `order` WHERE `u_id` = '$user_id' AND status != 'cart' ORDER BY order_date DESC";
    $result = mysqli_query($conn, $sql);
    $orders = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $order_id = $row['O_id'];
            
            $products_sql = "SELECT op.*, p.name, p.img FROM order_product op 
                           JOIN product p ON op.p_id = p.p_id 
                           WHERE op.o_id = $order_id";
            $products_result = mysqli_query($conn, $products_sql);
            $products = [];
            
            if ($products_result && mysqli_num_rows($products_result) > 0) {
                while($product_row = mysqli_fetch_assoc($products_result)) {
                    $products[] = $product_row;
                }
            }
            
            $row['products'] = $products;
            $orders[] = $row;
        }
    }
    return $orders;
}

$orders = getUserOrders($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلباتي - متجر إلكتروني</title>
    <link rel="stylesheet" href="static/styles.css">
    <style>
        .orders-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        
        .order-status {
            padding: 5px 15px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-processing { background-color: #f39c12; }
        .status-shipped { background-color: #3498db; }
        .status-delivered { background-color: #27ae60; }
        .status-cancelled { background-color:rgb(68, 0, 0); }
        
        .order-products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .product-item {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        
        .product-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
            margin-left: 10px;
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .product-details {
            font-size: 12px;
            color: #666;
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
                <li><a href="orders.php" class="active">طلباتي</a></li>
                <li><a href="logout.php">تسجيل خروج</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <div class="orders-container">
            <h1 style="text-align: center; margin-bottom: 30px;">طلباتي</h1>
            
            <?php if (empty($orders)): ?>
                <div style="text-align: center; padding: 50px;">
                    <h3>لا توجد طلبات</h3>
                    <p>لم تقم بأي طلبات بعد</p>
                    <a href="products.php" class="btn">تصفح المنتجات</a>
                </div>
            <?php else: ?>
                <?php foreach($orders as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <h3>طلب رقم: <?php echo $order['O_id']; ?></h3>
                                <p style="color: #666; margin: 5px 0;">تاريخ الطلب: <?php echo date('d/m/Y', strtotime($order['order_date'])); ?></p>
                                <p style="color: #666; margin: 5px 0;">العنوان: <?php echo htmlspecialchars($order['address']); ?></p>
                            </div>
                            <div style="text-align: left;">
                                <?php
                                $statusClass = 'status-processing';
                                $statusText = $order['status'];
                                
                                switch($order['status']) {
                                    case 'مشحون':
                                        $statusClass = 'status-shipped';
                                        break;
                                    case 'تم التسليم':
                                        $statusClass = 'status-delivered';
                                        break;
                                    case 'ملغي':
                                        $statusClass = 'status-cancelled';
                                        break;
                                }
                                ?>
                                <span class="order-status <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                <p style="font-weight: bold; margin-top: 10px; font-size: 18px;">
                                    المجموع: <?php echo number_format($order['price'], 2); ?> شيكل
                                </p>
                            </div>
                        </div>
                        
                        <?php if (!empty($order['products'])): ?>
                            <div class="order-products">
                                <?php foreach($order['products'] as $product): ?>
                                    <div class="product-item">
                                        <img src="images/<?php echo htmlspecialchars($product['img']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                        <div class="product-info">
                                            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                                            <div class="product-details">
                                                الكمية: <?php echo $product['count']; ?> × <?php echo number_format($product['price'], 2); ?> شيكل
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجرنا الإلكتروني</p>
    </footer>
</body>
</html>