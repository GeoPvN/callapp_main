<?php
// MySQL Connect Link
require_once('../../../includes/classes/core.php');
 
// Main Strings
$action                     = $_REQUEST['act'];
$error                      = '';
$data                       = '';
$user_id	                = $_SESSION['USERID'];
$open_number                = $_REQUEST['open_number'];
$queue                      = $_REQUEST['queue'];
$scenario_id                = $_REQUEST['scenario_id'];
$status                     = $_REQUEST['status'];
$outgoing_status            = $_REQUEST['outgoing_status'];
 
// Incomming Call Dialog Strings
$hidden_id                  = $_REQUEST['id'];
$incomming_id               = $_REQUEST['incomming_id'];
$incomming_date             = $_REQUEST['incomming_date'];
$incomming_date_up          = $_REQUEST['incomming_date_up'];
$call_comment               = mysql_real_escape_string($_REQUEST['call_comment']);


$client_status              = mysql_real_escape_string($_REQUEST['client_status']);
$client_person_number       = mysql_real_escape_string($_REQUEST['client_person_number']);
$client_person_lname        = mysql_real_escape_string($_REQUEST['client_person_lname']);
$client_person_fname        = mysql_real_escape_string($_REQUEST['client_person_fname']);
$client_person_phone1       = mysql_real_escape_string($_REQUEST['client_person_phone1']);
$client_person_phone2       = mysql_real_escape_string($_REQUEST['client_person_phone2']);
$client_person_mail1        = mysql_real_escape_string($_REQUEST['client_person_mail1']);
$client_person_mail2        = mysql_real_escape_string($_REQUEST['client_person_mail2']);
$client_person_addres1      = mysql_real_escape_string($_REQUEST['client_person_addres1']);
$client_person_addres2      = mysql_real_escape_string($_REQUEST['client_person_addres2']);
$client_person_note         = mysql_real_escape_string($_REQUEST['client_person_note']);

$client_number              = mysql_real_escape_string($_REQUEST['client_number']);
$client_name                = mysql_real_escape_string($_REQUEST['client_name']);
$client_phone1              = mysql_real_escape_string($_REQUEST['client_phone1']);
$client_phone2              = mysql_real_escape_string($_REQUEST['client_phone2']);
$client_mail1               = mysql_real_escape_string($_REQUEST['client_mail1']);
$client_mail2               = mysql_real_escape_string($_REQUEST['client_mail2']);
$client_note                = mysql_real_escape_string($_REQUEST['client_note']);

$task_type_id			= $_REQUEST['task_type_id'];
$task_start_date		= $_REQUEST['task_start_date'];
$task_end_date			= $_REQUEST['task_end_date'];
$task_departament_id	= $_REQUEST['task_departament_id'];
$task_recipient_id		= $_REQUEST['task_recipient_id'];
$task_priority_id		= $_REQUEST['task_priority_id'];
$task_controler_id		= $_REQUEST['task_controler_id'];
$task_status_id		    = $_REQUEST['task_status_id'];
$task_description		= mysql_real_escape_string($_REQUEST['task_description']);
$task_note			    = mysql_real_escape_string($_REQUEST['task_note']);

$type_id = $_REQUEST['type_id'];

