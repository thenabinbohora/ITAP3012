
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';
require_admin();

$pid = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id=c.category_id WHERE p.product_id=?");
$stmt->execute([$pid]);
$p = $stmt->fetch();
if (!$p) { header("Location: " . base_url('/admin/products.php')); exit; }

if ($_SERVER['REQUEST_METHOD']==='POST') {
  $name = trim($_POST['name']??'');
  $desc = trim($_POST['description']??'');
  $image = trim($_POST['image']??'');
  $cost = (float)($_POST['cost']??0);
  $qty = (int)($_POST['quantity']??0);
  $catName = trim($_POST['category']??'');
  $special = trim($_POST['special_features']??'');

  $stmt = $pdo->prepare("SELECT category_id FROM categories WHERE category_name=?");
  $stmt->execute([$catName]);
  $cat = $stmt->fetch();
  if (!$cat) { $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)")->execute([$catName]); $cat_id = (int)$pdo->lastInsertId(); }
  else { $cat_id = (int)$cat['category_id']; }

  $pdo->prepare("UPDATE products SET category_id=?, name=?, description=?, image=?, cost=?, quantity=?, special_features=? WHERE product_id=?")
      ->execute([$cat_id,$name,$desc,$image,$cost,$qty,$special,$pid]);

  header("Location: " . base_url('/admin/products.php')); exit;
}

include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Edit Product</h2>
  <form method="post" class="contact-form" style="max-width:800px">
    <div class="form-group"><label>Name *</label><input name="name" value="<?=h($p['name'])?>" required></div>
    <div class="form-group"><label>Category *</label><input name="category" value="<?=h($p['category_name'])?>" required></div>
    <div class="form-group"><label>Description</label><input name="description" value="<?=h($p['description'])?>"></div>
    <div class="form-group"><label>Image URL</label><input name="image" value="<?=h($p['image'])?>"></div>
    <div class="form-group"><label>Cost</label><input name="cost" type="number" step="0.01" value="<?=h($p['cost'])?>"></div>
    <div class="form-group"><label>Quantity</label><input name="quantity" type="number" value="<?=h($p['quantity'])?>"></div>
    <div class="form-group"><label>Special Features</label><input name="special_features" value="<?=h($p['special_features'])?>"></div>
    <button class="submit-btn" type="submit">Save Changes</button>
  </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
