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
	    mysql_query("UPDATE `outgoing_campaign_detail_contact_detail` SET
            	            `actived`=0
            	     WHERE  `id`='$_REQUEST[id]';");
	
	    break;
	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
		
	  	$rResult = mysql_query("SELECT  `id`,
  	                                    `name`
                                FROM    `outgoing_campaign_detail_contact_detail`
                                WHERE   `actived` = 1 AND `type` = 2 AND outgoing_campaign_detail_contact_id = $_REQUEST[outgoing_campaign_detail_contact_id]");

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
    case 'save_contact_info_mail':
        $outgoing_campaign_detail_contact_id = $_REQUEST['outgoing_campaign_detail_contact_id'];
        if($_REQUEST['outgoing_campaign_detail_contact_id'] == ''){
            $outgoing_campaign_detail_contact_id = increment('outgoing_campaign_detail_contact');
        }
        if($_REQUEST['outgoing_campaign_detail_contact_detail_id'] == ''){
            mysql_query("INSERT INTO `outgoing_campaign_detail_contact_detail`
                        (`outgoing_campaign_detail_contact_id`, `date`, `user_id`, `type`, `name`)
                        VALUES
                        ('$outgoing_campaign_detail_contact_id', NOW(), '$_SESSION[USERID]', '2', '$_REQUEST[contact_info_mail]');");
        }else{
            mysql_query("UPDATE `outgoing_campaign_detail_contact_detail` SET 
                                `date`=NOW(),
                                `user_id`='$_SESSION[USERID]',
                                `name`='$_REQUEST[contact_info_mail]'
                         WHERE  `id`='$_REQUEST[outgoing_campaign_detail_contact_detail_id]';");
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

function Getincomming($hidden_id)
{
	$res = mysql_fetch_assoc(mysql_query("  SELECT  `id`,
                                                    `name`
                                            FROM    `outgoing_campaign_detail_contact_detail`
                                            WHERE   `id` = $hidden_id"));
	return $res;
}

function GetPage($res)
{
	$data  .= '
	<div id="dialog-form">
	    <fieldset>
	       <legend>ძირითადი ინფორმაცია</legend>
	           <input id="outgoing_campaign_detail_contact_detail_id" type="hidden" value="'.$res[id].'" />
               <table>
                   <tr>
                       <td><label for="contact_info_mail">ელ-ფოსტა</label></td>
                   </tr>
                   <tr>
                       <td><input id="contact_info_mail" type="text" value="'.$res[name].'"></td>
                   </tr>
               </table>
	    </fieldset>
	</div>';

	return $data;
}

?>