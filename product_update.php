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
    require_once('connect.php');
    $id = $_POST['id'];
    $name = $_POST['name'];
    $img = '';
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    if($_FILES['img']['error'] == 0){
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], 'images/'.$img);
    }
    if($img == ''){
        $sql = "UPDATE `product` SET `name`='$name', `price` = '$price',`description` = '$description' WHERE `p_id` = $id" ;
    }
    else{
        $sql = "UPDATE `product` SET `name`='$name', `price` = '$price',`img` = '$img',`description` = '$description' WHERE `p_id` = $id";
    }
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
header ('Location: product.php');
