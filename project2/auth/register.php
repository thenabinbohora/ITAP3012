
<?php
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/helpers.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $full_name = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm  = $_POST['confirm'] ?? '';
  $contact  = trim($_POST['contact'] ?? '');

  if ($full_name === '') $errors[] = "Full name is required.";
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
  if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";
  if ($password !== $confirm) $errors[] = "Passwords do not match.";

  if (!$errors) {
    $stmt = $pdo->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    if ($stmt->fetch()) $errors[] = "Email is already registered.";
  }

  if (!$errors) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role, contact_number) VALUES (?, ?, ?, 'customer', ?)");
    $stmt->execute([$full_name, $email, $hash, $contact]);
    $success = true;
  }
}

include __DIR__ . '/../includes/header.php';
?>
<section class="container">
  <h2>Register</h2>
  <?php if ($success): ?>
    <p>Registration successful. <a href="<?= base_url('/auth/login.php') ?>">Login here</a>.</p>
  <?php else: ?>
    <?php if ($errors): ?>
      <ul style="color:#e74c3c">
        <?php foreach($errors as $e): ?><li><?=h($e)?></li><?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <form method="post" class="contact-form" style="max-width:600px">
      <div class="form-group"><label>Full Name *</label><input name="full_name" value="<?=h($_POST['full_name'] ?? '')?>"></div>
      <div class="form-group"><label>Email *</label><input type="email" name="email" value="<?=h($_POST['email'] ?? '')?>"></div>
      <div class="form-group"><label>Contact Number</label><input name="contact" value="<?=h($_POST['contact'] ?? '')?>"></div>
      <div class="form-group"><label>Password *</label><input type="password" name="password"></div>
      <div class="form-group"><label>Confirm Password *</label><input type="password" name="confirm"></div>
      <button class="submit-btn" type="submit">Create Account</button>
    </form>
  <?php endif; ?>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
