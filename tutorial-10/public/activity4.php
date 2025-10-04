<?php
$filename = 'art.xml';

if (file_exists($filename)) {
    $art = simplexml_load_file($filename);

    echo "<h1>Paintings Record</h1>";
    echo "<ul>";

    // Looping through each <painting> element
    foreach ($art->painting as $p) {
        echo "<li>";
        // Displaying title
        echo "<strong>Title:</strong> " . $p->title . "<br>";
        // Displaying author name
        echo "<strong>Artist:</strong> " . $p->artist->name . "<br>";
        // Displaying year
        echo "<strong>Year:</strong> " . $p->year . "<br>";
        // Displaying ID attribute
        echo "<strong>ID:</strong> " . $p['id'] . "<br>";
        echo "</li><br>";
    }

    echo "</ul>";
} else {
    exit('Failed to open ' . $filename);
}
?>
