<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    var_dump($_FILES);
    $name = $_POST['name'];
    $img = '';
    $description = $_POST['description'];
    $price = $_POST['price'];


    if($_FILES['img']['error'] == 0){
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], 'images/'.$img);
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
// header ('Location: category_show.php')