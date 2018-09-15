<?php
## PROCEDURE
$host = $_REQUEST["dbHost"]; //"localhost";
$dbname = $_REQUEST["dbName"]; //"ellora_demo";
$user = $_REQUEST["dbUser"]; //"root";
$password = $_REQUEST["dbPassword"]; //"";
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
$query = "select ".$_REQUEST["dbQuery"];
    $st = $pdo->prepare($query);
	if(!$st->execute()){
		$output["status"] = "ERROR";
		$output["error"] = $st->errorinfo();
	}
	else{
		$output["status"] = "OK";
		$output["resultset"] = ($st->rowCount())?$st->fetchAll(PDO::FETCH_ASSOC):array("Output"=>"No results to show");
	}
	echo json_encode($output);
    $pdo = null;
## END PROCEDURE
?>
