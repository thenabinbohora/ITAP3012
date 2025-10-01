<!DOCTYPE html>
<html>
<head>
    <title>Activity 2</title>
</head>
<body>
<?php
$servername = "db";
$username   = "root";
$password   = "rootpass";
// Creating connection
$conn = new mysqli($servername, $username, $password);
// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Creating database
$sql = "CREATE DATABASE IF NOT EXISTS myDb";
if ($conn->query($sql) === TRUE) {
    echo "Database 'myDb' created successfully <br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}
// Selecting database
$conn->select_db("myDb");
// Creating table 
$tableSql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
              ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($tableSql) === TRUE) {
    echo "Table 'MyGuests' created successfully <br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}
// Closing connection
$conn->close();
?>
</body>
</html>
