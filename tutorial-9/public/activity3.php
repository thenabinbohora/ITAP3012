<?php
// Starting the session
session_start();

if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0; 
} else {
    $_SESSION['count']++;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Activity 3</title>
</head>
<body>
<h1>Session Counter</h1>
<p>Total Session count: <?php echo $_SESSION['count']; ?></p>
</body>
</html>
