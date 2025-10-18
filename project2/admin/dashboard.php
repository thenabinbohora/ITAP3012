
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';
require_admin();

$totalProducts = $pdo->query("SELECT COUNT(*) AS c FROM products")->fetch()['c'];
$totalOrders = $pdo->query("SELECT COUNT(*) AS c FROM orders")->fetch()['c'];
$totalSales = $pdo->query("SELECT COALESCE(SUM(total_amount),0) AS s FROM orders")->fetch()['s'];

include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Admin Dashboard</h2>
  <div class="about-content">
    <div><h3>Total Products</h3><p><?=h($totalProducts)?></p></div>
    <div><h3>Total Orders</h3><p><?=h($totalOrders)?></p></div>
    <div><h3>Total Sales</h3><p>$<?=h(number_format($totalSales,2))?></p></div>
  </div>
  <p style="margin-top:1rem">
    <a class="filter-btn" href="<?= base_url('/admin/products.php') ?>">Manage Products</a>
    <a class="filter-btn" href="<?= base_url('/admin/reports.php') ?>">View Reports</a>
  </p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
