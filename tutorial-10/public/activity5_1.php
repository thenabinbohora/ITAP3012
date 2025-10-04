<?php
// JSON string
$jsonStr = '{"artist": {"name":"Manet","nationality":"France"}}';
// Decoding JSON string into a PHP object
$data = json_decode($jsonStr);
// Accessing values
echo "Artist Name: " . $data->artist->name . "<br>";
echo "Nationality: " . $data->artist->nationality . "<br>";
?>
