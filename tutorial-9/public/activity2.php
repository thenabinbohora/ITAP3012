<?php
$expiryTime = time() + (86400 * 30);
$name = "user";
$value = "Nabin Bohora";
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
if (count($_COOKIE) > 0) {
    echo "<p>Cookies are enabled.</p>";
} else {
    echo "<p>Cookies are disabled.</p>";
}
if ( !isset($_COOKIE['user']) ) { echo "this cookie doesn't exist"; }
else {
 echo "The username retrieved from the cookie is:".
 $_COOKIE['user'];
}
?>
</body>
</html>
