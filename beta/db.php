<?php
$base_url = 'http://myvalert.com/';
function getConnection() {
    try {
        $db_username = "root";
        $db_password = "root";
        $conn = new PDO('mysql:host=localhost;dbname=nova_vbackup;charset=UTF8', $db_username, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
 
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    return $conn;
}

?>
