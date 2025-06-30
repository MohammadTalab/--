<?php
$page_title = 'طلباتي - متجر خير بلادك';
$current_page = 'orders';
require_once 'connect.php';
require_once 'functions.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

include 'header.php';
?>

    <main>
        <div class="orders-container">
            <h2>طلباتي</h2>
            <div class="empty-orders">
                <p>لا توجد طلبات حالياً</p>
                <a href="products.php" class="btn">تصفح المنتجات</a>
            </div>
        </div>
    </main>

<?php include 'footer.php'; ?>
