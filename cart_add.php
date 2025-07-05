<?php
session_start();

$id = $_GET['id'];
if(isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] ++; // Increment quantity if item already exists in cart
} else {
    // If item does not exist in cart, add it with quantity 1
$_SESSION['cart'][$id] = 1;
}
header("Location: product.php"); // Redirect to cart page