switch ($action) {
	case 'get_add_page':
		$page		= GetPage('','');
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(Getincomming($hidden_id));
		$data		= array('page'	=> $page);

		break;
    case 'ststus':
        $page 		= getStatus($type_id,$user_id);
        $user 		= getUser($user_id);
        $sub        = getSubStatusOut(2,'');
        $data		= array('page'	=> $page,
                            'user'  => $user,
                            'sub'   => $sub);
    
        break;
    case 'getsubstatus':
        $page 		= getSubStatusOut($_REQUEST[task_status_id],'');
        $data		= array('page'	=> $page);
        break;
	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
		$operator = $_REQUEST['operator'];
		$gr = $_SESSION['USERGR'];
		if($operator == 0 || $operator == '' || $gr == 1){
		    $operator_fillter = '';
		}else{
		    $operator_fillter = "AND outgoing_campaign_detail.responsible_person_id = $operator";
		}
		$sub_status = $_REQUEST[sub_status];
		if($sub_status != 0){
		    $sub_s = " AND  outgoing_campaign_detail.`sub_status` = $sub_status";
		}
		
		if($status != 1){
// 	  	$rResult = mysql_query("SELECT  outgoing_campaign_detail.`id`,
//                                         outgoing_campaign_detail.`id`,
//                                         outgoing_campaign_detail.update_date,
//                                         phone_base_detail.`note`,
// 	  	                                phone_base_detail.phone1,
// 	  	                                phone_base_detail.info1,
//                                         phone_base_detail.`client_name`,
//                                         CONCAT(outgoing_campaign_detail_contact.fname,' ',outgoing_campaign_detail_contact.lname),
//                                         outgoing_campaign_detail_contact.`person_position`,
//                                         outgoing_campaign_detail.`call_res`,
//                                         outgoing_campaign_detail.call_comment,
//                                         CONCAT('<p style=\"padding: 3px 0;\" onclick=\"play(\'',DATE_FORMAT(asterisk_outgoing.call_datetime,'%Y/%m/%d/'),asterisk_outgoing.file_name,'\')\">მოსმენა</p>') AS `file`
//                                 FROM `outgoing_campaign`
//                                 JOIN outgoing_campaign_detail ON outgoing_campaign.id = outgoing_campaign_detail.outgoing_campaign_id
//                                 LEFT JOIN outgoing_campaign_detail_contact ON outgoing_campaign_detail.id = outgoing_campaign_detail_contact.outgoing_campaign_detail_id AND outgoing_campaign_detail_contact.person_gmpiri = 1
//                                 JOIN phone_base_detail ON outgoing_campaign_detail.phone_base_detail_id = phone_base_detail.id
//                                 LEFT JOIN asterisk_outgoing ON phone_base_detail.phone1 = asterisk_outgoing.phone
//                                 WHERE outgoing_campaign_detail.actived = 1 AND  outgoing_campaign_detail.`status` = $status $operator_fillter");
	  	
	  	// DB table to use
	  	$table = 'outgoing_campaign';
	  	
	  	// Table's primary key
	  	$primaryKey = '`outgoing_campaign_detail`.`id`';
	  	
	  	// Array of database columns which should be read and sent back to DataTables.
	  	// The `db` parameter represents the column name in the database, while the `dt`
	  	// parameter represents the DataTables column identifier. In this case simple
	  	// indexes
	  	$fff = 'concat("<p class=playthis clickvalue=",date_format(cast(`asterisk_outgoing`.`call_datetime` AS date),"%Y/%m/%d/"),`asterisk_outgoing`.`file_name`,">მოსმენა</p>") AS `file`';
	  	$columns = array(
	  	    array( 'db' => 'outgoing_campaign_detail.`id`', 		        'dt' => 0 ),
	  	    array( 'db' => 'outgoing_campaign_detail.`id`', 		        'dt' => 1 ),
	  	    array( 'db' => 'outgoing_campaign_detail.update_date',  		'dt' => 2 ),
	  	    array( 'db' => 'phone_base_detail.`note`',  			        'dt' => 3 ),
	  	    array( 'db' => 'phone_base_detail.phone1',  	                'dt' => 4 ),
	  	    array( 'db' => 'phone_base_detail.info1',                       'dt' => 5 ),
	  	    array( 'db' => 'phone_base_detail.`client_name`',     		    'dt' => 6 ),
	  	    array( 'db' => 'CONCAT(outgoing_campaign_detail_contact.fname," ",outgoing_campaign_detail_contact.lname)',	            'dt' => 7 ),
	  	    array( 'db' => 'outgoing_campaign_detail_contact.`person_position`',		        'dt' => 8 ),
	  	    array( 'db' => 'outgoing_campaign_detail.call_res',	        'dt' => 9 ),
	  	    array( 'db' => 'outgoing_campaign_detail.call_comment',	    'dt' => 10 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_ivr=1,"კი",IF(outgoing_campaign_detail.sc_ivr=2,"არა",""))',	        'dt' => 11 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_phone=1,"კი",IF(outgoing_campaign_detail.sc_phone=2,"არა",""))',	        'dt' => 12 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_mail=1,"კი",IF(outgoing_campaign_detail.sc_mail=2,"არა",""))',	        'dt' => 13 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_chat=1,"კი",IF(outgoing_campaign_detail.sc_chat=2,"არა",""))',	        'dt' => 14 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_social=1,"კი",IF(outgoing_campaign_detail.sc_social=2,"არა",""))',	    'dt' => 15 ),
	  	    array( 'db' => 'outgoing_campaign_detail.sc_other',	        'dt' => 16 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_callcenter=1,"კი",IF(outgoing_campaign_detail.sc_callcenter=2,"არა",""))',	'dt' => 17 ),
	  	    array( 'db' => 'outgoing_campaign_detail.sc_printer',	'dt' => 18 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_laser=1,"კი","")',	'dt' => 19 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_inkjet=1,"კი","")',	'dt' => 20 ),
	  	    array( 'db' => 'outgoing_campaign_detail.sc_other_print',	'dt' => 21 ),
	  	    array( 'db' => 'outgoing_campaign_detail.sc_cartrij',	'dt' => 22 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_charging=1,"თვითონ ტენიან",IF(outgoing_campaign_detail.sc_charging=2,"სხვა უტენის",""))',	'dt' => 23 ),
	  	    array( 'db' => 'outgoing_campaign_detail.sc_who_charging',	'dt' => 24 ),
	  	    array( 'db' => 'IF(outgoing_campaign_detail.sc_buying_new=1,"კი","")',	'dt' => 25 ),
	  	    array( 'db' => 'outgoing_campaign_detail.sc_provided',	'dt' => 26 ),
	  	    array( 'db' => 'user_info.`name`',	'dt' => 27 ),
	  	    array( 'db' => 'outgoing_campaign_detail.`id`',	    'dt' => 28 ),
	  	    array( 'db' => 'outgoing_campaign_detail.`id`',	    'dt' => 29 )
	  	
	  	);
	  	
	  	// SQL server connection information
	  	$sql_details = array(
	  	    'user' => 'root',
	  	    'pass' => 'Gl-1114',
	  	    'db'   => 'callapp_1_0',
	  	    'host' => 'localhost'
	  	);
	  	
	  	
	  	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	  	 * If you just want to use the basic configuration for DataTables with PHP
	  	 * server-side, there is no need to edit below this line.
	  	*/
	  	//mysql_close();
	  	require( '../../../includes/ssp.class.php' );
	  	
	  	$where_param = "JOIN outgoing_campaign_detail ON outgoing_campaign.id = outgoing_campaign_detail.outgoing_campaign_id
	  	                JOIN user_info ON outgoing_campaign_detail.responsible_person_id = user_info.user_id
                        LEFT JOIN outgoing_campaign_detail_contact ON outgoing_campaign_detail.id = outgoing_campaign_detail_contact.outgoing_campaign_detail_id AND outgoing_campaign_detail_contact.person_gmpiri = 1
                        JOIN phone_base_detail ON outgoing_campaign_detail.phone_base_detail_id = phone_base_detail.id
                        
                        WHERE outgoing_campaign_detail.actived = 1 AND  outgoing_campaign_detail.`status` = $status $sub_s $operator_fillter
	  	                GROUP BY outgoing_campaign_detail.id";
	  	//echo($columns);
	  	$data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where_param, "");
		}else{
		    $rResult = mysql_query("SELECT 	project.`id`,
                                		    project.`id`,
                                		    project.`create_date`,
                                		    project.`name`
                                	FROM   `project`
                        		    JOIN outgoing_campaign ON project.id = outgoing_campaign.project_id
                        		    GROUP BY project.id");
		
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
    				if($i == ($count - 1)){
    				    $row[] = '<div class="callapp_checkbox">
                                      <input type="checkbox" id="callapp_checkbox_'.$aRow[$hidden].'" name="check_'.$aRow[$hidden].'" value="'.$aRow[$hidden].'" class="check" />
                                      <label for="callapp_checkbox_'.$aRow[$hidden].'"></label>
                                  </div>';
    				}
    			}
    			$data['aaData'][] = $row;
    		}
	    }
	    break;
    case 'send_sms':
        $page		= GetSmsSendPage();
        $data		= array('page'	=> $page);
    
        break;
    case 'send_mail':
        $page		= GetMailSendPage();
        $data		= array('page'	=> $page);
    
        break;
    case 'get_list_mail':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];

		    $rResult = mysql_query("SELECT id,
                            		        date,
                            		        address,
                            		        `subject`,
                            		        if(`status`=3,'გასაგზავნია',IF(`status`=2,'გაგზავნილია',''))
                    		        FROM `sent_mail`
                    		        WHERE outgoing_id = $_REQUEST[out_id] AND status != 1");
		
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
				if($i == ($count - 1)){
				    $row[] = '<div class="callapp_checkbox">
                                  <input type="checkbox" id="callapp_checkbox_'.$aRow[$hidden].'" name="check_'.$aRow[$hidden].'" value="'.$aRow[$hidden].'" class="check" />
                                  <label for="callapp_checkbox_'.$aRow[$hidden].'"></label>
                              </div>';
				}
			}
			$data['aaData'][] = $row;
		}
	
    
        break;
    case 'save_incomming':
        $checker     = json_decode($_REQUEST[checker]);
        $input       = json_decode($_REQUEST[input]);
        $radio       = json_decode($_REQUEST[radio]);
        $date        = json_decode($_REQUEST[date]);
        $date_time   = json_decode($_REQUEST[date_time]);
        $select_op   = json_decode($_REQUEST[select_op]);

        $inc_id = $incomming_id;
        
        
        mysql_query("DELETE FROM scenario_results
                     WHERE outgoing_campaign_detail_id=$inc_id;");
        foreach ($checker as $key => $value) {
            
            $quest_id = str_replace("checkbox","",$key);            
            $val = substr($value,10);
            $last =  preg_split("/[\s,^]+/",$val);
            foreach($last as $answer){               
                mysql_query("INSERT INTO `scenario_results` 
                            (`user_id`, `outgoing_campaign_detail_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
                            VALUES
                            ('$user_id', '$inc_id', '1', '$quest_id', '$answer', NULL)");
            }
        }
        
        foreach ($radio as $key => $value) {
			    $quest_id = str_replace("radio","",$key);            
                $val = substr($value,10);
                $last =  preg_split("/[\s,^]+/",$val);
			    mysql_query("INSERT INTO `scenario_results` 
                            (`user_id`, `outgoing_campaign_detail_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
                            VALUES
                            ('$user_id', '$inc_id', '1', '$quest_id', '$last[0]', NULL)");
		}
        
		foreach ($input as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
                         (`user_id`, `outgoing_campaign_detail_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
                         VALUES
                         ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
		
		foreach ($date as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
		        (`user_id`, `outgoing_campaign_detail_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
		        VALUES
		        ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
		
		foreach ($date_time as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
		        (`user_id`, `outgoing_campaign_detail_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
		        VALUES
		        ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
		
		foreach ($select_op as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
		        (`user_id`, `outgoing_campaign_detail_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
		        VALUES
		        ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}

		$call_res = mysql_real_escape_string($_REQUEST[call_res]);
		$call_back = mysql_real_escape_string($_REQUEST[call_back]);
		$sc_ivr = mysql_real_escape_string($_REQUEST[sc_ivr]);
		$sc_phone = mysql_real_escape_string($_REQUEST[sc_phone]);
		$sc_mail = mysql_real_escape_string($_REQUEST[sc_mail]);
		$sc_chat = mysql_real_escape_string($_REQUEST[sc_chat]);
		$sc_social = mysql_real_escape_string($_REQUEST[sc_social]);
		$sc_ext = mysql_real_escape_string($_REQUEST[sc_ext]);
		$sc_ipphone = mysql_real_escape_string($_REQUEST[sc_ipphone]);
		$sc_other = mysql_real_escape_string($_REQUEST[sc_other]);
		$sc_callcenter = mysql_real_escape_string($_REQUEST[sc_callcenter]);
		$sc_printer = mysql_real_escape_string($_REQUEST[sc_printer]);
		$sc_laser = mysql_real_escape_string($_REQUEST[sc_laser]);
		$sc_inkjet = mysql_real_escape_string($_REQUEST[sc_inkjet]);
		$sc_other_print = mysql_real_escape_string($_REQUEST[sc_other_print]);
		$sc_cartrij = mysql_real_escape_string($_REQUEST[sc_cartrij]);
		$sc_charging = mysql_real_escape_string($_REQUEST[sc_charging]);
		$sc_who_charging = mysql_real_escape_string($_REQUEST[sc_who_charging]);
		$sc_buying_new = mysql_real_escape_string($_REQUEST[sc_buying_new]);
		$sc_provided = mysql_real_escape_string($_REQUEST[sc_provided]);
		$permeability_id = mysql_real_escape_string($_REQUEST[permeability_id]);
		mysql_query("UPDATE 	`outgoing_campaign_detail` SET
                				`status`='$outgoing_status',
		                        `sub_status`='$_REQUEST[outgoing_sub_status]',
                				`update_date`=NOW(),
                				`call_comment`='$call_comment',
		                        `call_res`='$call_res',
		                        `call_back`='$call_back',
                    		    sc_ivr='$sc_ivr',
                    		    sc_phone='$sc_phone',
                    		    sc_mail='$sc_mail',
                    		    sc_chat='$sc_chat',
                    		    sc_social='$sc_social',
		                        sc_ext='$sc_ext',
		                        sc_ipphone='$sc_ipphone',
                    		    sc_other='$sc_other',
                    		    sc_callcenter='$sc_callcenter',
                    		    sc_printer='$sc_printer',
                        	    sc_laser='$sc_laser',
                        	    sc_inkjet='$sc_inkjet',
                        	    sc_other_print='$sc_other_print',
                        	    sc_cartrij='$sc_cartrij',
                        	    sc_charging='$sc_charging',
                        	    sc_who_charging='$sc_who_charging',
                        	    sc_buying_new='$sc_buying_new',
                        	    sc_provided='$sc_provided',
		                        permeability_id='$permeability_id'
                     WHERE 	    `id`='$incomming_id'");
		
		if($task_type_id > 0){
		    mysql_query("INSERT INTO `task`
            		    (`user_id`, `outgoing_id`, `task_recipient_id`, `task_controler_id`, `task_date`, `task_start_date`, `task_end_date`, `task_departament_id`, `task_type_id`, `task_priority_id`, `task_description`, `task_note`, `task_status_id`)
            		    VALUES
            		    ('$user_id', '$incomming_id', '$task_recipient_id', '$task_controler_id', NOW(), '$task_start_date', '$task_end_date', '$task_departament_id', '$task_type_id', '$task_priority_id', '$task_description', '$task_note', '$task_status_id');");
		}
		
		$client_person_fname = mysql_real_escape_string($_REQUEST[client_person_fname]);
		$client_person_lname = mysql_real_escape_string($_REQUEST[client_person_lname]);
		$client_person_number = mysql_real_escape_string($_REQUEST[client_person_number]);
		$client_person_phone1 = mysql_real_escape_string($_REQUEST[client_person_phone1]);
		$client_person_phone2 = mysql_real_escape_string($_REQUEST[client_person_phone2]);
		$client_person_mail1 = mysql_real_escape_string($_REQUEST[client_person_mail1]);
		$client_person_mail2 = mysql_real_escape_string($_REQUEST[client_person_mail2]);
		$client_person_addres1 = mysql_real_escape_string($_REQUEST[client_person_addres1]);
		$client_person_addres2 = mysql_real_escape_string($_REQUEST[client_person_addres2]);
		$client_number = mysql_real_escape_string($_REQUEST[client_number]);
		$client_name = mysql_real_escape_string($_REQUEST[client_name]);
		$client_person_note = mysql_real_escape_string($_REQUEST[client_person_note]);
		$info1 = mysql_real_escape_string($_REQUEST[info1]);
		
		$base = mysql_fetch_array(mysql_query("SELECT phone_base_detail_id FROM `outgoing_campaign_detail` WHERE id = $incomming_id"));
		mysql_query("UPDATE `phone_base_detail` SET
                            `firstname`='$client_person_fname',
                            `lastname`='$client_person_lname',
                            `pid`='$client_person_number',
                            `phone1`='$client_person_phone1',
                            `phone2`='$client_person_phone2',
                            `mail1`='$client_person_mail1',
                            `mail2`='$client_person_mail2',
                            `address1`='$client_person_addres1',
                            `address2`='$client_person_addres2',
                            `id_code`='$client_number',
                            `client_name`='$client_name',
                            `note`='$client_person_note',
		                    `info1`='$info1'
                     WHERE  `id`='$base[0]';");
        break;
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);


/* ******************************
 *	Request Functions
* ******************************
*/

function getStatusOut($id){

    $req = mysql_query("    SELECT 	`id`,
                                    `name`
                            FROM    `task_status`
                            WHERE   `actived` = 1 AND `type` = 1 AND id != 1");

    $data .= '';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function getSubStatusOut($id,$sub_id){

    $req = mysql_query("    SELECT 	`task_sub_status`.`id`,
                                    `task_sub_status`.`name`
                            FROM    `task_status`
                            JOIN    `task_sub_status` ON task_status.id = task_sub_status.task_status_id AND task_sub_status.`actived` = 1
                            WHERE   `task_status`.`actived` = 1 AND `task_status`.`type` = 1 AND `task_status`.id = $id");

    $data .= '<option value="0" selected="selected"></option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $sub_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function getStatusTask(){

    $req = mysql_query("    SELECT 	`id`,
                                    `name`
                            FROM    `task_status`
                            WHERE   `actived` = 1 AND `type` = 2");

    $data .= '<option value="0">-----</option>';
    while( $res = mysql_fetch_assoc($req)){
        $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
    }

    return $data;
}

function GetPriority(){

    $req = mysql_query("    SELECT 	`id`,
                                    `name`
                            FROM    `priority`
                            WHERE   `actived` = 1");

    $data .= '<option value="0">-----</option>';
    while( $res = mysql_fetch_assoc($req)){
        $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
    }

    return $data;
}

function GetDepartament(){

    $req = mysql_query("    SELECT 	`id`,
                                    `name`
                            FROM    `department`
                            WHERE   `actived` = 1");

    $data .= '<option value="0">-----</option>';
    while( $res = mysql_fetch_assoc($req)){
        $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
    }

    return $data;
}

function GetTaskType(){

    $req = mysql_query("    SELECT 	`id`,
                                    `name`
                            FROM    `task_type`
                            WHERE   `actived` = 1");

    $data .= '<option value="0">-----</option>';
    while( $res = mysql_fetch_assoc($req)){
        $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
    }

    return $data;
}

function getStatus($type,$user_id){
    if((GetUserGroup($user_id) == 1 || GetUserGroup($user_id) == 2) && $type == 1){
        $activation = "";
    }else{
        $activation = " AND id != 1";
    }
    
    
    $req = mysql_query("    SELECT 	`id`,
                    				`type`,
                    				`name`
                            FROM `task_status`
                            WHERE actived = 1 AND type = $type $activation");

    $data .= '';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == 1){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function getUser($user_id){
    if(GetUserGroup($user_id) == 1 || GetUserGroup($user_id) == 2){
        $whoami = "";
        $data .= '<option value="0" selected="selected">ყველა ოპერატორი</option>';
    }else{
        $whoami = " AND `users`.`id` = $user_id";
    }
    
    $req = mysql_query("SELECT 	    `users`.`id`,
                    				`user_info`.`name`
                        FROM 		`users`
                        JOIN 		`user_info` ON `users`.`id` = `user_info`.`user_id`
                        WHERE		`users`.`actived` = 1 $whoami");
    
    while( $res = mysql_fetch_assoc($req)){
        
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        
    }
    
    return $data;
}

function getUsers(){
    $req = mysql_query("SELECT 	    `users`.`id`,
                                    `user_info`.`name`
                        FROM 		`users`
                        JOIN 		`user_info` ON `users`.`id` = `user_info`.`user_id`
                        WHERE		`users`.`actived` = 1");
    
    $data .= '<option value="0">-----</option>';
    while( $res = mysql_fetch_assoc($req)){
        $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
    }

    return $data;
}

function gethandbook($id,$done_id){
    $req = mysql_query("  SELECT `id`,
                            	 `value`
                          FROM   `scenario_handbook_detail`
                          WHERE  `scenario_handbook_id` = $id AND actived = 1");

    $data .= '<option value="0" >----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $done_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['value'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['value'] . '</option>';
        }
    }

    return $data;

}
function getpermeability($id,$done_id){
    $req = mysql_query("SELECT `id`,
                               `name`
                        FROM   `permeability`
                        WHERE  `actived` = 1");

    $data .= '<option value="0" >----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $done_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;

}

function Getincomming($hidden_id)
{
	$res = mysql_fetch_assoc(mysql_query("SELECT 	`outgoing_campaign_detail`.`id`,
	                                                `outgoing_campaign_detail`.`update_date`,
	                                                `outgoing_campaign_detail`.`status`,
	                                                `outgoing_campaign_detail`.`sub_status`,
	                                                `outgoing_campaign_detail`.`call_comment`,
	                                                `outgoing_campaign_detail`.`call_res`,
	                                                `outgoing_campaign_detail`.`call_back`,
                                                    `outgoing_campaign`.`project_id`,
                                                    `outgoing_campaign`.`scenario_id`,
                                                    `outgoing_campaign`.`create_date`,
	                                                sc_ivr,
                                            	    sc_phone,
                                            	    sc_mail,
                                            	    sc_chat,
                                            	    sc_social,
                                            	    sc_other,
                                            	    sc_callcenter,
                                            	    sc_printer,
                                            	    sc_laser,
                                            	    sc_inkjet,
                                            	    sc_other_print,
                                            	    sc_cartrij,
                                            	    sc_charging,
                                            	    sc_who_charging,
                                            	    sc_buying_new,
                                            	    sc_provided,
	                                                permeability_id,
                                                    `phone_base_detail`.`phone1`,
                                                    `phone_base_detail`.`phone2`,
                                                    `phone_base_detail`.`firstname`,
                                                    `phone_base_detail`.`lastname`,
                                                    `phone_base_detail`.`pid`,
                                                    `phone_base_detail`.`address1`,
                                                    `phone_base_detail`.`address2`,
                                                    `phone_base_detail`.`age`,
                                                    `phone_base_detail`.`activities`,
                                                    `phone_base_detail`.`born_date`,
                                                    `phone_base_detail`.`client_name`,
                                                    `phone_base_detail`.`id_code`,
                                                    `phone_base_detail`.`info1`,
                                                    `phone_base_detail`.`info2`,
                                                    `phone_base_detail`.`info3`,
                                                    `phone_base_detail`.`mail1`,
                                                    `phone_base_detail`.`mail2`,
                                                    `phone_base_detail`.`note`,
                                                    `phone_base_detail`.`sex`,
                                                    `user_info`.`name` AS `username`,
	                                                `main_user_info`.`name` AS `main_username`,
                                            	    `project`.`name` AS `project_name`,
                                            	    `scenario`.`name` AS `scenario_name`
                                        FROM 		`outgoing_campaign`
                                        JOIN 		`outgoing_campaign_detail` ON `outgoing_campaign`.`id` = `outgoing_campaign_detail`.`outgoing_campaign_id`
                                        JOIN 		`phone_base_detail` ON outgoing_campaign_detail.phone_base_detail_id = phone_base_detail.id
                                	    JOIN        `scenario` ON `outgoing_campaign`.`scenario_id` = `scenario`.`id`
	                                    JOIN        `project` ON `outgoing_campaign`.`project_id` = `project`.`id`
                                        LEFT JOIN `users` ON `outgoing_campaign_detail`.`responsible_person_id` = `users`.`id`
                                        LEFT JOIN `user_info` ON `users`.`id` = `user_info`.`user_id`
	                                    LEFT JOIN `users` AS main_user ON `outgoing_campaign_detail`.`user_id` = `main_user`.`id`
                                        LEFT JOIN `user_info` AS main_user_info ON `main_user`.`id` = `main_user_info`.`user_id`
                                        WHERE 	`outgoing_campaign`.`actived` = 1 AND `outgoing_campaign_detail`.`id` =  $hidden_id"));
	return $res;
}

function GetPage($res)
{
    if($res['client_name'] == ''){
        $display = 'display:none;';
        $table = '<table class="margin_top_10">
                       <tr>
                           <td '.(($res['pid'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_number">პირადი ნომერი</label></td>
                           <td '.(($res['id_code'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_number">საიდენტ. ნომერი</label></td>
                           <td '.(($res['firstname'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_lname">სახელი</label></td>
                           <td '.(($res['lastname'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_fname">გვარი</label></td>
                       </tr>
                       <tr>
                           <td '.(($res['pid'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_number" type="text" value="'.$res['pid'].'"></td>
                           <td '.(($res['id_code'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_number" type="text" value="'.$res['id_code'].'"></td>
                           <td '.(($res['firstname'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_lname" type="text" value="'.$res['firstname'].'"></td>
                           <td '.(($res['lastname'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_fname" type="text" value="'.$res['lastname'].'"></td>
                        </tr>
                        <tr>
                            <td '.(($res['phone1'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_phone1">ტელეფონი 1</label></td>
    	                    <td '.(($res['phone2'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_phone2">ტელეფონი 2</label></td>
                            <td '.(($res['mail1'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_mail1">ელ-ფოსტა 1</label></td>
    	                    <td '.(($res['mail2'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_mail2">ელ-ფოსტა 2</label></td>
    	                </tr>
	                    <tr>
                            <td '.(($res['phone1'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_phone1" type="text" value="'.$res['phone1'].'"></td>
    	                    <td '.(($res['phone2'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_phone2" type="text" value="'.$res['phone2'].'"></td>
                            <td '.(($res['mail1'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_mail1" type="text" value="'.$res['mail1'].'"></td>
    	                    <td '.(($res['mail2'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_mail2" type="text" value="'.$res['mail2'].'"></td>
    	                </tr>
                        <tr>
                            <td '.(($res['address1'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_addres1">მისამართი 1</label></td>
    	                    <td '.(($res['address2'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_addres2">მისამართი 2</label></td>
                            <td '.(($res['note'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_note">შენიშვნა</label></td>
    	                    <td '.(($res['client_name'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_name">კლიენტის დასახელება</label></td>
    	                </tr>
	                    <tr>
                            <td '.(($res['address1'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_addres1" type="text" value="'.$res['address1'].'"></td>
    	                    <td '.(($res['address2'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_addres2" type="text" value="'.$res['address2'].'"></td>
                            <td '.(($res['note'] == '')?'style="display:none;"':'').'><textarea id="client_person_note" style="resize: vertical;width: 185px;">'.$res['note'].'</textarea></td>
    	                    <td '.(($res['client_name'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_name" type="text" value="'.$res['client_name'].'"></td>
    	                </tr>
	                </table>';
    }else{
        $display = '';
        $table = '<table class="margin_top_10">
            <tr>
            <td><label for="client_name">დასახელება</label></td>
            <td><label for="client_person_note">საქმიანობის სფერო</label></td>
            </tr>
            <tr>
            <td><input style="width: 185px;" id="client_name" type="text" value="'.$res['client_name'].'"></td>
            <td colspan="2"><textarea id="client_person_note" style="resize: vertical;width: 380px;">'.$res['note'].'</textarea></td>
            </tr>
            <tr>
            <td><label for="client_person_phone1">ტელეფონი 1</label></td>
            <td><label for="client_person_phone2">ტელეფონი 2</label></td>
            <td><label for="client_person_mail1">ელ-ფოსტა 1</label></td>
            </tr>
            <tr>
            <td><input style="width: 185px;" id="client_person_phone1" type="text" value="'.$res['phone1'].'"></td>
            <td><input style="width: 185px;" id="client_person_phone2" type="text" value="'.$res['phone2'].'"></td>
            <td><input style="width: 185px;" id="client_person_mail1" type="text" value="'.$res['mail1'].'"></td>
            </tr>
            <tr>
            <td><label for="client_person_mail2">ელ-ფოსტა 2</label></td>
            <td><label for="client_person_addres1">მისამართი 1</label></td>
    	    <td><label for="client_person_addres2">მისამართი 2</label></td>
            </tr>
            <tr>
            <td><input style="width: 185px;" id="client_person_mail2" type="text" value="'.$res['mail2'].'"></td>
            <td><input style="width: 185px;" id="client_person_addres1" type="text" value="'.$res['address1'].'"></td>
            <td><input style="width: 185px;" id="client_person_addres2" type="text" value="'.$res['address2'].'"></td>
            </tr>
            <tr>
            <td colspan="3"><label for="info1">www</label></td>
            </tr>
            <tr>
            <td colspan="3"><input style="width: 572px;" id="info1" type="text" value="'.$res['info1'].'"></td>
            </tr>
                       <tr>
                           <td '.(($res['pid'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_number">პირადი ნომერი</label></td>
                           <td '.(($res['id_code'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_number">საიდენტ. ნომერი</label></td>
                           <td '.(($res['firstname'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_lname">სახელი</label></td>
                           <td '.(($res['lastname'] == '')?'style="display:none;"':'style="width: 290px;"').'><label for="client_person_fname">გვარი</label></td>
                       </tr>
                       <tr>
                           <td '.(($res['pid'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_number" type="text" value="'.$res['pid'].'"></td>
                           <td '.(($res['id_code'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_number" type="text" value="'.$res['id_code'].'"></td>
                           <td '.(($res['firstname'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_lname" type="text" value="'.$res['firstname'].'"></td>
                           <td '.(($res['lastname'] == '')?'style="display:none;"':'').'><input style="width: 185px;" id="client_person_fname" type="text" value="'.$res['lastname'].'"></td>
                        </tr>
	                </table>';
        
    }
	$data  .= '
	<div id="dialog-form">
	    <fieldset style="width: 430px;  float: left;">
	       <legend>ძირითადი ინფორმაცია</legend>
	       <input id="scenario_id" type="hidden" value="'.$res[scenario_id].'" />
	       <table class="dialog-form-table">
	           <tr>
	               <td>დამფორმირებელი :</td>
            	   <td>'.$res['main_username'].'</td>
            	   <td></td>
	           </tr>
    	       <tr>
	               <td style="width: 150px;"><label for="incomming_id">მომართვის №</label></td>
	               <td style="width: 150px;"><label for="incomming_date">შექმნის თარიღი</label></td>
	               <td style="width: 150px;"><label for="incomming_date_up">შევსების თარიღი</label></td>
    	       </tr>
	           <tr>
	               <td><input style="width: 110px;" id="incomming_id" type="text" value="'.$res['id'].'" disabled></td>
	               <td><input style="width: 125px;" id="incomming_date" type="text" value="'.$res['create_date'].'" disabled></td>
	               <td><input style="width: 125px;" id="incomming_date_up" type="text" value="'.(($res['update_date']!='')?$res['update_date']:date('Y-m-d H:i:s')).'" disabled></td>
    	       </tr>
	       </table>
	       <table class="dialog-form-table">	           
    	       <tr>
	               <td style="width: 220px;"><label for="project">პროექტი</label></td>
	               <td style="width: 195px;"><label for="scenario">სცენარი</label></td>
    	       </tr>
	           <tr>
	               <td><input style="width: 185px;" id="project" type="text" value="'.$res['project_name'].'" disabled></td>
	               <td><input style="width: 185px;" id="scenario" type="text" value="'.$res['scenario_name'].'" disabled></td>
	           </tr>
	       </table> 
	       <table class="dialog-form-table">
	           <tr>
	               <td style="width: 250px;"><label for="outgoing_status">შედეგი</label></td>
	               <td><label for="call_back">გადასარეკია უკან</label></td>
    	       </tr>
	           <tr>
	               <td><select id="outgoing_status" style="width: 100%;">'.getStatusOut($res['status']).'</select></td>
	               <td><input style="width: 156px;" id="call_back" type="text" value="'.$res['call_back'].'" ></td>
	           </tr>
	           <tr>
	               <td style="width: 150px;"><label for="outgoing_sub_status">შედეგის მიზეზი</label></td>
	               <td style="width: 150px;"><label for="permeability_id">შეღწევადობა</label></td>
    	       </tr>
	           <tr>
	               <td><select id="outgoing_sub_status" style="width: 100%;">'.getSubStatusOut($res['status'],$res['sub_status']).'</select></td>
	               <td><select id="permeability_id" style="width: 100%;">'.getpermeability($res['permeability_id']).'</select></td>
	           </tr>
    	       <tr>
	               <td colspan="2" style="width: 150px;"><label for="incomming_id">ზარის შესახებ</label></td>
    	       </tr>
	           <tr>
	               <td colspan="2"><textarea style="width: 407px; margin:0;resize:vertical;" id="call_comment" >'.$res['call_comment'].'</textarea></td>
	           </tr>
	           <tr>
	               <td colspan="2" style="width: 150px;"><label for="incomming_id">დარეკვის შედეგი</label></td>
    	       </tr>
	           <tr>
	               <td colspan="2"><textarea style="width: 407px; margin:0;resize:vertical;" id="call_res" >'.$res['call_res'].'</textarea></td>
	           </tr>
	       </table>
	    </fieldset>
	    
        <div id="side_menu" style="float: left;height: 485px;width: 80px;margin-left: 10px; background: #272727; color: #FFF;margin-top: 6px;">
	       <spam class="info" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'info\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/info.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">ინფო</div></spam>
	       <spam class="scenar" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'scenar\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/scenar.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">სცენარი</div></spam>
	       <spam class="task" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'task\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/task.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">დავალება</div></spam>
	       <spam class="sms" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'sms\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/sms.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">SMS</div></spam>
	       <spam class="mail" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'mail\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/mail.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">E-mail</div></spam>
	       <spam class="record" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'record\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/record.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">ჩანაწერი</div></spam>
	       <spam class="file" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'file\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/file.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">ფაილი</div></spam>
	    </div>
	    
	    <div style="width: 619px;float: left;margin-left: 10px;" id="right_side">
            <fieldset style="display:none;" id="info">
                <legend>მომართვის ავტორი</legend>
	            <span class="hide_said_menu">x</span>
                
	    
        	    <div id="pers">
	               '.$table.'
        	    </div>
	                   <fieldset style="display:block;width: 251px;float:left;margin-right: 15px" id="info">
	                   <legend>კომუნიკაცია</legend>
	                   <table>
	                   <tr>
	                   <td>IVR</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_ivr" '.(($res['sc_ivr'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_ivr" '.(($res['sc_ivr'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
	                   <tr>
	                   <td>ტელეფონი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_phone" '.(($res['sc_phone'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_phone" '.(($res['sc_phone'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
	                   <tr>
	                   <td>ელ-ფოსტა</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_mail" '.(($res['sc_mail'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_mail" '.(($res['sc_mail'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
	                   <tr>
	                   <td>ვებ-ჩატი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_chat" '.(($res['sc_chat'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_chat" '.(($res['sc_chat'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
	                   <tr>
	                   <td>სოც.ქსელი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_social" '.(($res['sc_social'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_social" '.(($res['sc_social'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
	                   <tr>
	                   <td>სხვა</td><td colspan=2><input style="width: 96px" type="text" id="sc_other" value="'.$res[sc_other].'"></td>
	                   </tr>
	                   <tr>
	                   <td>ქოლ-ცენტრი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_callcenter" '.(($res['sc_callcenter'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_callcenter" '.(($res['sc_callcenter'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
                       <tr>
	                   <td>IP-ტელეფონი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_ipphone" '.(($res['sc_ipphone'] == 1)?'checked':'').' value="1">კი</td><td><input style="float: left;margin-top: -3px;" type="radio" name="sc_ipphone" '.(($res['sc_ipphone'] == 2)?'checked':'').' value="2">არა</td>
	                   </tr>
	                   <tr>
	                       <td>თანამშრომლების (ექსთ) რ-ბა</td>
                           <td colspan=2><input style="width: 95px;" min="0" type="number" id="sc_ext" value="'.$res[sc_ext].'"></td>
                       </tr>
	                   </table>
	                   </fieldset>
	                   <fieldset style="display:block;width: 287px;" id="info">
	                   <legend>პრინტერები/კარტრიჯები</legend>
	                   <table>
	                   <tr>
	                       <td style="width: 145px;">პრინტერების რ-ბა</td>
	                   </tr>
                       <tr>
                           <td><input style="width: 95px;" min="0" type="number" id="sc_printer" value="'.$res[sc_printer].'"></td>
                       </tr>
                       <tr>
	                       <td><span style="float: left;">ლაზერული</span><input style="float: left;margin-top: -3px;" type="checkbox" id="sc_laser" '.(($res['sc_laser'] == 1)?'checked':'').' value="1"></td>
	                       <td><span style="float: left;">ჭავლური</span><input style="float: left;margin-top: -3px;" type="checkbox" id="sc_inkjet" '.(($res['sc_inkjet'] == 1)?'checked':'').' value="1"></td>
	                   </tr>
                       <tr>
                       <tr>
	                       <td colspan=2>სხვა</td>
	                   </tr>
                       <tr>
                           <td colspan=2><input style="width: 269px;" type="text" id="sc_other_print" value="'.$res[sc_other_print].'"></td>
                       </tr>
                       <tr>
	                       <td>კარტრიჯების რ-ბა/თვე</td>
	                   </tr>
                       <tr>
                           <td><input style="width: 95px;" min="0" type="number" id="sc_cartrij" value="'.$res[sc_cartrij].'"></td>
                       </tr>
	                   <tr>
	                       <td><span style="float: left;">თვითონ ტენიან</span><input style="float: left;margin-top: -3px;" type="radio" name="sc_charging" '.(($res['sc_charging'] == 1)?'checked':'').' value="1"></td>
	                       <td><span style="float: left;">სხვა უტენის</span><input style="float: left;margin-top: -3px;" type="radio" name="sc_charging" '.(($res['sc_charging'] == 2)?'checked':'').' value="2"></td>
	                   </tr>
                       <tr>
	                       <td colspan=2>ვინ უტენის</td>
	                   </tr>
                       <tr>
                           <td colspan=2><input style="width: 269px;" type="text" id="sc_who_charging" value="'.$res[sc_who_charging].'"></td>
                       </tr>
                       
                       <tr>
	                       <td colspan=2><span style="float: left;">ახალს ყიდულობენ</span><input style="float: left;margin-top: -3px;" type="checkbox" id="sc_buying_new" '.(($res['sc_buying_new'] == 1)?'checked':'').' value="1"></td>
	                   </tr>
                       <tr>
	                       <td colspan=2>მომწოდებელი</td>
	                   </tr>
                       <tr>
                           <td colspan=2><input style="width: 269px;" type="text" id="sc_provided" value="'.$res[sc_provided].'"></td>
                       </tr>
                       
	                   </table>
	                   </fieldset>
	            <div style="margin-top: 20px;'.$display.'">
    	           <div id="button_area">
                        <button id="add_contact_info">დამატება</button>
    	                <button id="delete_contact_info">წაშლა</button>
                    </div>
                    <table class="display" id="table_contact_info" >
                        <thead>
                            <tr id="datatable_header">
                                <th>ID</th>
                                <th style="width: 100%;">სახელი გვარი</th>
                                <th style="width: 100%;">თანამდებობა</th>
                                <th style="width: 100%;">ტელეფონი</th>
                                <th style="width: 100%;">ელ-ფოსტა</th>
	                            <th style="width: 100%;">გ.მ. პირი</th>
    	                        <th class="check" style="width: 30px;">&nbsp;</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="search_header">
                                <th class="colum_hidden">
                            	   <input type="text" name="search_id" value="ფილტრი" class="search_init" />
                                </th>
                                <th>
                                	<input type="text" name="search_number" value="ფილტრი" class="search_init" />
                                </th>
                                <th>
                                    <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                                </th>
                                <th>
                                    <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                                </th>
	                            <th>
                                    <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                                </th>
                                <th>
                                    <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                                </th>
    	                        <th style="border-right: 1px solid #E6E6E6 !important;">
                                	<div class="callapp_checkbox">
                                        <input type="checkbox" id="check-all-contact_info" name="check-all-contact_info" />
                                        <label for="check-all-contact_info"></label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
    	        </div>
            </fieldset>
        	                        
        	<fieldset style="display:none;height: 465px;overflow: scroll;overflow-x: hidden;" id="scenar">
                <legend>სცენარი</legend>
	            <span class="hide_said_menu">x</span>';
	$my_scenario = $res[scenario_id];
	 
	 
	$query = mysql_query("SELECT 	`question`.id,
                            	    `question`.`name`,
                            	    `question`.note,
                            	    `scenario`.`name`,
                            	    `scenario_detail`.id AS sc_det_id,
                            	    `scenario_detail`.`sort`
                    	    FROM    `scenario`
                    	    JOIN    scenario_detail ON scenario.id = scenario_detail.scenario_id
                    	    JOIN    question ON scenario_detail.quest_id = question.id
                    	    WHERE   scenario.id = $my_scenario AND scenario_detail.actived = 1
                    	    ORDER BY scenario_detail.sort ASC");
	
	$data .= '
	
		            <button who="0" id="show_all_scenario" style="float: right; margin-top: 15px;">ყველას ჩვენება</button><div class="clear"></div>';
	
	
	if($res[id] == ''){
	    $inc_id = 0;
	    $inc_checker = " AND scenario_results.outgoing_campaign_detail_id = 0";
	}else{
	    $inc_id = $res[id];
	    $inc_checker = " AND scenario_results.outgoing_campaign_detail_id = $res[id]";
	}
	while ($row = mysql_fetch_array($query)) {
	
	    $last_q = mysql_query(" SELECT question_detail.id
                    	        FROM `question_detail`
                    	        JOIN scenario_detail ON scenario_detail.quest_id = question_detail.quest_id
                    	        AND scenario_detail.scenario_id = $my_scenario
                    	        WHERE question_detail.quest_id = $row[0]");
	
	    $data .= '<div style="" class="quest_body '.$row[5].'" id="'.$row[0].'">
		            <table class="dialog-form-table" style="width: 255px !important;table-layout: fixed;">
		    		<tr>
						<td style="font-weight:bold;">'.$row[5].'. '. $row[1] .' <img onclick="imnote(\''.$row[5].'\')" style="border: none;padding: 0;margin-left: 8px;margin-top: -7px;cursor: pointer;" src="media/images/icons/kitxva.png" alt="14 ICON" height="24" width="24"></td>
		                </tr><tr style="display:none;" id="imnote_'. $row[5] .'" ><td>'.$row[2].'</td></tr>
		                    ';
	
	    while ($last_a = mysql_fetch_array($last_q)){
	
	
	         
	        $query1 = mysql_query(" SELECT CASE 	WHEN question_detail.quest_type_id = 1 THEN CONCAT('<tr><td style=\"width:428px; text-align:left;\"><input next_quest=\"',scenario_destination.destination,'\" ',IF(scenario_results.outgoing_campaign_detail_id = $inc_id && question_detail.id = scenario_results.question_detail_id,'checked','') ,' class=\"check_input\" ansver_val=\"',question_detail.answer,'\" style=\"float:left;\" type=\"checkbox\" name=\"checkbox', question_detail.quest_id, '\" id=\"checkbox', question_detail.id, '\" value=\"', question_detail.id, '\"><label for=\"checkbox', question_detail.id, '\" style=\"float:left; padding: 7px;white-space: pre-line;\">', question_detail.answer, '</label></td></tr>')
                                    	            WHEN question_detail.quest_type_id = 2 THEN CONCAT('<tr><td style=\"width:428px; text-align:left;\"><label style=\"float:left; padding: 7px 0;width: 428px;\" for=\"input|', question_detail.quest_id, '|', question_detail.id, '\">',question_detail.answer,'</label><input next_quest=\"',scenario_destination.destination,'\" value=\"',IF(scenario_results.outgoing_campaign_detail_id = $inc_id && question_detail.id = scenario_results.question_detail_id,scenario_results.additional_info,''),'\" class=\"inputtext\"style=\"float:left;\"  type=\"text\" id=\"input|', question_detail.quest_id, '|', question_detail.id, '\" q_id=\"',question_detail.id,'\" /> </td></tr>')
                                    	            WHEN question_detail.quest_type_id = 4 THEN CONCAT('<tr><td style=\"width:428px; text-align:left;\"><input next_quest=\"',scenario_destination.destination,'\" ',IF(scenario_results.outgoing_campaign_detail_id = $inc_id && question_detail.id = scenario_results.question_detail_id,'checked','') ,' class=\"radio_input\" ansver_val=\"',question_detail.answer,'\" style=\"float:left;\" type=\"radio\" name=\"radio', question_detail.quest_id, '\" id=\"radio', question_detail.id, '\" value=\"', question_detail.id, '\"><label for=\"radio', question_detail.id, '\" style=\"float:left; padding: 7px;white-space: pre-line;\">', question_detail.answer, '</label></td></tr>')
                                    	            WHEN question_detail.quest_type_id = 5 THEN CONCAT('<tr><td style=\"width:428px; text-align:left;\"><label style=\"float:left; padding: 7px 0;width: 428px;\" for=\"input|', question_detail.quest_id, '|', question_detail.id, '\">',question_detail.answer,'</label><input next_quest=\"',scenario_destination.destination,'\" value=\"',IF(scenario_results.outgoing_campaign_detail_id = $inc_id && question_detail.id = scenario_results.question_detail_id,scenario_results.additional_info,''),'\" class=\"date_input\"  style=\"float:left;\" type=\"text\" id=\"input|', question_detail.quest_id, '|', question_detail.id, '\" q_id=\"',question_detail.id,'\" /> </td></tr>')
                                    	            WHEN question_detail.quest_type_id = 6 THEN CONCAT('<tr><td style=\"width:428px; text-align:left;\"><label style=\"float:left; padding: 7px 0;width: 428px;\" for=\"input|', question_detail.quest_id, '|', question_detail.id, '\">',question_detail.answer,'</label><input next_quest=\"',scenario_destination.destination,'\" value=\"',IF(scenario_results.outgoing_campaign_detail_id = $inc_id && question_detail.id = scenario_results.question_detail_id,scenario_results.additional_info,''),'\" class=\"date_time_input\"  style=\"float:left;\" type=\"text\" id=\"input|', question_detail.quest_id, '|', question_detail.id, '\" q_id=\"',question_detail.id,'\" /> </td></tr>')
                                    	            WHEN question_detail.quest_type_id = 7 THEN question_detail.answer
                            	            END AS `ans`,
                            	            question_detail.quest_type_id,
                            	            scenario_handbook.`name`,
                            	            scenario_results.additional_info,
                            	            question_detail.quest_id,
                            	            question_detail.id,
                            	            scenario_destination.destination
                    	            FROM question_detail
                    	            LEFT JOIN scenario_results ON question_detail.id = scenario_results.question_detail_id $inc_checker
                    	            LEFT JOIN outgoing_campaign_detail ON outgoing_campaign_detail.id = scenario_results.outgoing_campaign_detail_id
                    	            JOIN scenario_detail ON scenario_detail.scenario_id = $my_scenario AND scenario_detail.actived = 1
                            	    JOIN scenario_destination ON scenario_detail.id = scenario_destination.scenario_detail_id AND scenario_destination.answer_id = $last_a[0]
                    	            LEFT JOIN scenario_handbook ON question_detail.answer = scenario_handbook.id
                    	            WHERE question_detail.id = $last_a[0]
                    	            ");
	
	
	
	        $g =0;
	        while ($row1 = mysql_fetch_array($query1)) {
	            $q_type = $row1[1];
	            if($q_type == 7){
	                $data .= '  <tr>
                                                    <td style="width:428px; text-align:left;">
                                                    <label style="float:left; padding: 7px 0;width: 428px;" for="">'.$row1[2].'</label>
                                                    <select class="hand_select" next_quest="'.$row1[6].'" style="float:left;width: 235px;"  id="hand_select|'.$row1[4].'|'.$row1[5].'" >'.gethandbook($row1[0],$row1[3]).'</select>
                                                    </td>';
	            }else{
	                $data .= $row1[0];
	            }
	        }}
	
	        $data .= '</table>
                    <hr class="myhr"><br></div>';
	
	}
	
	$data .= '
	    
	    <div style="margin-top: 15px; display: none;" class="last_quest">
        	<table class="dialog-form-table">
        		<tr>
        			<td style="font-weight:bold;">
        				არ დაგავიწყდეთ სტატუსის შეცვლა და შენახვის ღილაკზე დაკლიკება!
        			</td>
        		</tr>
        	</table>
        	<hr>
        	<br>
        </div>
	    
	    <button id="back_quest" back_id="0" style="float:left;">უკან</button><button id="next_quest" style="float:right;" next_id="0">წინ</button>
	
    	    </fieldset>
        	                        
            <fieldset style="display:none;" id="task">
                <legend>დავალების ფორმირება</legend>
	            <span class="hide_said_menu">x</span>
	            <table>
	               <tr>
	                   <td><label for="task_type_id">დავალების ტიპი</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><select style="width: 595px;" id="task_type_id">'.GetTaskType().'</select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_start_date">პერიოდი</label></td>
	               </tr>	              
	               <tr>
	                   <td style="width: 350px;"><input style="float: left;" id="task_start_date" type="text" value=""><label for="task_start_date" style="float: left;margin-top: 7px;margin-left: 2px;">-დან</label></td>
	                   <td><input style="float: left;" id="task_end_date" type="text" value=""><label for="task_end_date" style="float: left;margin-top: 7px;margin-left: 2px;">-მდე</label></td>
	               </tr>
	               <tr>
	                   <td><label for="task_departament_id">განყოფილება</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><select style="width: 595px;" id="task_departament_id">'.GetDepartament().'</select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_recipient_id">ადრესატი</label></td>
	                   <td><label for="task_controler_id">მაკონტროლებელი</label></td>
	               </tr>	              
	               <tr>
	                   <td><select style="width: 245px;" id="task_recipient_id">'.getUsers().'</select></td>
	                   <td><select style="width: 245px;" id="task_controler_id">'.getUsers().'</select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_priority_id">პრიორიტეტი</label></td>
	                   <td><label for="task_status_id">სტატუსი</label></td>
	               </tr>	              
	               <tr>
	                   <td><select style="width: 245px;" id="task_priority_id">'.GetPriority().'</select></td>
	                   <td><select style="width: 245px;" id="task_status_id">'.getStatusTask().'</select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_description">აღწერა</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><textarea style="resize: vertical;width: 589px;" id="task_description"></textarea></td>
	               </tr>
	               <tr>
	                   <td><label for="task_note">შენიშვნა</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><textarea style="resize: vertical;width: 589px;" id="task_note"></textarea></td>
	               </tr>
	            </table>
            </fieldset>
            
            <fieldset style="display:none;" id="sms">
                <legend>SMS</legend>
	            <span class="hide_said_menu">x</span>	 
	            <div class="margin_top_10">           
	            <div id="button_area">
                    <button id="add_sms">ახალი SMS</button>
                </div>
                <table class="display" id="table_sms" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">ადრესატი</th>
                            <th style="width: 100%;">ტექსტი</th>
                            <th style="width: 100%;">სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                        	   <input type="text" name="search_id" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                        </tr>
                    </thead>
                </table>
	            </div>
            </fieldset>
            
            <fieldset style="display:none;" id="mail">
                <legend>E-mail</legend>
	            <span class="hide_said_menu">x</span>
	            <div class="margin_top_10">           
	            <div id="button_area">
                    <button id="add_mail">ახალი E-mail</button>
                </div>
                <table class="display" id="table_mail" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">ადრესატი</th>
                            <th style="width: 100%;">გზავნილი</th>
                            <th style="width: 100%;">სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                        	   <input type="text" name="search_id" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                        </tr>
                    </thead>
                </table>
	            </div>
            </fieldset>
            
            <fieldset style="display:none;" id="record">
                <legend>ჩანაწერები</legend>
	            <span class="hide_said_menu">x</span>
	                '.show_record($res).'
            </fieldset>
            
            <fieldset style="display:none;" id="file">
                <legend>ფაილი</legend>
	            <span class="hide_said_menu">x</span>
	                '.show_file($res).'
            </fieldset></div>
	       </fieldset>
	    </div>
	</div><input type="hidden" value="'.$res[id].'" id="hidden_id">';

	return $data;
}

function GetSmsSendPage() {
    $data = '
        <div id="dialog-form">
            <fieldset style="width: 299px;">
					<legend>SMS</legend>
			    	<table class="dialog-form-table">
						<tr>
							<td><label for="d_number">ადრესატი</label></td>
						</tr>
			    		<tr>
							<td>
								<span id="errmsg" style="color: red; display: none;">მხოლოდ რიცხვი</span>
								<input type="text" id="sms_phone"  value="">
							</td>
							<td>
								<button id="copy_phone">Copy</button>
							</td>
							<td>
								<button id="sms_shablon">შაბლონი</button>
							</td>
						</tr>
						<tr>
							<td><label for="content">ტექსტი</label></td>
						</tr>
					
						<tr>
							
							<td colspan="6">	
								<textarea maxlength="150" style="width: 298px; resize: vertical;" id="sms_text" name="call_content" cols="300" rows="4"></textarea>
							</td>
						</tr>
						<tr>
							<td>
								<input style="width: 50px;" type="text" id="simbol_caunt" value="0/150">
							</td>
							<td>
								
							</td>
							
							<td>
								<button id="send_sms">გაგზავნა</button>
							</td>
						</tr>	
					</table>
		        </fieldset>
        </div>';
    return $data;
}

function GetMailSendPage(){
    $data = '
            <div id="dialog-form">
        	    <fieldset style="height: auto;">
        	    	<table class="dialog-form-table">
        				
        				<tr>
        					<td style="width: 90px; "><label for="d_number">ადრესატი:</label></td>
        					<td>
        						<input type="text" style="width: 490px !important;"id="mail_address" value="" />
        					</td>
        				</tr>
        				<tr>
        					<td style="width: 90px;"><label for="d_number">CC:</label></td>
        					<td>
        						<input type="text" style="width: 490px !important;" id="mail_address1" value="" />
        					</td>
        				</tr>
        				<tr>
        					<td style="width: 90px;"><label for="d_number">Bcc:</label></td>
        					<td>
        						<input type="text" style="width: 490px !important;" id="mail_address2" value="" />
        					</td>
        				</tr>
        				<tr>
        					<td style="width: 90px;"><label for="d_number">სათაური:</label></td>
        					<td>
        						<input type="text" style="width: 490px !important;" id="mail_text" value="" />
        					</td>
        				</tr>
        			</table>
        			<table class="dialog-form-table">
        				<tr>
        					<td>	
        						<textarea id="input" style="width:551px; height:200px"></textarea>
        					</td>
        			   </tr>
        			</table>
			    </fieldset>
		    </div>';
    return $data;
}

function show_record($res){
    $ph1 = "`source` LIKE '%test%'";
    $ph2 = "or `source` LIKE '%test%'";
    if(strlen($res[phone1]) > 4){
        $ph1 = "`source` LIKE '%$res[phone1]%'";
    }
    if(strlen($res[phone2]) > 4){
        $ph2 = " or `source` LIKE '%$res[phone2]%'";
    }
    $record_incomming = mysql_query("SELECT  `datetime`,
                                             TIME_FORMAT(SEC_TO_TIME(duration),'%i:%s') AS `duration`,
                                             CONCAT(DATE_FORMAT(asterisk_incomming.call_datetime, '%Y/%m/%d/'),`file_name`) AS file_name
                                     FROM    `asterisk_incomming`
                                     WHERE   $ph1 $ph2 AND disconnect_cause != 'ABANDON'");
    while ($record_res_incomming = mysql_fetch_assoc($record_incomming)) {
        $str_record_incomming .= '<tr>
                                    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">'.$record_res_incomming[datetime].'</td>
                            	    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">'.$record_res_incomming[duration].'</td>
                            	    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;" onclick="listen(\''.$record_res_incomming[file_name].'\')"><span>მოსმენა</span></td>
                        	      </tr>';
    }
    
    $ph1 = "`phone` LIKE '%test%'";
    $ph2 = "or `phone` LIKE '%test%'";
    if(strlen($res[phone1]) > 4){
        $ph1 = "`phone` LIKE '%$res[phone1]%'";
    }
    if(strlen($res[phone2]) > 4){
        $ph2 = " or `phone` LIKE '%$res[phone2]%'";
    }
    
    $record_outgoing = mysql_query("SELECT  `call_datetime`,
                                            TIME_FORMAT(SEC_TO_TIME(duration),'%i:%s') AS `duration`,
                                            CONCAT(DATE_FORMAT(asterisk_outgoing.call_datetime, '%Y/%m/%d/'),`file_name`) AS file_name
                                    FROM    `asterisk_outgoing`
                                    WHERE   $ph1 $ph2");
    while ($record_res_outgoing = mysql_fetch_assoc($record_outgoing)) {
        $str_record_outgoing .= '<tr>
                                    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">'.$record_res_outgoing[call_datetime].'</td>
                            	    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">'.$record_res_outgoing[duration].'</td>
                            	    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;" onclick="listen(\''.$record_res_outgoing[file_name].'\')"><span>მოსმენა</span></td>
                        	      </tr>';
    }
    
    if($str_record_outgoing == ''){
        $str_record_outgoing = '<tr>
                                    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;" colspan=3>ჩანაწერი არ მოიძებნა</td>
                        	      </tr>';
    }
    
    if($str_record_incomming == ''){
        $str_record_incomming = '<tr>
                                    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;" colspan=3>ჩანაწერი არ მოიძებნა</td>
                        	      </tr>';
    }
    
    $data = '  <div style="margin-top: 10px;">
                    <audio controls autoplay style="margin-left: 145px;" id="auau">
                      <source src="" type="audio/wav">
                      Your browser does not support the audio element.
                    </audio>
               </div>
               <fieldset style="display:block !important; margin-top: 10px;">
                    <legend>შემომავალი ზარი</legend>
    	            <table style="margin: auto;">
    	               <tr>
    	                   <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">თარიღი</td>
                    	   <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">ხანგძლივობა</td>
                    	   <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">მოსმენა</td>
                	    </tr>
    	                '.$str_record_incomming.'
            	    </table>
	            </fieldset>
	            <fieldset style="display:block !important; margin-top: 10px;">
                    <legend>გამავალი ზარი</legend>
    	            <table style="margin: auto;">
    	               <tr>
    	                   <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">თარიღი</td>
                    	   <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">ხანგძლივობა</td>
                    	   <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">მოსმენა</td>
                	    </tr>
    	                '.$str_record_outgoing.'
            	    </table>
	            </fieldset>';
    return $data;
}

function show_file($res){
    $file_incomming = mysql_query("  SELECT `name`,
                                            `rand_name`,
                                            `file_date`,
                                            `id`
                                     FROM   `file`
                                     WHERE  `outgoing_id` = $res[id] AND `actived` = 1");
    while ($file_res_incomming = mysql_fetch_assoc($file_incomming)) {
        $str_file_incomming .= '<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 180px;float:left;">'.$file_res_incomming[file_date].'</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 189px;float:left;">'.$file_res_incomming[name].'</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;width: 160px;float:left;" onclick="download_file(\''.$file_res_incomming[rand_name].'\')">ჩამოტვირთვა</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;width: 20px;float:left;" onclick="delete_file(\''.$file_res_incomming[id].'\',\'outgoing\')">-</div>';
    }
    $data = '<div style="margin-top: 15px;">
                    <div style="width: 100%; border:1px solid #CCC;float: left;">    	            
    	                   <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 180px;float:left;">თარიღი</div>
                    	   <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 189px;float:left;">დასახელება</div>
                    	   <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 160px;float:left;">ჩამოტვირთვა</div>
                           <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 20px;float:left;">-</div>
    	                   <div style="text-align: center;vertical-align: middle;float: left;width: 595px;"><button id="upload_file" style="cursor: pointer;background: none;border: none;width: 100%;height: 25px;padding: 0;margin: 0;">აირჩიეთ ფაილი</button><input style="display:none;" type="file" name="file_name" id="file_name"></div>
                           <div id="paste_files">
                           '.$str_file_incomming.'
                           </div>
            	    </div>
	            </div>';
    return $data;
}

?>