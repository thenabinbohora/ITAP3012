
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';
require_login();

if (!isset($_SESSION['cart']) || !$_SESSION['cart']) { header("Location: " . base_url('/views/cart.php')); exit; }

try {
  $pdo->beginTransaction();

  $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
  $stmt = $pdo->query("SELECT * FROM products WHERE product_id IN ($ids) FOR UPDATE");
  $products = []; while($row = $stmt->fetch()) { $products[$row['product_id']] = $row; }

  $total = 0.00;
  foreach ($_SESSION['cart'] as $pid => $qty) {
    if (!isset($products[$pid])) throw new Exception("Product not found.");
    if ($products[$pid]['quantity'] < $qty) throw new Exception("Insufficient stock for: " . $products[$pid]['name']);
    $total += $qty * (float)$products[$pid]['cost'];
  }

  $ins = $pdo->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'paid')");
  $ins->execute([$_SESSION['user_id'], $total]);
  $order_id = (int)$pdo->lastInsertId();

  $insItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
  $updStock = $pdo->prepare("UPDATE products SET quantity = quantity - ? WHERE product_id = ?");

  foreach ($_SESSION['cart'] as $pid => $qty) {
    $price = (float)$products[$pid]['cost'];
    $insItem->execute([$order_id, $pid, $qty, $price]);
    $updStock->execute([$qty, $pid]);
  }

  $pdo->commit();
  $_SESSION['cart'] = [];
  header("Location: " . base_url('/views/order_success.php?order_id='.$order_id)); exit;

} catch(Exception $e) {
  $pdo->rollBack();
  $error = $e->getMessage();
}

include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Checkout</h2>
  <?php if (isset($error)): ?>
    <p style="color:#e74c3c">Checkout failed: <?=h($error)?></p>
    <p><a class="filter-btn" href="<?= base_url('/views/cart.php') ?>">Back to Cart</a></p>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
