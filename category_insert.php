<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('connect.php');
    var_dump($_FILES);
    $name = $_POST['name'];
    $img = '';
    $description = $_POST['description'];

    if($_FILES['img']['error'] == 0){
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], 'images/'.$img);
    }
    $sql = "INSERT INTO `category` (`name`,`img`,`description`) VALUES('$name','$img', '$description')";
    if(mysqli_query($conn, $sql))
    {
        echo 'succed';
    }
  else{
    echo 'error';
  }
}
// header ('Location: category_show.php')