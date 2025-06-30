<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: cart.php");
    exit;
}

$product_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// الحصول على معرف سلة التسوق النشطة
$check_cart_sql = "SELECT O_id FROM `order` WHERE u_id = '$user_id' AND status = 'cart' LIMIT 1";
$cart_result = mysqli_query($conn, $check_cart_sql);

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    $cart_row = mysqli_fetch_assoc($cart_result);
    $cart_id = $cart_row['O_id'];
    
    // التحقق من وجود المنتج في السلة
    $check_product_sql = "SELECT count FROM order_product WHERE o_id = '$cart_id' AND p_id = '$product_id'";
    $product_result = mysqli_query($conn, $check_product_sql);
    
    if ($product_result && mysqli_num_rows($product_result) > 0) {
        $product_row = mysqli_fetch_assoc($product_result);
        
        if ($product_row['count'] > 1) {
            // تقليل الكمية إذا كانت أكثر من واحد
            $new_count = $product_row['count'] - 1;
            $update_sql = "UPDATE order_product SET count = '$new_count' WHERE o_id = '$cart_id' AND p_id = '$product_id'";
            mysqli_query($conn, $update_sql);
        } else {
            // حذف المنتج من السلة إذا كانت الكمية واحد
            $delete_sql = "DELETE FROM order_product WHERE o_id = '$cart_id' AND p_id = '$product_id'";
            mysqli_query($conn, $delete_sql);
        }
        
        $_SESSION['message'] = 'تم تحديث السلة بنجاح';
    }
}

header("Location: cart.php");
exit;
