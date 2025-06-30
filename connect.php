<?php 
$conn = mysqli_connect('localhost','root','','kheirbiladak');

if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}