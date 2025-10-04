<?php
// Creating connection
$con = mysqli_connect("db","root","rootpass","nabin");
// Checking connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}
?>
