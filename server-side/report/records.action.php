<?php

require_once('../../includes/classes/core.php');


$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';

switch ($action) {
	case 'get_list' :
		$count    = $_REQUEST['count'];
		$hidden   = $_REQUEST['hidden'];
		$start    = $_REQUEST['start'];
		$end      =	$_REQUEST['end'];
		
	  	$rResult = mysql_query("SELECT cdr.calldate,
									   cdr.calldate,
								       cdr.src,
								       cdr.dst,
								       CONCAT(SUBSTR((cdr.duration / 60), 1, 1), ':', cdr.duration % 60) as `time`,
								       CONCAT('<p onclick=play(', '\'', SUBSTRING(cdr.userfield, 7), '\'',  ')>მოსმენა</p>', '<a download=\"audio.wav\" href=\"http://109.234.117.182:8181/records/', SUBSTRING(cdr.userfield, 7), '\">ჩამოტვირთვა</a>')
								FROM   cdr
							WHERE      cdr.disposition = 'ANSWERED' AND cdr.userfield != '' AND cdr.dcontext = 'from-internal' AND DATE(cdr.calldate) >= '$start' AND DATE(cdr.calldate) <= '$end'");
	  
		$data = array(
				"aaData"	=> array()
		);

		while ( $aRow = mysql_fetch_array( $rResult ) )
		{
			$row = array();
			for ( $i = 0 ; $i < $count ; $i++ )
			{
				/* General output */
				$row[] = $aRow[$i];
			}
			$data['aaData'][] = $row;
		}

		break;
		
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

?>