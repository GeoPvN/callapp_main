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
		$departmetn_id		= $_REQUEST['id'];
	       $page		= GetPage(GetHolidays($departmetn_id));
           $data		= array('page'	=> $page);

		break;
	case 'get_list' :
        $count	= $_REQUEST['count'];
	    $hidden	= $_REQUEST['hidden'];
	    	
	    $rResult = mysql_query("SELECT  `id`,
                        				`name`
                                FROM    `holidays_category`
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
                              <input type="checkbox" id="callapp_checkbox_cat_'.$aRow[$hidden].'" name="check_'.$aRow[$hidden].'" value="'.$aRow[$hidden].'" class="check" />
                              <label for="callapp_checkbox_cat_'.$aRow[$hidden].'"></label>
                          </div>';
	            }
	        }
	        $data['aaData'][] = $row;
	    }

		break;
	case 'save_cat':
		$id 		              = $_REQUEST['id'];
		$name                     = $_REQUEST['name'];
		
	
		
		if($name != ''){
			if(!CheckHolidaysExist($name, $id)){
				if ($id == '') {
					AddHolidays($name);
				}else {
					SaveHolidays($id, $name);
				}
								
			} else {
				$error = '"' . $name . '" უკვე არის სიაში!';
				
			}
		}
		
		break;
	case 'disable':
		$id	= $_REQUEST['id'];
		DisableHolidays($id);

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

function AddHolidays($name)
{
	$user_id	= $_SESSION['USERID'];
	mysql_query("INSERT INTO 	 `holidays_category`
								(`name`,`user_id`)
					VALUES 		('$name', '$user_id')");
}

function SaveHolidays($id, $name)
{
	$user_id	= $_SESSION['USERID'];
	mysql_query("	UPDATE `holidays_category`
					SET     `name` = '$name',
							`user_id` ='$user_id'
					WHERE	`id` = $id");
}

function DisableHolidays($id)
{
	mysql_query("	UPDATE `holidays_category`
					SET    `actived` = 0
					WHERE  `id` = $id");
}

function CheckHolidaysExist($name)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT `id`
											FROM   `holidays_category`
											WHERE  `name` = '$name' && `actived` = 1"));
	if($res['id'] != ''){
		return true;
	}
	return false;
}


function GetHolidays($id)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT  `id`,
                                    				`name`
                                            FROM    `holidays_category`
											WHERE   `id` = $id" ));

	return $res;
}

function GetPage($res = '')
{
	$data = '
	<div id="dialog-form">
	    <fieldset>
	    	<legend>დამატება</legend>

	    	<table class="dialog-form-table">
				<tr>
					<td style="width: 170px;"><label for="name">სახელი</label></td>
					<td>
						<input type="text" id="name" value="' . $res['name'] . '" />
					</td>
				</tr>

			</table>
			<!-- ID -->
			<input type="hidden" id="id" value="' . $res['id'] . '" />
        </fieldset>
    </div>
    ';
	return $data;
}

?>
