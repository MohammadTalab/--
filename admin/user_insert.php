<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "لا تملك صلاحية الوصول لهذه الصفحة.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../connect.php');
    $name = $_POST['name'];
    $email = $row_cat['email'];
    $password = $row_cat['password'];
    $sql = "INSERT INTO user (name,email,password,) VALUES('$name', 'email', '$password')";
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
header ('Location: user_show.php');