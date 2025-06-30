<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = 'يرجى تسجيل الدخول أولاً لإضافة منتجات إلى السلة';
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$product_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

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
        $_SESSION['message'] = 'حدث خطأ أثناء إنشاء سلة التسوق';
        header("Location: index.php");
        exit;
    }
}

$check_product_sql = "SELECT count FROM order_product WHERE o_id = '$cart_id' AND p_id = '$product_id'";
$product_result = mysqli_query($conn, $check_product_sql);

if ($product_result && mysqli_num_rows($product_result) > 0) {
    $product_row = mysqli_fetch_assoc($product_result);
    $new_count = $product_row['count'] + 1;
    $update_sql = "UPDATE order_product SET count = '$new_count' WHERE o_id = '$cart_id' AND p_id = '$product_id'";
    mysqli_query($conn, $update_sql);
} else {
    $insert_sql = "INSERT INTO order_product (o_id, p_id, count) VALUES ('$cart_id', '$product_id', 1)";
    mysqli_query($conn, $insert_sql);
}

$_SESSION['message'] = 'تمت إضافة المنتج إلى السلة بنجاح';
header("Location: index.php");
exit;
