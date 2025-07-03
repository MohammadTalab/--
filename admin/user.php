
<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    echo "لا تملك صلاحية الوصول لهذه الصفحة.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user List</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div><a href="user_add.php" class="btn">Add New user</a></div>
    <table class="show">
        <tr>
            <th>u_id</th>
            <th>name</th>
            <th>email</th>
            <th>password</th>
        </tr>

        <?php
        require_once("connect.php");
        $sql = "SELECT * FROM user";
        $res_user = mysqli_query($conn, $sql);
            $i = 1;
            while($row = mysqli_fetch_assoc($res_user)) {
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo '<td>';
                echo '<a href="u_id_edit.php?id='.$row['u_id'].'">Edit</a> ';
                echo '<a href="u_id_delete.php?id='.$row['u_id'].'">Delete</a> ';
                echo '</td>';
                echo "</tr>";
                $i++;
            }
        ?>
    </table>
</body>
</html>