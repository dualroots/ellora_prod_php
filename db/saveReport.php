<?php
$_REQUEST = json_decode(file_get_contents('php://input'), true);
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
            $temp_json["saved"] = "FAILED TO LOAD FILE";
			echo json_encode($temp_json);
			return;
	}
	else{
		$reports = simplexml_import_dom($dom);
//		foreach($reports->report as $report){
//			if($report->reportId == $_REQUEST["i"]){
////Replace Existing
//$root   = $dom->documentElement;
//$fnode  = $root->firstChild;
//$items = $dom->getElementsByTagName('report');
//$i=0;
//foreach ($items as $item){
//    $node = $item->getElementsByTagName('reportId')->item(0);$i++;
//    if ($node->nodeValue == $_REQUEST["i"]){
//        $k = $i;
//    }
//}
//if(isset($k)){
//	$d = $dom->getElementsByTagName('report')->item(--$k);
////	$val = $d->parentNode->getElementsByTagName('reportId')->item($k)->nodeValue;$val++;
//	$d->parentNode->getElementsByTagName('query')->item($k)->nodeValue = $_REQUEST["c"];
//	$dom->save($fileName);
//	system("echo '[".date("Y-m-d H:i:s")."] {Edit Report} Report with ID -".$_REQUEST["i"]."- Query Edited::".$_SESSION["USER_ID"]."' >> /var/log/meetingkaro/admin_log/activity");
//	echo "absAlert(\$('body').children(':first'),'Report','Saved Successfully','s');";
//	echo "uCustomReports();remo(o);";
//	return;
//}
//
////END Replace Existing
////			echo "absAlert(o,'$fileName','Report with ID <b>".$_REQUEST["i"]."</b> already exists.','a');";return;
//			}
//		}
		$report = $reports->addChild('report');
        foreach ($_REQUEST as $key => $value){
            if (is_array($value)){
                $report->addChild($key,null);
            }else{
                $report->addChild($key,$value);
            }
        }
//        $report->addChild('hostname',$_REQUEST["hostname"]);
//        $report->addChild('dbUser',$_REQUEST["dbUser"]);
//        $report->addChild('dbPassword',$_REQUEST["dbPassword"]);
//        $report->addChild('query',$_REQUEST["query"]);
//        $report->addChild('groupByValue',$_REQUEST["groupByValue"]);
//        $report->addChild('subGroupByValue',$_REQUEST["subGroupByValue"]);
//        $report->addChild('graphType',$_REQUEST["graphType"]);
//        $report->addChild('checkedShowDashboard',$_REQUEST["checkedShowDashboard"]);
//        $report->addChild('reportTitle',$_REQUEST["reportTitle"]);

		if($reports->asXML($fileName)){
            $temp_json["saved"] = "OK";
			echo json_encode($temp_json);
			return;
		}else{
            $temp_json["saved"] = "FAILED TO SAVE";
			echo json_encode($temp_json);
			return;
		}
	}
?>

