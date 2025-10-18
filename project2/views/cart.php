
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product_id'])) {
  $pid = (int)$_POST['add_product_id'];
  $qty = max(1, (int)($_POST['qty'] ?? 1));
  $_SESSION['cart'][$pid] = ($_SESSION['cart'][$pid] ?? 0) + $qty;
  header("Location: " . base_url('/views/cart.php')); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  foreach ($_POST['qty'] as $pid => $q) {
    $q = (int)$q;
    if ($q <= 0) unset($_SESSION['cart'][$pid]);
    else $_SESSION['cart'][$pid] = $q;
  }
  header("Location: " . base_url('/views/cart.php')); exit;
}

$items = []; $total = 0.00;
if ($_SESSION['cart']) {
  $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
  $rows = $pdo->query("SELECT * FROM products WHERE product_id IN ($ids)")->fetchAll();
  foreach ($rows as $r) {
    $qty = $_SESSION['cart'][$r['product_id']];
    $line = $qty * (float)$r['cost'];
    $total += $line;
    $items.append(['p'=>$r, 'qty'=>$qty, 'line'=>$line]);
  }
}

include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Your Cart</h2>
  <?php if (!$items): ?>
    <p>Cart is empty. <a href="<?= base_url('/views/shop.php') ?>">Continue shopping</a>.</p>
  <?php else: ?>
    <form method="post">
      <table style="width:100%; border-collapse:collapse">
        <thead><tr><th style="text-align:left; padding:8px; border-bottom:1px solid #ddd">Product</th><th>Price</th><th>Qty</th><th>Line</th></tr></thead>
        <tbody>
          <?php foreach($items as $it): ?>
            <tr>
              <td style="padding:8px"><?=h($it['p']['name'])?></td>
              <td style="text-align:center">$<?=h(number_format($it['p']['cost'],2))?></td>
              <td style="text-align:center"><input type="number" name="qty[<?=h($it['p']['product_id'])?>]" value="<?=h($it['qty'])?>" min="0" style="width:80px; padding:6px; border:2px solid #bdc3c7; border-radius:6px"></td>
              <td style="text-align:center">$<?=h(number_format($it['line'],2))?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p style="text-align:right; margin-top:10px"><strong>Total:</strong> $<?=h(number_format($total,2))?></p>
      <div style="display:flex; gap:10px; justify-content:flex-end">
        <button class="filter-btn" type="submit" name="update" value="1">Update Cart</button>
        <a class="filter-btn" href="<?= base_url('/views/checkout.php') ?>">Proceed to Checkout</a>
      </div>
    </form>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
