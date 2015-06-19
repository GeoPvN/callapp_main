<?php

/* ******************************
 *	Request aJax actions
* ******************************
*/

require_once('../../includes/classes/core.php');
include('../../includes/classes/log.class.php');
$log 		= new Log();

$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';

//incomming
$incom_id						= $_REQUEST['id'];
$id_p							= $_REQUEST['id_p'];
$phone							= $_REQUEST['phone'];
$person_name					= $_REQUEST['person_name'];
$type							= $_REQUEST['type'];
$call_vote						= $_REQUEST['call_vote'];
$results_id						= $_REQUEST['results_id'];
$information_category_id		= $_REQUEST['information_category_id'];
$information_sub_category_id	= $_REQUEST['information_sub_category_id'];
$content_id						= $_REQUEST['content_id'];
$product_id						= $_REQUEST['product_id'];
$forward_id						= $_REQUEST['forward_id'];
$connect						= $_REQUEST['connect'];
$results_comment				= $_REQUEST['results_comment'];
$content						= $_REQUEST['content'];
$task_type_id					= $_REQUEST['task_type_id'];
$task_department_id				= $_REQUEST['task_department_id'];
$persons_id						= $_REQUEST['persons_id'];
$comment						= $_REQUEST['comment'];
$source_id						= $_REQUEST['source_id'];
$c_date							= $_REQUEST['c_date'];

