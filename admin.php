<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin List</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div><a href="admin_add.php" class="btn">Add New admin</a></div>
    <table class="show">
        <tr>
            <th>u_id</th>
            <th>name</th>
            <th>user name</th>
            <th>password</th>
        </tr>

        <?php
        require_once("connect.php");
        $sql = "SELECT * FROM admin";
        $res_user = mysqli_query($conn, $sql);
            $i = 1;
            while($row = mysqli_fetch_assoc($res_admin)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['user name'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo '<td>';
                echo '<a href="admin_edit.php?id='.$row['a_id'].'">Edit</a> ';
                echo '<a href="admin_delete.php?id='.$row['a_id'].'">Delete</a> ';
                echo '</td>';
                echo "</tr>";
                $i++;
            }
        ?>
    </table>
</body>
</html>