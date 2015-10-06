<?php
// MySQL Connect Link
require_once('../../includes/classes/core.php');
 
// Main Strings
$action                     = $_REQUEST['act'];
$error                      = '';
$data                       = '';
$user_id	                = $_SESSION['USERID'];
$open_number                = $_REQUEST['open_number'];
$queue                      = $_REQUEST['queue'];
$scenario_id                = $_REQUEST['scenario_id'];
 
// Incomming Call Dialog Strings
$hidden_id                  = $_REQUEST['id'];
$incomming_id               = $_REQUEST['incomming_id'];
$incomming_date             = $_REQUEST['incomming_date'];
$incomming_phone            = $_REQUEST['incomming_phone'];
$incomming_cat_1            = $_REQUEST['incomming_cat_1'];
$incomming_cat_1_1          = $_REQUEST['incomming_cat_1_1'];
$incomming_cat_1_1_1        = $_REQUEST['incomming_cat_1_1_1'];
$incomming_comment          = $_REQUEST['incomming_comment'];


$client_status              = $_REQUEST['client_status'];
$client_person_number       = $_REQUEST['client_person_number'];
$client_person_lname        = $_REQUEST['client_person_lname'];
$client_person_fname        = $_REQUEST['client_person_fname'];
$client_person_phone1       = $_REQUEST['client_person_phone1'];
$client_person_phone2       = $_REQUEST['client_person_phone2'];
$client_person_mail1        = $_REQUEST['client_person_mail1'];
$client_person_mail2        = $_REQUEST['client_person_mail2'];
$client_person_addres1      = $_REQUEST['client_person_addres1'];
$client_person_addres2      = $_REQUEST['client_person_addres2'];
$client_person_note         = $_REQUEST['client_person_note'];

$client_number              = $_REQUEST['client_number'];
$client_name                = $_REQUEST['client_name'];
$client_phone1              = $_REQUEST['client_phone1'];
$client_phone2              = $_REQUEST['client_phone2'];
$client_mail1               = $_REQUEST['client_mail1'];
$client_mail2               = $_REQUEST['client_mail2'];
$client_note                = $_REQUEST['client_note'];
$client_addres1             = $_REQUEST['client_addres1'];
$client_addres2             = $_REQUEST['client_addres2'];

