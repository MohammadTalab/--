<?php
$page_title = 'السلة - متجر خير بلادك';
$current_page = 'cart';
require_once 'connect.php';

include 'header.php';

// عرض رسائل النظام إن وجدت
if (isset($_SESSION['message'])) {
    echo '<div class="message info">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}

// التحقق من تسجيل دخول المستخدم
if (!isset($_SESSION['user_id'])) {
    echo '<div class="message error">يرجى تسجيل الدخول لعرض سلة التسوق</div>';
    echo '<div class="empty-cart"><a href="login.php" class="btn">تسجيل الدخول</a></div>';
} else {
    // الحصول على سلة التسوق النشطة للمستخدم
    $user_id = $_SESSION['user_id'];
    $cart_sql = "SELECT o.O_id FROM `order` o WHERE o.u_id = '$user_id' AND o.status = 'cart' LIMIT 1";
    $cart_result = mysqli_query($conn, $cart_sql);
    
    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        $cart_row = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart_row['O_id'];
        
        // الحصول على محتويات السلة
        $items_sql = "SELECT op.*, p.name, p.price, p.image FROM order_product op 
                      JOIN product p ON op.p_id = p.p_id 
                      WHERE op.o_id = '$cart_id'";
        $items_result = mysqli_query($conn, $items_sql);
        
        $has_items = ($items_result && mysqli_num_rows($items_result) > 0);
?>

    <main>
        <div class="cart-container">
            <h2>محتويات السلة</h2>

            <?php if (!$has_items): ?>
                <div class="empty-cart">
                    <p>السلة فارغة حالياً</p>
                    <a href="products.php" class="btn">تصفح المنتجات</a>
                </div>
            <?php else: ?>
                <div class="cart-table-container">
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>المجموع</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            while ($item = mysqli_fetch_assoc($items_result)):
                                $subtotal = $item['price'] * $item['count'];
                                $total += $subtotal;
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><?php echo (int)$item['count']; ?></td>
                                <td><?php echo number_format($item['price'], 2); ?> شيكل</td>
                                <td><?php echo number_format($subtotal, 2); ?> شيكل</td>
                                <td>
                                    <a href="remove_cart.php?id=<?php echo (int)$item['p_id']; ?>" class="btn-remove">حذف</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        
                            <tr>
                                <td colspan="3" class="text-right">المجموع الكلي:</td>
                                <td><?php echo number_format($total, 2); ?> شيكل</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="cart-actions">
                    <a href="products.php" class="btn secondary">متابعة التسوق</a>
                    <a href="checkout.php" class="btn">إتمام الطلب</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php 
    } else {
        // لا توجد سلة نشطة
        echo '<div class="empty-cart">';
        echo '<p>السلة فارغة حالياً</p>';
        echo '<a href="products.php" class="btn">تصفح المنتجات</a>';
        echo '</div>';
    }
}
?>

<?php include 'footer.php'; ?>
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3"><strong>المجموع الكلي</strong></td>
                                <td colspan="2"><strong><?php echo number_format($total, 2); ?> شيكل</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="cart-actions">
                    <a href="products.php" class="btn btn-secondary">متابعة التسوق</a>
                    <a href="checkout.php" class="btn btn-primary">إتمام الطلب</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

<?php include 'footer.php'; ?>
<?php
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
        echo '<td>' . (int)$item['quantity'] . '</td>';
        echo '<td>' . number_format($row['price'], 2) . ' شيكل</td>';
        echo '<td>' . number_format($subtotal, 2) . ' شيكل</td>';            
        echo '<td><a href="remove_cart.php?id=' . (int)$id . '">حذف</a></td>';
        echo '</tr>';

    
     echo '<tr><td colspan="3" style="text-align:right;"><strong>المجموع الكلي</strong></td>
        <td colspan="2"><strong>' . number_format($total, 2) . ' شيكل</strong></td>
    </tr>';
    echo '</table>';


?>

<br><br>
<a href="index.php">العودة للمتجر</a>
<a href="completed.php">العودة للمتجر</a>

