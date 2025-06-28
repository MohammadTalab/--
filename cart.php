<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<h2>محتويات السلة</h2>
<?php if (empty($cart)): ?>
  <p>السلة فارغة.</p>
<?php else: ?>
  <ul>
  <?php foreach ($cart as $id => $item): ?>
    <li>
      <?php echo $item['name']; ?> - الكمية: <?php echo $item['quantity']; ?> - السعر: <?php echo $item['price'] * $item['quantity']; ?> شيكل
      <a href="remove_cart.php?id=<?php echo $id; ?>">حذف</a>
    </li>
  <?php endforeach; ?>
  </ul>
  <a href="checkout.php">إتمام الشراء</a>
<?php endif; ?>

<a href="index.php">العودة للمتجر</a>
