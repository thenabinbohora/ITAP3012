<?php
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
 include("file_with_errors.php");
 preg_match('/^https?:\/\/[\w-]+\.[\w.]+(?:\/[\w./-]*)?$/', $url);



?>