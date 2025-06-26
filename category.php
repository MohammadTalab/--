<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php
   // include_once("include/header.php");
  //  include_once("include/menu.php");
    ?>

    <div><a href="category_add.php" class="btn">Add New Category</a></div>
    <table class="show">
        <tr>
            <th>#</th>
            <th>name</th>
            <th>img</th>
            <th>description</th>
        </tr>

        <?php
        require_once("connect.php");
        $sql = "SELECT * FROM category";
        $res_category = mysqli_query($conn, $sql);
            $i = 1;
            while($row = mysqli_fetch_assoc($res_category)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><img src='images/" . $row['img'] . "' width='50'></td>";
                echo "<td>" . $row['description'] . "</td>";
                echo '<td>';
                echo '<a href="category_edit.php?id='.$row['c_id'].'">Edit</a> ';
                echo '<a href="category_delete.php?id='.$row['c_id'].'">Delete</a> ';
                echo '</td>';
                echo "</tr>";
                $i++;
            }

        ?>
    </table>

  <?php// include_once("include/footer.php"); ?>
</body>
</html>