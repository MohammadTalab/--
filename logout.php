<?php
session_start();

// حفظ رسالة قبل حذف بيانات الجلسة
$_SESSION['message'] = 'تم تسجيل الخروج بنجاح';

// حذف جميع متغيرات الجلسة ما عدا الرسالة
$message = $_SESSION['message'];
session_unset();
$_SESSION['message'] = $message;

// توجيه المستخدم إلى الصفحة الرئيسية
header('Location: index.php');
exit();
?>
