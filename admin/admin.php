<?php
session_start();

if (!isset($_SESSION['user_id'])) {
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
    <title>لوحة الإدارة - متجر خير بلادك</title>
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <?php
    // عرض رسائل النظام إن وجدت
    if (isset($_SESSION['message'])) {
        echo '<div class="message info">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>
    <div><a href="admin_add.php" class="btn">إضافة مشرف جديد</a></div>
    <table class="show">
        <tr>
            <th>u_id</th>
            <th>name</th>
            <th>username</th>
            <th>password</th>
        </tr>

        <?php
        require_once("../connect.php");
        $sql = "SELECT * FROM admin";
        $res_user = mysqli_query($conn, $sql);
            $i = 1;
            while($row = mysqli_fetch_assoc($res_user)) {
                echo "<tr>";
                echo "<td>" . $row['a_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
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