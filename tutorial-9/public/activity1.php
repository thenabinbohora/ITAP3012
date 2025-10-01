<?php
// a) Creating a cookie
$expiryTime = time() + (86400 * 30);
$name = "user";
$value = "Mubashir Hussain";
setcookie($name, $value, $expiryTime, "/");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Activity 1</title>
</head>
<body>
<h1>Cookies</h1>
<?php
// b) Retrieving the cookie
if ( !isset($_COOKIE['user']) ) { echo "this cookie doesn't exist"; }
else {
 echo "The username retrieved from the cookie is:".
 $_COOKIE['user'];
}
?>
</body>
</html>
