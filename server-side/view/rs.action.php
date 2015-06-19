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
		$paytype_id		= $_REQUEST['id'];
		$page		= GetPage(Getpay_type($paytype_id));
		$data		= array('page'	=> $page);

		break;
	case 'get_list' :
		$count	= $_REQUEST['count'];
		$hidden	= $_REQUEST['hidden'];
			
		$rResult = mysql_query("SELECT 	`id`,
									    'მიღება ჩაბარება'
							    FROM 	`rs`");

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
	case 'save_paytype':
		$id           = $_REQUEST['id'];
		$theacte      = $_REQUEST['theacte'];
		$theactee     = $_REQUEST['theactee'];
		
        mysql_query("UPDATE `rs` SET 
                            `head`='$theacte',
                            `footer`='$theactee'
                     WHERE (`id`='$id');");

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

function Getpay_type($paytype_id)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT  `id`,
													`head`,
	                                                `footer`
											FROM    `rs`
											WHERE   `id` = $paytype_id" ));

	return $res;
}

function GetPage($res = '')
{
	$data = '
	<div id="dialog-form">
	    <fieldset>
	    	<legend>ძირითადი ინფორმაცია</legend>
	        <textarea style="width: 100%; height: 210px;" id="theacte">
	           ' . $res['head'] . '
	        </textarea>
            <textarea style="width: 100%; height: 370px;" id="theactee">
	           ' . $res['footer'] . '
            </textarea>
			<!-- ID -->
			<input type="hidden" id="paytype_id" value="' . $res['id'] . '" />
        </fieldset>
    </div>
    ';
	return $data;
}

?>
