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
    <table class="show">
        <tr>
            <th>#</th>
            <th>name</th>
            <th>image</th>
            <th>price</th>
            <th>quantity</th>
            <th>total</th>
            <th>delete</th>
            <th>edit</th>
        </tr>
        <?php
        $cart = $_SESSION['cart'];
        require_once("connect.php");

        $sum = 0;
        
        foreach($cart as $id => $item){
            $sql = "SELECT * FROM `product` WHERE `p_id` = $id";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            echo '
            <tr>
                <td>1</td>
                <td>'.$row['name'].'</td>
                <td><img src="images/'.$row['img'].'"></td>
                <td>'.$row['price'].'</td>
                <td>'.$item.'</td>
                <td>'.($row['price']*$item).'</td>
                <td><a href="cart_delete.php?id='.$id.'" class="delete">Delete</a></td>
                <td><a href="cart_add.php?id='.$id.'" class="edit">add</a></td>

            </tr>';
            $sum += $row['price']*$item;
        }
        ?>
        <tr>
            <th colspan="5">المجموع</th>
  <th><?php echo $sum;?></th>          
</tr>
    </table>
</body>
</html>