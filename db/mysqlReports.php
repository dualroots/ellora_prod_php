<?php
//include("./dbconnect.php");
$msg=array();$err = array();$result=array();$final_result=array();
$fileName = 'customReports.xml';
	if(!file_exists($fileName)){
		$input = "<?xml version='1.0' standalone='yes'?><reports />"; 
		$reports = new SimpleXmlElement($input);
		$reports->asXML($fileName);
		chmod($fileName, 0755);
	}
	$dom=new DOMDocument();
	$dom->load($fileName);
	if (!$dom) {
		$msg["status"]= "false";
		array_push($err,"Error while parsing the document");
	}
	else{
		$reports = simplexml_import_dom($dom);
		foreach($reports->report as $report){
//$st = $pdo->prepare($report["query"]);
//if(!$st->execute()){
//$report["queryStatus"] = "ERROR";
//$query_error = $st->errorinfo();
//unset($report["error"]);
//$report["error"] = $query_error;
//}
//else{
//$report["queryStatus"] = "OK";
//$report["result"] = "";
//$query_result = ($st->rowCount())?$st->fetchAll(PDO::FETCH_ASSOC):array("Output"=>"No results to show");
//echo json_encode($query_result);
//}
			array_push($result,$report);
		}
        
	}
	if(empty($err)){$msg["status"]="OK";}
	else{$msg["error"]=$err;}
$test = json_encode($result);
$test_d = json_decode($test, true);
foreach($test_d as $taste){
    $temp_json = array();
    foreach($taste as $key=>$value){
        if($key == "resultset"){continue;}
        $temp_json[$key]= $value;
        
        if($key=="dbQuery"){  

            $host = $temp_json["dbHost"]; //"localhost";
            $dbname = $temp_json["dbName"]; //"ellora_demo";
            $user = $temp_json["dbUser"]; //"root";
            $password = is_array($temp_json["dbPassword"])? "" : $temp_json["dbPassword"];
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

            //echo $value;
            $st = $pdo->prepare($value);
            if(!$st->execute()){
                $temp_json["queryStatus"] = "ERROR";
                $temp_json["error"] = $st->errorinfo();
            }
            else{
                $temp_json["queryStatus"] = "OK";
                $temp_json["resultset"] = ($st->rowCount())?$st->fetchAll(PDO::FETCH_ASSOC):array("Output"=>"No results to show");
            }
            $pdo = null;

        }
        
        
        
    }
    array_push($final_result,$temp_json);
}

    echo json_encode($final_result);
?>
