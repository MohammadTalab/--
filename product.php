<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product List</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php
   // include_once("include/header.php");
  //  include_once("include/menu.php");
    ?>

    <div><a href="product_add.php" class="btn">Add New product</a></div>
    <table class="show">
        <tr>
            <th>name</th>
            <th>img</th>
            <th>description</th>
            <th>price</th>
        </tr>

        <?php
        require_once("connect.php");
        $sql = "SELECT * FROM product";
        $res_product = mysqli_query($conn, $sql);
    {
            $i = 1;
            while($row = mysqli_fetch_assoc($res_product)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><img src='images/" . $row['img'] . "' width='50'></td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo '<td>';
                echo '<a href="category_edit.php?id='.$row['p_id'].'">Edit</a> ';
                echo '<a href="category_delete.php?id='.$row['p_id'].'">Delete</a> ';
                echo '</td>';
                echo "</tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        ?>
    </table>

  <?php// include_once("include/footer.php"); ?>
</body>
</html>