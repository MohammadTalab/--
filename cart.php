<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<h2>محتويات السلة</h2>

<?php 
if (empty($cart)) {
    echo '<p>السلة فارغة.</p>';
} else {
    require_once('connect.php');
    echo '<table border="1">';
    echo '<tr>
        <th>المنتج</th>
        <th>الكمية</th>
        <th>السعر</th>
        <th>المجموع</th>
        <th>الإجراءات</th>
    </tr>';

    $total = 0;

    foreach ($cart as $id => $item) {
        $sql = "SELECT * FROM `product` WHERE p_id = $id";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $subtotal = $row['price'] * $item['quantity'];
        $total += $subtotal;

        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . (int)$item['quantity'] . '</td>';
        echo '<td>' . number_format($row['price'], 2) . ' شيكل</td>';
        echo '<td>' . number_format($subtotal, 2) . ' شيكل</td>';            
        echo '<td><a href="remove_cart.php?id=' . (int)$id . '">حذف</a></td>';
        echo '</tr>';
    }
     echo '<tr><td colspan="3" style="text-align:right;"><strong>المجموع الكلي</strong></td>
        <td colspan="2"><strong>' . number_format($total, 2) . ' شيكل</strong></td>
    </tr>';

}
?>

<br><br>
<a href="index.php">العودة للمتجر</a>
