<?php
//This is session1.php and we will use this session for next page
session_start();
$_SESSION['userid'] = "ITAP3012";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Activity 4</title>
</head>
<body>
<h1>Session 1</h1>
<p>Session 'userid' has been registered. </p>
<p><a href="session2.php">Go to Session 2</a></p>
</body>
</html>
