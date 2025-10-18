
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';

$keyword = trim($_GET['q'] ?? '');
$cat = trim($_GET['cat'] ?? '');

$sql = "SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id WHERE 1=1";
$params = [];
if ($keyword !== '') { $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)"; $params.extend([f"%{$keyword}%", f"%{$keyword}%"]); }
if ($cat !== '') { $sql .= " AND c.category_name = ?"; $params.append($cat); }
$sql .= " ORDER BY p.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

$cats = $pdo->query("SELECT category_name FROM categories ORDER BY category_name")->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<section class="products">
  <div class="container">
    <h2>Dynamic Shop</h2>
    <form method="get" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:1rem">
      <input name="q" placeholder="Search products..." value="<?=h($keyword)?>" style="padding:10px; border:2px solid #bdc3c7; border-radius:6px; min-width:240px">
      <select name="cat" style="padding:10px; border:2px solid #bdc3c7; border-radius:6px">
        <option value="">All Categories</option>
        <?php foreach($cats as $c): $sel = ($cat===$c['category_name']) ? 'selected' : ''; ?>
          <option <?=$sel?>><?=h($c['category_name'])?></option>
        <?php endforeach; ?>
      </select>
      <button class="filter-btn" type="submit">Filter</button>
      <a class="filter-btn" href="<?= base_url('/views/shop.php') ?>">Reset</a>
    </form>

    <div class="product-grid">
      <?php foreach($products as $p): ?>
        <article class="product-card">
          <div class="product-image"><img src="<?=h($p['image'])?>" alt="<?=h($p['name'])?>"></div>
          <div class="product-info">
            <h3><?=h($p['name'])?></h3>
            <p><?=h($p['description'])?></p>
            <div class="price">$<?=h(number_format($p['cost'],2))?></div>
            <form method="post" action="<?= base_url('/views/cart.php') ?>" style="display:flex; gap:10px; align-items:center">
              <input type="hidden" name="add_product_id" value="<?=h($p['product_id'])?>">
              <input type="number" name="qty" min="1" max="<?=h($p['quantity'])?>" value="1" style="width:80px; padding:8px; border:2px solid #bdc3c7; border-radius:6px">
              <button class="add-to-cart" type="submit">Add to Cart</button>
            </form>
            <small>In stock: <?=h($p['quantity'])?></small>
          </div>
        </article>
      <?php endforeach; ?>
      <?php if (!$products): ?><p>No products found.</p><?php endif; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
