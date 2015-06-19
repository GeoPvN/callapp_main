<?php
include('../../includes/classes/core.php');
$start  	= $_REQUEST['start'];
$end    	= $_REQUEST['end'];
$count 		= $_REQUEST["count"];
$action 	= $_REQUEST['act'];
$task 		= $_REQUEST['task'];
$type       = $_REQUEST['type'];
$scenar   = $_REQUEST['scenar'];
$s_category = $_REQUEST['sub_category'];
$done 		= $_REQUEST['done']%3;
$name 		= $_REQUEST['name'];
$user 		= $_REQUEST['user'];
$title 		= $_REQUEST['title'];
$text[0] 	= "გამავალი   ზარები დავალებების მიხედვით";
$text[1] 	= "'$task'- სცენარის  მიხედვით";
$text[2] 	= "'$scenar'-'$task' მიხედვით";
//$text[3] 	= "'$departament'- შემოსული  ქვე–კატეგორიის მიხედვით";
$c="3 or incomming_call.call_type_id=0";
if ($type=="ინფორმაცია")  $c=1;
elseif ($type=="პრეტენზია") $c=2;
//------------------------------------------------query-------------------------------------------
$user_ch = '';
if($user == 0){
   $user_ch = "";
}else{
   $user_ch = "AND task_detail.responsible_user_id = $user";
}

