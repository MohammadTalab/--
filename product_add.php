<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>إضافة منتج</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="../style/style.css"/>
    <style>
        body {
            background: #f7f7fa;
            font-family: 'Cairo', Tahoma, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        form {
            max-width: 500px;
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
        input[type="text"], input[type="number"], textarea, select, input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1em;
            background: #f9fafb;
            transition: border 0.2s;
        }
        input[type="text"]:focus, input[type="number"]:focus, textarea:focus, select:focus {
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
// include_once('header.php');
// include_once('menu.php');
require_once('db.php');


$sql = "SELECT * FROM `category` ORDER BY `name`";
$res_category = mysqli_query($conn, $sql);
?>

<form action="product_insert.php" method="post" enctype="multipart/form-data">
    <table class="form">
        <caption>إضافة منتج</caption>

        <tr>
            <td><label for="name">اسم المنتج:</label></td>
            <td><input type="text" name="name" id="name" required></td>
        </tr>

        <tr>
            <td><label for="category">التصنيف:</label></td>
            <td>
                <select name="category" id="category" required>
                    <option value="">اختر التصنيف </option>
                    <?php
                    while ($row = mysqli_fetch_assoc($res_category)) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td><label for="description">الوصف:</label></td>
            <td><textarea name="description" id="description" rows="4" cols="30"></textarea></td>
        </tr>

        <tr>
            <td><label for="price">السعر:</label></td>
            <td><input type="number" name="price" id="price" step="0.01" required></td>
        </tr>

        <tr>
            <td><label for="img">صورة المنتج:</label></td>
            <td><input type="file" name="img" id="img" accept="image/*" required></td>
        </tr>

        <tr>
            <td colspan="2" style="text-align:center;">
                <input type="submit" name="submit" value="إرسال">
            </td>
        </tr>
    </table>
</form>

</body>
</html>
