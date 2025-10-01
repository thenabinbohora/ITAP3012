<?php
//Using and Getting session in session2.php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Activity 4</title>
</head>
<body>
<h1>Session 2</h1>
<?php
if (isset($_SESSION['userid'])) {
    echo "<p>You are a registered user. UserID = " . $_SESSION['userid'] . "</p>";
} else {
    echo "<p>Please register yourself with the website.</p>";
}
?>
<p><a href="session1.php">Back to Session 1</a></p>
</body>
</html>
