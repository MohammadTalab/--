<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "UPDATE `user` SET `name`='$name', `email` =$email , `password` =$password WHERE `u_id` = $id";
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
header ('Location: user.php');