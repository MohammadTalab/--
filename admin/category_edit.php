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
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة صنف</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<?php
require_once('../connect.php');
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM category WHERE c_id = '" . $_GET['id'] . "'";;
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $description = $row_cat['description'];
    $img = $row_cat['img'];

// include('include/header.php');
// include('include/menu.php');
?>
    <form action="category_update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <table class="form">
            <caption>تعديل صنف</caption>
            <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name" value="<?php echo $name;?>"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <img src='images/<?php echo $img;?>' width='100px' alt='صورة الصنف'>
                </td>
            </tr>
            <tr>
                <td><label for="img">الصور:</label></td>
                <td><input type="file" name="img" id="img"></td>
            </tr>
            <tr>
                <td><label for="description">الوصف:</label></td>
                <td><textarea name="description" id="description" cols="40" rows="10"><?php echo $description;?></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="تعديل"></td>
            </tr>
        </table>
    </form>
<?php
}
// include('include/footer.php');
?>
</body>
</html>