<!DOCTYPE html>
<html>
<head>
  <title>Activity 3</title>
</head>
<body>
<h1>Insert and Display Records</h1>
<form method="post">
  First name: <input type="text" name="firstname" required><br><br>
  Last name: <input type="text" name="lastname" required><br><br>
  Email: <input type="email" name="email"><br><br>

  Method:
  <label><input type="radio" name="method" value="mysqli" checked> MySQLi</label>
  <label><input type="radio" name="method" value="pdo"> PDO</label>
  <br><br>

  <input type="submit" name="insert" value="Insert Record">
</form>

<form method="post" style="margin-top:15px;">
  <input type="submit" name="show" value="Show Records">
</form>
<hr>
<?php
$host = "db"; 
$user = "root";
$pass = "rootpass";
$db   = "myDb";
$table = "MyGuests";

// Inserting record
if (isset($_POST['insert'])) {
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $email     = trim($_POST['email']);
    $method    = $_POST['method'] ?? 'mysqli'; // Inserting using mysqli or pdo

    if ($method === 'pdo') {
        // Inserting using PDO
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $stmt = $pdo->prepare("INSERT INTO $table (firstname, lastname, email) VALUES (?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email === '' ? null : $email]);
            echo "<p>Record inserted using PDO.</p>";
        } catch (PDOException $e) {
            echo "<p>PDO error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        // Inserting using MySQLi
        $mysqli = new mysqli($host, $user, $pass, $db);
        if ($mysqli->connect_error) {
            die("<p>MySQLi connection failed: " . $mysqli->connect_error . "</p>");
        }
        $stmt = $mysqli->prepare("INSERT INTO $table (firstname, lastname, email) VALUES (?, ?, ?)");
        $em = ($email === '' ? null : $email);
        $stmt->bind_param("sss", $firstname, $lastname, $em);
        if ($stmt->execute()) {
            echo "<p>Record inserted using MySQLi.</p>";
        } else {
            echo "<p>MySQLi error: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
        $mysqli->close();
    }
}
// Showing records
if (isset($_POST['show'])) {
    echo "<h2>All Records (MySQLi)</h2>";
    $mysqli = new mysqli($host, $user, $pass, $db);
    if (!$mysqli->connect_error) {
        $res = $mysqli->query("SELECT id, firstname, lastname, email, reg_date FROM $table ORDER BY id DESC");
        if ($res && $res->num_rows) {
            while ($row = $res->fetch_assoc()) {
                echo $row["id"]." - ".$row["firstname"]." ".$row["lastname"]." - ".($row["email"] ?? "")." - ".$row["reg_date"]."<br>";
            }
        } else {
            echo "No records found.";
        }
        $mysqli->close();
    }
    echo "<h2>All Records (PDO)</h2>";
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $stmt = $pdo->query("SELECT id, firstname, lastname, email, reg_date FROM $table ORDER BY id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows) {
            foreach ($rows as $row) {
                echo $row["id"]." - ".$row["firstname"]." ".$row["lastname"]." - ".($row["email"] ?? "")." - ".$row["reg_date"]."<br>";
            }
        } else {
            echo "No records found.";
        }
    } catch (PDOException $e) {
        echo "PDO error: " . htmlspecialchars($e->getMessage());
    }
}
?>
</body>
</html>
