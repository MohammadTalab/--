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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>إضافة مستخدم</title>
    <link rel="stylesheet" href="../style/style.css"/>
</head>
<body>
<?php
require_once('../connect.php');


$sql = "SELECT  u_id ,name , email, password FROM user";
$res = mysqli_query($conn, $sql);
 
    echo '<table>';
    echo '<caption>عرض المستخدمين</caption>';
    echo '<tr><th>اسم المستخدم</th><th>البريد الإلكتروني</th><th>كلمة المرور</th></tr>';

    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['password'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';

?>
</body>
</html>