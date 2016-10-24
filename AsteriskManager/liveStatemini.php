<?php
 
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$begintime = $time;
$inuse      = Array();
$dict_queue = Array();
$qu = $_REQUEST['qu'];
$filter_queues = array($qu);

require("config.php");
require("asmanager.php");
require("realtime_functions.php");
if(isset($_SESSION['QSTATS']['hideloggedoff'])) {
    $ocultar= $_SESSION['QSTATS']['hideloggedoff'];
} else {
    $ocultar="false";
}
if(isset($_SESSION['QSTATS']['filter'])) {
    $filter= $_SESSION['QSTATS']['filter'];
} else {
    $filter="";
}

$am=new AsteriskManager();
$am->connect($manager_host,$manager_user,$manager_secret);

$channels = get_channels ($am);
foreach($channels as $ch=>$chv) {
  list($chan,$ses) = split("-",$ch,2);
  $inuse["$chan"]=$ch;
}

$queues   = get_queues   ($am,$channels);

foreach ($queues as $key=>$val) {
  $queue[] = $key;
}

$color['unavailable']="flesh_off.png";
$color['unknown']="#dadada";
$color['busy']="flesh_inc.png";
$color['dialout']="#d0303f";
$color['ringing']="flesh_ringing.png";
$color['not in use']="flesh_free.png";
$color['paused']="#000000";


$off=0;
$free=0;
$use=0;
foreach($filter_queues  as $qn) {
	if($filter=="" || stristr($qn,$filter)) {
		$contador=1;
		if(!isset($queues[$qn]['members'])) continue;
		foreach($queues[$qn]['members'] as $key=>$val) {
		
		    $stat="";
		    $last="";
		    $dur="";
		    $clid="";
		    $akey = $queues[$qn]['members'][$key]['agent'];
		    $aname = $queues[$qn]['members'][$key]['name'];
		    $aval = $queues[$qn]['members'][$key]['type'];
		    $stat = $queues[$qn]['members'][$key]['status'];
		    $last = $queues[$qn]['members'][$key]['lastcall'];
		
		    
		    if($aval == "unavailable" || $aval == "unknown") {
		        $off++;
		    } else if($aval == "busy") {
		        $use++;
		        
		    } else {
		        $free++;
		    }
		}

	}
}
$data = array('off'=>$off,'free'=>$free,'use'=>$use);
echo json_encode($data, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>