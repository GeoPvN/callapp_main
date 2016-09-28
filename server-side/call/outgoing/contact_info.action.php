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
$call_comment               = $_REQUEST['call_comment'];

switch ($action) {
	case 'get_add_page':
		$page		= GetPage('','');
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(Getincomming($hidden_id));
		$data		= array('page'	=> $page);

		break;
	case 'disable':
	    mysql_query("UPDATE `outgoing_campaign_detail_contact` SET
            	            `actived`=0
            	     WHERE  `id`='$_REQUEST[id]';");
	
	    break;
	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];

	  	$rResult = mysql_query("SELECT  outgoing_campaign_detail_contact.`id`,
                                        IF(outgoing_campaign_detail_contact.type=2,client_title,CONCAT(fname,' ',lname)) AS `cl_name`,
                                        `person_position`,
                                        (SELECT GROUP_CONCAT(`name`) FROM outgoing_campaign_detail_contact_detail WHERE outgoing_campaign_detail_contact_detail.actived = 1 AND outgoing_campaign_detail_contact_detail.outgoing_campaign_detail_contact_id = outgoing_campaign_detail_contact.id AND outgoing_campaign_detail_contact_detail.type = 1),
                                        (SELECT GROUP_CONCAT(`name`) FROM outgoing_campaign_detail_contact_detail WHERE outgoing_campaign_detail_contact_detail.actived = 1 AND outgoing_campaign_detail_contact_detail.outgoing_campaign_detail_contact_id = outgoing_campaign_detail_contact.id AND outgoing_campaign_detail_contact_detail.type = 2)
                                FROM `outgoing_campaign_detail_contact`
                                WHERE outgoing_campaign_detail_id = $_REQUEST[outgoing_campaign_detail_id] AND actived = 1");
		
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
                                  <input type="checkbox" id="callapp_checkbox_contact_'.$aRow[$hidden].'" name="check_'.$aRow[$hidden].'" value="'.$aRow[$hidden].'" class="check" />
                                  <label for="callapp_checkbox_contact_'.$aRow[$hidden].'"></label>
                              </div>';
				}
			}
			$data['aaData'][] = $row;
		}
	
	    break;
    case 'save_contact_info':
        if($_REQUEST['outgoing_campaign_detail_contact_id'] == ''){
            mysql_query("INSERT INTO `outgoing_campaign_detail_contact`
                        (`outgoing_campaign_detail_id`, `date`, `user_id`, `type`, `fname`, `lname`, `person_number`, `city_id`, `addres`, `comment`, `client_title`, `client_number`,`person_position`,`person_gmpiri`)
                        VALUES
                        ('$_REQUEST[outgoing_campaign_detail_id]', NOW(), '$_SESSION[USERID]', '$_REQUEST[type]', '$_REQUEST[fname]', '$_REQUEST[lname]', '$_REQUEST[person_number]', '$_REQUEST[city_id]', '$_REQUEST[addres]', '$_REQUEST[client_comment]', '$_REQUEST[client_title]', '$_REQUEST[client_number]', '$_REQUEST[person_position]', '$_REQUEST[person_gmpiri]');");
        }else{
            mysql_query("UPDATE `outgoing_campaign_detail_contact` SET
                                `date`=NOW(),
                                `user_id`='$_SESSION[USERID]',
                                `type`='$_REQUEST[type]',
                                `fname`='$_REQUEST[fname]',
                                `lname`='$_REQUEST[lname]',
                                `person_number`='$_REQUEST[person_number]',
                                `city_id`='$_REQUEST[city_id]',
                                `addres`='$_REQUEST[addres]',
                                `comment`='$_REQUEST[client_comment]',
                                `client_title`='$_REQUEST[client_title]',
                                `client_number`='$_REQUEST[client_number]',
                                `person_position`='$_REQUEST[person_position]',
                                `person_gmpiri`='$_REQUEST[person_gmpiri]'
                         WHERE  `id`='$_REQUEST[outgoing_campaign_detail_contact_id]';");
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

function city($id){
    $req = mysql_query("  SELECT `id`,
                            	 `name`
                          FROM   `city`
                          WHERE  `actived` = 1");

    $data .= '<option value="0" >----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;

}

function Getincomming($id)
{
	$res = mysql_fetch_assoc(mysql_query(" SELECT   id,
                                                    type,
                                                    fname,
                                                    lname,
                                                    person_number,
                                                    city_id,
                                                    addres,
                                                    `comment`,
                                                    client_number,
                                                    client_title,
                                            	    person_position,
                                            	    person_gmpiri
                                            FROM `outgoing_campaign_detail_contact`
                                            WHERE id = $id"));
	return $res;
}

function GetPage($res)
{
    $juridical_status1 = '';
    $juridical_status2 = '';
    $juridical_status3 = '';
    
    if($res['person_gmpiri'] == 1){
        $ju1 = 'checked';
    }
    if($res['type'] == 1){
        $juridical_status1 = 'checked';
    }else if($res['type'] == 2){
        $juridical_status2 = 'checked';
    }else if($res['type'] == 3){
        $juridical_status3 = 'checked';
    }else{
        $juridical_status1 = 'checked';
    }
	$data  .= '
	<div id="dialog-form">
	    <fieldset style="">
	       <legend>ძირითადი ინფორმაცია</legend>
	            <input id="outgoing_campaign_detail_contact_id" type="hidden" value="'.$res[id].'" />
        	    <div id="pers" style="float:left;height: 477px;">
	            <div style="overflow: hidden;width: 60%; margin:auto;display:none;"><input '.$juridical_status1.' type="radio" name="person" id="person1" class="left" value="1"><label for="person1" class="left" style="margin-top: 7px;">ფიზიკური</label><input '.$juridical_status2.' id="person2" type="radio" name="person" class="left" value="2"><label for="person2" class="left" style="margin-top: 7px;">იურიდიული</label><input '.$juridical_status3.' id="person3" type="radio" name="person" class="left" value="3"><label for="person3" class="left" style="margin-top: 7px;">დიპლომატი</label></div>
                   <table id="iuridiuli" '.(($res['type']==2)?'':'style="display:none;"').'>
                   <tr>
	                   <td style="width: 250px;" ><label for="client_title">დასახელება</label></td>
                       <td><label for="client_number">საიდენტიფიკაციო ნომერი</label></td>
	               </tr>
	               <tr>
	                   <td><input id="client_title" type="text" value="'.$res[client_title].'"></td>
                       <td><input id="client_number" type="text" value="'.$res[client_number].'"></td>
	               </tr>
                   </table>
	               <table>
    	               <tr>
    	                   <td style="width: 250px;" ><label for="client_name">სახელი</label></td>
	                       <td><label for="client_surname">გვარი</label></td>
    	               </tr>
    	               <tr>
    	                   <td><input id="fname" type="text" value="'.$res[fname].'"></td>
	                       <td><input id="lname" type="text" value="'.$res[lname].'"></td>
    	               </tr>
	                   <tr>
    	                   <td style="width: 250px;" ><label for="person_position">თანამდებობა</label></td>
	                       <td><label for="person_gmpiri">გ.მ. პირი</label></td>
    	               </tr>
    	               <tr>
    	                   <td><input id="person_position" type="text" value="'.$res[person_position].'"></td>
	                       <td><input id="person_gmpiri" name="person_gmpiri" '.$ju1.' type="checkbox" value="1"></td>
    	               </tr>
	                   <tr>
    	                   <td colspan="2"><label for="client_comment">კომენტარი</label></td>
    	               </tr>
    	               <tr>
    	                   <td colspan="2"><textarea id="client_comment" style="resize: vertical;width: 420px;height: 50px;">'.$res[comment].'</textarea></td>
    	               </tr>
                   </table>
        	    </div>
    	        <div style="float:left;width:490px;margin-left: 20px;">
    	                       <h5 style="margin-bottom: 7px;">ტელეფონი</h5>
        	           <div id="button_area">
                            <button id="add_contact_info_phone">დამატება</button>
        	                <button id="delete_contact_info_phone">წაშლა</button>
                        </div>
                        <table class="display" id="table_contact_info_phone" >
                            <thead>
                                <tr id="datatable_header">
                                    <th>ID</th>
                                    <th style="width: 100%;">ტელეფონი</th>
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
        	                        <th style="border-right: 1px solid #E6E6E6 !important;">
                                    	<div class="callapp_checkbox">
                                            <input type="checkbox" id="check-all-contact_info_phone" name="check-all-contact_info_phone" />
                                            <label for="check-all-contact_info_phone"></label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
        	            </div>
    	                <div style="float:left;width:490px;margin-left: 20px;">
    	                       <h5 style="margin-bottom: 7px;">ელ-ფოსტა</h5>
        	            <div id="button_area">
                            <button id="add_contact_info_mail">დამატება</button>
        	                <button id="delete_contact_info_mail">წაშლა</button>
                        </div>
                        <table class="display" id="table_contact_info_mail" >
                            <thead>
                                <tr id="datatable_header">
                                    <th>ID</th>
                                    <th style="width: 100%;">ელ-ფოსტა</th>
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
        	                        <th style="border-right: 1px solid #E6E6E6 !important;">
                                    	<div class="callapp_checkbox">
                                            <input type="checkbox" id="check-all-contact_info_mail" name="check-all-contact_info_mail" />
                                            <label for="check-all-contact_info_mail"></label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                        </table>
        	            </div>
	    </fieldset>
	</div>';

	return $data;
}


?>