<?php
// MySQL Connect Link
require_once('../../includes/classes/core.php');

// Main Strings
$action                     = $_REQUEST['act'];
$error                      = '';
$data                       = '';

// Incomming Call Dialog Strings
$hidden_id         = $_REQUEST['id'];
$project_name      = $_REQUEST['project_name'];
$project_type      = $_REQUEST['project_type'];
$project_add_date  = $_REQUEST['project_add_date'];




switch ($action) {
	case 'get_add_page':
		$page		= GetPage('',object($hidden_id));
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(object($hidden_id));
		$data		= array('page'	=> $page);

		break;
	case 'disable':
		$hidden_id        = $_REQUEST['id'];
		mysql_query("	UPDATE  `project`
		SET
		`actived` = 0
		WHERE `id`='$hidden_id'
		");
	
		break;
	case 'save-project':
		$hidden_id		  = $_REQUEST['project_hidden_id'];
    	$hidden_client_id = $_REQUEST['hidden_client_id'];
    	
    	if($hidden_id==''){
    		Addproject($hidden_client_id, $project_name, $project_type, $project_add_date);
    	}else{
    		Saveproject($hidden_id,$project_name, $project_type, $project_add_date);
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

function Addproject($hidden_client_id, $project_name, $project_type, $project_add_date){
	
	$user = $_SESSION['USERID'];

	mysql_query("INSERT INTO `project` 
						(`user_id`, `client_id`, `name`, `type_id`, `create_date`, `actived`) 
					VALUES 
						('$user', '$hidden_client_id', '$project_name', '$project_type', '$project_add_date', '1')");

}

function Saveproject($hidden_id,$project_name, $project_type, $project_add_date){
	
	$user = $_SESSION['USERID'];
	
	mysql_query("UPDATE  `project`
	 				SET  `user_id`='$user', 
						 `name`='$project_name', 
						 `type_id`='$project_type', 
						 `create_date`='$project_add_date' 
				WHERE `id`='$hidden_id'");

}


function Get_type($count){
	$data = '';
	$req = mysql_query("SELECT id, `name`
						FROM `call_type`");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){

		if($res['id'] == $count){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		}else{
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}
	return $data;
}
function object($hidden_id){
	
	$res = mysql_fetch_assoc(mysql_query("SELECT  id,
												  `name`,
												  type_id,
												  create_date
											FROM `project`
											WHERE id='$hidden_id'"));
	return $res;
}

function GetPage($res,$increment){
	if ($res[id]=='') {
		$incr_id=increment(project);
	}else{
		$incr_id=$res[id];
	}
	
	$data  .= '
	
	<div id="dialog-form">
	    <fieldset style="width: 260px; height: 255px; float: left;">
	       <legend>ძირითადი ინფორმაცია</legend>
			<table class="dialog-form-table">
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1_1_1">დასახელება</label></td>
    	       </tr>
	           <tr>
	               <td colspan="2"><input id="project_name" style="resize: vertical;width: 250px;" value="'.$res[name].'"></td>
    	       </tr>
	       		<tr>
	               <td colspan="2"><label style="margin-top: 30px;" for="incomming_comment">ტიპი</label></td>
	           </tr>
	           <tr>
               		<td>
						<select style="margin-top: 10px; width: 257px;"  id="project_type">'. Get_type($res[type_id]).'</select>
					</td>
	               
	           </tr>
			   <tr>
                             
        	       <td><label style="margin-top: 30px;" for="client_person_phone2">შექმნის თარიღი</label></td>
               </tr>
    	       <tr>
                   <td><input id="project_add_date" type="text" value="'.$res[create_date].'"></td>
               </tr>
	       </table>
		 </fieldset>
	    
	    
        <div id="side_menu1" style="float: left;height: 273px; width: 80px;margin-left: 10px; background: #272727; color: #FFF;margin-top: 6px;">
	       <spam class="phone" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side1(\'phone\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/info.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">ნომერი</div></spam>
	       
	   
	    </div>
	    
	    <div style="width: 445px; float: left; margin-left: 10px;" id="right_side_project">
            <fieldset style="display:none;" id="phone">
                <legend>ნომერი</legend>
	            <span id="hide_said_menu_number" class="hide_said_menu">x</span>
                <div class="margin_top_10">           
	            <div id="button_area">
                    <button id="add_number">დამატება</button>
					<button id="delete_number">წაშლა</button>
                </div>
				<table class="display" id="table_number" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 70px;">ნომერი</th>
                            <th style="width: 70px;">რიგი</th>
                            <th style="width: 100px;">შიდა ნომ.</th>
                            <th style="width: 100px;">სცენარი</th>
							<th style="width: 11px;" class="check"></th>
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
				                <input type="checkbox" name="check-all" id="check-all">
				            </th>
						</tr>
                    </thead>
                </table>
	            </div>
		</fieldset>
    	</div>
	</div>
	</div>
	<input type="hidden" value="'.$res[id].'" id="project_hidden_id">
	<input type="hidden" value="'.$incr_id.'" id="hidden_project_id">';

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