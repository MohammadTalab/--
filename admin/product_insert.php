<?php
session_start();

if (!isset($_SESSION['role'])) {
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
    $img = '';
    $description = $_POST['description'];
    $price = $_POST['price'];

    if($_FILES['img']['error'] == 0){
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], '../images/'.$img);
    }
    $sql = "INSERT INTO `product` (`name`,`img`,`description`,`price`) VALUES('$name','$img', '$description','$price')";
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
header ('Location: product_show.php');
