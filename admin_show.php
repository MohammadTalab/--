<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <title>اظهار المدير </title>
    <link rel="stylesheet" href="static/style.css"/>
</head>
<body>
<?php
require_once('connect.php');

if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
    echo 'مرحبا بك يا '.$_SESSION['name'];

}
else{
    header('Location: admin_logout.php');
}

$sql = "SELECT  * FROM admin";
$res = mysqli_query($conn, $sql);
     echo '<table class="show">';
    echo '<caption>عرض المديرين</caption>';
    echo '<tr>
        <th>اسم المدير</th>
        <th> اسم المستخدم</th>
        <th>كلمة المرور</th>
        <th>خيارات</th>
        </tr>';
  
    while ($row = mysqli_fetch_assoc($res)) {
        echo '<tr>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['username'] . '</td>';
        echo '<td>' . $row['password'] . '</td>';
        echo '<td>';
        echo '<a href="admin_edit.php?id='.$row['a_id'].'">تعديل</a>';
        echo ' ';
        echo '<a href="admin_delete.php?id='.$row['a_id'].'">حذف</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
?>
</body>
</html>
