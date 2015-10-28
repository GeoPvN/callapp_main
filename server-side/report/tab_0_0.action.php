<?php
require_once('../../includes/classes/core.php');
header('Content-Type: application/json');
$start = $_REQUEST['start'];
$end   = $_REQUEST['end'];
$agent = $_REQUEST['agent'];
$queuet = $_REQUEST['queuet'];

$row_done_blank = mysql_query(" SELECT 	COUNT(*) AS `count`,
							    CONCAT('დამუშავებული',' ',COUNT(*)) AS `cause1`
							    FROM `incomming_call`
							    WHERE DATE(call_date) >= '$start' AND DATE(call_date) <= '$end' AND call_phone != '' AND extension IN ($agent)  ");



    


$result = mysql_query("SELECT   COUNT(*) AS `count`,
                    			CONCAT('ნაპასუხბი',' ',COUNT(*)) AS `cause`
                        FROM 	`asterisk_incomming`
                        WHERE	disconnect_cause != 'ABANDON' 
                        AND DATE(call_datetime) >= '$start'
                        AND DATE(call_datetime) <= '$end' 
                        AND dst_queue IN ($queuet) 
                        AND dst_extension in ($agent)");
					
$row = array();
$row1 = array();
$rows = array();
while($r = mysql_fetch_array($result)) {
    $r1 = mysql_fetch_array($row_done_blank);
	$row[0] = 'დაუმუშავებელი: '.($r[0] - $r1[0]);
	$row[1] = (float)($r[0] - $r1[0]);
	$row1[0] = $r1[1];
	$row1[1] = (float)$r[0];
	array_push($rows,$row);
	array_push($rows,$row1);
}



echo json_encode($rows);

?>