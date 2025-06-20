<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض المنتجات</title>
</head>
<body>
<?php
require_once('connect.php');
$sql = "SELECT * from `category`";
$res_cat = mysqli_query($conn, $sql);
while($row_cat = mysqli_fetch_array($res_cat)){
    echo 'name: '.$row_cat['name'].'<br>';;
    echo 'Image: <img src="images/'.$row_cat['img'].'"><br>';;
    echo 'Description: '.$row_cat['description'].'<br>';;
    echo '-----------------------';
}

?>
</body>
</html>