switch ($done){
	case  1:
	    $type_checker = '';
	    $user_r		= $_SESSION['USERID'];
	    if($user_r == 16){
	        $type_checker = "AND task.task_type_id = 4";
	    }
		$result = mysql_query("	SELECT 	shabloni.`name`,
										COUNT(*),
							 			CONCAT(ROUND(COUNT(*)/(
													SELECT
																COUNT(*)
													 FROM 		task
													 JOIN 		task_type ON task.task_type_id=task_type.id
												     JOIN 		task_detail ON task.id=task_detail.task_id
													 JOIN       shabloni ON task.template_id = shabloni.id
													 JOIN		task_scenar ON task_detail.id = task_scenar.task_detail_id
		                                             JOIN       phone ON task_detail.phone_base_id = phone.id
													 WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND task_type.`name`='$task' AND task_detail.`status` in(2,3) $type_checker $user_ch
														)*100,2),'%')
							FROM 		task
							JOIN 		task_type ON task.task_type_id=task_type.id
							JOIN 		task_detail ON task.id=task_detail.task_id
							JOIN 		shabloni ON task.template_id = shabloni.id
		                    JOIN        phone ON task_detail.phone_base_id = phone.id
							JOIN		task_scenar ON task_detail.id = task_scenar.task_detail_id
							 WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND task_type.`name`='$task' AND task_detail.`status` in(2,3) $type_checker $user_ch
						GROUP BY shabloni.`name`
								");
		$text[0]=$text[1];
	break;
	case 2:
	    if($task == 'სატელეფონო გაყიდვები'){
		$result = mysql_query("SELECT
										CASE  	task_scenar.`result_quest`
												WHEN 1 THEN 'დადებითი'
												WHEN 2 THEN 'უარყოფითი'
												WHEN 3 THEN 'მოიფიქრებს'
												ELSE 'არაა დაფიქსირებული'
												END,
										COUNT(*),
										CONCAT(ROUND(COUNT(*)/(
													SELECT COUNT(*) FROM 		task
													JOIN 	task_type ON task.task_type_id=task_type.id
													JOIN 	task_detail ON task.id=task_detail.task_id
													JOIN	task_scenar ON task_scenar.task_detail_id=task_detail.id
													JOIN 	shabloni ON task.template_id = shabloni.id
		    	                                    JOIN    phone ON task_detail.phone_base_id = phone.id
											  		WHERE 	DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
																task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) $user_ch
														)*100,2),'%')
								FROM 		task
								JOIN 		task_type ON task.task_type_id=task_type.id
								JOIN 		task_detail ON task.id=task_detail.task_id
								JOIN		task_scenar ON task_scenar.task_detail_id=task_detail.id
								JOIN 		shabloni ON task.template_id = shabloni.id
		    	                JOIN        phone ON task_detail.phone_base_id = phone.id
							   	WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
								 				task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) $user_ch
								GROUP BY task_scenar.`result_quest`");
	    }
	    if($task == 'სხვა სცენარი') {
	        $result = mysql_query("SELECT
	                                          CASE  	task_scenar.`result_quest1`
												WHEN 1 THEN 'დიახ'
												WHEN 2 THEN 'არა'
	                                            WHEN 3 THEN 'სხვა'
												ELSE 'არაა დაფიქსირებული'
												END,
                                COUNT(*),
                                CONCAT(ROUND(COUNT(*)/(
                                SELECT COUNT(*) FROM 		task
                                JOIN 	task_type ON task.task_type_id=task_type.id
                                JOIN 	task_detail ON task.id=task_detail.task_id
                                JOIN	task_scenar ON task_scenar.task_detail_id=task_detail.id
                                JOIN 	shabloni ON task.template_id = shabloni.id
	            	            JOIN    phone ON task_detail.phone_base_id = phone.id
                                WHERE 	DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
                                task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) $user_ch
                            )*100,2),'%')
                                FROM 		task
                                JOIN 		task_type ON task.task_type_id=task_type.id
                                JOIN 		task_detail ON task.id=task_detail.task_id
                                JOIN		task_scenar ON task_scenar.task_detail_id=task_detail.id
                                JOIN 		shabloni ON task.template_id = shabloni.id
	                            JOIN        phone ON task_detail.phone_base_id = phone.id
                                WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
                                task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) $user_ch
                                GROUP BY task_scenar.`result_quest1`");
	    }
	    if($task == 'სატელეფონო კვლევა'){
	        $result = mysql_query("SELECT
	                                          CASE  	task_scenar.`b2`
												WHEN 1 THEN 'კმაყოფილი'
												WHEN 2 THEN 'მეტ-ნაკლებად კმაყოფილი'
												WHEN 3 THEN 'უკმაყოფილო'
												ELSE 'არაა დაფიქსირებული'
												END,
                                COUNT(*),
                                CONCAT(ROUND(COUNT(*)/(
                                SELECT COUNT(*) FROM 		task
                                JOIN 	task_type ON task.task_type_id=task_type.id
                                JOIN 	task_detail ON task.id=task_detail.task_id
                                JOIN	task_scenar ON task_scenar.task_detail_id=task_detail.id
                                JOIN 	shabloni ON task.template_id = shabloni.id
	                            JOIN    phone ON task_detail.phone_base_id = phone.id
                                WHERE 	DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
                                task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) $user_ch
                            )*100,2),'%')
                                FROM 		task
                                JOIN 		task_type ON task.task_type_id=task_type.id
                                JOIN 		task_detail ON task.id=task_detail.task_id
                                JOIN		task_scenar ON task_scenar.task_detail_id=task_detail.id
                                JOIN 		shabloni ON task.template_id = shabloni.id
	                            JOIN    phone ON task_detail.phone_base_id = phone.id
                                WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
                                task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) $user_ch
                                GROUP BY task_scenar.`b2`");
	    }
		$text[0]=$text[2];
	break;
	default:
	    $type_checker = '';
	    $user_r		= $_SESSION['USERID'];
	    if($user_r == 16){
	        $type_checker = "AND task.task_type_id = 4";
	    }
	    if($user_r == 26){
	        $type_checker = "AND task.task_type_id = 1";
	    }
		$result = mysql_query("SELECT 	task_type.`name`,
								COUNT(*),
								CONCAT(ROUND(COUNT(*)/(
										SELECT COUNT(*) FROM 		task
										JOIN 		task_type ON task.task_type_id=task_type.id
										JOIN 		task_detail ON task.id=task_detail.task_id
										JOIN		task_scenar ON task_detail.id = task_scenar.task_detail_id
		                                JOIN        phone ON task_detail.phone_base_id = phone.id
										WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND task_detail.`status` in(2,3) $type_checker $user_ch
										)*100,2),'%')
								FROM 		task
								JOIN 		task_type ON task.task_type_id=task_type.id
								JOIN 		task_detail ON task.id=task_detail.task_id
								JOIN		task_scenar ON task_detail.id = task_scenar.task_detail_id
		                        JOIN        phone ON task_detail.phone_base_id = phone.id
							 	WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND task_detail.`status` in(2,3) $type_checker $user_ch
								GROUP BY task_type.`name`");

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
	      if ($s_category == 'არაა დაფიქსირებული')
	      {
	          $s_category = 0;
	      }
	      elseif ($s_category == 'დადებითი')
	      {
	          $s_category = 1;
	      }
	      elseif ($s_category == 'უარყოფითი')
	      {
	          $s_category = 2;
	      }
	      elseif ($s_category == 'მოიფიქრებს')
	      {
	          $s_category = 3;
	      }
	      elseif ($s_category == 'კმაყოფილი')
	      {
	          $s_category = 1;
	      }
	      elseif ($s_category == 'მეტ-ნაკლებად კმაყოფილი')
	      {
	          $s_category = 2;
	      }
	      elseif ($s_category == 'უკმაყოფილო')
	      {
	          $s_category = 3;
	      }
	      elseif ($s_category == 'დიახ')
	      {
	          $s_category = 1;
	      }
	      elseif ($s_category == 'არა')
	      {
	          $s_category = 2;
	      }elseif ($s_category == 'სხვა')
	      {
	          $s_category = 3;
	      }
	      
		 $result = mysql_query("SELECT 	task_detail.id,
	                                    `task_scenar`.`date`,
										task_type.`name`,
										shabloni.`name`,
										IF(task_detail.phone_base_inc_id != '', incomming_call.first_name, phone.first_last_name),
										persons.`name`,
										priority.`name`,
										IF(task_detail.phone_base_inc_id != '', '', phone.note),
		                                task_detail.call_content
								FROM 	`task`
								JOIN	task_detail ON task.id = task_detail.task_id
								JOIN	task_type ON task.task_type_id = task_type.id
	    						JOIN    shabloni ON task.template_id = shabloni.id
								LEFT JOIN incomming_call ON task_detail.phone_base_inc_id = incomming_call.id
								JOIN    phone ON task_detail.phone_base_id = phone.id
	    						JOIN    priority ON task.priority_id = priority.id
	                            JOIN	users ON task_detail.responsible_user_id = users.id
								JOIN	persons ON users.person_id = persons.id 
	                            JOIN	task_scenar ON task_detail.id = task_scenar.task_detail_id 
	    						WHERE DATE(`task_scenar`.`date`) >= '$start' AND DATE(`task_scenar`.`date`) <= '$end' AND
                                task_type.`name`='$task' AND shabloni.`name`='$scenar' AND task_detail.`status` in(2,3) AND 
		        IF(task_type.`name` = 'სატელეფონო კვლევა', task_scenar.`b2` = '$s_category',IF(task_type.`name` = 'სატელეფონო გაყიდვები',task_scenar.`result_quest` = '$s_category', IF(task_type.`name` = 'სხვა სცენარი',task_scenar.`result_quest1` = '$s_category',''))) $user_ch
	                            ORDER BY task.priority_id ASC");
		    $data = array("aaData"	=> array());
		    while ( $aRow = mysql_fetch_array( $result ) )
		    {	$row = array();
		    $data['aaData'][] =$aRow;
		    }
		    echo json_encode($data); return 0;
		break;
	default :
		echo "Action Is Null!";
		break;

}



?>