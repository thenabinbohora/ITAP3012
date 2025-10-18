
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';
require_admin();

$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';
$cat = $_GET['cat'] ?? '';

$where = " WHERE 1=1 ";
$params = [];
if ($from) { $where .= " AND o.order_date >= ? "; $params[] = $from." 00:00:00"; }
if ($to)   { $where .= " AND o.order_date <= ? "; $params[] = $to." 23:59:59"; }
if ($cat)  { $where .= " AND c.category_name = ? "; $params[] = $cat; }

$sql = "
SELECT c.category_name, p.name, SUM(oi.quantity) AS qty, SUM(oi.quantity*oi.price) AS revenue
FROM order_items oi
JOIN orders o ON oi.order_id=o.order_id
JOIN products p ON oi.product_id=p.product_id
JOIN categories c ON p.category_id=c.category_id
$where
GROUP BY c.category_name, p.name
ORDER BY revenue DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();

$cats = $pdo->query("SELECT category_name FROM categories ORDER BY category_name")->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Sales Reports</h2>
  <form method="get" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:1rem">
    <input type="date" name="from" value="<?=h($from)?>">
    <input type="date" name="to" value="<?=h($to)?>">
    <select name="cat">
      <option value="">All Categories</option>
      <?php foreach($cats as $c): $sel = ($cat===$c['category_name']) ? 'selected' : ''; ?>
        <option <?=$sel?>><?=h($c['category_name'])?></option>
      <?php endforeach; ?>
    </select>
    <button class="filter-btn" type="submit">Generate</button>
    <a class="filter-btn" href="<?= base_url('/admin/reports.php') ?>">Reset</a>
  </form>

  <table style="width:100%; border-collapse:collapse">
    <thead><tr><th style="text-align:left">Category</th><th style="text-align:left">Product</th><th>Qty</th><th>Revenue</th></tr></thead>
    <tbody>
      <?php foreach($rows as $r): ?>
      <tr>
        <td style="padding:6px"><?=h($r['category_name'])?></td>
        <td><?=h($r['name'])?></td>
        <td style="text-align:center"><?=h($r['qty'])?></td>
        <td style="text-align:center">$<?=h(number_format($r['revenue'],2))?></td>
      </tr>
      <?php endforeach; ?>
      <?php if (!$rows): ?><tr><td colspan="4">No data for selected filters.</td></tr><?php endif; ?>
    </tbody>
  </table>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
