<?php

require_once('connect.php');

function getAllProducts() {
    global $conn;
    $sql = "SELECT p.*, c.name as category_name FROM product p 
            LEFT JOIN category c ON p.c_id = c.c_id 
            ORDER BY p.p_id";
    $result = mysqli_query($conn, $sql);
    $products = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}

function getProduct($id) {
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $sql = "SELECT p.*, c.name as category_name FROM product p 
            LEFT JOIN category c ON p.c_id = c.c_id 
            WHERE p.p_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $product = null;
    
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    }
    return $product;
}

function getCartCount($user_id) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT COUNT(*) as count FROM order_product op 
            JOIN `order` o ON op.o_id = o.O_id 
            WHERE o.u_id = '$user_id' AND o.status = 'cart'";
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }
    return 0;
}

function getCartItems($user_id) {
    global $conn;
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT op.*, p.name, p.image as img, p.description, p.price 
            FROM order_product op 
            JOIN product p ON op.p_id = p.p_id 
            JOIN `order` o ON op.o_id = o.O_id 
            WHERE o.u_id = '$user_id' AND o.status = 'cart'";
    $result = mysqli_query($conn, $sql);
    $items = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }
    }
    return $items;
}

function loginUser($email, $password) {
    global $conn;
    $sql = "SELECT id, name, email, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            return true;
        }
    }
    return false;
}

function registerUser($name, $email, $password) {
    global $conn;
    
    $check_sql = "SELECT id FROM users WHERE email = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $email);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);
    
    if (mysqli_num_rows($check_result) > 0) {
        return false; 
    }
    

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        $user_id = mysqli_insert_id($conn);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        return true;
    }
    
    return false;
}

function getAllCategories() {
    global $conn;
    $sql = "SELECT * FROM category ORDER BY name";
    $result = mysqli_query($conn, $sql);
    $categories = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
    }
    return $categories;
}

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_unset();
    session_destroy();
}
?>
