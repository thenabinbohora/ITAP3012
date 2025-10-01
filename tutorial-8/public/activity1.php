<!DOCTYPE html>
<html>
<head>
  <title>Activity 1</title>
</head>
<body>
<h1>Calculator</h1>
<form method="post">
  Enter a number: <input type="text" name="number" required>
  <input type="submit" name="submit" value="OK">
</form>
<?php
// Function to calculate inverse
function calculateInverse($x) {
    if ($x == 0) {
        throw new Exception("Division by zero is not allowed");
    }
    return 1 / $x;
}

if (isset($_POST['submit'])) {
    $num = $_POST['number'];

    try {
        $result = calculateInverse($num);
        echo "<p>The inverse of $num is: $result</p>";
    } catch (Exception $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>
</body>
</html>
