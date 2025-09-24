<!DOCTYPE html>
<html>
<head>
    <title>Activity 1</title>
</head>
<body>
<?php
// Database settings
$servername = "db";   // service name from docker-compose.yml
$username   = "root";
$password   = "rootpass";
$database   = "itap_t7"; // make sure this DB exists (created in init script)

// ---------------- MySQLi Connection ----------------
echo "<h2>MySQLi Connection</h2>";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("MySQLi connection failed: " . $conn->connect_error);
}
echo "✅ Connected successfully with MySQLi<br>";
$conn->close();

// ---------------- PDO Connection ----------------
echo "<h2>PDO Connection</h2>";
try {
    $dsn = "mysql:host=$servername;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected successfully with PDO<br>";
} catch (PDOException $e) {
    echo "❌ Connection failed with PDO: " . $e->getMessage();
}
?>
</body>
</html>
