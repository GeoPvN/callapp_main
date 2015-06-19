<?php
/* ******************************
 *	Request aJax actions
 * ******************************
*/

require_once ('../../../../includes/classes/core.php');
$action = $_REQUEST['act'];
$error	= '';
$data	= '';

$user				= $_SESSION['USERID'];
$task_id 			= $_REQUEST['id'];

$cur_date			= $_REQUEST['cur_date'];
$done_start_time	= $_REQUEST['done_start_time'];
$done_end_time		= $_REQUEST['done_end_time'];
$task_type_id		= $_REQUEST['task_type_id'];
$template_id		= $_REQUEST['template_id'];
$task_department_id	= $_REQUEST['task_department_id'];
$persons_id			= $_REQUEST['persons_id'];
$status				= $_REQUEST['status'];


switch ($action) {
	case 'get_add_page':
		$page		= GetPage($res='');
		$data		= array('page'	=> $page);
		
        break;
    case 'get_task':
        $page		= Gettask();
        $data		= array('page'	=> $page);
        
        break;
    case 'set_task':
    	$set_task_department_id		= $_REQUEST['set_task_department_id'];
    	$set_persons_id				= $_REQUEST['set_persons_id'];
    	$set_priority_id			= $_REQUEST['set_priority_id'];
    	$set_start_time				= $_REQUEST['set_start_time'];
    	$set_done_time				= $_REQUEST['set_done_time'];
    	$set_body					= $_REQUEST['set_body'];
    	
    	$set_task_id = mysql_fetch_assoc(mysql_query("SELECT `task_id` FROM `task_detail` WHERE `id` = '$task_id'"));
    	$tas = $set_task_id[task_id]; 
        GetSetTask($task_id, $tas, $set_task_department_id, $set_persons_id, $set_priority_id, $set_start_time, $set_done_time, $set_body);
        
        break;
    case 'get_edit_page':
	  
		$page		= GetPage(Getincomming($task_id));
        
        $data		= array('page'	=> $page);
        
        break;
        
    case 'disable':
    	$id_delete	= $_REQUEST['id_delete'];
    	
    	mysql_query("DELETE FROM `task_detail` WHERE `id`='$id_delete'");
        
        break;
	
 	case 'get_list' :
	    
        $user		= $_SESSION['USERID'];

    	// DB table to use
    	$table = 'new_out0';
    	 
    	// Table's primary key
    	$primaryKey = 'id';
    	 
    	// Array of database columns which should be read and sent back to DataTables.
    	// The `db` parameter represents the column name in the database, while the `dt`
    	// parameter represents the DataTables column identifier. In this case simple
    	// indexes
    	$columns = array(
    	    array( 'db' => 'id', 			    'dt' => 0 ),
    	    array( 'db' => 'original_id', 		'dt' => 1 ),
    	    array( 'db' => 'person_n',  		'dt' => 2 ),
    	    array( 'db' => 'first_last_name',   'dt' => 3 ),
    	    array( 'db' => 'task_type_name',    'dt' => 4 ),    	    
    	    array( 'db' => 'depart_name',       'dt' => 5 ),
    	    array( 'db' => 'end_date',			'dt' => 6 ),
    	    array( 'db' => 'note',			    'dt' => 7 ),    	     
    	);
    	 
    	// SQL server connection information
    	$sql_details = array(
    	    'user' => 'root',
    	    'pass' => 'Gl-1114',
    	    'db'   => 'asteriskcdrdb',
    	    'host' => 'localhost'
    	);
    	 
    	 
    	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    	 * If you just want to use the basic configuration for DataTables with PHP
    	 * server-side, there is no need to edit below this line.
    	*/
    	mysql_close();
    	require( '../../../../includes/ssp.class.php' );
    	 
    	$where_param = " where `status` = 0 and user_id = $user ";
    	
    	$data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where_param);

        break;
    case 'save_outgoing':
	
		$user_id		= $_SESSION['USERID'];
		
		if(empty($task_id)){
			$task_id = mysql_insert_id();
			Addtask($cur_date, $done_start_time, $done_end_time, $task_type_id, $template_id, $task_department_id, $persons_id, $status);
			//Addsite_user($incomming_call_id, $personal_pin, $friend_pin, $personal_id);
		}else{
			
			Savetask($task_id, $cur_date, $done_start_time, $done_end_time, $task_type_id, $template_id, $task_department_id, $persons_id);
			//Savesite_user($incom_id, $personal_pin, $name, $personal_phone, $mail,  $personal_id);
			
		}
		
        break;
        
    case 'get_responsible_person_add_page':
        $page 		= GetResoniblePersonPage();
        $data		= array('page'	=> $page);
        
        break;
    case 'done_outgoing':
        $task_detail_id = $_REQUEST['id'];
        $phone			= $_REQUEST['phone'];
        $phone1			= $_REQUEST['phone1'];
        $person_n		= $_REQUEST['person_n'];
        $first_name		= $_REQUEST['first_name'];
        $mail			= $_REQUEST['mail'];
        $city_id		= $_REQUEST['city_id'];
        $b_day			= $_REQUEST['b_day'];
        $addres			= $_REQUEST['addres'];
        $age			= $_REQUEST['age'];
        $sex			= $_REQUEST['sex'];
        $profession		= $_REQUEST['profession'];
        $interes		= $_REQUEST['interes'];
        	
        $set_task_department_id	= $_REQUEST['set_task_department_id'];
        $set_persons_id			= $_REQUEST['set_persons_id'];
        $set_priority_id		= $_REQUEST['set_priority_id'];
        $set_start_time			= $_REQUEST['set_start_time'];
        $set_done_time			= $_REQUEST['set_done_time'];
        $set_body				= $_REQUEST['set_body'];
        $task_type_id_seller	= $_REQUEST['task_type_id_seller'];
        $set_shabloni			= $_REQUEST['set_shabloni'];
        
        $sqesi = $_REQUEST['sqesi'];
        $asaki = $_REQUEST['asaki'];
        $tematika = $_REQUEST['tematika'];
        $tematika_inp = $_REQUEST['tematika_inp'];
        $rubrika1 = $_REQUEST['rubrika1'];
        $rubrika2 = $_REQUEST['rubrika2'];
        $rubrika3 = $_REQUEST['rubrika3'];
        $gazeti = $_REQUEST['gazeti'];
        $reklama = $_REQUEST['reklama'];
        $yidva = $_REQUEST['yidva'];
        $rcheva = $_REQUEST['rcheva'];
        $qalaqi = $_REQUEST['qalaqi'];
        $call_content = $_REQUEST['call_content'];
        	
        	
        if($set_task_department_id != 0){
            TaskFromireba($set_task_department_id, $set_persons_id, $set_priority_id, $set_start_time, $set_done_time, $set_body, $task_type_id_seller, $set_shabloni, $task_id);
        }
        
        $res = mysql_fetch_row(mysql_query("SELECT `phone_base_id`, `phone_base_inc_id`
                                            FROM `task_detail`
                                            WHERE `id` = '$task_detail_id' "));
        $phone_base = $res[phone_base_id];
        mysql_query("UPDATE `phone` SET
                            `phone1`			='$phone',
                            `phone2`			='$phone1',
                            `first_last_name`	='$first_name',
                            `person_n`			='$person_n',
                            `addres`			='$addres',
                            `mail`				='$mail',
                            `city`				='$city_id',
                            `born_day`			='$b_day',
                            `age`				='$age',
                            `sex`				='$sex',
                            `profession`		='$profession',
                            `interes`			='$interes'
                    WHERE 	`id`				='$phone_base'");
        
        $insOrupd = mysql_num_rows(mysql_query("SELECT * FROM `test_scenari` WHERE task_detail_id = $task_detail_id"));
        
        if($insOrupd == 0){
            mysql_query("INSERT INTO `test_scenari`
                        (`task_detail_id`, `sqesi`, `asaki`, `tematika`, `tematika_inp`, `rubrika1`, `rubrika2`, `rubrika3`, `gazeti`, `reklama`, `yidva`, `rcheva`, `qalaqi`)
                        VALUES
                        ('$task_detail_id', '$sqesi', '$asaki', '$tematika', '$tematika_inp', '$rubrika1', '$rubrika2', '$rubrika3', '$gazeti', '$reklama', '$yidva', '$rcheva', '$qalaqi')");
        }else{
            mysql_query("UPDATE `test_scenari` SET 
                `sqesi`='$sqesi',
                `asaki`='$asaki',
                `tematika`='$tematika',
                `tematika_inp`='$tematika_inp',
                `rubrika1`='$rubrika1',
                `rubrika2`='$rubrika2',
                `rubrika3`='$rubrika3',
                `gazeti`='$gazeti',
                `reklama`='$reklama',
                `yidva`='$yidva',
                `rcheva`='$rcheva',
                `qalaqi`='$qalaqi'
                WHERE `task_detail_id`='$task_detail_id';
                        ");
        }
        
        mysql_query("UPDATE `task_detail` SET
            `call_content` = '$call_content',
            `status`	='$status'
            WHERE  `id`		='$task_detail_id'
            ");
        
        break;
        
    case 'save_task':
    	// task_detail------------------------
    	$phone				= $_REQUEST['p_phone'];
    	$person_n			= $_REQUEST['p_person_n'];
    	$first_name			= $_REQUEST['p_first_name'];
    	$mail				= $_REQUEST['p_mail'];
    	$last_name 			= $_REQUEST['p_last_name'];
    	$person_status 		= $_REQUEST['p_person_status'];
    	$addres 			= $_REQUEST['p_addres'];
    	$b_day				= $_REQUEST['p_b_day'];
    	$city_id 			= $_REQUEST['p_city_id'];
    	$family_id 			= $_REQUEST['p_family_id'];
    	$profesion 			= $_REQUEST['p_profesion'];
    	$user				= $_SESSION['USERID'];
    	//------------------------------------
    	
    	mysql_query("INSERT INTO `task_detail` 
    			( `user_id`, `task_id`, `person_n`, `first_name`, `last_name`, `person_status`, `phone`, `mail`, `addres`, `b_day`, `city_id`, `family_id`, `profesion`, `actived`) 
    			VALUES 
    			( '$user', '$task_id', '$person_n', '$first_name', '$last_name', '$person_status', '$phone', '$mail', '$addres', '$b_day', '$city_id', '$family_id', '$profesion', '1')");
        
        break;
        
    case 'change_responsible_person':
        $responsible_person = $_REQUEST['rp'];
        $number_p = $_REQUEST['number'];
        $note_p = $_REQUEST['note_p'];
        $sorce_p = $_REQUEST['sorce_p'];
        
        ChangeResponsiblePerson($number_p, $responsible_person, $note_p, $sorce_p);
        
        break;
    case '':
    default:
       $error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);


/* ******************************
 *	Request Functions
 * ******************************
 */
 
function TaskFromireba($set_task_department_id, $set_persons_id, $set_priority_id, $set_start_time, $set_done_time, $set_body, $task_type_id_seller, $set_shabloni, $id)
{
    $user  = $_SESSION['USERID'];
    $c_date		= date('Y-m-d H:i:s');

    $shablon_id =  mysql_fetch_row(mysql_query("SELECT 	`id`
        FROM 		`shabloni`
        WHERE 		`name` = '$set_shabloni'
        GROUP BY 	`shabloni`.`name`"));

    mysql_query("INSERT INTO `task`
        (`user_id`, `responsible_user_id`, `date`, `start_date`, `end_date`, `department_id`, `template_id`, `task_type_id`, `priority_id`, `comment`, `status`, `actived`, `outgoing_id`)
        VALUES
        ('$user', '$set_persons_id', '$c_date', '$set_start_time', '$set_done_time', '$set_task_department_id', '$shablon_id[0]', '$task_type_id_seller', '$set_priority_id', '$set_body', '1', '1','$id')");

    $task_edit = mysql_fetch_row(mysql_query("SELECT MAX(id) AS `task_id` FROM `task`"));

}

function GetSetTask($task_id, $tas, $set_task_department_id, $set_persons_id, $set_priority_id, $set_start_time, $set_done_time, $set_body)
{
	$c_date		= date('Y-m-d H:i:s');
	$user  = $_SESSION['USERID'];
	mysql_query("UPDATE `task` SET
	`user_id`				='$user',
	`responsible_user_id`	='$set_persons_id',
	`date`					='$c_date',
	`start_date`			='$set_start_time',
	`end_date`				='$set_done_time',
	`department_id`			='$set_task_department_id',
	`priority_id`			='$set_priority_id',
	`comment`				='$set_body'
	WHERE `id`				='$tas'
	");
	
	mysql_query("UPDATE `task_detail` SET
						`status`	='0'
				WHERE   `id`		='$task_id'
				");
}

function checkgroup($user){
	$res = mysql_fetch_assoc(mysql_query("
											SELECT users.group_id
											FROM    users
											WHERE  users.id = $user
										"));
	return $res['group_id'];
	
}


function Addtask($cur_date, $done_start_time, $done_end_time, $task_type_id, $template_id, $task_department_id, $persons_id, $status)
{  
	$user		= $_SESSION['USERID'];
	mysql_query("INSERT INTO `task` 
				( `user_id`, `responsible_user_id`, `date`, `start_date`, `end_date`, `department_id`, `template_id`, `task_type_id`, `status`, `actived`)
				VALUES
				( '$user', '$persons_id', '$cur_date', '$done_start_time', '$done_end_time', '$task_department_id', '$template_id', '$task_type_id', '$status', '1')
				");

}
function Addsite_user($incomming_call_id, $personal_pin, $friend_pin, $personal_id)
{
	
	$user		= $_SESSION['USERID'];
	mysql_query("INSERT INTO `site_user` 	(`incomming_call_id`, `site`, `pin`, `friend_pin`, `name`, `phone`, `mail`, `personal_id`, `user`)
						           		 VALUES 
											( '$incomming_call_id', '243', '$personal_pin', '$friend_pin', '11111111', 22222, '333', '$personal_id', '$user')");

}

function Getshabl($templ){

	$req = mysql_query("	SELECT 	`id`,
			`name`
			FROM 	shabloni
			WHERE 	id = $templ
			GROUP BY 	`shabloni`.`name`
			");

			$res = mysql_fetch_assoc($req);
			$shabl_name .= $res[name];

			return $shabl_name;
}

function Getstatus($status){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	status

							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $status){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Savetask($task_id, $cur_date, $done_start_time, $done_end_time, $task_type_id, $template_id, $task_department_id, $persons_id)
{
	$c_date		= date('Y-m-d H:i:s');
	$user  = $_SESSION['USERID'];
	mysql_query("UPDATE `task` SET  
								`user_id`				='$user',
								`responsible_user_id`	='$persons_id', 
								`date`					='$c_date',
								`planned_end_date`		='$planned_end_date',
								`fact_end_date`			='$fact_end_date', 
								`call_duration`			='$call_duration', 
								`priority_id`			='$priority_id',
								`template_id` 			='$template_id',
								`phone`					='$phone', 
								`comment`				='$comment', 
								`problem_comment`		='$problem_comment', 
								`status`='0', 
								`actived`='1'
								 WHERE `id`				='$task_id'
									");


}
function Savesite_user($incom_id, $personal_pin, $name, $personal_phone, $mail,  $personal_id)
{

	$user  = $_SESSION['USERID'];
	mysql_query("UPDATE 	`site_user` 
				SET			
							`site`						='243', 
							`pin`						='$personal_pin', 
							`name`						='$name', 
							`phone`						='$personal_phone', 
							`mail`						='$mail', 
							`personal_id`				='$personal_id', 
							`user`						='$user'
							 WHERE `incomming_call_id`	='$incom_id'
							
					");

}


function Getcall_status($status)
{
	$data = '';
	$req = mysql_query("SELECT 	`id`, `call_status`
						FROM 	`status`
						WHERE 	actived=1");
	

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		
		if($res['id'] == $call_status_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['$status'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['$status'] . '</option>';
		}
	}
	return $data;
}
	function Getpay_type($pay_type_id)
	{
		$data = '';
		$req = mysql_query("SELECT 	`id`, `name`
							FROM 	`pay_type`
							WHERE 	actived=1");
	
	
		$data .= '<option value="0" selected="selected">----</option>';
		while( $res = mysql_fetch_assoc($req)){
			if($res['id'] == $pay_type_id){
				$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
			} else {
				$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
			}
		}
	
		return $data;
	}
	function Get_bank($bank_id)
	{
		$data = '';
		$req = mysql_query("SELECT 	`id`, `name`
							FROM 	`bank`
							WHERE 	actived=1");
	
	
		$data .= '<option value="0" selected="selected">----</option>';
		while( $res = mysql_fetch_assoc($req)){
			if($res['id'] == $bank_id){
				$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
			} else {
				$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
			}
		}
	
		return $data;
	}
	
function Getbank_object($bank_object_id)
{  
	$data = '';
	$req = mysql_query("SELECT  id,
						     	`name`
						FROM 	bank_object
						WHERE 	bank_object.bank_id=$bank_object_id && actived =1");


	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $bank_object_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getbank_object_edit($bank_object_id)
{

	$data = '';
	$req = mysql_query("SELECT  id,
								`name`
						FROM 	bank_object
						WHERE 	bank_object.id=$bank_object_id && actived =1");


	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $bank_object_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}
	
function Getcard_type($card_type_id)
{
	$data = '';
	$req = mysql_query("SELECT 	`id`, `name`
						FROM 	`card_type`
						WHERE 	actived=1");


	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $card_type_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}
function Getcard_type1($card_type1_id)
{
	$data = '';
	$req = mysql_query("SELECT 	`id`, `name`
						FROM 	`card_type`
						WHERE 	actived=1");


	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $card_type1_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}
function Getpay_aparat($pay_aparat_id)
{
	$data = '';
	$req = mysql_query("SELECT 	`id`, `name`
						FROM 	`pay_aparat`
						WHERE 	actived=1");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $pay_aparat_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}
function Getobject($object_id)
{
	$data = '';
	$req = mysql_query("SELECT 	`id`, `name`
						FROM 	`object`
						WHERE 	actived=1");


	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $object_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}
function Getcategory($category_id)

{ 			

	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `category`
						WHERE actived=1 && parent_id=0 ");


	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $category_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getcategory1($category_id)
{

	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `category`
						WHERE actived=1 && parent_id=$category_id");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $category_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
	
}

function Getcategory1_edit($category_id)
{

	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `category`
						WHERE actived=1 && id=$category_id");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $category_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;

}

function Getcall_type($call_type_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `call_type`
						WHERE actived=1");
		
	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $call_type_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getpriority($priority_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `priority`
						WHERE actived=1 ");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $priority_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}


function Gettemplate($template_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `template`
						WHERE actived=1 ");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $template_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}


function Gettask_type($task_type_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
					    FROM `task_type`
					    WHERE actived=1");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $task_type_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getdepartment($department_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	department
							WHERE 	actived=1
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $department_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}


function Getpersonss($persons_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `persons`
						WHERE actived=1 ");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $persons_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getpattern($id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `pattern`
						WHERE actived=1 ");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getshipping($id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
						FROM `shipping`
						WHERE actived=1 ");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getshablon($id,$templ){
	
	$req = mysql_query("	SELECT `id`,
    	                           `name`
    	                    FROM   `scenario`
    	                    WHERE  `actived` = 1");
	

				$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
	if($res['id'] == $templ){
	$data .= '<option value="' . $res['name'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
		$data .= '<option value="' . $res['name'] . '">' . $res['name'] . '</option>';
		}
		}

		return $data;
}


function Getcity($city_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	city
							WHERE 	actived=1
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $city_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getscenar(){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	shabloni
							GROUP BY 	`shabloni`.`name`
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $id){
			$data .= '<option value="' . $res['name'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['name'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getincomming($task_id)
{
$res = mysql_fetch_assoc(mysql_query("	SELECT 	task_detail.id,
                                				`task`.`date`,
                                				`task`.`template_id`,
                                				`task_detail`.`status`,
                                				`task`.start_date,
                                				task.end_date,
                                				task.`task_type_id`,
                                				task.`template_id`,
                                                task_detail.call_content,
                                				phone.phone1 as phone,
                                				phone.phone2 as phone2,
                                				phone.born_day as b_day,
                                				phone.first_last_name as first_name,
                                				phone.addres as addres,
                                				phone.person_n as person_n,
                                				phone.city as city_id,
                                				phone.mail as mail,
                                				phone.sex as sex,
                                				phone.age as age,
                                				phone.profession as profession,
                                				phone.interes as interes,
                                                test_scenari.sqesi,
                                                test_scenari.asaki,
                                                test_scenari.tematika,
                                                test_scenari.tematika_inp,
                                                test_scenari.rubrika1,
                                                test_scenari.rubrika2,
                                                test_scenari.rubrika3,
                                                test_scenari.gazeti,
                                                test_scenari.reklama,
                                                test_scenari.yidva,
                                                test_scenari.rcheva,
                                                test_scenari.qalaqi
                                        FROM 	`task`
                                        LEFT JOIN	task_detail ON task.id = task_detail.task_id
                                        LEFT JOIN	task_type ON task.task_type_id = task_type.id
                                        LEFT JOIN phone ON task_detail.phone_base_id = phone.id
                                        LEFT JOIN test_scenari ON test_scenari.task_detail_id = task_detail.id
                                        WHERE	task_detail.id = '$task_id'
			" ));
	
	return $res;
}

function GetPage($res='', $shabloni)
{
		$data  .= '<div id="dialog-form">
							<div style="float: left; width: 710px;">
								<fieldset >
							    	<legend>ძირითადი ინფორმაცია</legend>
						
							    	<table width="65%" class="dialog-form-table">
										<tr>
											<td style="width: 180px;"><label for="">დავალების №</label></td>
											<td style="width: 180px;"><label for="">თარიღი</label></td>
										</tr>
										<tr>
											<td>
												<input type="text" id="id" class="idle" onblur="this.className=\'idle\'" disabled value="' . $res['id']. '" disabled="disabled" />
											</td>
											<td>
												<input type="text" id="c_date" class="idle" onblur="this.className=\'idle\'" disabled  value="' .  $res['date']. '" disabled="disabled" />
											</td>		
										</tr>
									</table><br>
								
														
								<fieldset style="width:250px; float:left;">
							    	<legend>დავალების ტიპი</legend>
								<table class="dialog-form-table">
							    		<tr>
											<td><select style="width: 305px;" id="task_type_id_seller" disabled class="idls object">'.Gettask_type($res['task_type_id']).'</select></td>
										</tr>
									</table>
								</fieldset>
								<fieldset style="width:340px; float:left; margin-left:10px;">
							    	<legend>სცენარის დასახელება</legend>
								<table class="dialog-form-table">
							    		<tr>
											<td><select style="width: 375px;" id="shabloni" disabled class="idls object">'.Getshablon('',$res['template_id']).'</select></td>
										</tr>
									</table>
								</fieldset>
						        ';
		

		$data .= '<div id="dialog-form" style="width:100%; overflow-y:scroll; max-height:400px;">
                    <fieldset>
                        <legend>კითხვები</legend>
		    <div class="1" id="2">
            <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">სავალდებულოა მონიშნეთ 1 პასუხი</textarea>
            <table class="dialog-form-table">
    		<tbody>
                <tr>
    			  <td style="font-weight:bold;">1. სქესი</td>
                </tr>
                <tr>
                  <td style="width:707px; text-align:left;">
                  <input style="float:left;" type="radio" name="sqesi" value="1" '.(($res['sqesi']=='1')?'checked':"").'>
                  <label style="float:left; padding: 7px;">მამრობითი</label>
                  </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="sqesi" value="2" '.(($res['sqesi']=='2')?'checked':"").'>
		    <label style="float:left; padding: 7px;">მდედორბითი</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    <div class="2" id="1">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">სავალდებულო შეკითხვა</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">2. ასაკი</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="1" '.(($res['asaki']=='1')?'checked':"").'>
		    <label style="float:left; padding: 7px;">18 წლამდე</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="2" '.(($res['asaki']=='2')?'checked':"").'>
		    <label style="float:left; padding: 7px;">18-24</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="3" '.(($res['asaki']=='3')?'checked':"").'>
		    <label style="float:left; padding: 7px;">25-34</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="4" '.(($res['asaki']=='4')?'checked':"").'>
		    <label style="float:left; padding: 7px;">35-44</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="5" '.(($res['asaki']=='5')?'checked':"").'>
		    <label style="float:left; padding: 7px;">45-54</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="6" '.(($res['asaki']=='6')?'checked':"").'>
		    <label style="float:left; padding: 7px;">55-64</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="asaki" value="7" '.(($res['asaki']=='7')?'checked':"").'>
		    <label style="float:left; padding: 7px;">65+</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="3" id="3">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">შესაძლებელია რამდენიმე პასუხი</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">3. რა თემატიკის საგაზეთო სტატიები გაინტერესებთ ყველაზე მეტად?</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="პოლიტიკა"  '.((preg_match('#^.*პოლიტიკა.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">პოლიტიკა</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="ბიზნესი/ეკონომიკა" '.((preg_match('#^.*ბიზნესი/ეკონომიკა.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">ბიზნესი/ეკონომიკა</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="კრიმინალი" '.((preg_match('#^.*კრიმინალი.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">კრიმინალი</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="მედიცინა" '.((preg_match('#^.*მედიცინა.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">მედიცინა</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="რელიგია" '.((preg_match('#^.*რელიგია.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">რელიგია</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="სპორტი" '.((preg_match('#^.*სპორტი.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">სპორტი</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="სამხედრო თემა" '.((preg_match('#^.*სამხედრო თემა.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">სამხედრო თემა</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="სასარგებლო რჩევები" '.((preg_match('#^.*სასარგებლო რჩევები.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">სასარგებლო რჩევები</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="სოციალური თემები" '.((preg_match('#^.*სოციალური თემები.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">სოციალური თემები</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="ისტორიული" '.((preg_match('#^.*ისტორიული.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">ისტორიული</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="შოუბიზნესი" '.((preg_match('#^.*შოუბიზნესი.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">შოუბიზნესი</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="checkbox" name="tematika" value="კულტურა/ხელოვნება" '.((preg_match('#^.*კულტურა/ხელოვნება.*$#', $res['tematika']))?'checked':"").'>
		    <label style="float:left; padding: 7px;">კულტურა/ხელოვნება</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input value="'.$res['tematika_inp'].'" style="float:left;" type="text" id="tematika_inp">
		    <label style="float:left; padding: 7px;" for="tematika_inp">სხვა, დაასახელეთ</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="4" id="4">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">დაასახელეთ მაქსიმუმ სამი რუბრიკა</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">4. რომელ რუბრიკას კითხულობთ ყველაზე მეტი ინტერესით?</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input value="'.$res['rubrika1'].'" style="float:left;" type="text" id="rubrika1">
		    <label style="float:left; padding: 7px;" for="rubrika1">პასუხი 1</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input value="'.$res['rubrika2'].'" style="float:left;" type="text" id="rubrika2">
		    <label style="float:left; padding: 7px;" for="rubrika2">პასუხი 2</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input value="'.$res['rubrika3'].'" style="float:left;" type="text" id="rubrika3">
		    <label style="float:left; padding: 7px;" for="rubrika3">პასუხი 3</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="5" id="6">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">შესაძლებელია მხოლოდ ერთი პასუხი</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">5. რა მოცულობის საგაზეთო სტატიების წაკითხვა გირჩევნიათ?</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="gazeti" value="1" '.(($res['gazeti']=='1')?'checked':"").'>
		    <label style="float:left; padding: 7px;">ვრცელი</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="gazeti" value="2" '.(($res['gazeti']=='2')?'checked':"").'>
		    <label style="float:left; padding: 7px;">მცირე</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="gazeti" value="3" '.(($res['gazeti']=='3')?'checked':"").'>
		    <label style="float:left; padding: 7px;">საშუალო ზომის</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="gazeti" value="4" '.(($res['gazeti']=='4')?'checked':"").'>
		    <label style="float:left; padding: 7px;">მოცულობას არ აქვს მნიშვნელობა</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="6" id="7">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">მხოლოდ ერთი პასუხი</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">6. აქცევთ თუ არა ყურადღებას რეკლამას გაზეთში?</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="reklama" value="1" '.(($res['reklama']=='1')?'checked':"").'>
		    <label style="float:left; padding: 7px;">დიახ</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="reklama" value="2" '.(($res['reklama']=='2')?'checked':"").'>
		    <label style="float:left; padding: 7px;">არა</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="7" id="8">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">მხოლოდ ერთი პასუხი</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">7. მიგიღიათ თუ არა ყიდვის გადაწყვეტილება კვირის პალიტრაში ნანახი რეკლამის საფუძველზე?</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="yidva" value="1" '.(($res['yidva']=='1')?'checked':"").'>
		    <label style="float:left; padding: 7px;">დიახ</label>
		    </td>
		    </tr>
		    <tr>
		    <td style="width:707px; text-align:left;">
		    <input style="float:left;" type="radio" name="yidva" value="2" '.(($res['yidva']=='2')?'checked':"").'>
		    <label style="float:left; padding: 7px;">არა</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="8" id="5"><textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">შესაძლებელია რამდენიმე პასუხი</textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">8. რას ურჩევდით კვირის პალიტრას?</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input value="'.$res['rcheva'].'" style="float:left;" type="text" id="rcheva">
		    <label style="float:left; padding: 7px;" for="rcheva">პასუხი</label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    
		    
		    <div class="9" id="9">
		    <textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle"></textarea>
		            <table class="dialog-form-table">
		    		<tbody><tr>
						<td style="font-weight:bold;">9. გთხოვთ დაასახელოთ თქვენი საცხოვრებელი ქალაქი/რეგიონი</td>
		                </tr>
		                    <tr>
		    <td style="width:707px; text-align:left;">
		    <input value="'.$res['qalaqi'].'" style="float:left;" type="text" id="qalaqi">
		    <label style="float:left; padding: 7px;" for="qalaqi"></label>
		    </td>
		    </tr>
		    </tbody>
		    </table>
                    <hr><br>
		    </div>
		    </fieldset>
		          </div>';
						
						  $data .= '<fieldset style="width:350px;; float:left;">
								    	<legend>ზარის დაზუსტება</legend>
									<table class="dialog-form-table">
								    		<tr>
												<td><textarea  style="width: 350px; height:70px; resize: none;" id="call_content" class="idle" name="content" cols="300" >' . $res['call_content'] . '</textarea></td>
											</tr>
									</table>
									</fieldset>	
									<fieldset style="width:300px; float:left; margin-left:10px; max-height:90px;">
								    	<legend>სტატუსი</legend>
									<table class="dialog-form-table" style="height: 80px;">
											<tr>
												<td></td>
											</tr>
								    		<tr>
												<td><select style="width: 328px;" id="status" class="idls object">'.Getstatus($res['status']).'</select></td>
											</tr>
									</table>
									</fieldset>
								<fieldset style="margin-top: 5px;">
								    	<legend>დავალების ფორმირება</legend>
							
								    	<table class="dialog-form-table" >
											<tr>
												<td style="width: 280px;"><label for="set_task_department_id">განყოფილება</label></td>
												<td style="width: 280px;"><label for="set_persons_id">პასუხისმგებელი პირი</label></td>
												<td style="width: 280px;"><label for="set_priority_id">პრიორიტეტი</label></td>
											</tr>
								    		<tr>
												<td><select style="width: 200px;"  id="set_task_department_id" class="idls object">'.Getdepartment($res['task_department_id']).'</select></td>
												<td><select style="width: 200px;" id="set_persons_id" class="idls object">'. Getpersons($res['persons_id']).'</select></td>
												<td><select style="width: 200px;" id="set_priority_id" class="idls object">'.Getpriority($res['priority_id']).'</select></td>
											</tr>
											</table>
											<table class="dialog-form-table" style="width: 720px;">
											<tr>
												<td style="width: 150px;"><label>შესრულების პერიოდი</label></td>
												<td style="width: 150px;"><label></label></td>
												<td style="width: 150px;"><label>კომენტარი</label></td>
											</tr>
											<tr>
												<td><input style="width: 130px; float:left;" id="set_start_time" class="idle" type="text"><span style="margin-left:5px; ">დან</span></td>
										  		<td><input style="width: 130px; float:left;" id="set_done_time" class="idle" type="text"><span style="margin-left:5px; ">მდე</span></td>
												<td>
													<textarea  style="width: 270px; resize: none;" id="set_body" class="idle" name="content" cols="300">' . $res['comment'] . '</textarea>
												</td>
											</tr>
										</table>
							        </fieldset>	
							</fieldset>	
							</div>';
						
						
						$data .='<div style="float: right;  width: 355px;">
								<fieldset>
								<legend>აბონენტი</legend>
								<table style="height: 243px;">						
									<tr>
										<td style="width: 180px; color: #3C7FB1;">ტელეფონი 1</td>
										<td style="width: 180px; color: #3C7FB1;">ტელეფონი 2</td>
									</tr>
									<tr>
										<td>
											<input type="text" id="phone"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['phone'] . '" />
										</td>
										<td>
											<input type="text" id="phone1"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['phone2'] . '" />
										</td>
															
									</tr>
									<tr>
										<td style="width: 180px; color: #3C7FB1;">სახელი</td>
										<td style="width: 180px; color: #3C7FB1;">ელ-ფოსტა</td>
									</tr>
									<tr >
										<td style="width: 180px;">
											<input type="text" id="first_name"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['first_name'] . '" />
										</td>
										<td style="width: 180px;">
											<input type="text" id="mail"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['mail'] . '" />
										</td>			
									</tr>
									<tr>
										<td td style="width: 180px; color: #3C7FB1;">ქალაქი</td>
										<td td style="width: 180px; color: #3C7FB1;">დაბადების თარიღი</td>
									</tr>
									<tr>
										<td><input type="text" id="city_id"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['city_id'] . '" /></td>	
										<td td style="width: 180px;">
											<input type="text" id="b_day"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['b_day'] . '" />		
										</td>
									</tr>
									<tr>
										<td td style="width: 180px; color: #3C7FB1;">მისამართი</td>
										<td style="width: 180px; color: #3C7FB1;">პირადი ნომერი</td>
									</tr>
									<tr>
										<td td style="width: 180px;">
											<input type="text" id="addres"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['addres'] . '" />		
										</td>
										<td style="width: 180px;">
											<input type="text" id="person_n"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['person_n'] . '" />
										</td>
									</tr>
													
									<tr>
										<td td style="width: 180px; color: #3C7FB1;">ასაკი</td>
										<td style="width: 180px; color: #3C7FB1;">სქესი</td>
									</tr>
									<tr>
										<td td style="width: 180px;">
											<input type="text" id="age"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['age'] . '" />		
										</td>
										<td style="width: 180px;">
											<input type="text" id="sex"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['sex'] . '" />
										</td>
									</tr>
									
									<tr>
										<td td style="width: 180px; color: #3C7FB1;">პროფესია</td>
										<td style="width: 180px; color: #3C7FB1;">ინტერესების სფერო</td>
									</tr>
									<tr>
										<td td style="width: 180px;">
											<input type="text" id="profession"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['profession'] . '" />		
										</td>
										<td style="width: 180px;">
											<input type="text" id="interes"  class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="' . $res['interes'] . '" />
										</td>
									</tr>
									
								</table>
							</fieldset>';
							$data .= GetRecordingsSection($res);	
						$data .=	'</div>
				    </div>';
	
	
	$data .= '<input type="hidden" id="outgoing_call_id" value="' . $res['id'] . '" />';

	return $data;
}

function GetRecordingsSection($res)
{
    $phone = '---';
    $phone1 = '---';
    if($res['phone'] != ''){
        $phone = $res[phone];
    }
    if($res['phone2'] != '') {
        $phone1 = $res[phone2];
    }

	$req = mysql_query("SELECT  `calldate` AS 'time',
			SUBSTR(`userfield`, 7) as userfield
			FROM     `cdr`
			WHERE     (`src` in('100','101','250','150','200') && (`dst` LIKE '%$phone%' or `dst` LIKE '%$phone1%'))");

	$data .= '
        <fieldset style="margin-top: 10px; width: 333px; float: right;">
            <legend>ჩანაწერები</legend>

            <table style="width: 65%; border: solid 1px #85b1de; margin:auto;">
                <tr style="border-bottom: solid 1px #85b1de; height: 20px;">
                    <th style="padding-left: 10px;">დრო</th>
                    <th  style="border: solid 1px #85b1de; padding-left: 10px;">ჩანაწერი</th>
                </tr>';
	if (mysql_num_rows($req) == 0){
		$data .= '<td colspan="2" style="height: 20px; text-align: center;">ჩანაწერები ვერ მოიძებნა</td>';
	}

	while( $res2 = mysql_fetch_assoc($req)){
		$link = $res2['userfield'];
		$data .= '
                <tr style="border-bottom: solid 1px #85b1de; height: 20px;">
                    <td style="vertical-align: middle; text-align: center;">' . $res2['time'] . '</td>
                    <td style="vertical-align: middle; text-align: center;"><button class="download" str="' . $link . '">მოსმენა</button></td>
                </tr>';
	}

	$data .= '
            </table>
        </fieldset>';

	return $data;
}

function ChangeResponsiblePerson($number_p, $responsible_person, $note_p, $sorce_p){
		$note_checker = '';
		$note_checker_sub = '';
		//if($note_p != '0' || $sorce_p != '0'){
		    $ch_note_p = "";
		    $ch_sorce_p = "";
		    if($note_p != '0'){
		    $ch_note_p = "AND phone.note = '$note_p'";
		    }
		    if($sorce_p != '0'){
		    $ch_sorce_p = "AND phone.sorce = '$sorce_p'";
		    }
		    
		$filtr_res = mysql_query("	SELECT 	task_detail.id 
									FROM 	task_detail
									JOIN 	phone ON task_detail.phone_base_id = phone.id $ch_note_p $ch_sorce_p
		                            WHERE   task_detail.status = 0");
									
			while ($row_r = mysql_fetch_assoc($filtr_res)){
				$note_checker .= $row_r['id'].',';
			}
			$gg = substr($note_checker,0,-1);
			$note_checker_sub = "and id in($gg)";
			
		//}
		//$note_checker_sub;
		mysql_query("UPDATE `task_detail` SET 
							`responsible_user_id`='$responsible_person',
							`status`='1'
					 WHERE 	ISNULL(`responsible_user_id`) $note_checker_sub
					 LIMIT $number_p");

}

function GetPersons(){
	$data = '';
	$req = mysql_query("SELECT 		users.id AS `id`,
									persons.`name` AS `name`
						FROM 		`persons`
						JOIN    	users ON users.person_id = persons.id");

	$data .= '<option value="' . 0 . '" selected="selected">' . '' . '</option>';

	while( $res = mysql_fetch_assoc($req)){
		$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
	}
	return $data;
}

function GetResoniblePersonPage(){
	$data = '
		<div id="dialog-form">
			<fieldset>
				<legend>ძირითადი ინფორმაცია</legend>
				<table width="100%" class="dialog-form-table" cellpadding="10px" >
					<tr>
						<th><label for="responsible_person">პასუხისმგებელი პირი</label></th>
					</tr>
					<tr>
						<th>
							<select style="width: 230px;" id="responsible_person" class="idls address">'. GetPersons() .'</select>
						</th>
					</tr>
					<tr>
						<th><label for="raodenoba">რაოდენობა</label></th>
					</tr>
					<tr>
						<th>
							<input type="text" id="raodenoba" class="idls address" value="" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
						</th>
					</tr>
					<tr>
						<th><label for="shenishvna">შენიშვნა</label></th>
					</tr>
					<tr>
						<th>
							<select style="width: 230px;" id="shenishvna" class="idls object">'.GetShenishvna().'</select>
						</th>
					</tr>
					<tr>
						<th><label for="shenishvna">წყარო</label></th>
					</tr>
					<tr>
						<th>
							<select style="width: 230px;" id="wyaro" class="idls object">'.GetWyaro().'</select>
						</th>
					</tr>
				</table>
			</fieldset>
		</div>';
	return $data;

}

function GetShenishvna()
{
	$data = '';
	$req = mysql_query("SELECT `phone`.`note`
						FROM 	`task_detail`
						JOIN 	`phone` ON `task_detail`.`phone_base_id` = `phone`.`id`
						GROUP BY `phone`.`note` ");
	
	$data .= '<option value="0" selected="selected"></option>';
	while( $res = mysql_fetch_assoc($req)){
		
			$data .= '<option value="' . $res['note'] . '">' . $res['note'] . '</option>';
		
	}
	
	return $data;
}

function GetWyaro()
{
    $data = '';
    $req = mysql_query("SELECT `phone`.`sorce`
						FROM 	`task_detail`
						JOIN 	`phone` ON `task_detail`.`phone_base_id` = `phone`.`id`
						GROUP BY `phone`.`sorce` ");

    $data .= '<option value="0" selected="selected"></option>';
    while( $res = mysql_fetch_assoc($req)){

        $data .= '<option value="' . $res['sorce'] . '">' . $res['sorce'] . '</option>';

    }

    return $data;
}

function increment($table){

	$result   		= mysql_query("SHOW TABLE STATUS LIKE '$table'");
	$row   			= mysql_fetch_array($result);
	$increment   	= $row['Auto_increment'];
	$next_increment = $increment+1;
	mysql_query("ALTER TABLE '$table' AUTO_INCREMENT=$next_increment");

	return $increment;
}
?>