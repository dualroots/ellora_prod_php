<?php
$host = "localhost";
$dbname = "ellora_demo";
$user = "root";
$password = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;unix_socket=/tmp/mysql.sock", $user, $password, array(
    PDO::ATTR_PERSISTENT => true
));
$output["status"] = "OK";
//echo json_encode($output);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
        die();
}

?>

