
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';
require_login();
include __DIR__ . '/../includes/header.php';
$order_id = (int)($_GET['order_id'] ?? 0);
?>
<section class="container">
  <h2>Order Successful</h2>
  <p>Thank you! Your order <strong>#<?=h($order_id)?></strong> has been placed.</p>
  <p><a class="filter-btn" href="<?= base_url('/views/shop.php') ?>">Continue Shopping</a></p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
