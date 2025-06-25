<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    $name = $_POST['name'];
    $username = $row_cat['username'];
    $password = $row_cat['password'];
    $sql = "INSERT INTO `user` (`name`,`username`,`password`,) VALUES('$name', '$username', '$password')";
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
header ('Location: admin_show.php');