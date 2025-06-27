<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../connect.php');

    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE `user` SET `name`='$name', `email`='$email', `password`='$hashed_password' WHERE `u_id` = $id";

    if(mysqli_query($conn, $sql)) {
        echo 'تم التعديل بنجاح';
    } else {
        echo 'حدث خطأ أثناء التعديل';
    }
    
    header('Location: user.php');
    exit();
}
?>
