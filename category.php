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
    include_once("include/header.php");
    include_once("include/menu.php");
    ?>

    <div><a href="category_add.php" class="btn">Add New Category</a></div>
    <table class="show">
        <tr>
            <th>#</th>
            <th>name</th>
            <th>img</th>
            <th>description</th>
            <th>price</th>
        </tr>

        <?php
        require_once("include/connect.php");
        $sql = "SELECT * FROM category";
        $res_category = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res_category) > 0) {
            $i = 1;
            while($row = mysqli_fetch_assoc($res_category)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td><img src='../images/" . $row['img'] . "' width='50'></td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "</tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        ?>
    </table>

    <?php include_once("include/footer.php"); ?>
</body>
</html>