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

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once('../connect.php');
    $id = $_POST['id'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "UPDATE admin SET name='$name', username='$username', password='$password' WHERE u_id = $id";
    if(mysqli_query($conn, $sql))
    {
        $_SESSION['message'] = 'تم تحديث بيانات المسؤول بنجاح';
    }
    else{
        $_SESSION['message'] = 'حدث خطأ أثناء تحديث البيانات: ' . mysqli_error($conn);
    }
    
    header('Location: admin.php');
    exit();
}