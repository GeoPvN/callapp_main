<?php
include('../../includes/classes/core.php');
$start  	= $_REQUEST['start'];
$end    	= $_REQUEST['end'];
$count 		= $_REQUEST["count"];
$action 	= $_REQUEST['act'];
$departament= $_REQUEST['departament'];
$type       = $_REQUEST['type'];
$category   = $_REQUEST['category'];
$s_category = $_REQUEST['sub_category'];
$done 		= $_REQUEST['done']%3;
$name 		= $_REQUEST['name'];
$user 		= $_REQUEST['user'];
$title 		= $_REQUEST['title'];
$text[0] 	= "გამოტოვებული ზარები პასუხისმგებელი პირების მიხედვით";
$text[1] 	= "'$type'- პასუხისმგებელი პირების მიხედვით";
$text[2] 	= "'$category'-განყოფილებების მიხედვით";

if ($category=="გადაცემულია გასარკვევად")  $c=1;
elseif ($category=="გარკვევის პროცესშია") $c=2;
elseif ($category=="მოგვარებულია") $c=3;
elseif ($category=="გაუქმებულია") $c=4;

//------------------------------------------------query-------------------------------------------
switch ($done){
	case  1:
	    $result = mysql_query(" SELECT  persons.`name`,
	                                    COUNT(*),	                                    
	                                    (
                                        ROUND((COUNT(*)/(SELECT  COUNT(*)
                        		        FROM `cdr`
                        		        JOIN incomming_call ON cdr.calldate = incomming_call.miss_date
                        		        WHERE DATE(calldate) >= '2015-01-12'
                        		        AND DATE(calldate) <= '2015-01-12'
                        		        AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = '' and incomming_call.miss_date != '') *100),2)
                                        )	                                    
                		        FROM    `cdr`
                		        JOIN    incomming_call ON cdr.calldate = incomming_call.miss_date
								JOIN    users ON incomming_call.user_id = users.id
								JOIN    persons ON users.person_id = persons.id 
                		        WHERE DATE(calldate) >= '$start'
                		        AND DATE(calldate) <= '$end'
                		        AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = '' and incomming_call.miss_date != '' AND persons.`name` = '$type'
                	            GROUP BY persons.`name`");
		$text[0]=$text[1];
	break;
	case 2:
		
		$text[0]=$text[2];
	break;
	default:
// 		$res1 = mysql_query("SELECT  SUBSTR(cdr.dst,3) AS dst
// 		        FROM	cdr
// 		        WHERE 	DATE(cdr.calldate) >= '$start'
// 		        AND 	DATE(cdr.calldate) <= '$end'
// 		        AND 	cdr.src IN('100','101','150','200','201','250')
// 		        AND     SUBSTR(cdr.dst,3) >4
// 		        GROUP BY cdr.dst");
		    
// 		        while($rq = mysql_fetch_assoc($res1)){
// 		    $out .= $rq[dst].'|';
// 		    }
// 		    $out = substr($out, 0, -1);
// 		        $out = str_replace("'","",$out);
		        
// 			$result = mysql_query("SELECT  'შემდგომში ნაპასუხები' AS `status`,
//                                             COUNT(cd.uniqueid)			    
//                                 FROM	queue_stats
//                                 left JOIN	qname ON	queue_stats.qname = qname.qname_id
//                                 left JOIN	qevent ON	queue_stats.qevent = qevent.event_id
//                                 left JOIN	cdr as cd ON	queue_stats.uniqueid = cd.uniqueid
// 	  	                        LEFT JOIN   incomming_call ON cd.calldate = incomming_call.miss_date
//                                 WHERE 	DATE(queue_stats.datetime) >= '$start'
//                                 AND 	DATE(queue_stats.datetime) <= '$end' 
//                                 AND 	qevent.`event` IN ('ABANDON', 'CONNECT')
// 	  	                        AND cd.src NOT IN ((SELECT phone FROM incomming_call WHERE DATE(incomming_call.miss_date) >= '$start' AND DATE(incomming_call.miss_date) <= '$end'))
// 	  	                        AND ISNULL(incomming_call.miss_date)
// 								AND     cd.src REGEXP '$out'
//                                 GROUP BY cd.disposition
//                     	  	    HAVING SUM(IF(cd.disposition = 'ANSWERED', 0, 1) ) > 0                                
	  	    
// 	  	                        UNION ALL
	  	    
// 	  	                        SELECT  'უპასუხო' AS `status`,
// 			                             COUNT(cd.uniqueid)
//                     	  	    FROM	queue_stats
//                     	  	    left JOIN	qname ON	queue_stats.qname = qname.qname_id
//                     	  	    left JOIN	qevent ON	queue_stats.qevent = qevent.event_id
//                     	  	    left JOIN	cdr as cd ON	queue_stats.uniqueid = cd.uniqueid
//                     	  	    LEFT JOIN   incomming_call ON cd.calldate = incomming_call.miss_date
//                     	  	    WHERE 	DATE(queue_stats.datetime) >= '$start'
//                     	  	    AND 	DATE(queue_stats.datetime) <= '$end'
//                     	  	    AND 	qevent.`event` IN ('ABANDON', 'CONNECT')
//                     	  	    AND cd.src NOT IN ((SELECT phone FROM incomming_call WHERE DATE(incomming_call.date) >= '$start' AND DATE(incomming_call.date) <= '$end'))
//                     	  	    AND ISNULL(incomming_call.miss_date)
//                     	  	    AND     cd.src NOT REGEXP '$out'
//                     	  	    GROUP BY cd.disposition
//                     	  	    HAVING SUM(IF(cd.disposition = 'ANSWERED', 0, 1) ) > 0");

	    $result = mysql_query(" SELECT  persons.`name`,
	                                    COUNT(*),	                                    
	                                    (
                                        ROUND((COUNT(*)/(SELECT  COUNT(*)
                        		        FROM `cdr`
                        		        JOIN incomming_call ON cdr.calldate = incomming_call.miss_date
                        		        WHERE DATE(calldate) >= '2015-01-12'
                        		        AND DATE(calldate) <= '2015-01-12'
                        		        AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = '' and incomming_call.miss_date != '') *100),2)
                                        )	                                    
                		        FROM    `cdr`
                		        JOIN    incomming_call ON cdr.calldate = incomming_call.miss_date
								JOIN    users ON incomming_call.user_id = users.id
								JOIN    persons ON users.person_id = persons.id 
                		        WHERE DATE(calldate) >= '$start'
                		        AND DATE(calldate) <= '$end'
                		        AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = '' and incomming_call.miss_date != ''
                	            GROUP BY persons.`name`");

		break;
		
}
///----------------------------------------------act------------------------------------------
switch ($action) {
	case "get_list":
		$data = array("aaData"	=> array());
		while ( $aRow = mysql_fetch_array( $result ) )
		{	$row = array();
			for ( $i = 0 ; $i < $count ; $i++ )
			{
				$row[0] = '0';

				$row[$i+1] = $aRow[$i];
			}
			$data['aaData'][] =$row;
		}
		echo json_encode($data); return 0;
		break;
	case 'get_category' :
		$rows = array();
		while($r = mysql_fetch_array($result)) {
			$row[0] = $r[0];
			$row[1] = (float) $r[1];
			$rows['data'][]=$row;
		}
		$rows['text']=$text[0];
		echo json_encode($rows);
		break;
	case 'get_in_page':
		mysql_query("SET @i = 0;");
	  	$rResult = mysql_query("SELECT  calldate,
                            		        calldate,
                            		        src,
                            		        CASE
                                		        WHEN SUBSTR(lastdata,8) = 'saleslandarasamushao_2' THEN '2420421'
                                                WHEN lastdata = 'custom/riders-arasamushao' THEN '2420421'
                                                WHEN lastdata = 'custom/giorgobaridersland-8khz' THEN '2420421'
            									WHEN SUBSTR(lastdata,8) = 'biblusiarasamushao' THEN '2486844'
            									WHEN SUBSTR(lastdata,8) = 'arasamuSaosaaTebSi' THEN '2196053'
            									WHEN SUBSTR(lastdata,8) = 'giorgobabiblusi-8khz' THEN '2196013'
                                                WHEN lastdata = 'custom/palitragiorgoba-8khz' THEN '2196053'
            									WHEN lastdata = 'custom/palitragiorgoba-8khz' THEN '2196013'
    	  	    
    	  	                                    WHEN lastdata = 'custom/RIDERS-NonWork' THEN '2420421'
            									WHEN lastdata = 'custom/BIBLUS-NonWork' THEN '2486844'
            									WHEN lastdata = 'custom/PALITRA-NonWork' THEN '2196053'
            									WHEN lastdata = 'custom/PALITRA-NonWork' THEN '2196013'
    
                                                WHEN lastdata = 'custom/NEWriders' THEN '2420421'
            									WHEN lastdata = 'custom/NEWbiblus' THEN '2486844'
                                                WHEN lastdata = 'custom/marketing-samushao' THEN '2159030'
                                                WHEN lastdata = 'SIP/200,\"\",trM(auto-blkvm)' THEN '2159030'
                                                WHEN lastdata = 'custom/marketing_arasamushao_saatebi' THEN '2159030'
                                                WHEN lastdata = 'custom/satelefono-marketingi-arasamushao' THEN '2159030'
                                                WHEN lastdata = 'custom/satelefono_marketingi' THEN '2159030'
                                                WHEN lastdata = 'custom/NEWmarketing' THEN '2159030'
    
    
                                                WHEN lastdata = 'custom/newyeahrbiblus' THEN '2486844'
                                                WHEN lastdata = 'custom/newyeahrpalitra1' THEN '2196053'
                                                WHEN lastdata = 'custom/Sesacvlelipirveliteqsti' THEN '196013'
                                                WHEN lastdata = 'custom/riders-samushao' THEN '2420421'
                            		        END AS `lastdata`,
                            		        SEC_TO_TIME(billsec) as `billsec`,
		                                    department.`name` AS `dep_name`,
											info_category.`name` AS `cat_name`,
  											sub.`name` AS `cat_sub_name`,
  	                                        incomming_call.first_name,
											incomming_call.phone,
  											incomming_call.call_comment,
											call_status.`name` AS `c_status`,
  											persons.`name`
                    		        FROM `cdr`
                    		        JOIN incomming_call ON cdr.calldate = incomming_call.miss_date
		                            LEFT JOIN 		info_category  ON incomming_call.information_category_id=info_category.id
    	  							LEFT JOIN 		info_category as `sub`  ON incomming_call.information_sub_category_id=sub.id
    								LEFT JOIN		call_status ON incomming_call.call_status_id = call_status.id
    								LEFT JOIN		department ON incomming_call.department_id = department.id
    								JOIN			users ON incomming_call.user_id = users.id
    								JOIN			persons ON users.person_id = persons.id 
                    		        WHERE DATE(calldate) >= '$start'
                    		        AND DATE(calldate) <= '$end'
                    		        AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = '' and incomming_call.miss_date != '' AND persons.`name` = '$type'
	                                GROUP BY cdr.calldate");
	  
$data = array(
				"aaData"	=> array()
		);

		while ( $aRow = mysql_fetch_array( $rResult ) )
		{
			$row = array();
			$row1 = array();
			
			for ( $i = 0 ; $i < $count ; $i++ )
			{
				$row[] = $aRow[$i];
				$a=$aRow;
				
				{
				
				}
			}
			$data['aaData'][] = $row;
		}
		echo json_encode($data); return 0;
		break;
	default :
		echo "Action Is Null!";
		break;

}



?>