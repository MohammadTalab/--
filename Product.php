<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <?php
        // $_SESSION['cart'];
       echo 5;
        require_once("connect.php");
        $sql = "SELECT * FROM product";
        $res_product = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($res_product)) {
            echo '
            <div class="item">
                <img src="images/'.$row['img'].'" alt="">
                <h2>'.$row['name'].'</h2>
                <p class="desc">'.$row['description'].'</p>
                <p class="price">'.$row['price'].'</p>
                <a href="cart_add.php?id='.$row['p_id'].'">add to cart</a>
            </div>';
        }
    ?>
    </div>

</body>
</html>