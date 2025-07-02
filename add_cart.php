<?php
session_start();
$id = $_GET['id'];

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
  $_SESSION['cart'][$id]['quantity'] += 1;
} else {
//   $products = [
//     1 => ["name" => "منتج 1", "price" => 100],
//     2 => ["name" => "منتج 2", "price" => 150],
//   ];
$_SESSION['cart'][$id]['quantity'] = 1;
//   if (isset($product[$id])) {
//     $_SESSION['cart'][$id] = $product[$id];
//     $_SESSION['cart'][$id]['quantity'] = 1;
//   }
}

header("Location: index.php");
exit;
