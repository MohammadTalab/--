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
        echo '
        <div class="item">
            <img src="images/1.PNG" alt="">
            <h2>عنوان 1</h2>
            <p class="desc">وصف العنوان 1</p>
            <p class="price">15</p>
            <a href="#">إضافة</a>
        </div>';
    ?>
    </div>
     <?php
        require_once("connect.php");
        $sql = "SELECT * FROM product";
        $res_product = mysqli_query($conn, $sql);
            $i = 1;
            while($row = mysqli_fetch_assoc($res_product)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><img src='images/" . $row['img'] . "' width='50'></td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo '<td>';
                echo '<a href="product_add.php?id='.$row['p_id'].'" class="add">Add</a> ';
                echo '</td>';
                echo '<td>';
                echo '<a href="product_edit.php?id='.$row['p_id'].'" class="edit">Edit</a>  ';
                echo '</td>';
                echo "</tr>";
                $i++;
            }
        ?>
    </table>

</body>
</html>