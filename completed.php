<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>صفحة إتمام الشراء</title>
</head>
<body>

  <div class="checkout-container">
    <h1>إتمام الشراء</h1>

    <form action="" method="post">
    <div class="shipping-info">
      <h2>معلومات الشحن</h2>

      <p>الاسم الكامل:</p>
      <input type="text" name="full_name"><br><br>

      <p>رقم الهاتف:</p>
      <input type="tel" name = "num-id"><br><br>

      <p>العنوان:</p>
      <input type="text" name="address"><br><br>
    </div>

    <?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تم الطلب</title>
    <link rel="stylesheet" href="static/styles.css">
</head>
<body>
    <div class="confirmation">
        <h2>✅ تم إتمام طلبك بنجاح!</h2>
        <p>شكراً لتسوقك معنا </p>
        <a href="index.php" class="btn">العودة للرئيسية</a>
    </div>
</body>
</html>



    <br><br>
    <input type="submit" value="تأكيد الشراء">
  </div>
</form>

</body>
</html>
