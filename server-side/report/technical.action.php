<?php
require_once('../../includes/classes/core.php');
//----------------------------- ცვლადი

$agent	= $_REQUEST['agent'];
$queue	= $_REQUEST['queuet'];
$start_time = $_REQUEST['start_time'];
$end_time 	= $_REQUEST['end_time'];
$day = (strtotime($end_time)) -  (strtotime($start_time));
$day_format = ($day / (60*60*24)) + 1;


// ----------------------------------

if($_REQUEST['act'] =='answear_dialog_table'){

	$data		= array('page' => array(
			'answear_dialog' => ''
	));
	$count = 		$_REQUEST['count'];
	$hidden = 		$_REQUEST['hidden'];
	$rResult = mysql_query("SELECT 	cdr.calldate,
									cdr.calldate,
									cdr.src,
									cdr.dst,
									qagent.agent,
									TIME_FORMAT(SEC_TO_TIME(cdr.duration - 15), '%i:%s'),
									CONCAT('<p onclick=play(', '\'', SUBSTRING(cdr.userfield, 35),'.wav', '\'',  ')>მოსმენა</p>', '<a download=\"audio.wav\" href=\"http://109.234.117.182:8181/records/', SUBSTRING(cdr.userfield, 35),'.wav', '\">ჩამოტვირთვა</a>') AS `dwn`
							FROM 	queue_stats
							JOIN 	cdr ON queue_stats.uniqueid = cdr.uniqueid
							JOIN 	qagent ON queue_stats.qagent = qagent.agent_id
							JOIN 	qname ON queue_stats.qname = qname.qname_id
							WHERE 	queue_stats.qevent in (7,8)
							AND 	DATE(queue_stats.`datetime`) >= '$start_time'
							AND 	DATE(queue_stats.`datetime`) <= '$end_time'
							AND 	qname.queue IN ($queue)
							AND		qagent.agent IN ($agent)");
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
		
}
elseif($_REQUEST['act'] =='miss_checker'){

	$data		= array('page' => array(
			             'technik_miss_info' => '',
	                     'answer_call_by_queue_miss' => '',
	                     'un_answer_call_miss' => ''
	));

	$miss_total = mysql_fetch_row(mysql_query(" SELECT  COUNT(*)
                                                FROM `cdr` 
                                                WHERE DATE(calldate) >= '$start_time' 
                                                AND DATE(calldate) <= '$end_time' AND !(TIME(calldate) >= '09:30:00' AND TIME(calldate) <= '20:00:00')
                                                AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = ''"));
	
	$res = mysql_query("SELECT  cdr.src
    					FROM `cdr`
    					WHERE DATE(calldate) >= '$start_time'
    					AND DATE(calldate) <= '$end_time' AND !(TIME(calldate) >= '09:30:00' AND TIME(calldate) <= '20:00:00')
    					AND LENGTH(lastdata) > 15 AND lastdata != 'custom/XorcieldebaMonitoringi' AND userfield = ''
    					");
	
	while($check_res = mysql_fetch_array($res)){
	    $str .= $check_res[0].',';
	}
	$str = substr($str,0,-1);
	
	$miss_answer = mysql_fetch_row(mysql_query("SELECT    COUNT(*)
	                                            FROM      cdr
                    							WHERE cdr.disposition = 'ANSWERED'
                    							AND cdr.userfield != '' 
                    							AND cdr.src IN ($agent)
                    							AND DATE(cdr.calldate) >= '$start_time'
                    							AND DATE(cdr.calldate) <= '$end_time'
                    							AND SUBSTRING(cdr.lastdata,5,7) IN ($queue)
	                                            AND dst IN ($str)"));
	
	$miss_noanswer = mysql_fetch_row(mysql_query("SELECT COUNT(*) 
                    	                        FROM   cdr
                    							WHERE      cdr.disposition = 'NO ANSWER'
                    							AND cdr.userfield != '' 
                    							AND cdr.src IN ($agent)
                    							AND DATE(cdr.calldate) >= '$start_time'
                    							AND DATE(cdr.calldate) <= '$end_time'
                    							AND SUBSTRING(cdr.lastdata,5,7) IN ($queue)"));
	
	$miss_done = mysql_fetch_row(mysql_query("SELECT  COUNT(*)
                    		        FROM `cdr`
                    		        JOIN incomming_call ON cdr.calldate = incomming_call.miss_date
                    		        WHERE DATE(calldate) >= '$start_time'
                    		        AND DATE(calldate) <= '$end_time'
                    		        AND LENGTH(lastdata) > 15 
                            	    AND lastdata != 'custom/XorcieldebaMonitoringi' 
                            	    AND userfield = '' 
                            	    AND incomming_call.miss_date != ''"));
	
	$miss_undone = mysql_fetch_row(mysql_query("SELECT  COUNT(*)
                                    	    FROM `cdr`
                                    	    LEFT JOIN incomming_call ON cdr.calldate = incomming_call.miss_date
                                    	    WHERE DATE(calldate) >= '$start_time'
                                    	    AND DATE(calldate) <= '$end_time'
                                    	    AND LENGTH(lastdata) > 15
                                    	    AND lastdata != 'custom/XorcieldebaMonitoringi'
                                    	    AND userfield = ''
                                    	    AND incomming_call.miss_date != '' and ISNULL(miss_date)"));

		
    $data['page']['technik_miss_info'] = '
                                        <td>ზარი</td>
                                        <td>'.$miss_total[0].'</td>
                                        <td id="miss_answear_dialog" style="cursor: pointer; text-decoration: underline;">'.$miss_answer[0].'</td>
                                        <td id="miss_unanswear_dialog" style="cursor: pointer; text-decoration: underline;">'.($miss_total[0] - $miss_answer[0]).'</td>
                                        <td id="miss_undone_dialog" style="cursor: pointer; text-decoration: underline;">'.$miss_done[0].'</td>                    
                                        <td>'.$miss_undone[0].'</td>
                                        <td>'.round((($miss_answer[0] / $miss_total[0]) * 100),2).'%</td>
                                        <td>'.round(((($miss_total[0] - $miss_answer[0]) / $miss_total[0]) * 100),2).'%</td>
                                        <td>'.round((($miss_done[0] / $miss_answer[0]) * 100),2).'%</td>
                                        <td>'.round((($miss_undone[0] / $miss_answer[0]) * 100),2).'%</td>
                                         ';
    
    $ress =mysql_query("SELECT dst,
                        COUNT(*) as `call`,
                        ROUND(((COUNT(*) / (
                        SELECT COUNT(*)
                        FROM `cdr`
                        WHERE disposition = 'ANSWERED'
                        AND DATE(calldate) = '$start_time'
                        AND DATE(calldate) = '$end_time'
                        AND userfield != ''
                        AND dst IN ($agent)
                        AND src IN ($str)
                        )) * 100),2) as call_prc,
                        SUM(duration) as `duration`,
                        ROUND(((SUM(duration) / (
                        SELECT SUM(duration)
                        FROM `cdr`
                        WHERE disposition = 'ANSWERED'
                        AND DATE(calldate) = '$start_time'
                        AND DATE(calldate) = '$end_time'
                        AND userfield != ''
                        AND dst IN ($agent)
                        AND src IN ($str)
                        )) * 100),2) as duration_prc,
                        ROUND((SUM(duration) / COUNT(*)),2) as duration_avg,
                        (SUM(duration) - SUM(billsec)) as hold_time,
                        ROUND(( (SUM(duration) - SUM(billsec)) / COUNT(*)),2) as hold_time_avg
                        FROM `cdr`
                        WHERE disposition = 'ANSWERED'
                        AND DATE(calldate) = '$start_time'
                        AND DATE(calldate) = '$end_time'
                        AND userfield != ''
                        AND dst IN ($agent)
                        AND src IN ($str)
                        GROUP BY dst
        ");
    
    while($row = mysql_fetch_assoc($ress)){
    $data['page']['answer_call_by_queue_miss'] = '
                                        <tr>
                    					<td>'.$row[dst].'</td>
                    					<td>'.$row[call].'</td>
                    					<td>'.$row[call_prc].' %</td>
                    					<td>'.$row[duration].' წუთი</td>
                    					<td>'.$row[duration_prc].' %</td>
                    					<td>'.$row[duration_avg].' წუთი</td>
                    					<td>'.$row[hold_time].' წამი</td>
                    					<td>'.$row[hold_time_avg].' წამი</td>
                    					</tr>
                                                ';
    }
    
    
    $queue_miss = mysql_query("
                                SELECT dst,
                                COUNT(*) as `call`,
                                ROUND(((COUNT(*) / (
                                                    SELECT COUNT(*)
                                                    FROM `cdr`
                                                    WHERE disposition = 'ANSWERED'
                                                    AND DATE(calldate) = '$start_time'
                                                    AND DATE(calldate) = '$end_time'
                                                    AND userfield != ''
                                                    AND dst IN ($queue)
                                                    AND src IN ($str)
                                                     )) * 100),2) as `call_prc`
                                FROM `cdr`
                                WHERE disposition = 'ANSWERED'
                                AND DATE(calldate) = '$start_time'
                                AND DATE(calldate) = '$end_time'
                                AND userfield != ''
                                AND dst IN ($queue)
                                AND src IN ($str)
                                GROUP BY dst
                            ");
    
    while ($queue_miss_row = mysql_fetch_row($queue_miss)){
    $data['page']['answer_call_miss'] = '
                                            <tr>
                        					<td>'.$queue_miss_row[0].'</td>
                        					<td>'.$queue_miss_row[1].'</td>
                        					<td>'.$queue_miss_row[2].'</td>
                        					</tr>
                                            ';
    }
    
    $queue_miss_un = mysql_query("
                                SELECT dst,
                                COUNT(*) as `call`,
                                ROUND(((COUNT(*) / (
                                SELECT COUNT(*)
                                FROM `cdr`
                                WHERE disposition = 'NO ANSWER'
                                AND DATE(calldate) = '$start_time'
                                AND DATE(calldate) = '$end_time'
                                AND userfield != ''
                                AND dst IN ($queue)
                                AND src IN ($str)
                                )) * 100),2) as `call_prc`
                                FROM `cdr`
                                WHERE disposition = 'NO ANSWER'
                                AND DATE(calldate) = '$start_time'
                                AND DATE(calldate) = '$end_time'
                                AND userfield != ''
                                AND dst IN ($queue)
                                AND src IN ($str)
                                GROUP BY dst
                                ");
    
    while ($queue_miss_un_row = mysql_fetch_row($queue_miss_un)){
    $data['page']['unanswer_call_miss'] = '
                                            <tr>
                        					<td>'.$queue_miss_un_row[0].'</td>
                        					<td>'.$queue_miss_un_row[1].'</td>
                        					<td>'.$queue_miss_un_row[2].'</td>
                        					</tr>
                                            ';
    }
}
else
if($_REQUEST['act'] =='unanswear_dialog_table'){

	$data		= array('page' => array(
			'answear_dialog' => ''
	));
	$count = 		$_REQUEST['count'];
	$hidden = 		$_REQUEST['hidden'];
	$rResult = mysql_query("SELECT 	cdr.calldate,
									cdr.calldate,
									cdr.src,
									cdr.dst,
									TIME_FORMAT(SEC_TO_TIME(cdr.duration), '%i:%s')
							FROM	queue_stats
							left JOIN	qname ON	queue_stats.qname = qname.qname_id
							left JOIN	qevent ON	queue_stats.qevent = qevent.event_id
							left JOIN	cdr ON	queue_stats.uniqueid = cdr.uniqueid
							WHERE 	DATE(queue_stats.datetime) >= '$start_time'
							AND 	DATE(queue_stats.datetime) <= '$end_time' 
							AND 	qname.queue IN ($queue) 
							AND 	qevent.`event` IN ('ABANDON')");
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

}elseif($_REQUEST['act'] =='undone_dialog_table'){
    $data		= array('page' => array(
        'answear_dialog' => ''
    ));
    $count = 		$_REQUEST['count'];
    $hidden = 		$_REQUEST['hidden'];
    
    $inc = mysql_query("SELECT phone
			FROM 	incomming_call
			WHERE 	DATE(date) >= '$start_time'
			AND 	DATE(date) <= '$end_time'
			AND 	phone != ''");
    while($res_i = mysql_fetch_array($inc)){
        $inc_str .= $res_i[0].',';
    }
    $inc_filtr = substr($inc_str, 0, -1);
    
    $rResult = mysql_query("SELECT 	cdr.calldate,
        cdr.calldate,
        cdr.src,
        cdr.dst,
        qagent.agent,
        TIME_FORMAT(SEC_TO_TIME(cdr.duration - 15), '%i:%s'),
        CONCAT('<p onclick=play(', '\'', SUBSTRING(cdr.userfield, 35),'.wav', '\'',  ')>მოსმენა</p>', '<a download=\"audio.wav\" href=\"http://109.234.117.182:8181/records/', SUBSTRING(cdr.userfield, 35),'.wav', '\">ჩამოტვირთვა</a>') AS `dwn`
        FROM 	queue_stats
        JOIN 	cdr ON queue_stats.uniqueid = cdr.uniqueid
        JOIN 	qagent ON queue_stats.qagent = qagent.agent_id
        JOIN 	qname ON queue_stats.qname = qname.qname_id
        WHERE 	queue_stats.qevent in (7,8)
        AND 	DATE(queue_stats.`datetime`) >= '$start_time'
        AND 	DATE(queue_stats.`datetime`) <= '$end_time'
        AND 	qname.queue IN ($queue)
        AND		qagent.agent IN ($agent)
        AND     cdr.src NOT IN ($inc_filtr) 
        GROUP BY cdr.src");
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
    
}elseif($_REQUEST['act'] =='miss_dialog_table'){
$data		= array('page' => array(
			'answear_dialog' => ''
	));
	$count = 		$_REQUEST['count'];
	$hidden = 		$_REQUEST['hidden'];
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
                                    SEC_TO_TIME(billsec) as `billsec`
                            FROM `cdr` 
                            WHERE DATE(calldate) >= '$start_time' 
                            AND DATE(calldate) <= '$end_time' AND TIME(calldate) >= '20:00:00'
                            AND LENGTH(lastdata) > 15 AND userfield = '' AND lastdata != 'custom/XorcieldebaMonitoringi' 
	                        UNION ALL
	                        SELECT  calldate,
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
                                    SEC_TO_TIME(billsec) as `billsec`
                            FROM `cdr` 
                            WHERE DATE(calldate) >= '$start_time' 
                            AND DATE(calldate) <= '$end_time' AND TIME(calldate) <= '09:30:00'
                            AND LENGTH(lastdata) > 15 AND userfield = '' AND lastdata != 'custom/XorcieldebaMonitoringi' ");
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
    
}elseif($_REQUEST['act'] =='undone_dialog'){
    $data['page']['answear_dialog'] = '
															
													
												                <table class="display" id="example2">
												                    <thead>
												                        <tr id="datatable_header">
												                            <th>ID</th>
												                            <th style="width: 100%;">თარიღი</th>
												                            <th style="width: 120px;">წყარო</th>
												                            <th style="width: 120px;">ადრესატი</th>
																			<th style="width: 80px;">ოპერატორი</th>
												                            <th style="width: 80px;">დრო</th>
												                            <th style="width: 100px;">ქმედება</th>
												                        </tr>
												                    </thead>
												                    <thead>
												                        <tr class="search_header">
												                            <th class="colum_hidden">
												                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
												                            </th>
												                            <th>
												                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="">
																			</th>
												                            <th>
												                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
												                            </th>                            
												                            <th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
												                            </th>
												                            <th>
												                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 70px;"/>
												                            </th>
												                            <th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 70px;" />
												                            </th>
																			<th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
												                            </th>
												                            
												                        </tr>
												                    </thead>
												                </table>
												        
						
													';
}elseif($_REQUEST['act'] =='miss_dialog'){
    $data['page']['answear_dialog'] = '
															
													
								<table class="display" id="example3">
				                    <thead>
				                        <tr id="datatable_header">
				                            <th>ID</th>
				                            <th style="width: 100%;">თარიღი</th>
				                            <th style="width: 120px;">წყარო</th>
				                            <th style="width: 100px;">ადრესატი</th>
				                            <th style="width: 80px;">დრო</th>
				                        </tr>
				                    </thead>
				                    <thead>
				                        <tr class="search_header">
				                            <th class="colum_hidden">
				                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
				                            </th>
				                            <th>
				                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="width: 100px;">
											</th>
				                            <th>
				                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
				                            </th>
				                            <th>
				                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
				                            </th>
											<th>
				                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 60px;" />
				                            </th>
				                        </tr>
				                    </thead>
				                </table>
												        
						
													';
}else
if($_REQUEST['act'] =='answear_dialog'){

				$data['page']['answear_dialog'] = '
															
													
												                <table class="display" id="example">
												                    <thead>
												                        <tr id="datatable_header">
												                            <th>ID</th>
												                            <th style="width: 100%;">თარიღი</th>
												                            <th style="width: 120px;">წყარო</th>
												                            <th style="width: 120px;">ადრესატი</th>
																			<th style="width: 80px;">ოპერატორი</th>
												                            <th style="width: 80px;">დრო</th>
												                            <th style="width: 100px;">ქმედება</th>
												                        </tr>
												                    </thead>
												                    <thead>
												                        <tr class="search_header">
												                            <th class="colum_hidden">
												                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
												                            </th>
												                            <th>
												                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="">
																			</th>
												                            <th>
												                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
												                            </th>                            
												                            <th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
												                            </th>
												                            <th>
												                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 70px;"/>
												                            </th>
												                            <th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 70px;" />
												                            </th>
																			<th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
												                            </th>
												                            
												                        </tr>
												                    </thead>
												                </table>
												        
						
													';
			
			
}
else
if($_REQUEST['act'] =='unanswear_dialog'){

	$data['page']['answear_dialog'] = '
								
							
												                <table class="display" id="example1">
												                    <thead>
												                        <tr id="datatable_header">
												                            <th>ID</th>
												                            <th style="width: 100%;">თარიღი</th>
												                            <th style="width: 120px;">წყარო</th>
												                            <th style="width: 100px;">ადრესატი</th>
												                            <th style="width: 80px;">დრო</th>
												                        </tr>
												                    </thead>
												                    <thead>
												                        <tr class="search_header">
												                            <th class="colum_hidden">
												                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
												                            </th>
												                            <th>
												                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="">
																			</th>
												                            <th>
												                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
												                            </th>
												                            <th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
												                            </th>
																			<th>
												                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 70px;" />
												                            </th>
												                        </tr>
												                    </thead>
												                </table>


													';
		
		
}
else
{
    $r_user = "4,5,6,7,34,35";
    if($agent == "'EXT100'"){
        $r_user = 4;
    }elseif ($agent == "'EXT101'"){
        $r_user = 7;
    }elseif ($agent == "'EXT150'"){
        $r_user = 6;
    }elseif ($agent == "'EXT250'"){
        $r_user = 5;
    }elseif ($agent == "'EXT200'"){
        $r_user = "34,35";
    }

$row_done_blank = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `count`
													FROM `incomming_call`
													WHERE DATE(date) >= '$start_time' AND DATE(date) <= '$end_time' AND phone != '' and ISNULL(miss_date) AND user_id IN ($r_user)"));


$data		= array('page' => array(
										'answer_call' => '',
										'technik_info' => '',
										'report_info' => '',
										'answer_call_info' => '',
										'answer_call_by_queue' => '',
										'disconnection_cause' => '',
										'unanswer_call' => '',
										'disconnection_cause_unanswer' => '',
										'unanswered_calls_by_queue' => '',
										'totals' => '',
										'call_distribution_per_day' => '',
										'call_distribution_per_hour' => '',
										'call_distribution_per_day_of_week' => '',
										'service_level' => ''
								));

$data['error'] = $error;
//------------------------------- ტექნიკური ინფორმაცია

	$row_answer = mysql_fetch_assoc(mysql_query("	SELECT	COUNT(*) AS `count`,
															q.queue AS `queue`
													FROM	queue_stats AS qs,
															qname AS q,
															qagent AS ag,
															qevent AS ac
													WHERE qs.qname = q.qname_id 
													AND qs.qagent = ag.agent_id 
													AND qs.qevent = ac.event_id 
													AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
													AND q.queue IN ($queue) 
													AND ag.agent in ($agent)
													AND ac.event IN ( 'COMPLETECALLER', 'COMPLETEAGENT') 
													ORDER BY ag.agent"));
	
	$row_abadon = mysql_fetch_assoc(mysql_query("	SELECT 	COUNT(*) AS `count`,
															ROUND((SUM(qs.info3) / COUNT(*))) AS `sec`
													FROM	queue_stats AS qs,
															qname AS q, 
															qagent AS ag,
															qevent AS ac
													WHERE qs.qname = q.qname_id
													AND qs.qagent = ag.agent_id
													AND qs.qevent = ac.event_id
													AND DATE(qs.datetime) >= '$start_time'
													AND DATE(qs.datetime) <= '$end_time' 
													AND q.queue IN ($queue) 
													AND ac.event IN ('ABANDON')"));
	
	$row_miss = mysql_fetch_assoc(mysql_query("
	                                            SELECT COUNT(*) + (
	                                                                SELECT COUNT(*)
                                                                    FROM `cdr` 
                                                                    WHERE DATE(calldate) >= '$start_time' 
                                                                    AND DATE(calldate) <= '$end_time' AND TIME(calldate) <= '09:30:00'
                                                                    AND LENGTH(lastdata) > 15 AND userfield = '' AND lastdata != 'custom/XorcieldebaMonitoringi' 
	                                                               ) as `num`
                                                FROM `cdr` 
                                                WHERE DATE(calldate) >= '$start_time' 
                                                AND DATE(calldate) <= '$end_time' AND TIME(calldate) >= '20:00:00'
                                                AND LENGTH(lastdata) > 15 AND userfield = '' AND lastdata != 'custom/XorcieldebaMonitoringi' 
	                                           "));
	
	
	$data['page']['technik_info'] = '
							
                    <td>ზარი</td>
                    <td>'.($row_answer[count] + $row_abadon[count] + $row_miss[num]).'</td>
                    <td id="answear_dialog" style="cursor: pointer; text-decoration: underline;">'.$row_answer[count].'</td>
                    <td id="unanswear_dialog" style="cursor: pointer; text-decoration: underline;">'.$row_abadon[count].'</td>
                    <td id="miss_dialog" style="cursor: pointer; text-decoration: underline;">'.$row_miss[num].'</td>
                    <td>'.$row_done_blank[count].'</td>
                    <td id="undone_dialog" style="cursor: pointer; text-decoration: underline;">'.($row_answer[count] - $row_done_blank[count]).'</td>
                    <td>'.round(((($row_answer[count]) / ($row_answer[count] + $row_abadon[count] + $row_miss[num])) * 100),2).' %</td>
                    <td>'.round(((($row_abadon[count]) / ($row_answer[count] + $row_abadon[count] + $row_miss[num])) * 100),2).' %</td>
                    <td>'.round(((($row_miss[num]) / ($row_answer[count] + $row_abadon[count] + $row_miss[num])) * 100),2).' %</td>
                    <td>'.round(((($row_done_blank[count]) / ($row_answer[count])) * 100),2).' %</td>
                    <td>'.round(((($row_answer[count] - $row_done_blank[count]) / ($row_answer[count])) * 100),2).' %</td>
                    
                
							';
// -----------------------------------------------------

//------------------------------- ნაპასუხები ზარები რიგის მიხედვით

	$g = mysql_query("	SELECT	COUNT(*) AS `count`,
									q.queue AS `queue`
									FROM	queue_stats AS qs,
									qname AS q,
									qagent AS ag,
									qevent AS ac
									WHERE qs.qname = q.qname_id
									AND qs.qagent = ag.agent_id
									AND qs.qevent = ac.event_id
									AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
									AND q.queue IN ($queue)
									AND ag.agent in ($agent)
									AND ac.event IN ( 'COMPLETECALLER', 'COMPLETEAGENT')
									GROUP BY q.queue");
	
	while ($rr = mysql_fetch_assoc($g)){								
	$data['page']['answer_call'] .= '
							<tr><td>'.$rr[queue].'</td><td>'.$rr[count].' ზარი</td><td>'.round(((($rr[count]) / ($row_answer[count])) * 100)).' %</td></tr>
							';
	}
//-------------------------------------------------------

//------------------------------- მომსახურების დონე(Service Level)

	
	
	$res_service_level = mysql_query("	SELECT 	qs.info1
							FROM 	queue_stats AS qs,
									qname AS q,
									qagent AS ag,
									qevent AS ac 
							WHERE 	qs.qname = q.qname_id 
							AND qs.qagent = ag.agent_id 
							AND qs.qevent = ac.event_id 
							AND DATE(qs.datetime) >= '$start_time'
							AND DATE(qs.datetime) <= '$end_time'
							AND q.queue IN ($queue)
							AND ag.agent in ($agent) 
							AND ac.event IN ('CONNECT')
						");
	$w15 = 0;
	$w30 = 0;
	$w45 = 0;
	$w60 = 0;
	$w75 = 0;
	$w90 = 0;
	$w91 = 0;
	
	
	
	
	while ($res_service_level_r = mysql_fetch_assoc($res_service_level)) {
	
		if ($res_service_level_r['info1'] < 15) {
			$w15++;
		}
	
		if ($res_service_level_r['info1'] < 30){
			$w30++;
		}
	
		if ($res_service_level_r['info1'] < 45){
			$w45++;
		}
	
		if ($res_service_level_r['info1'] < 60){
			$w60++;
		}
	
		if ($res_service_level_r['info1'] < 75){
			$w75++;
		}
	
		if ($res_service_level_r['info1'] < 90){
			$w90++;
		}
	
		$w91++;
	
	}
	
	$d30 = $w30 - $w15;
	$d45 = $w45 - $w30;
	$d60 = $w60 - $w45;
	$d75 = $w75 - $w60;
	$d90 = $w90 - $w75;
	$d91 = $w91 - $w90;
	
	
	$p15 = round($w15 * 100 / $w91);
	$p30 = round($w30 * 100 / $w91);
	$p45 = round($w45 * 100 / $w91);
	$p60 = round($w60 * 100 / $w91);
	$p75 = round($w75 * 100 / $w91);
	$p90 = round($w90 * 100 / $w91);
	
	
	
	
	
	$data['page']['service_level'] = '
							
							<tr class="odd">
						 		<td>15 წამში</td>
					 			<td>'.$w15.'</td>
					 			<td></td>
					 			<td>'.$p15.'%</td>
					 		</tr>
				 			<tr>
						 		<td>30 წამში</td>
					 			<td>'.$w30.'</td>
					 			<td>'.$d30.'</td>
					 			<td>'.$p30.'%</td>
					 		</tr>
				 			<tr class="odd">
						 		<td>45 წამში</td>
					 			<td>'.$w45.'</td>
					 			<td>'.$d45.'</td>
					 			<td>'.$p45.'%</td>
					 		</tr>
				 			<tr>
						 		<td>60 წამში</td>
					 			<td>'.$w60.'</td>
					 			<td>'.$d60.'</td>
					 			<td>'.$p60.'%</td>
					 		</tr>
				 			<tr class="odd">
						 		<td>75 წამში</td>
					 			<td>'.$w75.'</td>
					 			<td>'.$d75.'</td>
					 			<td>'.$p75.'%</td>
					 		</tr>
					 		<tr>
						 		<td>90 წამში</td>
					 			<td>'.$w90.'</td>
					 			<td>'.$d90.'</td>
					 			<td>'.$p90.'%</td>
					 		</tr>
					 		<tr class="odd">
						 		<td>90+ წამში</td>
					 			<td>'.$w91.'</td>
					 			<td>'.$d91.'</td>
					 			<td>100%</td>
					 		</tr>
							';
	
//-------------------------------------------------------
	
//---------------------------------------- რეპორტ ინფო

	$data['page']['report_info'] = '
				
                <tr>
                    <td class="tdstyle">რიგი:</td>
                    <td>'.$queue.'</td>
                </tr>
                <tr>
                    <td class="tdstyle">საწყისი თარიღი:</td>
                    <td>'.$start_time.'</td>
                </tr>
                <tr>
                    <td class="tdstyle">დასრულების თარიღი:</td>
                    <td>'.$end_time.'</td>
                </tr>
                <tr>
                    <td class="tdstyle">პერიოდი:</td>
                    <td>'.$day_format.' დღე</td>
                </tr>

							';
	
//----------------------------------------------


//------------------------------------ ნაპასუხები ზარები

$row_transfer = mysql_fetch_assoc(mysql_query("	SELECT	COUNT(*) AS `count`
												FROM	queue_stats AS qs,
												qname AS q,
												qagent AS ag,
												qevent AS ac
												WHERE qs.qname = q.qname_id
												AND qs.qagent = ag.agent_id
												AND qs.qevent = ac.event_id
												AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
												AND q.queue IN ($queue)
												AND ag.agent in ($agent)
												AND ac.event IN ( 'TRANSFER')
												ORDER BY ag.agent"));

$row_clock = mysql_fetch_assoc(mysql_query("	SELECT	ROUND((SUM(qs.info1) / COUNT(*)),2) AS `hold`,
														ROUND((SUM(qs.info2) / COUNT(*)),2) AS `sec`,
														ROUND((SUM(qs.info2) / 60 ),2) AS `min`
												FROM 	queue_stats AS qs,
														qname AS q,
														qagent AS ag,
														qevent AS ac 
												WHERE	qs.qname = q.qname_id 
												AND qs.qagent = ag.agent_id 
												AND qs.qevent = ac.event_id 
												AND q.queue IN ($queue) 
												AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
												AND ac.event IN ('COMPLETECALLER', 'COMPLETEAGENT')
												ORDER BY qs.datetime"));




	$data['page']['answer_call_info'] = '

                   	<tr>
					<td class="tdstyle">ნაპასუხები ზარები</td>
					<td>'.$row_answer[count].' ზარი</td>
					</tr>
					<tr>
					<td class="tdstyle">გადამისამართებული ზარები</td>
					<td>'.$row_transfer[count].' ზარი</td>
					</tr>
					<tr>
					<td class="tdstyle">საშ. ხანგძლივობა:</td>
					<td>'.$row_clock[sec].' წამი</td>
					</tr>
					<tr>
					<td class="tdstyle">სულ საუბრის ხანგძლივობა:</td>
					<td>'.$row_clock[min].' წუთი</td>
					</tr>
					<tr>
					<td class="tdstyle">ლოდინის საშ. ხანგძლივობა:</td>
					<td>'.$row_clock[hold].' წამი</td>
					</tr>

							';
	
//---------------------------------------------

	
//--------------------------- ნაპასუხები ზარები ოპერატორების მიხედვით

 	$ress =mysql_query("SELECT 	ag.agent as `agent`, 
 								count(ev.event) AS `num`,
 								round(((count(ev.event) / (
 	
 	SELECT count(ev.event) AS num
 	FROM queue_stats AS qs, qname AS q, qevent AS ev
 	WHERE qs.qname = q.qname_id
 	and qs.qevent = ev.event_id
 	and DATE(qs.datetime) >= '$start_time'
 	and DATE(qs.datetime) <= '$end_time'
 	and q.queue IN ($queue)
 	AND ev.event IN ('COMPLETECALLER', 'COMPLETEAGENT')
 	
 	)) * 100),2) AS `call_pr`,
 	ROUND((sum(qs.info2) / 60),2) AS `call_time`,
 	
 	round(((sum(qs.info2) / (
 	
 	SELECT sum(qs.info2)
 	FROM queue_stats AS qs, qname AS q, qevent AS ev
 	WHERE qs.qname = q.qname_id
 	and qs.qevent = ev.event_id
 	and DATE(qs.datetime) >= '$start_time'
 	and DATE(qs.datetime) <= '$end_time'
 	and q.queue IN ($queue)
 	AND ev.event IN ('COMPLETECALLER', 'COMPLETEAGENT')
 	
 	))* 100),2) AS `call_time_pr`,
 	TIME_FORMAT(SEC_TO_TIME(sum(qs.info2) / count(ev.event)), '%i:%s') AS `avg_call_time`,
 	sum(qs.info1) AS `hold_time`,
 	ROUND((sum(qs.info1) / count(ev.event)),2) AS `avg_hold_time`
 	FROM queue_stats AS qs, qname AS q, qevent AS ev, qagent AS `ag` WHERE ag.agent_id = qs.qagent AND
 	qs.qname = q.qname_id and qs.qevent = ev.event_id 
 	AND DATE(qs.datetime) >= '$start_time'
 	AND DATE(qs.datetime) <= '$end_time'
 	AND q.queue IN ($queue) 
 	AND ev.event IN ('COMPLETECALLER', 'COMPLETEAGENT')
 	GROUP BY ag.agent");

while($row = mysql_fetch_assoc($ress)){

	$data['page']['answer_call_by_queue'] .= '

                   	<tr>
					<td>'.$row[agent].'</td>
					<td>'.$row[num].'</td>
					<td>'.$row[call_pr].' %</td>
					<td>'.$row[call_time].' წუთი</td>
					<td>'.$row[call_time_pr].' %</td>
					<td>'.$row[avg_call_time].' წუთი</td>
					<td>'.$row[hold_time].' წამი</td>
					<td>'.$row[avg_hold_time].' წამი</td>
					</tr>

							';

}

//----------------------------------------------------

//--------------------------- კავშირის გაწყვეტის მიზეზეი


$row_COMPLETECALLER = mysql_fetch_assoc(mysql_query("	SELECT	COUNT(*) AS `count`,
																	q.queue AS `queue`
												FROM	queue_stats AS qs,
														qname AS q,
														qagent AS ag,
														qevent AS ac
												WHERE qs.qname = q.qname_id
												AND qs.qagent = ag.agent_id
												AND qs.qevent = ac.event_id
												AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
												AND q.queue IN ($queue)
												AND ag.agent in ($agent)
												AND ac.event IN ( 'COMPLETECALLER')
												ORDER BY ag.agent"));

$row_COMPLETEAGENT = mysql_fetch_assoc(mysql_query("	SELECT	COUNT(*) AS `count`,
																q.queue AS `queue`
														FROM	queue_stats AS qs,
																qname AS q,
																qagent AS ag,
																qevent AS ac
														WHERE qs.qname = q.qname_id
														AND qs.qagent = ag.agent_id
														AND qs.qevent = ac.event_id
														AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
														AND q.queue IN ($queue)
														AND ag.agent in ($agent)
														AND ac.event IN (  'COMPLETEAGENT')
														ORDER BY ag.agent"));

	$data['page']['disconnection_cause'] = '

                   <tr>
					<td class="tdstyle">ოპერატორმა გათიშა:</td>
					<td>'.$row_COMPLETEAGENT[count].' ზარი</td>
					<td>0.00 %</td>
					</tr>
					<tr>
					<td class="tdstyle">აბონენტმა გათიშა:</td>
					<td>'.$row_COMPLETECALLER[count].' ზარი</td>
					<td>0.00 %</td>
					</tr>

							';

//-----------------------------------------------

//----------------------------------- უპასუხო ზარები


	$data['page']['unanswer_call'] = '

                   	<tr>
					<td class="tdstyle">უპასუხო ზარების რაოდენობა:</td>
					<td>'.$row_abadon[count].' ზარი</td>
					</tr>
					<tr>
					<td class="tdstyle">ლოდინის საშ. დრო კავშირის გაწყვეტამდე:</td>
					<td>'.$row_abadon[sec].' წამი</td>
					</tr>
					<tr>
					<td class="tdstyle">საშ. რიგში პოზიცია კავშირის გაწყვეტამდე:</td>
					<td>1</td>
					</tr>
					<tr>
					<td class="tdstyle">საშ. საწყისი პოზიცია რიგში:</td>
					<td>1</td>
					</tr>

							';


//--------------------------------------------

	
//----------------------------------- კავშირის გაწყვეტის მიზეზი

	$row_timeout = mysql_fetch_assoc(mysql_query("	SELECT 	COUNT(*) AS `count`
			FROM 	queue_stats AS qs,
			qname AS q,
			qagent AS ag,
			qevent AS ac
			WHERE qs.qname = q.qname_id
			AND qs.qagent = ag.agent_id
			AND qs.qevent = ac.event_id
			AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
			AND q.queue IN ($queue)
			AND ac.event IN ('EXITWITHTIMEOUT')
			ORDER BY qs.datetime"));
	

	$data['page']['disconnection_cause_unanswer'] = '

                  <tr> 
                  <td class="tdstyle">აბონენტმა გათიშა</td>
			      <td>'.$row_abadon[count].' ზარი</td>
			      <td>'.round((($row_abadon[count] / $row_abadon[count]) * 100),2).' %</td>
		        </tr>
			    <tr> 
                  <td class="tdstyle">დრო ამოიწურა</td>
			      <td>'.$row_timeout[count].' ზარი</td>
			      <td>'.round((($row_timeout[count] / $row_timeout[count]) * 100),2).' %</td>
		        </tr>

							';

//--------------------------------------------

//------------------------------ უპასუხო ზარები რიგის მიხედვით

	$r = mysql_query("	SELECT 	COUNT(*) AS `count`,
										q.queue as `queue`
										FROM 	queue_stats AS qs,
										qname AS q,
										qagent AS ag,
										qevent AS ac
										WHERE qs.qname = q.qname_id
										AND qs.qagent = ag.agent_id
										AND qs.qevent = ac.event_id
										AND DATE(qs.datetime) >= '$start_time' AND DATE(qs.datetime) <= '$end_time'
										AND q.queue IN ($queue)
										AND ac.event IN ('ABANDON')
										GROUP BY q.queue");
	while ($Unanswered_Calls_by_Queue = mysql_fetch_assoc($r)){
	$data['page']['unanswered_calls_by_queue'] .= '

                   	<tr><td>'.$Unanswered_Calls_by_Queue[queue].'</td><td>'.$Unanswered_Calls_by_Queue[count].' ზარი</td><td>'.round((($Unanswered_Calls_by_Queue[count] / $row_abadon[count]) * 100),2).' %</td></tr>

							';
	}
	
//---------------------------------------------------

//------------------------------------------- სულ

	$data['page']['totals'] = '

                   	<tr> 
                  <td class="tdstyle">ნაპასუხები ზარების რაოდენობა:</td>
		          <td>'.$row_answer[count].' ზარი</td>
	            </tr>
                <tr>
                  <td class="tdstyle">უპასუხო ზარების რაოდენობა:</td>
                  <td>'.$row_abadon[count].' ზარი</td>
                </tr>
		        <tr>
                  <td class="tdstyle">ოპერატორი შევიდა:</td>
		          <td>0</td>
	            </tr>
                <tr>
                  <td class="tdstyle">ოპერატორი გავიდა:</td>
                  <td>0</td>
                </tr>

							';
	
//------------------------------------------------

	
//-------------------------------- ზარის განაწილება დღეების მიხედვით
	
	$res = mysql_query("
						SELECT 	DATE(qs.datetime) AS `datetime`,
								COUNT(*) AS `answer_count`,
								ROUND((( COUNT(*) / (
									SELECT 	COUNT(*) AS `count`
									FROM 	queue_stats AS qs,
											qname AS q, 
											qagent AS ag,
											qevent AS ac 
									WHERE qs.qname = q.qname_id
									AND qs.qagent = ag.agent_id 
									AND qs.qevent = ac.event_id
									AND DATE(qs.datetime) >= '$start_time'
									AND DATE(qs.datetime) <= '$end_time'
									AND q.queue IN ($queue,'NONE')
									AND ac.event IN ('COMPLETECALLER','COMPLETEAGENT')
										)) *100),2) AS `call_answer_pr`,
						TIME_FORMAT(SEC_TO_TIME((SUM(qs.info2) / COUNT(*))), '%i:%s') AS `avg_durat`,
						ROUND((SUM(qs.info1) / COUNT(*))) AS `avg_hold`
						FROM 	queue_stats AS qs,
									qname AS q, 
									qagent AS ag,
									qevent AS ac 
						WHERE qs.qname = q.qname_id
						AND qs.qagent = ag.agent_id 
						AND qs.qevent = ac.event_id
						AND DATE(qs.datetime) >= '$start_time'
						AND DATE(qs.datetime) <= '$end_time'
						AND q.queue IN ($queue,'NONE')
						AND ac.event IN ('COMPLETECALLER','COMPLETEAGENT')
						GROUP BY DATE(qs.datetime)
						");

	$ress = mysql_query("
						SELECT 	COUNT(*) AS `unanswer_call`,
				
								ROUND((( COUNT(*) / (
									SELECT 	COUNT(*) AS `count`
									FROM 		queue_stats AS qs,
													qname AS q, 
													qagent AS ag,
													qevent AS ac 
									WHERE qs.qname = q.qname_id
									AND qs.qagent = ag.agent_id 
									AND qs.qevent = ac.event_id
									AND DATE(qs.datetime) >= '$start_time'
									AND DATE(qs.datetime) <= '$end_time'
									AND q.queue IN ($queue,'NONE')
									AND ac.event IN ('ABANDON','EXITWITHTIMEOUT')
								)) *100),2) AS `call_unanswer_pr`
						FROM 	queue_stats AS qs,
									qname AS q, 
									qagent AS ag,
									qevent AS ac 
						WHERE qs.qname = q.qname_id
						AND qs.qagent = ag.agent_id 
						AND qs.qevent = ac.event_id
						AND DATE(qs.datetime) >= '$start_time'
						AND DATE(qs.datetime) <= '$end_time'
						AND q.queue IN ($queue,'NONE')
						AND ac.event IN ('ABANDON', 'EXITWITHTIMEOUT')
						GROUP BY DATE(qs.datetime)
						");
	
	
	
	while($row = mysql_fetch_assoc($res)){
		$roww = mysql_fetch_assoc($ress);
			$data['page']['call_distribution_per_day'] .= '

                   	<tr class="odd">
					<td>'.$row[datetime].'</td>
					<td>'.$row[answer_count].'</td>
					<td>'.$row[call_answer_pr].' %</td>
					<td>'.$roww[unanswer_call].'</td>
					<td>'.$roww[call_unanswer_pr].' %</td>
					<td>'.$row[avg_durat].' წუთი</td>
					<td>'.$row[avg_hold].' წამი</td>
					<td></td>
					<td></td>
					</tr>

							';
	}
	
//----------------------------------------------------

	
//-------------------------------- ზარის განაწილება საათების მიხედვით

	
	
	

			
			$res124 = mysql_query("
					SELECT  HOUR(qs.datetime) AS `datetime`,
					COUNT(*) AS `answer_count`,
					ROUND((( COUNT(*) / (
					SELECT 	COUNT(*) AS `count`
					FROM 	queue_stats AS qs,
					qname AS q,
					qagent AS ag,
					qevent AS ac
					WHERE qs.qname = q.qname_id
					AND qs.qagent = ag.agent_id
					AND qs.qevent = ac.event_id
					AND DATE(qs.datetime) >= '$start_time'
					AND DATE(qs.datetime) <= '$end_time'
					AND q.queue IN ($queue,'NONE')
					AND ac.event IN ('COMPLETECALLER','COMPLETEAGENT')
			)) *100),2) AS `call_answer_pr`,
					ROUND((SUM(qs.info2) / COUNT(*)),0) AS `avg_durat`,
					ROUND((SUM(qs.info1) / COUNT(*)),0) AS `avg_hold`
					FROM 	queue_stats AS qs,
					qname AS q,
					qagent AS ag,
					qevent AS ac
					WHERE qs.qname = q.qname_id
					AND qs.qagent = ag.agent_id
					AND qs.qevent = ac.event_id
					AND DATE(qs.datetime) >= '$start_time'
					AND DATE(qs.datetime) <= '$end_time'
					AND q.queue IN ($queue,'NONE')
					AND ac.event IN ('COMPLETECALLER','COMPLETEAGENT')
					GROUP BY HOUR(qs.datetime)
					");
			
			$res1244 = mysql_query("
					SELECT  HOUR(qs.datetime) AS `datetime`,
					COUNT(*) AS `unanswer_count`,
					ROUND((( COUNT(*) / (
					SELECT 	COUNT(*) AS `count`
					FROM 	queue_stats AS qs,
					qname AS q,
					qagent AS ag,
					qevent AS ac
					WHERE qs.qname = q.qname_id
					AND qs.qagent = ag.agent_id
					AND qs.qevent = ac.event_id
					AND DATE(qs.datetime) >= '$start_time'
					AND DATE(qs.datetime) <= '$end_time'
					AND q.queue IN ($queue,'NONE')
					AND ac.event IN ('ABANDON','EXITWITHTIMEOUT')
			)) *100),2) AS `call_unanswer_pr`
					FROM 	queue_stats AS qs,
					qname AS q,
					qagent AS ag,
					qevent AS ac
					WHERE qs.qname = q.qname_id
					AND qs.qagent = ag.agent_id
					AND qs.qevent = ac.event_id
					AND DATE(qs.datetime) >= '$start_time'
					AND DATE(qs.datetime) <= '$end_time'
					AND q.queue IN ($queue,'NONE')
					AND ac.event IN ('ABANDON','EXITWITHTIMEOUT')
					AND HOUR(qs.datetime) > 9
					GROUP BY HOUR(qs.datetime)
					");
			
		while($row = mysql_fetch_assoc($res124)){
		$roww = mysql_fetch_assoc($res1244);
			$data['page']['call_distribution_per_hour'] .= '
				<tr class="odd">
						<td>'.$row[datetime].':00</td>
						<td>'.(($row[answer_count]!='')?$row[answer_count]:"0").'</td>
						<td>'.(($row[call_answer_pr]!='')?$row[call_answer_pr]:"0").' %</td>
						<td>'.(($roww[unanswer_count]!='')?$roww[unanswer_count]:"0").'</td>
						<td>'.(($roww[call_unanswer_pr]!='')?$roww[call_unanswer_pr]:"0").'%</td>
						<td>'.(($row[avg_durat]!='')?$row[avg_durat]:"0").' წამი</td>
						<td>'.(($row[avg_hold]!='')?$row[avg_hold]:"0").' წამი</td>
						<td></td>
						<td></td>
						</tr>
				';
		}

//-------------------------------------------------


//------------------------------ ზარის განაწილება კვირების მიხედვით


$res12 = mysql_query("
					SELECT  CASE
									WHEN DAYOFWEEK(qs.datetime) = 1 THEN 'კვირა'
									WHEN DAYOFWEEK(qs.datetime) = 2 THEN 'ორშაბათი'
									WHEN DAYOFWEEK(qs.datetime) = 3 THEN 'სამშაბათი'
									WHEN DAYOFWEEK(qs.datetime) = 4 THEN 'ოთხშაბათი'
									WHEN DAYOFWEEK(qs.datetime) = 5 THEN 'ხუთშაბათი'
									WHEN DAYOFWEEK(qs.datetime) = 6 THEN 'პარასკევი'
									WHEN DAYOFWEEK(qs.datetime) = 7 THEN 'შაბათი'
							END AS `datetime`,
							COUNT(*) AS `answer_count`,
							ROUND((( COUNT(*) / (
								SELECT COUNT(*) AS `count`
								FROM 	queue_stats AS qs,
											qname AS q, 
											qagent AS ag,
											qevent AS ac 
								WHERE qs.qname = q.qname_id
								AND qs.qagent = ag.agent_id 
								AND qs.qevent = ac.event_id
								AND DATE(qs.datetime) >= '$start_time'
								AND DATE(qs.datetime) <= '$end_time'
								AND q.queue IN ($queue,'NONE')
								AND ac.event IN ('COMPLETECALLER','COMPLETEAGENT')
							)) *100),2) AS `call_answer_pr`,
							ROUND((SUM(qs.info2) / COUNT(*)),0) AS `avg_durat`,
							ROUND((SUM(qs.info1) / COUNT(*)),0) AS `avg_hold`
					FROM 	queue_stats AS qs,
								qname AS q, 
								qagent AS ag,
								qevent AS ac 
					WHERE qs.qname = q.qname_id
					AND qs.qagent = ag.agent_id 
					AND qs.qevent = ac.event_id
					AND DATE(qs.datetime) >= '$start_time'
					AND DATE(qs.datetime) <= '$end_time'
					AND q.queue IN ($queue,'NONE')
					AND ac.event IN ('COMPLETECALLER','COMPLETEAGENT')
					GROUP BY DAYOFWEEK(qs.datetime)
					");

$res122 = mysql_query("
					SELECT 
							COUNT(*) AS `unanswer_count`,
							ROUND((( COUNT(*) / (
								SELECT COUNT(*) AS `count`
								FROM 	queue_stats AS qs,
											qname AS q,
											qagent AS ag,
											qevent AS ac
								WHERE qs.qname = q.qname_id
								AND qs.qagent = ag.agent_id
								AND qs.qevent = ac.event_id
								AND DATE(qs.datetime) >= '$start_time'
								AND DATE(qs.datetime) <= '$end_time'
								AND q.queue IN ($queue,'NONE')
								AND ac.event IN ('ABANDON','EXITWITHTIMEOUT')
							)) *100),2) AS `call_unanswer_pr`
					FROM 	queue_stats AS qs,
								qname AS q,
								qagent AS ag,
								qevent AS ac
					WHERE qs.qname = q.qname_id
					AND qs.qagent = ag.agent_id
					AND qs.qevent = ac.event_id
					AND DATE(qs.datetime) >= '$start_time'
					AND DATE(qs.datetime) <= '$end_time'
					AND q.queue IN ($queue,'NONE')
					AND ac.event IN ('ABANDON','EXITWITHTIMEOUT')
					GROUP BY DAYOFWEEK(qs.datetime)
					");

	while($row = mysql_fetch_assoc($res12)){
	$roww = mysql_fetch_assoc($res122);
	$data['page']['call_distribution_per_day_of_week'] .= '

                   	<tr class="odd">
					<td>'.$row[datetime].'</td>
					<td>'.(($row[answer_count]!='')?$row[answer_count]:"0").'</td>
					<td>'.(($row[call_answer_pr]!='')?$row[call_answer_pr]:"0").' %</td>
					<td>'.(($roww[unanswer_count]!='')?$roww[unanswer_count]:"0").'</td>
					<td>'.(($roww[call_unanswer_pr]!='')?$roww[call_unanswer_pr]:"0").'%</td>
					<td>'.(($row[avg_durat]!='')?$row[avg_durat]:"0").' წამი</td>
					<td>'.(($row[avg_hold]!='')?$row[avg_hold]:"0").' წამი</td>
					<td></td>
					<td></td>
					</tr>
						';

}

//---------------------------------------------------
}

echo json_encode($data);

?>