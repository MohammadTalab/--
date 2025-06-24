<?php
// ملف الاتصال بقاعدة البيانات - متجر خير بلادك

// إعدادات قاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kheirbiladak";

// إنشاء الاتصال
$conn = mysqli_connect($servername, $username, $password, $dbname);

// التحقق من الاتصال
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

// تعيين ترميز UTF-8 للعربية
mysqli_set_charset($conn, "utf8");

// بدء الجلسة
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
