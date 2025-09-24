<!DOCTYPE html>
<html>
<head>
    <title>Activity 3</title>
</head>
<body>
    <h1>PHP - Calculator</h1>
    <form method="post">
        <input type="number" name="num1" placeholder="Enter first number" required />
        <input type="number" name="num2" placeholder="Enter second number" required />
        <br> <br>
        <input type="submit" name="operation" value="Addition" />
        <input type="submit" name="operation" value="Subtraction" />
        <input type="submit" name="operation" value="Multiplication" />
        <input type="submit" name="operation" value="Division" />
    </form>
    <?php
    if (isset($_POST['operation'])) {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];
        $operation = $_POST['operation'];
        $result = "";

        switch ($operation) {
            case "Addition":
                $result = $num1 + $num2;
                break;
            case "Subtraction":
                $result = $num1 - $num2;
                break;
            case "Multiplication":
                $result = $num1 * $num2;
                break;
            case "Division":
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                } else {
                    $result = "Error: Division by zero!";
                }
                break;
            default:
                $result = "Invalid operation selected!";
        }
        echo "<h3>Result of $operation: $result</h3>";
    }
    ?>
</body>
</html>
