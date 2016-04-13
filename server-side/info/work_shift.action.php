<?php
require_once('../../includes/classes/core.php');
$action	= $_REQUEST['act'];
$error	= '';
$data	= '';
 
switch ($action) {
	case 'get_add_page':
		$page		= GetPage();
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		   $lang_id		= $_REQUEST['id'];
	       $page		= GetPage(GetLang($lang_id));
           $data		= array('page'	=> $page);

		break;
	case 'get_list' :
		$count	= $_REQUEST['count'];
		$hidden	= $_REQUEST['hidden'];
		 
		$rResult = mysql_query("SELECT 	`id`,
                        				`start_date`,
		                                `end_date`
                                FROM    `work_shift`
                                WHERE   `actived` = 1");

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
	case 'save_lang':
		$lang_id 	= $_REQUEST['id'];
		$start_date = $_REQUEST['start_date'];
		$end_date   = $_REQUEST['end_date'];

		if ($lang_id == '') {
			AddLang( $lang_id, $start_date, $end_date);
		}else {
			SaveLang($lang_id, $start_date, $end_date);
		}

		break;
	case 'disable':
		$lang_id	= $_REQUEST['id'];
		DisableLang($lang_id);

		break;
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);


/* ******************************
 *	Category Functions
* ******************************
*/

function AddLang($lang_id, $start_date, $end_date)
{
	$user_id	= $_SESSION['USERID'];
	mysql_query("INSERT INTO 	 `work_shift`
								(`user_id`, `start_date`, `end_date`)
					VALUES 		('$user_id', '$start_date', '$end_date')");
}

function SaveLang($lang_id, $start_date, $end_date)
{
	$user_id	= $_SESSION['USERID'];
	mysql_query("	UPDATE `work_shift`
					SET     `start_date` = '$start_date',
	                        `end_date`   = '$end_date',
							`user_id`    = '$user_id'
					WHERE	`id`         = $lang_id");
}

function DisableLang($lang_id)
{
	mysql_query("	UPDATE `work_shift`
					SET    `actived` = 0
					WHERE  `id` = $lang_id");
}

function GetLang($lang_id)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT  `id`,
													`start_date`,
	                                                `end_date`
											FROM    `work_shift`
											WHERE   `id` = $lang_id" ));

	return $res;
}

function GetPage($res = '')
{
	$data = '
	<div id="dialog-form">
	    <fieldset>
	    	<legend>ძირითადი ინფორმაცია</legend>
            <!-- ID -->
			<input type="hidden" id="lang_id" value="' . $res['id'] . '" />
	    	<table class="dialog-form-table">
                <tr>
					<td style="width: 170px;"><label for="start_date">დასაწყისი</label></td>
					<td>
						<input type="text" id="start_date" value="' . $res['start_date'] . '" />
					</td>
				</tr>
				<tr>
					<td style="width: 170px;"><label for="end_date">დასასრული</label></td>
					<td>
						<input type="text" id="end_date" value="' . $res['end_date'] . '" />
					</td>
				</tr>
			</table>
			
        </fieldset>
    </div>
    ';
	return $data;
}

?>
