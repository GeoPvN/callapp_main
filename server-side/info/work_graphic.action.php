<?php

require_once ('../../includes/classes/core.php');

$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';
switch ($action) {
	case 'get_list' :
		$count 		= $_REQUEST['count'];
		$hidden 	= $_REQUEST['hidden'];
	  	$rResult 	= mysql_query("SELECT id, `start`, `end` 
                                    FROM `work_graphic`
                                    WHERE actived=1	");

		$data = array(
				"aaData"	=> array()
		);
		while ( $aRow = mysql_fetch_array( $rResult ) )
		{
			$row = array();
			for ( $i = 0 ; $i < $count ; $i++ )
			{
				if($i == ($count - 1)){
					$row[] = '<input type="checkbox" name="check_' . $aRow[$hidden] . '" class="check" value="' . $aRow[$hidden] . '" />';
				}
				$row[] = $aRow[$i];

			}
			$data['aaData'][] = $row;
		}

		break;
		
	case "get_edit_page":
	$data['page'][]=page();
	   break;
	
	case 'disable':
		mysql_query("UPDATE `work_graphic` SET `actived`='0' WHERE (`id`='$_REQUEST[id]')");
		break;
		
	case 'get_add_page' :
	$data['page'][]=page();
		break;
   	case 'save_dialog' :
   		if($_REQUEST[id]==''){
		mysql_query("
				INSERT INTO `work_graphic` (`start`, `end`)
				VALUES ('$_REQUEST[start]', '$_REQUEST[end]')
		");}
		else{

			mysql_query("UPDATE `work_graphic` SET
			`start`='$_REQUEST[start]',
			`end`='$_REQUEST[end]' WHERE (`id`='$_REQUEST[id]')");
		}
   		break;
   		
	default:
		$error = 'Action is Null';
}
function page()
{
		$rResult 	= mysql_query("SELECT 	*
				FROM `work_graphic`
				where id='$_REQUEST[id]' AND work_graphic.actived=1
	  			");
		$res = mysql_fetch_array( $rResult );

	

	return '
	<div id="dialog-form">
		<fieldset >
	    	<legend >ძირითადი ინფორმაცია</legend>
<input type="" style="opacity: 0; height: 0px;" id="hidden"/>
	    	<table class="dialog-form-table">
				<tr>
					<td style="width: 200px;"><label for="">მუშაობის დასაწყისი</label></td>
					<td style="width: 200px;"><label for="">მუშაობის დასასრული</label></td>
				</tr>
					<td><input id="start" 	class="idle time" type="text" value="'.$res[start].	'" /></td>
					<td><input id="end"     class="idle time" type="text" value="'.$res[end].'" /></td>
				<tr>
			</table>
		</fieldset >
	</div>
<input type="hidden" id="id" value='.$_REQUEST[id].'>';

}

$data['error'] = $error;

echo json_encode($data);

?>