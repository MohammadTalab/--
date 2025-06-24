<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    // var_dump($_FILES);
    $id = $_POST['id'];
    if(isset($_POST['yes'])){
        $sql = "DELETE FROM `category` WHERE `c_id` = $id";
        if(mysqli_query($conn, $sql))
        {
            echo 'succed';
        }
    }
  else{
    echo 'error';
  }
}
header ('Location: category.php');