switch ($action) {
	case 'get_add_page':
		$number		= $_REQUEST['number'];
		$page		= GetPage($res='', $number);
		$data		= array('page'	=> $page);

		break;
	case 'disable':
		$incom_id				= $_REQUEST['id'];
		mysql_query("			UPDATE `incomming_call`
									    SET `actived`=0
										WHERE `id`=$incom_id ");
		break;
	case 'get_edit_page':
		$page		= GetPage(Getincomming($incom_id));

		$data		= array('page'	=> $page);

		break;
	case 'get_list' :
		$count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
	  	$rResult = mysql_query("select  		incomming_call.id,           
												incomming_call.id,
											  	DATE_FORMAT(incomming_call.`date`,'%d-%m-%y %H:%i:%s'),
												info_category.`name`,
												incomming_call.phone,
	  											incomming_call.content
								FROM 			incomming_call
								LEFT JOIN 		info_category  ON incomming_call.information_category_id=info_category.id
	  							WHERE 			incomming_call.actived = 1");
	  
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
	case 'save_incomming':
		$incom_id_check = $_REQUEST['id'];
		if($incom_id_check == ''){
			
			Addincomming($c_date, $id_p, $phone, $person_name, $type, $results_id, $information_category_id, $information_sub_category_id, $content_id, $product_id,  $forward_id, $connect, $results_comment, $content, $task_type_id, $task_department_id, $persons_id, $comment, $call_vote, $source_id);

		}else {
			
			Saveincomming($c_date, $id_p, $phone, $person_name, $type, $results_id, $information_category_id, $information_sub_category_id, $content_id, $product_id,  $forward_id, $connect, $results_comment, $content, $task_type_id, $task_department_id, $persons_id, $comment, $call_vote, $source_id);
	
		}
		break;
	case 'send_mail':
			$c_date = $_REQUEST['c_date'];			
			Sendmail($c_date,$phone,$results_id,$results_comment,$content,$product_id,$call_vote);
		break;
	case 'get_calls':
	
		$data		= array('calls' => getCalls());
	
		break;		
	case 'category_change':
		
		$information_category_id_check = $_REQUEST['information_category_id_check'];
		$data 	= 	array('cat'=>Getinformation_sub_category('',$information_category_id_check));
		
		break;	
	case 'set_task_type':
	
		$cat_id	=	$_REQUEST['cat_id'];
		$data 	= 	array('cat'=>Getbank_object($cat_id));
	
		break;
	
	case 'get_add_info':
	
		$pin	=	$_REQUEST['pin'];
		$data 	= 	array('info' => get_addition_all_info($pin));
	
		break;
		case 'get_add_info1':
		
		$personal_id	=	$_REQUEST['personal_id'];
		$data 	= 	array('info1' => get_addition_all_info1($personal_id));
	
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

function Addincomming($c_date, $id_p, $phone, $person_name, $type, $results_id, $information_category_id, $information_sub_category_id, $content_id, $product_id,  $forward_id, $connect, $results_comment, $content, $task_type_id, $task_department_id, $persons_id, $comment, $call_vote, $source_id){

	$user		= $_SESSION['USERID'];
	
	mysql_query("INSERT INTO `incomming_call` 
			(`id`, `user_id`, `date`, `phone`, `name`, `type`, `information_category_id`, `information_sub_category_id`, `product_id`, `source_id`, `content`, `results_id`, `results_comment`, `content_id`, `connect`, `forward_id`, `call_vote`, `actived`)
			 VALUES 
			('$id_p', '$user', '$c_date', '$phone', '$person_name', '$type', '$information_category_id', '$information_sub_category_id', '$product_id', '$source_id', '$content', '$results_id', '$results_comment', '$content_id', '$connect', '$forward_id', '$call_vote', '1')");
	
	GLOBAL $log;
	$log->setInsertLog('incomming_call');
	
	$personal_phone			= $_REQUEST['personal_phone'];
	$personal_id			= $_REQUEST['personal_id'];
	$personal_contragent	= $_REQUEST['personal_contragent'];
	$personal_mail			= $_REQUEST['personal_mail'];
	$personal_addres		= $_REQUEST['personal_addres'];
	$personal_status		= $_REQUEST['personal_status'];

	
	mysql_query("INSERT INTO `personal_info`
	( `user_id`, `incomming_call_id`, `personal_phone`, `personal_id`, `personal_contragent`, `personal_mail`, `personal_addres`, `personal_status`)
	VALUES
	( '$user', '$id_p', '$personal_phone', '$personal_id', '$personal_contragent', '$personal_mail', '$personal_addres', '$personal_status')");
	
	

}

				
function Saveincomming($c_date, $id_p, $phone, $person_name, $type, $results_id, $information_category_id, $information_sub_category_id, $content_id, $product_id,  $forward_id, $connect, $results_comment, $content, $task_type_id, $task_department_id, $persons_id, $comment, $call_vote, $source_id)
{
	GLOBAL $log;
	$log->setUpdateLogBefore('incomming_call', $id_p);
	$user		= $_SESSION['USERID'];
	mysql_query("UPDATE  `incomming_call` 
				SET  
						 `user_id`						='$user', 
						 `date`							='$c_date',
						 `phone`						='$phone', 
						 `name`							='$person_name',
						 `type`							='$type',
						 `information_category_id`		='$information_category_id', 
						 `information_sub_category_id`	='$information_sub_category_id',
						 `product_id`					='$product_id',
						 `source_id`					='$source_id',
						 `content`						='$content', 
						 `results_id`					='$results_id',
						 `results_comment`				='$results_comment',
						 `content_id`					='$content_id',
						 `connect`						='$content',
						 `forward_id`					='$forward_id',
						 `call_vote`					='$call_vote',
						 `actived`						='1'
			    WHERE    `id`							='$id_p'
							");
	
	$log->setUpdateLogAfter('incomming_call', $id_p);
	
	$personal_phone			= $_REQUEST['personal_phone'];
	$personal_id			= $_REQUEST['personal_id'];
	$personal_contragent	= $_REQUEST['personal_contragent'];
	$personal_mail			= $_REQUEST['personal_mail'];
	$personal_addres		= $_REQUEST['personal_addres'];
	$personal_status		= $_REQUEST['personal_status'];
	
	mysql_query("UPDATE  `personal_info`
				SET
						`user_id`					='$user',
						`personal_phone`			='$personal_phone',
						`personal_contragent`		='$personal_contragent',
						`personal_mail`				='$personal_mail',
						`personal_addres`			='$personal_addres',
						`personal_addres`			='$personal_addres',
						`personal_status`			='$personal_status'
				WHERE   `incomming_call_id`			='$id_p'
				");

}

function Sendmail($c_date,$phone,$results_id,$results_comment,$content,$product_id,$call_vote)
{
	$to      = 'dpapalashvili@yahoo.com';
	$subject = 'the subject';
	$vote = '';
	if($call_vote == 1){
		$vote = 'პოზიტიური';
	}elseif($call_vote == 2){
		$vote = 'ნეიტრალური';
	}elseif($call_vote == 3){
		$vote = 'ნეგატიური';
	}
	
	$res_results = mysql_fetch_assoc($req = mysql_query("	SELECT 	`name`
															FROM 	`results`
															WHERE 	`id` = $results_id
															"));
	
	$res_prduct = mysql_fetch_assoc($req = mysql_query("	SELECT 	`name`
															FROM 	`product`
															WHERE 	`id` = $product_id
															"));

	
	$message = 	'
				<table>
					<tr>
						<td style="width:20px;"></td>
						<td style="width:100px;"><b>თარიღი</b></td>
						<td style="width:60%;">'.$c_date.'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>დრო</b></td>
						<td>'.date($c_date, "h:i").'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>ტელეფონი</b></td>
						<td>'.$phone.'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>შედეგი</b></td>
						<td>'.$res_results['name'].'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>შედეგის კომენტარი</b></td>
						<td>'.$results_comment.'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>კომენტარი</b></td>
						<td>'.$content.'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>პროდუქტი</b></td>
						<td>'.$res_prduct['name'].'</td>
					</tr>
					<tr>
						<td></td>
						<td><b>ფიო</b></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td><b>ზარის შეფასება</b></td>
						<td></td>
					</tr>
				</table>
				';
	
	
	$headers = 	'From: info@gsunity.ge' . "\r\n" .
				'Reply-To: info@gsunity.ge' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
	
	
	mail($to, $subject, $message, $headers);
}

function Getcall_status($status)
{
	$data = '';
	$req = mysql_query("SELECT 	`id`, `call_status`
						FROM 	`status`
						WHERE 	actived=1");
	

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		
		if($res['id'] == $status){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['call_status'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['call_status'] . '</option>';
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


function Getdepartment($task_department_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
					    FROM `department`
					    WHERE actived=1 ");
	

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $task_department_id){
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

function Gettask_type($task_type_id)
{
	$data = '';
	$req = mysql_query("SELECT `id`, `name`
					    FROM `task_type`
					    WHERE actived=1 ");

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


function Getpersons($persons_id)
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

function getCalls(){
	$db1 = new sql_db ( "212.72.155.176", "root", "Gl-1114", "asteriskcdrdb" );

	$req = mysql_query("

						SELECT  	DISTINCT
									IF(SUBSTR(cdr.src, 1, 3) = 995, SUBSTR(cdr.src, 4, 9), cdr.src) AS `src`
						FROM    	cdr
						GROUP BY 	cdr.src
						ORDER BY 	cdr.calldate DESC
						LIMIT 		12


						");

	$data = '<tr class="trClass">
					<th class="thClass">#</th>
					<th class="thClass">ნომერი</th>
					<th class="thClass">ქმედება</th>
				</tr>
			';
	$i	= 1;
	while( $res3 = mysql_fetch_assoc($req)){

		$data .= '
	    		<tr class="trClass">
					<td class="tdClass">' . $i . '</td>
					<td class="tdClass" style="width: 30px !important;">' . $res3['src'] . '</td>
					<td class="tdClass" style="font-size: 13px !important;"><button class="insert" number="' . $res3['src'] . '">დამატება</button></td>
				</tr>';
		$i++;
	}

	return $data;


}

function get_addition_all_info($pin)
{
	$res1 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.pin = $pin AND incomming_call.call_type_id = 1 AND (task.`status` = 3 OR ISNULL(task.`status`))"));
	
	$res2 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a1`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.pin = $pin AND incomming_call.call_type_id = 2 AND (task.`status` = 3 OR ISNULL(task.`status`))"));
	
	$res3 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a2`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.pin = $pin AND incomming_call.call_type_id = 1 AND (task.`status` != 3 AND NOT ISNULL(task.`status`))"));
	
	$res4 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a3`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.pin = $pin AND incomming_call.call_type_id = 2 AND (task.`status` != 3 AND NOT ISNULL(task.`status`))"));
	
	$sum_incomming	 	= $res1['a'] + $res2['a1'] + $res3['a2'] + $res4['a3'];
	$sum_end	 		= $res1['a'] + $res2['a1'];
	$sum_actived		= $res3['a2'] + $res4['a3'];
	
	$data .= '<fieldset>
					<legend>მომართვების ისტორია</legend>
					<table>
						<tr>
							<td>სულ</td>
							<td></td>
							<td></td>
							<td style="width: 150px;"></td>
							<td>'.$sum_incomming.'</td>
						</tr>
						<tr>
							<td></td>
							<td>მოგვარებულები</td>
							<td></td>
							<td style="width: 150px;"></td>
						    <td>'.$sum_end.'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>პრეტენზია</td>
							<td style="width: 150px;"></td>
							<td>'. $res1['a'].'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>ინფორმაცია</td>
							<td style="width: 150px;"></td>
							<td>'.$res2['a1'].'</td>
						</tr>
						<tr>
							<td></td>
							<td>პრეტენზია</td>
							<td></td>
							<td style="width: 150px;"></td>
							<td>'.$sum_actived.'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>პრეტენზია</td>
							<td style="width: 150px;"></td>
							<td>'.$res3['a2'].'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>ინფორმაცია</td>
							<td style="width: 150px;"></td>
							<td>'. $res4['a3'].'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td style="width: 150px;"></td>
				    		<td style="width: 300px;">
							<input type="button" value="ვრცლად"/>
		      				</td>
						</tr>
					</table>
				</fieldset>';

	return $data;
}
function get_addition_all_info1($personal_id)
{
	$res1 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.personal_id = $personal_id AND incomming_call.call_type_id = 1 AND (task.`status` = 3 OR ISNULL(task.`status`))"));

	$res2 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.personal_id = $personal_id AND incomming_call.call_type_id = 2 AND (task.`status` = 3 OR ISNULL(task.`status`))"));

	$res3 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.personal_id = $personal_id AND incomming_call.call_type_id = 1 AND (task.`status` != 3 AND NOT ISNULL(task.`status`))"));

	$res4 = mysql_fetch_assoc(mysql_query("	SELECT COUNT(*) AS `a`
											FROM 			`site_user`
											JOIN 			incomming_call ON site_user.incomming_call_id = incomming_call.id
											LEFT JOIN 		task ON incomming_call.id = task.incomming_call_id
											WHERE 			site_user.personal_id = $personal_id AND incomming_call.call_type_id = 2 AND (task.`status` != 3 AND NOT ISNULL(task.`status`))"));

	$sum_incomming	 	= $res1['a'] + $res2['a'] + $res3['a'] + $res4['a'];
	$sum_end	 		= $res1['a'] + $res2['a'];
	$sum_actived		= $res3['a'] + $res4['a'];

	$data .= '<fieldset>
					<legend>მომართვების ისტორია</legend>
					<table>
						<tr>
							<td>სულ</td>
							<td></td>
							<td></td>
							<td style="width: 150px;"></td>
							<td>'.$sum_incomming.'</td>
						</tr>
						<tr>
							<td></td>
							<td>მოგვარებულები</td>
							<td></td>
							<td style="width: 150px;"></td>
						    <td>'.$sum_end.'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>პრეტენზია</td>
							<td style="width: 150px;"></td>
							<td>'. $res1['a'].'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>ინფორმაცია</td>
							<td style="width: 150px;"></td>
							<td>'.$res2['a'].'</td>
						</tr>
						<tr>
							<td></td>
							<td>პრეტენზია</td>
							<td></td>
							<td style="width: 150px;"></td>
							<td>'.$sum_actived.'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>პრეტენზია</td>
							<td style="width: 150px;"></td>
							<td>'.$res3['a'].'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>ინფორმაცია</td>
							<td style="width: 150px;"></td>
							<td>'. $res4['a'].'</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td style="width: 150px;"></td>
				    		<td style="width: 300px;">
							<input type="button" value="ვრცლად"/>
		      				</td>
						</tr>
					</table>
				</fieldset>';

	return $data;
}

function Getinformation_category($information_category_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	info_category 
							WHERE 	parent_id = '0'	AND `actived` = 1");
	
	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $information_category_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}
	
	return $data;
}

function Getinformation_sub_category($information_sub_category_id,$information_category_id_check){
	$req = mysql_query("	SELECT 	n1.`id`,
									n1.`name`
							FROM 	info_category
							JOIN 	info_category as n1 ON info_category.id = n1.parent_id
							WHERE 	info_category.id = $information_category_id_check AND n1.`actived` = 1");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $information_sub_category_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getcontent($content_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	content
							WHERE `actived` = 1
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $content_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getproduct($product_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	product
							WHERE `actived` = 1
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $product_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getforward($forward_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	forward
							WHERE `actived` = 1
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $forward_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getresults($results_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	results
							WHERE `actived` = 1
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $results_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getsource($source_id){
	$req = mysql_query("	SELECT 	`id`,
									`name`
							FROM 	source
							");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){
		if($res['id'] == $source_id){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		} else {
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}

	return $data;
}

function Getincomming($incom_id)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT    	incomming_call.id AS id,
														incomming_call.phone AS `phone`,
														DATE_FORMAT(incomming_call.`date`,'%d-%m-%y %H:%i:%s') AS call_date,
														incomming_call.`name`,
														incomming_call.type,
														incomming_call.information_category_id,
														incomming_call.information_sub_category_id,
														incomming_call.product_id,
														incomming_call.source_id,
														incomming_call.content,
														incomming_call.results_id,
														incomming_call.results_comment,
														incomming_call.content_id,
														incomming_call.connect,
														incomming_call.forward_id,
														incomming_call.call_vote,
														personal_info.personal_phone,
														personal_info.personal_id,
														personal_info.personal_contragent,
														personal_info.personal_mail,
														personal_info.personal_addres,
														personal_info.personal_status
												FROM 	incomming_call
												JOIN	personal_info ON incomming_call.id = personal_info.incomming_call_id
												where   incomming_call.id = $incom_id
														" ));
	return $res;
}

function GetPage($res='', $number)
{
	$c_date		= date('Y-m-d H:i:s');
	
	$num = 0;
	if($res[phone]==""){
		$num=$number;
	}else{ 
		$num=$res[phone]; 
	}
	
	$data  .= '
	<div id="dialog-form">
			<div style="float: left; width: 970px;">	
			
				<div id="dt_example" class="inner-table">
			        <div style="width:100%;" id="container" >        	
			            <div id="dynamic">
			                <table class="" id="all_sell" style="width: 100%;">
			                    <thead>
									<tr  id="datatable_header">
											
			                           <th style="display:none">ID</th>
										<th style="width:4%;">#</th>
										<th style="">თარიღი</th>
										<th style="">მომხმარებელი</th>
										<th style="">ტელეფონი</th>
										<th style="">პირადი №</th>
										<th style="">ელ-ფოსტა</th>
										<th style="">წიგნები</th>
										<th style="">ფასი</th>
										<th style="">ოპერატორი</th>
									</tr>
								</thead>
								<thead>
									<tr class="search_header">
										<th class="colum_hidden">
	                            			<input type="text" name="search_id" value="" class="search_init" style="width: 10px"/>
	                            		</th>
										<th>
											<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
										</th>
										<th>
											<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
										</th>
									</tr>
								</thead>
			                </table>
			            </div>
			            <div class="spacer">
			            </div>
			        </div>
			</div>
    </div>';

	return $data;
}

function GetRecordingsSection($res)
{
	$db2 = new sql_db ( "localhost", "root", "Gl-1114", "asteriskcdrdb" );

	$req = mysql_query("SELECT  TIME(`calldate`) AS 'time',
			`userfield`
			FROM     `cdr`
			WHERE     (`dst` = 2470017 && `userfield` != '' && DATE(`calldate`) = '$res[date]' && `src` LIKE '%$res[phone]%')
			OR      (`dst` LIKE '%$res[phone]%' && `userfield` != '' && DATE(`calldate`) = '$res[date]');");

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
		$src = $res2['userfield'];
		$link = explode("/", $src);
		$data .= '
                <tr style="border-bottom: solid 1px #85b1de; height: 20px;">
                    <td>' . $res2['time'] . '</td>
                    <td><button class="download" str="' . $link[5] . '">მოსმენა</button></td>
                </tr>';
	}

	$data .= '
            </table>
        </fieldset>';

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