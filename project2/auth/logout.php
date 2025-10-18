
<?php
require_once __DIR__ . '/../includes/helpers.php';
session_start();
$_SESSION = [];
session_destroy();
header("Location: " . base_url('/auth/login.php'));
exit;
