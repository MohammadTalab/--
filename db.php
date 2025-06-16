<?php
$conn = mysqli_connect('localhost', 'root', '', 'kheirbiladak');
if (!$conn) {
    die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
}

function getCartCount($user_id) {
    global $conn;
    if (!$user_id) return 0;
    
    $user_id = mysqli_real_escape_string($conn, $user_id);
    $sql = "SELECT SUM(op.count) as total_count
            FROM `order` o
            JOIN order_product op ON o.O_id = op.o_id
            WHERE o.u_id = '$user_id' AND o.status = 'cart'";
    
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_count'] ? (int)$row['total_count'] : 0;
    }
    return 0;
}
?>