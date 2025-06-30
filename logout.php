<?php
session_start();

$_SESSION['message'] = 'تم تسجيل الخروج بنجاح';

$message = $_SESSION['message'];
session_unset();
$_SESSION['message'] = $message;

header('Location: index.php');
exit();
?>
