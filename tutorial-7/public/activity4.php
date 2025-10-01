<!DOCTYPE html>
<html>
<head>
    <title>Activity 4</title>
</head>
<body>
<h1>Employee Form</h1>
<form method="post" action="">
  First name: <input type="text" name="first"><br><br>
  Last name: <input type="text" name="last"><br><br>
  Address: <input type="text" name="address"><br><br>
  Position: <input type="text" name="position"><br><br>
  <input type="submit" name="submit" value="Enter Information">
</form>

<?php
$host = "db";  
$user = "root";
$pass = "rootpass";
$db   = "Office";    // Database created in phpMyAdmin
$table = "employee"; // Table created in phpMyAdmin

if (isset($_POST['submit'])) {
    $firstname = $_POST['first'];
    $lastname  = $_POST['last'];
    $address   = $_POST['address'];
    $position  = $_POST['position'];

    // Opening MySQLi connection
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Inserting values
    $sql = "INSERT INTO $table (firstname, lastname, address, position)
            VALUES ('$firstname', '$lastname', '$address', '$position')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Thank you! Information entered.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>

</body>
</html>
