<?php

require_once('../../includes/classes/core.php');


$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';
$start    = $_REQUEST['start'];
$ext      = $_REQUEST['ext'];

switch ($action) {
	case 'get_list' :
		$count    = $_REQUEST['count'];
		$hidden   = $_REQUEST['hidden'];
		
	  	$rResult = mysql_query("SELECT  calldate,
                                DATE(calldate) AS `call_date`,
                                count(calldate) AS `total_call`,
                                (SELECT COUNT(cdr_answer.calldate)
                                FROM `cdr` AS cdr_answer
                                WHERE DATE(cdr_answer.calldate) = '$start' AND SUBSTR(cdr_answer.userfield,7, 3) = 'OUT' AND cdr_answer.billsec > 0 AND cdr_answer.src = cdr.src) AS `answer_call`,
                                (SELECT SEC_TO_TIME(SUM(cdr_answer.duration))
                                FROM `cdr` AS cdr_answer
                                WHERE DATE(cdr_answer.calldate) = '$start' AND SUBSTR(cdr_answer.userfield,7, 3) = 'OUT' AND cdr_answer.billsec > 0 AND cdr_answer.src = cdr.src) AS `answer_billsec`,
                                (SELECT COUNT(cdr_answer.calldate)
                                FROM `cdr` AS cdr_answer
                                WHERE DATE(cdr_answer.calldate) = '$start' AND SUBSTR(cdr_answer.userfield,7, 3) = 'OUT' AND cdr_answer.billsec = 0 AND cdr_answer.src = cdr.src) AS `unanswer_call`,
                                (SELECT SEC_TO_TIME(SUM(cdr_answer.duration))
                                FROM `cdr` AS cdr_answer
                                WHERE DATE(cdr_answer.calldate) = '$start' AND SUBSTR(cdr_answer.userfield,7, 3) = 'OUT' AND cdr_answer.billsec = 0 AND cdr_answer.src = cdr.src) AS `unanswer_billsec`,
                                (SELECT COUNT(task_scenar.id)
                                FROM `task_scenar`
                                JOIN users ON task_scenar.user_id = users.id
                                WHERE DATE(date) = '$start' AND result_quest = 1 AND users.ext = cdr.src) AS `dadebit`,
                                (SELECT COUNT(task_scenar.id)
                                FROM `task_scenar`
                                JOIN users ON task_scenar.user_id = users.id
                                WHERE DATE(date) = '$start' AND result_quest = 2 AND users.ext = cdr.src) AS `uaryofiti`,
                                (SELECT COUNT(task_scenar.id)
                                FROM `task_scenar`
                                JOIN users ON task_scenar.user_id = users.id
                                WHERE DATE(date) = '$start' AND result_quest = 3 AND users.ext = cdr.src) AS `moifiqrebs`
                                FROM `cdr`
                                WHERE DATE(calldate) = '$start' AND SUBSTR(userfield,7, 3) = 'OUT' AND billsec >= 0 AND src = $ext
                                GROUP BY src");
	  
		$data = array(
				"aaData"	=> array()
		);

		while ( $aRow = mysql_fetch_array( $rResult ) )
		{
			$row = array();
			for ( $i = 0 ; $i < $count ; $i++ )
			{
				/* General output */
			    if ($i == 7){
			        $row[] = "<div onclick=\"opendialog('$ext',1)\">$aRow[$i]</div>";
			    }elseif ($i == 8){
			        $row[] = "<div onclick=\"opendialog('$ext',2)\">$aRow[$i]</div>";
			    }elseif ($i == 9){
			        $row[] = "<div onclick=\"opendialog('$ext',3)\">$aRow[$i]</div>";
			    }else{
			        $row[] = $aRow[$i];
			    }
				
			}
			$data['aaData'][] = $row;
		}

		break;
	case 'get_out_call' :
	    $count    = $_REQUEST['count'];
	    $hidden   = $_REQUEST['hidden'];
	    
	    $rResult = mysql_query("SELECT 	task_detail.id,
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
	    						WHERE DATE(`task_scenar`.`date`) = '$start' AND users.ext = $ext AND task_scenar.result_quest = $_REQUEST[result_quest]
	                            ORDER BY task.priority_id ASC");
	         
	    $data = array("aaData"	=> array());
	    
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
	case 'get_page':
	    $page		= getpage();
	    
	    $data		= array('page'	=> $page);
	    break;
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

function getpage(){
    $data = '<div id="dialog-form">
            <table class="display" id="example1">
                <thead>
        			<tr id="datatable_header">
                        <th>ID</th>
        				<th style="width:19%;">დარეკვის თარიღი</th>
        				<th style="width:19%;">დავალების ტიპი</th>
        				<th style="width:19%;">სცენარი</th>
        				<th style="width:19%;">დასახელება</th>
        				<th style="width:19%;">პასუხისმგებელი პირი</th>
        				<th style="width:19%;">პრიორიტეტი</th>
        				<th style="width:19%;">შენიშვნა</th>
        				<th style="width:30%;">ზარის დაზუსტება</th>
        			</tr>
        		</thead>
        		<thead>
        			<tr class="search_header">
        				<th class="colum_hidden">
                			<input type="text" name="search_id" value="" class="search_init" style="width: 10px"/>
                		</th>
        				<th>
        					<input style="width:85px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:85px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_op_date" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				<th>
        					<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
        				</th>
        				
        			</tr>
        		</thead>
            </table>
        </div>
            ';
    return $data;
}

?>