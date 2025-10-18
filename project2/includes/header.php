
<?php /* Reusing original CSS/JS; not touching Project 1 files */ 
$conf = require __DIR__ . '/config.php';
$BASE = rtrim($conf['base_path'] ?? '', '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIT TechHUB - Dynamic</title>
  <link rel="stylesheet" href="<?= $BASE ?>/styles.css">
</head>
<body>
<header>
  <nav class="navbar">
    <div class="nav-container">
      <div class="logo"><h1>2024 VIT TechHUB</h1></div>
      <ul class="nav-menu">
        <li><a href="<?= $BASE ?>/index.html" class="nav-link">Static Home</a></li>
        <li><a href="<?= $BASE ?>/views/shop.php" class="nav-link">Dynamic Shop</a></li>
        <li><a href="<?= $BASE ?>/views/cart.php" class="nav-link">Cart</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role']==='admin'): ?>
            <li><a href="<?= $BASE ?>/admin/dashboard.php" class="nav-link">Admin</a></li>
          <?php endif; ?>
          <li><a href="<?= $BASE ?>/auth/logout.php" class="nav-link">Logout</a></li>
        <?php else: ?>
          <li><a href="<?= $BASE ?>/auth/login.php" class="nav-link">Login</a></li>
          <li><a href="<?= $BASE ?>/auth/register.php" class="nav-link">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>
<main style="padding-top:70px">
