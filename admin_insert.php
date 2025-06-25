<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "INSERT INTO `admin` (`name`,`username`,`password`) VALUES('$name', '$username', '$password')";
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
header ('Location: admin_show.php');