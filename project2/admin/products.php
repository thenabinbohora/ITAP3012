
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';
require_admin();

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['create'])) {
  $name = trim($_POST['name']??'');
  $desc = trim($_POST['description']??'');
  $image = trim($_POST['image']??'');
  $cost = (float)($_POST['cost']??0);
  $qty = (int)($_POST['quantity']??0);
  $catName = trim($_POST['category']??'');

  if ($name && $catName) {
    $stmt = $pdo->prepare("SELECT category_id FROM categories WHERE category_name=?");
    $stmt->execute([$catName]);
    $cat = $stmt->fetch();
    if (!$cat) { $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)")->execute([$catName]); $cat_id = (int)$pdo->lastInsertId(); }
    else { $cat_id = (int)$cat['category_id']; }
    $pdo->prepare("INSERT INTO products (category_id,name,description,image,cost,quantity,special_features) VALUES (?,?,?,?,?,?,?)")
        ->execute([$cat_id,$name,$desc,$image,$cost,$qty,$_POST['special_features']??'']);
  }
  header("Location: " . base_url('/admin/products.php')); exit;
}

if (isset($_GET['delete'])) {
  $pid = (int)$_GET['delete'];
  $pdo->prepare("DELETE FROM products WHERE product_id=?")->execute([$pid]);
  header("Location: " . base_url('/admin/products.php')); exit;
}

$products = $pdo->query("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id ORDER BY p.created_at DESC")->fetchAll();
include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Manage Products</h2>
  <h3>Add New Product</h3>
  <form method="post" class="contact-form" style="max-width:800px">
    <input type="hidden" name="create" value="1">
    <div class="form-group"><label>Name *</label><input name="name" required></div>
    <div class="form-group"><label>Category *</label><input name="category" placeholder="laptops / phones / accessories" required></div>
    <div class="form-group"><label>Description</label><input name="description"></div>
    <div class="form-group"><label>Image URL</label><input name="image"></div>
    <div class="form-group"><label>Cost</label><input name="cost" type="number" step="0.01" value="0"></div>
    <div class="form-group"><label>Quantity</label><input name="quantity" type="number" value="0"></div>
    <div class="form-group"><label>Special Features</label><input name="special_features"></div>
    <button class="submit-btn" type="submit">Add Product</button>
  </form>

  <h3 style="margin-top:2rem">All Products</h3>
  <table style="width:100%; border-collapse:collapse">
    <thead><tr><th style="text-align:left">Name</th><th>Category</th><th>Cost</th><th>Qty</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach($products as $p): ?>
      <tr>
        <td style="padding:6px"><?=h($p['name'])?></td>
        <td style="text-align:center"><?=h($p['category_name'])?></td>
        <td style="text-align:center">$<?=h(number_format($p['cost'],2))?></td>
        <td style="text-align:center"><?=h($p['quantity'])?></td>
        <td style="text-align:center">
          <a class="filter-btn" href="<?= base_url('/admin/product_edit.php?id='.$p['product_id']) ?>">Edit</a>
          <a class="filter-btn" href="<?= base_url('/admin/products.php?delete='.$p['product_id']) ?>" onclick="return confirm('Delete this product?')">Delete</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
