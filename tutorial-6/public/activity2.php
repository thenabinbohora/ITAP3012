<!DOCTYPE html>
<html>
<head>
    <title>Activity 2</title>
</head>
<body>
    <h1>PHP - Calculate Electricity Bill</h1>
    <form action="" method="post" id="quiz-form">
        <input type="number" name="units" id="units" placeholder="Please enter Units" required />
        <input type="submit" name="unit-submit" id="unit-submit" value="Submit" />
    </form>
    <?php
    if (isset($_POST['unit-submit'])) {
        $units = $_POST['units'];
        $bill = 0;
        if ($units <= 50) {
            $bill = $units * 3.50;
        } elseif ($units <= 150) {
            $bill = (50 * 3.50) + (($units - 50) * 4.00);
        } elseif ($units <= 250) {
            $bill = (50 * 3.50) + (100 * 4.00) + (($units - 150) * 5.20);
        } else {
            $bill = (50 * 3.50) + (100 * 4.00) + (100 * 5.20) + (($units - 250) * 6.50);
        }
        echo "<h3>Total amount of $units units is: AUD " . number_format($bill, 2) . "<h3>";
    }
    ?>
</body>
</html>
