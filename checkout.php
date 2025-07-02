<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart'];

foreach ($cart as $product_id => $item) {
    $quantity = (int)$item['quantity'];

    $sql = "SELECT price FROM product WHERE p_id = $product_id";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $price = $row['price'];
        $total = $price * $quantity;

        $insert = "INSERT INTO order (user_id, product_id, quantity, price, total)
                   VALUES ($user_id, $product_id, $quantity, $price, $total)";
        mysqli_query($conn, $insert);
    }
}

unset($_SESSION['cart']);

header('Location: completed.php');
exit;
?>
