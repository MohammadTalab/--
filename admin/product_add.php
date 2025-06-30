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
    <title>إضافة منتج - متجر خير بلادك</title>
    <link rel="shortcut icon" href="../images/LOGO.jpg" type="image/x-icon">
    <link rel="stylesheet" href="../static/styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <img src="../images/LOGO.jpg" alt="شعار متجر خير بلادك" class="logo-img">
            <a href="../index.php" class="logo-text">متجر خير بلادك</a>
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">الرئيسية</a></li>
                <li><a href="products.php">إدارة المنتجات</a></li>
                <li><a href="product_add.php" class="active">إضافة منتج</a></li>
                <li><a href="admin.php">لوحة الإدارة</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <form action="product_insert.php" method="post" enctype="multipart/form-data">
        <table class="form">
            <caption>إضافة منتج</caption>
            <tr>
                <td><label for="name">الاسم:</label></td>
                <td><input type="text" name="name" id="name"></td>
            </tr>
            <tr>
                <td><label for="img">الصور:</label></td>
                <td><input type="file" name="img" id="img"></td>
            </tr>
            <tr>
                <td><label for="description">الوصف:</label></td>
                <td><textarea name="description" id="description" cols="40" rows="4"></textarea></td>
            </tr>
            <tr>
                <td><label for="price">السعر:</label></td>
                <td><input type="number" step="0.1" name="price" id="price"></td>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="إضافة"></td>
            </tr>
        </table>
    </form>
<?php
// include('include/footer.php');
?>
    </main>

    <footer>
        <p>جميع الحقوق محفوظة &copy; 2025 - متجر خير بلادك</p>
    </footer>

    <script src="../static/JavaScript.js"></script>
</body>
</html>
