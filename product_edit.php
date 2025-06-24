<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة صنف</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        body {
            background: #f7f7fa;
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        form {
            max-width: 400px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px #0001;
            padding: 32px 24px 24px 24px;
        }
        table.form {
            width: 100%;
        }
        table.form caption {
            font-size: 1.5em;
            color: #2d3e50;
            margin-bottom: 18px;
            font-weight: bold;
        }
        table.form td {
            padding: 10px 0;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1em;
            background: #f9fafb;
            transition: border 0.2s;
        }
        input[type="text"]:focus, textarea:focus {
            border: 1.5px solid #4f8cff;
            outline: none;
        }
        input[type="submit"] {
            background: linear-gradient(90deg, #4f8cff, #38b6ff);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 0;
            width: 100%;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        input[type="submit"]:hover {
            background: linear-gradient(90deg, #38b6ff, #4f8cff);
        }
    </style>
</head>
<body>
<?php
require_once('connect.php');
$sql = "SELECT * FROM `product` WHERE p_id = " . $_GET['id'];
$res_cat = mysqli_query($conn, $sql);
if($row_cat = mysqli_fetch_assoc($res_cat)) {
    $name = $row_cat['name'];
    $description = $row_cat['description'];
    $img = $row_cat['img'];
    $price = $row_cat['price'];


// include('include/header.php');
// include('include/menu.php');
?>
    <form action="product_update.php" method="post" enctype="multipart/form-data">
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
                <td><label for="price">السعر:</label></td>
                <td><input type="number" step="0.01" name="price" id="price" value="<?php echo $price;?>"></td>
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