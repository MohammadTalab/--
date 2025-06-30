<?php
session_start();

// حفظ رسالة قبل حذف بيانات الجلسة
$_SESSION['message'] = 'تم تسجيل الخروج بنجاح';

// حذف متغيرات الجلسة المتعلقة بالمستخدم
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['role']);

// توجيه المستخدم إلى صفحة تسجيل الدخول
header('Location: admin_login.php');
exit();