switch ($action) {
	case 'get_add_page':
		$page		= GetPage('',increment(incomming_call));
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(Getincomming($hidden_id,$open_number),'',$open_number,$queue);
		$data		= array('page'	=> $page);

		break;
    case 'next_quest':
        $page 		= next_quest($hidden_id, $_REQUEST[next_id]);
        $data		= array('ne_id'	=> $page);
    
        break;
	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
	  	$rResult = mysql_query("SELECT 	incomming_call.id,
                        				incomming_call.id,
                        				incomming_call.date,
                        				incomming_call.phone,
                        				IF(personal_info.client_person_fname!='',personal_info.client_person_fname,personal_info.client_name) AS `name`,
                        				cat_1.`name` AS `cat_1`,
                        				cat_1_1.`name` AS `cat_1_1`,
                        				cat_1_1_1.`name` AS `cat_1_1_1`,
                        				`comment`
                                FROM 	`incomming_call`
                                LEFT JOIN	info_category AS cat_1 ON incomming_call.cat_1 = cat_1.id
                                LEFT JOIN	info_category AS cat_1_1 ON incomming_call.cat_1_1 = cat_1_1.id
                                LEFT JOIN	info_category AS cat_1_1_1 ON incomming_call.cat_1_1_1 = cat_1_1_1.id
                                LEFT JOIN personal_info ON incomming_call.id = personal_info.incomming_call_id");
	  
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
    case 'send_sms':
        $page		= GetSmsSendPage();
        $data		= array('page'	=> $page);
    
        break;
    case 'cat_2':
        $page		= get_cat_1_1($_REQUEST['cat_id'],'');
        $data		= array('page'	=> $page);
    
        break;
    case 'cat_3':
        $page		= get_cat_1_1_1($_REQUEST['cat_id'],'');
        $data		= array('page'	=> $page);
    
        break;
    case 'send_mail':
        $page		= GetMailSendPage();
        $data		= array('page'	=> $page);
    
        break;
    case 'save_incomming':
        if($hidden_id == ''){
            incomming_insert($user_id,$incomming_id,$incomming_date,$incomming_phone,$incomming_cat_1,$incomming_cat_1_1,$incomming_cat_1_1_1,$incomming_comment,$client_status,$client_person_number,$client_person_lname,$client_person_fname,$client_person_phone1,$client_person_phone2,$client_person_mail1,$client_person_mail2,$client_person_addres1,$client_person_addres2,$client_person_note,$client_number,$client_name,$client_phone1,$client_phone2,$client_mail1,$client_mail2,$client_note,$scenario_id,$client_addres1,$client_addres2);
        }else{
            incomming_update($user_id,$hidden_id,$incomming_phone,$incomming_cat_1,$incomming_cat_1_1,$incomming_cat_1_1_1,$incomming_comment,$client_status,$client_person_number,$client_person_lname,$client_person_fname,$client_person_phone1,$client_person_phone2,$client_person_mail1,$client_person_mail2,$client_person_addres1,$client_person_addres2,$client_person_note,$client_number,$client_name,$client_phone1,$client_phone2,$client_mail1,$client_mail2,$client_note,$client_addres1,$client_addres2);
        }
        $checker     = json_decode($_REQUEST[checker]);
        $input       = json_decode($_REQUEST[input]);
        $radio       = json_decode($_REQUEST[radio]);
        $date        = json_decode($_REQUEST[date]);
        $date_time   = json_decode($_REQUEST[date_time]);
        $select_op   = json_decode($_REQUEST[select_op]);
        
        if($hidden_id == ''){
            $inc_id = $incomming_id;
        }else{
            $inc_id = $hidden_id;
        }
        
        mysql_query("DELETE FROM scenario_results
                     WHERE incomming_call_id=$inc_id;");
        foreach ($checker as $key => $value) {
            
            $quest_id = str_replace("checkbox","",$key);            
            $val = substr($value,10);
            $last =  preg_split("/[\s,^]+/",$val);
            foreach($last as $answer){               
                mysql_query("INSERT INTO `scenario_results` 
                            (`user_id`, `incomming_call_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
                            VALUES
                            ('$user_id', '$inc_id', '1', '$quest_id', '$answer', NULL)");
            }
        }
        
        foreach ($radio as $key => $value) {
			    $quest_id = str_replace("radio","",$key);            
                $val = substr($value,10);
                $last =  preg_split("/[\s,^]+/",$val);
			    mysql_query("INSERT INTO `scenario_results` 
                            (`user_id`, `incomming_call_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
                            VALUES
                            ('$user_id', '$inc_id', '1', '$quest_id', '$last[0]', NULL)");
		}
        
		foreach ($input as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
                         (`user_id`, `incomming_call_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
                         VALUES
                         ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
		
		foreach ($date as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
		        (`user_id`, `incomming_call_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
		        VALUES
		        ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
		
		foreach ($date_time as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
		        (`user_id`, `incomming_call_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
		        VALUES
		        ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
		
		foreach ($select_op as $key => $value) {
		    $var               = preg_split("/[\s,|]+/",$key);
		    $val               = substr($value,10);
		    $quest_id          = $var[1];
		    $answer_id         = $var[2];
		    mysql_query("INSERT INTO `scenario_results`
		        (`user_id`, `incomming_call_id`, `scenario_id`, `question_id`, `question_detail_id`, `additional_info`)
		        VALUES
		        ('$user_id', '$inc_id', '1', '$quest_id', '$answer_id', '$val')");
		}
            
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

function incomming_insert($user_id,$incomming_id,$incomming_date,$incomming_phone,$incomming_cat_1,$incomming_cat_1_1,$incomming_cat_1_1_1,$incomming_comment,$client_status,$client_person_number,$client_person_lname,$client_person_fname,$client_person_phone1,$client_person_phone2,$client_person_mail1,$client_person_mail2,$client_person_addres1,$client_person_addres2,$client_person_note,$client_number,$client_name,$client_phone1,$client_phone2,$client_mail1,$client_mail2,$client_note,$scenario_id,$client_addres1,$client_addres2){
    mysql_query("INSERT INTO    `incomming_call` 
                 (`id`,`user_id`,`date`,`phone`,`cat_1`,`cat_1_1`,`cat_1_1_1`,`comment`,`scenario_id`)
                 VALUES
                 ('$incomming_id','$user_id','$incomming_date','$incomming_phone','$incomming_cat_1','$incomming_cat_1_1','$incomming_cat_1_1_1','$incomming_comment','$scenario_id')");
    
    mysql_query("INSERT INTO `personal_info` 
                 (`user_id`, `incomming_call_id`, `client_person_number`, `client_person_lname`, `client_person_fname`, `client_person_phone1`, `client_person_phone2`, `client_person_mail1`, `client_person_mail2`, `client_person_note`, `client_person_addres1`, `client_person_addres2`, `client_number`, `client_name`, `client_phone1`, `client_phone2`, `client_mail1`, `client_mail2`, `client_city1`, `client_city2`, `client_addres1`, `client_addres2`, `client_index1`, `client_index2`, `client_note`)
                 VALUES
                 ('$user_id', '$incomming_id', '$client_person_number', '$client_person_lname', '$client_person_fname', '$client_person_phone1', '$client_person_phone2', '$client_person_mail1', '$client_person_mail2', '$client_person_note', '$client_person_addres1', '$client_person_addres2', '$client_number', '$client_name', '$client_phone1', '$client_phone2', '$client_mail1', '$client_mail2', '', '', '$client_addres1', '$client_addres2', '', '', '$client_note');");
}

function incomming_update($user_id,$hidden_id,$incomming_phone,$incomming_cat_1,$incomming_cat_1_1,$incomming_cat_1_1_1,$incomming_comment,$client_status,$client_person_number,$client_person_lname,$client_person_fname,$client_person_phone1,$client_person_phone2,$client_person_mail1,$client_person_mail2,$client_person_addres1,$client_person_addres2,$client_person_note,$client_number,$client_name,$client_phone1,$client_phone2,$client_mail1,$client_mail2,$client_note,$client_addres1,$client_addres2){
    mysql_query("UPDATE `incomming_call` SET 
                        `user_id`='$user_id',
                        `phone`='$incomming_phone',
                        `cat_1`='$incomming_cat_1',
                        `cat_1_1`='$incomming_cat_1_1',
                        `cat_1_1_1`='$incomming_cat_1_1_1',
                        `comment`='$incomming_comment'
                 WHERE  `id`='$hidden_id'");
    
    mysql_query("UPDATE `personal_info` SET
                        `user_id`='$user_id',
                        `client_person_number`='$client_person_number',
                        `client_person_lname`='$client_person_lname',
                        `client_person_fname`='$client_person_fname',
                        `client_person_phone1`='$client_person_phone1',
                        `client_person_phone2`='$client_person_phone2',
                        `client_person_mail1`='$client_person_mail1',
                        `client_person_mail2`='$client_person_mail2',
                        `client_person_note`='$client_person_note',
                        `client_person_addres1`='$client_person_addres1',
                        `client_person_addres2`='$client_person_addres2',
                        `client_number`='$client_number',
                        `client_name`='$client_name',
                        `client_phone1`='$client_phone1',
                        `client_phone2`='$client_phone2',
                        `client_mail1`='$client_mail1',
                        `client_mail2`='$client_mail2',
                        `client_city1`=NULL,
                        `client_city2`=NULL,
                        `client_addres1`='$client_addres1',
                        `client_addres2`='$client_addres2',
                        `client_index1`=NULL,
                        `client_index2`=NULL,
                        `client_note`='$client_note'
                WHERE   `incomming_call_id`='$hidden_id'");
}

function get_cat_1($id){
    $req = mysql_query("  SELECT  `id`,
                                  `name`
                          FROM `info_category`
                          WHERE actived = 1 AND `parent_id` = 0");
    
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

function get_cat_1_1($id,$child_id){
    $req = mysql_query("  SELECT  `id`,
                                  `name`
                          FROM `info_category`
                          WHERE actived = 1 AND `parent_id` = $id");
    
    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $child_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }
    
    return $data;
}
function get_cat_1_1_1($id,$child_id){
    $req = mysql_query("  SELECT  `id`,
                                  `name`
                          FROM `info_category`
                          WHERE actived = 1 AND `parent_id` = $id");
    
    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $child_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }
    
    return $data;
}

function Getincomming($hidden_id,$open_number)
{
    if($hidden_id == ''){
        $filter = "incomming_call.`phone` = '$open_number' AND DATE(incomming_call.date) = DATE(NOW())";
    }else{
        $filter = "incomming_call.id =  $hidden_id";
    }

	$res = mysql_fetch_assoc(mysql_query("SELECT    incomming_call.id AS id,
                                    				incomming_call.`date` AS call_date,
                                    				DATE_FORMAT(incomming_call.`date`,'%y-%m-%d') AS `date`,
                                    				incomming_call.`phone`,
                                    				incomming_call.cat_1,
                                    				incomming_call.cat_1_1,
                                    				incomming_call.cat_1_1_1,
                                    				incomming_call.`comment`,
                                    				personal_info.`client_person_number`,
                                    				personal_info.`client_person_lname`,
                                    				personal_info.`client_person_fname`,
                                    				personal_info.`client_person_phone1`,
                                    				personal_info.`client_person_phone2`,
                                    				personal_info.`client_person_mail1`,
                                    				personal_info.`client_person_mail2`,
                                    				personal_info.`client_person_note`,
	                                                personal_info.`client_person_addres1`,
	                                                personal_info.`client_person_addres2`,
                                    				personal_info.`client_number`,
                                    				personal_info.`client_name`,
                                    				personal_info.`client_phone1`,
                                    				personal_info.`client_phone2`,
                                    				personal_info.`client_mail1`,
                                    				personal_info.`client_mail2`,
	                                                personal_info.`client_addres1`,
	                                                personal_info.`client_addres2`,
	                                                incomming_call.scenario_id AS `inc_scenario_id`,
                                    				personal_info.`client_note`
                                        FROM 	   incomming_call
                                        LEFT JOIN  personal_info ON incomming_call.id = personal_info.incomming_call_id
                                        WHERE      $filter
                                	    ORDER BY incomming_call.id DESC
                                        LIMIT 1"));
	return $res;
}

function GetPage($res,$increment,$open_number,$queue)
{
    echo $increment;
    if($increment == '' && $res == ''){
        $increment = increment(incomming_call);
    }
    $rr = mysql_fetch_array(mysql_query("SELECT scenario_id FROM queue WHERE number = '$queue'"));
	$data  .= '
	<div id="dialog-form">
	    <fieldset style="width: 430px;  float: left;">
	       <legend>ძირითადი ინფორმაცია</legend>
	       <input id="scenario_id" type="hidden" value="'.$rr[0].'" />
	       <table class="dialog-form-table">
	           <tr>
	               <td>დამფორმირებელი : </td>
            	   <td></td>
            	   <td></td>
	           </tr>
    	       <tr>
	               <td style="width: 150px;"><label for="incomming_id">მომართვის №</label></td>
	               <td style="width: 150px;"><label for="incomming_date">თარიღი</label></td>
	               <td><label for="incomming_phone">ტელეფონი</td>
    	       </tr>
	           <tr>
	               <td><input style="width: 110px;" id="incomming_id" type="text" value="'.(($res['id']=='')?$increment:$res['id']).'"></td>
	               <td><input style="width: 125px;" id="incomming_date" type="text" value="'.(($res['call_date']=='')?date("Y-m-d H:i:s"):$res['call_date']).'"></td>
	               <td><input style="width: 110px;" id="incomming_phone" type="text" value="'.$res['phone'].'"></td>
    	       </tr>
	       </table>
	       <table class="dialog-form-table">
	           <tr>
	               <td><label for="incomming_cat_1">კატეგორია 1</label></td>
	           </tr>
	           <tr>
	               <td><select id="incomming_cat_1" style="width: 420px;">'.get_cat_1($res['cat_1']).'</select></td>
	           </tr>
	           <tr>
	               <td><label for="incomming_cat_1_1">კატეგორია 1.1</label></td>
	           </tr>
	           <tr>
	               <td><select id="incomming_cat_1_1" style="width: 420px;">'.get_cat_1_1($res['cat_1'],$res['cat_1_1']).'</select></td>
	           </tr>
	           <tr>
	               <td><label for="incomming_cat_1_1_1">კატეგორია 1.1.1</label></td>
    	       </tr>
	           <tr>
	               <td><select id="incomming_cat_1_1_1" style="width: 420px;">'.get_cat_1_1_1($res['cat_1_1'],$res['cat_1_1_1']).'</select></td>
    	       </tr>
	       </table>
	       <table class="dialog-form-table">
	           <tr>
	               <td><label for="incomming_comment">დამატებითი ინფორმაცია</label></td>
	           </tr>
	           <tr>
	               <td><textarea id="incomming_comment" style="resize: vertical;width: 415px;height: 149px;">'.$res['comment'].'</textarea></td>
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
                <table>
                    <tr style="height:20px;">
                    	<td style="padding: 0px 0px 10px 110px;"><input type="radio" style="float:left;" onclick="client_status(\'pers\')" value="1" name="client_status" checked><span style="display: inline-block; margin: 8px;">ფიზიკური </span></td>
                    	<td style="height:20px;"><input type="radio" style="float:left;" onclick="client_status(\'iuri\')" value="2" name="client_status"><span style="display: inline-block; margin: 8px;">იურიდიული </span></td>
                    </tr>
                </table>
	    
        	    <div id="pers">
	               <table class="margin_top_10">
                           <tr>
                               <td><label for="client_person_number">პირადი ნომერი</label></td>
                               
                           </tr>
                           <tr>
                               <td><input style="width: 580px;" id="client_person_number" type="text" value="'.$res['client_person_number'].'"></td>
                                  
                           </tr>
                        </table>
                        <table class="margin_top_10">
                            <tr>
                                <td style="width: 328px;"><label for="client_lname">სახელი</label></td>
	                            <td><label for="client_person_fname">გვარი</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_lname" type="text" value="'.$res['client_person_lname'].'"></td>
	                            <td><input style="width: 250px;" id="client_person_fname" type="text" value="'.$res['client_person_fname'].'"></td>
                            </tr>
                        </table>
                        <table class="margin_top_10">
                            <tr>
                                <td style="width: 328px;"><label for="client_person_phone1">ტელეფონი 1</label></td>
        	                    <td><label for="client_person_phone2">ტელეფონი 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_phone1" type="text" value="'.$res['client_person_phone1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_person_phone2" type="text" value="'.$res['client_person_phone2'].'"></td>
                            </tr>
    	                    <tr>
                                <td style="width: 328px;"><label for="client_person_mail1">ელ-ფოსტა 1</label></td>
        	                    <td><label for="client_person_mail2">ელ-ფოსტა 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_mail1" type="text" value="'.$res['client_person_mail1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_person_mail2" type="text" value="'.$res['client_person_mail2'].'"></td>
                            </tr>
	                        <tr>
                                <td style="width: 328px;"><label for="client_person_addres1">მისამართი 1</label></td>
        	                    <td><label for="client_person_addres2">მისამართი 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_addres1" type="text" value="'.$res['client_person_addres1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_person_addres2" type="text" value="'.$res['client_person_addres2'].'"></td>
                            </tr>
                        </table>                	    
    	                <table class="margin_top_10">
        	                <tr>
        	                    <td><label for="client_person_note">შენიშვნა</label></td>
        	                </tr>
        	                <tr>
        	                    <td><textarea id="client_person_note" style="resize: vertical;width: 577px;">'.$res['client_person_note'].'</textarea></td>
        	                </tr>
    	                </table>
        	    </div>
	    
	            <div id="iuri" style="border: 1px solid #ccc;padding: 5px;margin-top: 20px;display:none;">
        	       <span class="client_main" onclick="show_main(\'client_main\',this)" style="border: 1px solid #ccc;border-bottom: 1px solid #F9F9F9;cursor: pointer;margin-top: -30px;margin-left: -6px;display: block;width: 100px;padding: 5px;text-align: center;">ძირითადი</span>
	               <span class="client_other" onclick="show_main(\'client_other\',this)" style="cursor: pointer;margin-top: -25px;margin-left: 108px;display: block;width: 125px;padding: 6px;text-align: center;">წარმომადგენელი</span>
	    
	               <div id="client_main">
                        <table class="margin_top_10">
                           <tr>
                               <td><label for="client_number">საიდენტ. ნომერი</label></td>
                               <td></td>
                           </tr>
                           <tr>
                               <td><input style="width: 483px;" id="client_number" type="text" value="'.$res['client_number'].'"></td>
                               <td><button id="client_checker" style="margin-left: 5px;">შემოწმება</button></td>
                           </tr>
                        </table>
                        <table class="margin_top_10">
                            <tr>
                                <td><label for="client_name">დასახელება</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 565px;" id="client_name" type="text" value="'.$res['client_name'].'"></td>
                            </tr>
                        </table>
                        <table class="margin_top_10">
                            <tr>
                                <td style="width: 312px;"><label for="client_phone1">ტელეფონი 1</label></td>
        	                    <td><label for="client_phone2">ტელეფონი 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_phone1" type="text" value="'.$res['client_phone1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_phone2" type="text" value="'.$res['client_phone2'].'"></td>
                            </tr>
    	                    <tr>
                                <td style="width: 312px;"><label for="client_mail1">ელ-ფოსტა 1</label></td>
        	                    <td><label for="client_mail2">ელ-ფოსტა 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_mail1" type="text" value="'.$res['client_mail1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_mail2" type="text" value="'.$res['client_mail2'].'"></td>
                            </tr>
        	                <tr>
                                <td style="width: 312px;"><label for="client_addres1">მისამართი 1</label></td>
        	                    <td><label for="client_person_addres2">მისამართი 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_addres1" type="text" value="'.$res['client_addres1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_addres2" type="text" value="'.$res['client_addres2'].'"></td>
                            </tr>
                        </table>
                	    <fieldset style="display:block !important;margin-left: 1px;width: 170px;margin-left: 215px;">
                                <legend>ფაქტიური</legend>
                                <table>
                                <tr>
                                    <td><label for="client_city2">ქალაქი/რაიონი</label></td>
                                </tr>
	                            <tr>
                                    <td><select id="client_city2"></select></td>
                                </tr>
	                            <tr>
                                    <td><label for="client_addres2">მისამართი</label></td>
                                </tr>
	                            <tr>
                                    <td><input id="client_addres2" type="text" value="" style="width: 160px;"></td>
                                </tr>
	                            <tr>
                                    <td><label for="client_index2">საფოსტო ინდექი</label></td>
                                </tr>
	                            <tr>
                                    <td><input id="client_index2" type="text" value="" style="width: 160px;"></td>
                                </tr>
                                </table>
                	    </fieldset>
    	               <table class="margin_top_10">
        	               <tr>
        	                   <td><label for="client_note">შენიშვნა</label></td>
        	               </tr>
        	               <tr>
        	                   <td><textarea id="client_note" style="resize: vertical;width: 565px;">'.$res['client_note'].'</textarea></td>
        	               </tr>
    	               </table>
	               </div>
	    
	               <div id="client_other" style="display:none;">
	                   <table class="margin_top_10">
                           <tr>
                               <td><label for="client_person_number">პირადი ნომერი</label></td>
                               
                           </tr>
                           <tr>
                               <td><input style="width: 565px;" id="client_person_number" type="text" value="'.$res['client_person_number'].'"></td>
                               
                           </tr>
                        </table>
                        <table class="margin_top_10">
                            <tr>
                                <td style="width: 312px;"><label for="client_lname">სახელი</label></td>
	                            <td><label for="client_person_fname">გვარი</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_lname" type="text" value="'.$res['client_person_lname'].'"></td>
	                            <td><input style="width: 250px;" id="client_person_fname" type="text" value="'.$res['client_person_fname'].'"></td>
                            </tr>
                        </table>
                        <table class="margin_top_10">
                            <tr>
                                <td style="width: 312px;"><label for="client_person_phone1">ტელეფონი 1</label></td>
        	                    <td><label for="client_person_phone2">ტელეფონი 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_phone1" type="text" value="'.$res['client_person_phone1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_person_phone2" type="text" value="'.$res['client_person_phone2'].'"></td>
                            </tr>
    	                    <tr>
                                <td style="width: 312px;"><label for="client_person_mail1">ელ-ფოსტა 1</label></td>
        	                    <td><label for="client_person_mail2">ელ-ფოსტა 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_mail1" type="text" value="'.$res['client_person_mail1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_person_mail2" type="text" value="'.$res['client_person_mail2'].'"></td>
                            </tr>
        	                <tr>
                                <td style="width: 312px;"><label for="client_person_addres1">მისამართი 1</label></td>
        	                    <td><label for="client_person_addres2">მისამართი 2</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="width: 250px;" id="client_person_addres1" type="text" value="'.$res['client_person_addres1'].'"></td>
        	                    <td><input style="width: 250px;" id="client_person_addres2" type="text" value="'.$res['client_person_addres2'].'"></td>
                            </tr>
                        </table>                	    
    	                <table class="margin_top_10">
        	                <tr>
        	                    <td><label for="client_person_note">შენიშვნა</label></td>
        	                </tr>
        	                <tr>
        	                    <td><textarea id="client_person_note" style="resize: vertical;width: 565px;">'.$res['client_person_note'].'</textarea></td>
        	                </tr>
    	                </table>
	               </div>
	    
        	    </div>
	    
            </fieldset>
    	    
            <fieldset style="display:none;" id="task">
                <legend>დავალების ფორმირება</legend>
	            <span class="hide_said_menu">x</span>
	            <table>
	               <tr>
	                   <td><label for="task_type_id">დავალების ტიპი</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><select style="width: 595px;" id="task_type_id"></select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_start_date">პერიოდი</label></td>
	               </tr>	              
	               <tr>
	                   <td style="width: 350px;"><input style="float: left;" id="task_start_date" type="text" value=""><label for="task_start_date" style="float: left;margin-top: 7px;margin-left: 2px;">-დან</label></td>
	                   <td><input style="float: left;" id="task_end_date" type="text" value=""><label for="task_end_date" style="float: left;margin-top: 7px;margin-left: 2px;">-დან</label></td>
	               </tr>
	               <tr>
	                   <td><label for="task_departament_id">განყოფილება</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><select style="width: 595px;" id="task_departament_id"></select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_recipient_id">ადრესატი</label></td>
	                   <td><label for="task_controler_id">მაკონტროლებელი</label></td>
	               </tr>	              
	               <tr>
	                   <td><select style="width: 245px;" id="task_recipient_id"></select></td>
	                   <td><select style="width: 245px;" id="task_controler_id"></select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_priority_id">პრიორიტეტი</label></td>
	                   <td><label for="task_status_id">სტატუსი</label></td>
	               </tr>	              
	               <tr>
	                   <td><select style="width: 245px;" id="task_priority_id"></select></td>
	                   <td><select style="width: 245px;" id="task_status_id"></select></td>
	               </tr>
	               <tr>
	                   <td><label for="task_description">არწერა</label></td>
	               </tr>
	               <tr>
	                   <td colspan=2><textarea style="resize: vertical;width: 589px;" id="task_description"></textarea></td>
	               </tr>
	               <tr>
	                   <td><label for="task_note">არწერა</label></td>
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
            </fieldset>';
	                    if($rr[0]==''){
	                        $my_scenario = $res['inc_scenario_id'];
	                    }else {
	                        $my_scenario = $rr[0];
	                    }
	                        
	                    $query = mysql_query("SELECT 	`question`.id,
            				                    `question`.`name`,
            				                    `question`.note,
                                                `scenario`.`name`,
        		                                `scenario_detail`.id AS sc_det_id,
        		                                `scenario_detail`.`sort`
                                    FROM        `scenario`
                                    JOIN        scenario_detail ON scenario.id = scenario_detail.scenario_id
                                    JOIN        question ON scenario_detail.quest_id = question.id
                                    WHERE       scenario.id = $my_scenario AND scenario_detail.actived = 1
                                    ORDER BY    scenario_detail.sort ASC");
		
		$data .= '
                    <fieldset style="display:none;height: 465px;" id="scenar">
                        <legend>კითხვები</legend>
		            <button who="0" id="show_all_scenario" style="margin-bottom: 10px;float: right;">ყველას ჩვენება</button>';
		
		
		if($res[id] == ''){
		    $inc_id = 0;
		    $inc_checker = " AND scenario_results.incomming_call_id = 0";
		}else{
		    $inc_id = $res[id];
		    $inc_checker = " AND scenario_results.incomming_call_id = $res[id]";
		}
while ($row = mysql_fetch_array($query)) {
		    
		    $last_q = mysql_query("  SELECT question_detail.id
                                     FROM `question_detail`
                                     JOIN scenario_detail ON scenario_detail.quest_id = question_detail.quest_id
                                     AND scenario_detail.scenario_id = $my_scenario
                                     WHERE question_detail.quest_id = $row[0]");
		    
		    $data .= '<div class="quest_body '.$row[5].'" id="'.$row[0].'">
		            <table class="dialog-form-table">
		    		<tr>
						<td style="font-weight:bold;">'.$row[5].'. '. $row[1] .' <img style="border: none;padding: 0;margin-left: 8px;margin-top: -2px;" src="media/images/icons/kitxva.png" alt="14 ICON" height="14" width="14" title="'.$row[2].'" ></td>
		                </tr>
		                    ';
		    
            while ($last_a = mysql_fetch_array($last_q)){
                
            
		     
		    $query1 = mysql_query(" SELECT CASE 	WHEN question_detail.quest_type_id = 1 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input next_quest=\"',scenario_destination.destination,'\" ',IF(scenario_results.incomming_call_id = $inc_id && question_detail.id = scenario_results.question_detail_id,'checked','') ,' class=\"check_input\" ansver_val=\"',question_detail.answer,'\" style=\"float:left;\" type=\"checkbox\" name=\"checkbox', question_detail.quest_id, '\" value=\"', question_detail.id, '\"><label style=\"float:left; padding: 7px;\">', question_detail.answer, '</label></td></tr>')
                        							WHEN question_detail.quest_type_id = 2 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><label style=\"float:left; padding: 7px 0;width: 565px;\" for=\"input|', question_detail.quest_id, '|', question_detail.id, '\">',question_detail.answer,'</label><input next_quest=\"',scenario_destination.destination,'\" value=\"',IF(scenario_results.incomming_call_id = $inc_id && question_detail.id = scenario_results.question_detail_id,scenario_results.additional_info,''),'\" class=\"inputtext\"style=\"float:left;\"  type=\"text\" id=\"input|', question_detail.quest_id, '|', question_detail.id, '\" q_id=\"',question_detail.id,'\" /> </td></tr>')
							                        WHEN question_detail.quest_type_id = 4 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input next_quest=\"',scenario_destination.destination,'\" ',IF(scenario_results.incomming_call_id = $inc_id && question_detail.id = scenario_results.question_detail_id,'checked','') ,' class=\"radio_input\" ansver_val=\"',question_detail.answer,'\" style=\"float:left;\" type=\"radio\" name=\"radio', question_detail.quest_id, '\" value=\"', question_detail.id, '\"><label style=\"float:left; padding: 7px;\">', question_detail.answer, '</label></td></tr>')
		                                            WHEN question_detail.quest_type_id = 5 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><label style=\"float:left; padding: 7px 0;width: 565px;\" for=\"input|', question_detail.quest_id, '|', question_detail.id, '\">',question_detail.answer,'</label><input next_quest=\"',scenario_destination.destination,'\" value=\"',IF(scenario_results.incomming_call_id = $inc_id && question_detail.id = scenario_results.question_detail_id,scenario_results.additional_info,''),'\" class=\"date_input\"  style=\"float:left;\" type=\"text\" id=\"input|', question_detail.quest_id, '|', question_detail.id, '\" q_id=\"',question_detail.id,'\" /> </td></tr>')
		                                            WHEN question_detail.quest_type_id = 6 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><label style=\"float:left; padding: 7px 0;width: 565px;\" for=\"input|', question_detail.quest_id, '|', question_detail.id, '\">',question_detail.answer,'</label><input next_quest=\"',scenario_destination.destination,'\" value=\"',IF(scenario_results.incomming_call_id = $inc_id && question_detail.id = scenario_results.question_detail_id,scenario_results.additional_info,''),'\" class=\"date_time_input\"  style=\"float:left;\" type=\"text\" id=\"input|', question_detail.quest_id, '|', question_detail.id, '\" q_id=\"',question_detail.id,'\" /> </td></tr>')
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
		                            LEFT JOIN incomming_call ON incomming_call.id = scenario_results.incomming_call_id
		                            LEFT JOIN scenario_destination ON scenario_destination.answer_id = $last_a[0]
		                            LEFT JOIN scenario_handbook ON question_detail.answer = scenario_handbook.id 
                                    WHERE question_detail.id = $last_a[0]
		                            ");

		
		        
		          $g =0;
		                        while ($row1 = mysql_fetch_array($query1)) {
		                            $q_type = $row1[1];	
                                    if($q_type == 7){
                                        $data .= '  <tr>
                                                    <td style="width:707px; text-align:left;">
                                                    <label style="float:left; padding: 7px 0;width: 565px;" for="">'.$row1[2].'</label>
                                                    <select class="hand_select" next_quest="'.$row1[6].'" style="float:left;width: 235px;"  id="hand_select|'.$row1[4].'|'.$row1[5].'" >'.gethandbook($row1[0],$row1[3]).'</select>
                                                    </td>';
                                    }else{
                                        $data .= $row1[0];
                                    }
                            }}
                    
                    $data .= '</table>
                    <hr><br></div>';
            
		}
		
		$data .= '<button id="back_quest" back_id="0" style="float:left;">უკან</button><button id="next_quest" style="float:right;" next_id="0">წინ</button></fieldset>
		</div>
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
    $record_incomming = mysql_query("SELECT  `datetime`,
                                             TIME_FORMAT(SEC_TO_TIME(duration),'%i:%s') AS `duration`,
                                             `file_name`
                                     FROM    `asterisk_incomming`
                                     WHERE   `source` LIKE '%$res[phone]%'");
    while ($record_res_incomming = mysql_fetch_assoc($record_incomming)) {
        $str_record_incomming .= '<tr>
                                    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">'.$record_res_incomming[datetime].'</td>
                            	    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;">'.$record_res_incomming[duration].'</td>
                            	    <td style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;" onclick="listen(\''.$record_res_incomming[file_name].'\')"><span>მოსმენა</span></td>
                        	      </tr>';
    }
    
    $record_outgoing = mysql_query("SELECT  `call_datetime`,
                                            TIME_FORMAT(SEC_TO_TIME(duration),'%i:%s') AS `duration`,
                                            `file_name`
                                    FROM    `asterisk_outgoing`
                                    WHERE   `phone` LIKE '%$res[phone]%'");
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
                    <audio controls style="margin-left: 145px;">
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
                                     WHERE  `incomming_call_id` = $res[id] AND `actived` = 1");
    while ($file_res_incomming = mysql_fetch_assoc($file_incomming)) {
        $str_file_incomming .= '<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 180px;float:left;">'.$file_res_incomming[file_date].'</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 189px;float:left;">'.$file_res_incomming[name].'</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;width: 160px;float:left;" onclick="download_file(\''.$file_res_incomming[rand_name].'\')">ჩამოტვირთვა</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;width: 20px;float:left;" onclick="delete_file(\''.$file_res_incomming[id].'\')">-</div>';
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

function increment($table){

    $result   		= mysql_query("SHOW TABLE STATUS LIKE '$table'");
    $row   			= mysql_fetch_array($result);
    $increment   	= $row['Auto_increment'];
    $next_increment = $increment+1;
    mysql_query("ALTER TABLE $table AUTO_INCREMENT=$next_increment");

    return $increment;
}

?>