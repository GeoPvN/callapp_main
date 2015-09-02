<?php
// MySQL Connect Link
require_once('../../includes/classes/core.php');

// Main Strings
$action                     = $_REQUEST['act'];
$error                      = '';
$data                       = '';

// Incomming Call Dialog Strings
$hidden_id                  = $_REQUEST['id'];
$incomming_id               = $_REQUEST['incomming_id'];
$incomming_date             = $_REQUEST['incomming_date'];
$incomming_phone            = $_REQUEST['incomming_phone'];
$incomming_cat_1            = $_REQUEST['incomming_cat_1'];
$incomming_cat_1_1          = $_REQUEST['incomming_cat_1_1'];
$incomming_cat_1_1_1        = $_REQUEST['incomming_cat_1_1_1'];
$incomming_comment          = $_REQUEST['incomming_comment'];


switch ($action) {
	case 'get_add_page':
		$page		= GetPage('',increment(incomming_call));
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(Getincomming($hidden_id));
		$data		= array('page'	=> $page);

		break;
    case 'next_quest':
        $page 		= next_quest($hidden_id, $_REQUEST[next_id]);
        $data		= array('ne_id'	=> $page);
    
        break;
	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
	  	$rResult = mysql_query("SELECT id,id,date,phone,cat_1,cat_1_1,cat_1_1_1,`comment` FROM `incomming_call`;");
	  
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
					$row[] = '<input style="margin-left: 16px;" type="checkbox" name="check_' . $aRow[$hidden] . '" class="check" value="' . $aRow[$hidden] . '" />';
				}
			}
			$data['aaData'][] = $row;
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

function next_quest($task_detail_id, $val) {
    $res = mysql_fetch_array(mysql_query("  SELECT 	`scenario_destination`.`destination`
        FROM 	`task`
        JOIN	task_detail ON task.id = task_detail.task_id
        JOIN	scenario ON task.template_id = scenario.id
        JOIN    scenario_detail ON scenario.id = scenario_detail.scenario_id
        JOIN    scenario_destination ON scenario_detail.id = scenario_destination.scenario_detail_id
        WHERE	task_detail.id = $task_detail_id AND scenario_destination.answer_id = $val"));

    return $res[0];

}

function Getincomming($hidden_id)
{
	$res = mysql_fetch_assoc(mysql_query("SELECT  incomming_call.id AS id,
												  incomming_call.`date` AS call_date,
												  DATE_FORMAT(incomming_call.`date`,'%y-%m-%d') AS `date`,
												  incomming_call.`phone`														
										  FROM 	  incomming_call
										  where   incomming_call.id =  $hidden_id"));
	return $res;
}

function GetPage($res,$increment)
{
	$data  .= '
	
	<div id="dialog-form">
	    <fieldset style="width: 260px; height: 255px; float: left;">
	       <legend>ძირითადი ინფორმაცია</legend>
			<table class="dialog-form-table">
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1_1_1">დასახელება</label></td>
    	       </tr>
	           <tr>
	               <td colspan="2"><input id="project_name" style="resize: vertical;width: 250px;"></input></td>
    	       </tr>
	       		<tr>
	               <td colspan="2"><label style="margin-top: 30px;" for="incomming_comment">ტიპი</label></td>
	           </tr>
	           <tr>
	               <td>
						<select style="margin-top: 10px; width: 250px;" id="project_type" type="text" value="">
									<option value="1" selected="selected">შემომავალი</option>
									<option value="2" selected="selected">გამავალი</option>
									<option value="0" selected="selected"></option>
					</td>
	           </tr>
			   <tr>
                             
        	       <td><label style="margin-top: 30px;" for="client_person_phone2">შექმნის თარიღი</label></td>
               </tr>
    	       <tr>
                   <td><input id="project_add_date" type="text" value=""></td>
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
                            <th style="width: 100px;">ტცენარი</th>
							<th class="check">#</th>
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
				                <input style="margin-left: 25px;" type="checkbox" name="check-all" id="check-all">
				            </th>
						</tr>
                    </thead>
                </table>
	            </div>
		</fieldset>
    	</div>
	</div>
	</div>
	<input type="hidden" value="'.$res[id].'" id="hidden_id">';

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