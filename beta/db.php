<?php
$base_url = 'http://myvalert.com/';
function getConnection() {
    try {
        $db_username = "vebinary_nova";
        $db_password = "nova@123";
        $conn = new PDO('mysql:host=localhost;dbname=vebinary_nova_new', $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $conn;
}

?>
