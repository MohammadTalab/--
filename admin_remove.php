<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    $id = $_POST['id'];
    if(isset($_POST['yes'])){
        $sql = "DELETE FROM `admin` WHERE `a_id` = $id";
        if(mysqli_query($conn, $sql))
        {
            echo 'succed';
        }
    }
  else{
    echo 'error';
  }
}
header ('Location: admin.php');