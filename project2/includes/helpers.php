
<?php
function is_logged_in(): bool { return isset($_SESSION['user_id']); }
function is_admin(): bool { return isset($_SESSION['role']) && $_SESSION['role']==='admin'; }
function require_login(): void { if (!is_logged_in()) { header("Location: " . base_url('/auth/login.php')); exit; } }
function require_admin(): void { if (!is_admin()) { header("Location: " . base_url('/auth/login.php')); exit; } }
function h($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Build absolute URL using base_path from config
function base_url(string $path=''): string {
  $conf = require __DIR__ . '/config.php';
  $base = rtrim($conf['base_path'] ?? '', '/');
  $path = '/'+ltrim($path,'/');
  return $base.$path;
}
