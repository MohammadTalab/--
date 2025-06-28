<?php
session_start();
$id = $_GET['id'];

if (isset($_SESSION['cart'][$id])) {
    if($_SESSION['cart'][$id]['quantity'] == 1){
        unset($_SESSION['cart'][$id]);
    }
    else{
        $_SESSION['cart'][$id]['quantity'] -- ;
    }
}

header("Location: cart.php");
exit;
