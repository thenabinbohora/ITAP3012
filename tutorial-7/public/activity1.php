<!DOCTYPE html>
<html>
<head>
    <title>Activity 1</title>
</head>
<body>
<?php
$servername = "db"; 
$username   = "root";
$password   = "rootpass";
$database   = "itap_t7"; 
// Creating Connection with MySQLi
echo "<h3>MySQLi Connection</h3>";
$conn = new mysqli($servername, $username, $password, $database);
// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br>";
$conn->close();
// Creating Connection with PDO
echo "<h3>PDO Connection</h3>";
try {
    $dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";
} catch (PDOException $e) {
    echo "Connection failed " . $e->getMessage();
}
?>
</body>
</html>
