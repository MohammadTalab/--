<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    require_once('connect.php');
    $sql = "SELECT * FROM product";
    $res = mysqli_query($conn, $sql);
    ?>
    <header>
        <h1>Kheairbladak</h1>
    </header>
    <?php
    if (mysqli_num_rows($res) > 0) {
        echo '<table>';
        echo '<caption>عرض المنتجات</caption>';
        echo '<tr><th>اسم المنتج</th><th>السعر</th><th>الوصف</th></tr>';

        while ($row = mysqli_fetch_assoc($res)) {
            echo '<tr>';
            echo "<td><img src='images/" . $row['img'] . "' width='50'></td>";
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['price'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo '<p style="text-align:center; margin-top:20px;">لا يوجد منتجات لعرضها حالياً.</p>';
    }
    ?>
    <div>
       
    </div>

</body>
</html>