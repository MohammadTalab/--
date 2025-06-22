<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once('db.php');
    var_dump($_FILES); 
    $name = $_POST['name'];
    $description = $_POST['description'];
    $img = '';
    $price = $_POST['price'];

    if ($_FILES['img']['error'] == 0) {
        $img = $_FILES['img']['name'];
        move_uploaded_file($_FILES['img']['tmp_name'], 'images/' . $img);
    }
    $sql = "INSERT INTO `product` (`name`, `description`, `img`, `price`) VALUES ('$name', '$description', '$img', '$price')";  
    if (mysqli_query($conn, $sql)) {
        echo 'success';
    } else {
        echo 'error: ' ;
    }
}
?>
