<?php
session_start();

$_SESSION['cart'][$_GET['id']]--;

if ($_SESSION['cart'][$_GET['id']] <= 0) {
    unset($_SESSION['cart'][$_GET['id']]);
}

header("Location: cart.php"); // Redirect to cart page
exit();
