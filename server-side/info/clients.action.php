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
    case 'send_sms':
        $page		= GetSmsSendPage();
        $data		= array('page'	=> $page);
    
        break;
    case 'send_mail':
        $page		= GetMailSendPage();
        $data		= array('page'	=> $page);
    
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
	<div id="tabs1" style="width: auto; height: 580px;">
		<ul>
		<li><a href="#tab-0">მთავარი</a></li>
		<li><a href="#tab-1">პროექტი</a></li>
		</ul>
	<div id="tab-0">
	<div id="dialog-form">
	    <fieldset style="width: 600px;  float: left;">
	       <legend>ძირითადი ინფორმაცია</legend>
			<table>
			<tr>
			<td>
	       <table>
	    		<tr>
					<td id="img_colum">
						<img style="margin-left: 17px;" id="upload_img" src="media/uploads/images/worker/" />
					</td>
				</tr>
				<tr>
					<td id="act">
						<span>
							<a href="#" id="view_image" class="complate">View</a> | <a href="#" id="delete_image" class="delete">Delete</a>
						</span>
					</td>
				</tr>
				</tr>
					<td>
						<div style="margin-top:10px; width: 127px; margin-left: 8px;" class="file-uploader">
							<input id="choose_file" type="file" name="choose_file" class="input" style="display: none;">
							<button id="choose_button" class="center">აირჩიეთ ფაილი</button>
						</div>
					</td>
				</tr>
			</table>
			</td>
			<td>
	       <table class="dialog-form-table">
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1">საიდენტიპიკაციო კოდი</label></td>
	           </tr>
	           <tr>
	                <td>
						<input type="text" id="identity_code" style="width: 300px;"></input>
					</td>
				    <td>
						<button style="float:right;" id="client_check" style="width: 60px;">შეამოწმე</button>
					</td>
				</tr>
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1_1">დასახელება</label></td>
	           </tr>
	           <tr>
	               <td colspan="2"><textarea id="client_name" style="resize: vertical;width: 415px;"></textarea></td>
	           </tr>
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1_1_1">იურიდიული მისამართი</label></td>
    	       </tr>
	           <tr>
	               <td colspan="2"><textarea id="jurid_address" style="resize: vertical;width: 415px;"></textarea></td>
    	       </tr>
	       		<tr>
	               <td colspan="2"><label for="incomming_comment">ფაქტიური მისამართი</label></td>
	           </tr>
	           <tr>
	               <td colspan="2"><textarea id="fact_address" style="resize: vertical;width: 415px;"></textarea></td>
	           </tr>
	       </table>
			 </td> 
			</tr>
			
			</table>
	    	<div class="margin_top_10">           
	            <div id="button_area">
                    <button id="add_client">დამატება</button>
					<button id="delete_client">წაშლა</button>
                </div>
				<table style="margin-top: -14px;" id="table_right_menu">
				<tr>
					<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;background:#2681DC;"><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
					</td>
						<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;"><img alt="log" src="media/images/icons/log.png" height="14" width="14">
					</td>
						<td style="cursor: pointer;padding: 4px;" id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
					</td>
				</tr>
				</table>
                <table class="display" id="table_client" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">სახელი</th>
                            <th style="width: 100%;">გვარი</th>
                            <th style="width: 103px;">თანამდებობა</th>
                            <th style="width: 100%;">მობილური</th>
							<th style="width: 100%;">ტელეფონი</th>
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
	    
	    
        <div id="side_menu" style="float: left;height: 517px;width: 80px;margin-left: 10px; background: #272727; color: #FFF;margin-top: 6px;">
	       <spam class="info" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'info\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/info.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">კონტრაქტი</div></spam>
	       <spam class="task" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'task\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/task.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">დოკუმენტი</div></spam>
	   
	    </div>
	    
	    <div style="width: 445px;float: left;margin-left: 10px;" id="right_side">
            <fieldset style="display:none;" id="info">
                <legend>კონტრაქტი</legend>
	            <span style="margin-right: 5px; margin-top: 50px;" class="hide_said_menu">x</span>
                <div id="pers">
	               	<table class="margin_top_10">
                            <tr>
                                <td style="width: 230px;"><label for="client_person_phone1">ხელშეკრულების ნომერი</label></td>
        	                    <td><label for="client_person_phone2">გაფორმების თარიღი</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="margin-top: 10px;" id="contract_number" type="text" value=""></td>
        	                    <td><input style="margin-top: 10px;" id="add_date" type="text" value=""></td>
                            </tr>
    	                    <tr>
        	                    <td colspan="2"><label style="margin-left: 135px; margin-top: 20px;" for="client_person_mail2">მოქმედების პერიოდი</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="margin-top: 10px;" id="contract_start_date" type="text" value="">
									
								</td>
        	                    <td><input style="margin-top: 10px;" id="contract_end_date" type="text" value=""></td>
                            </tr>
	                        <tr>
                                <td colspan="2"><label style="margin-top: 20px;" for="client_person_addres2">ხელშეკრულების ღირებულება</label></td>
                            </tr>
    	                    <tr>
								<tdcolspan="2">
									<td>
										<input style="margin-top: 10px;" style="width: 216px;" id="contract_price" type="text" value="">
									</td>
									<td><label style="margin-left: -58px; margin-top: 16px;">-ლარი</label></td>
								</td>
                            </tr>
							<tr>
                                <td colspan="2"><label style="margin-left: 141px; margin-top: 20px;" for="client_person_phone2">საანგარიშო პერიოდი</label></td>
                            </tr>
    	                    <tr>
                                <td><select style="margin-top: 10px;" id="angarish_period" type="text" value="">
									<option value="1" selected="selected">1</option>
									<option value="2" selected="selected">2</option>
									<option value="3" selected="selected">3</option>
									<option value="4" selected="selected">4</option>
									<option value="5" selected="selected">5</option>
									<option value="6" selected="selected">6</option>
									<option value="7" selected="selected">7</option>
									<option value="8" selected="selected">8</option>
									<option value="9" selected="selected">9</option>
									<option value="10" selected="selected">10</option>
									<option value="11" selected="selected">11</option>
									<option value="12" selected="selected">12</option>
									<option value="0" selected="selected"></option>
									</td>
        	                    <td><select style="margin-top: 10px;" id="angarish_period1" type="text" value="">
									<option value="1" selected="selected">კვირა</option>
									<option value="2" selected="selected">თვე</option>
									<option value="0" selected="selected"></option>
								</td>
                            </tr>
                        </table>                	    
    	        </div>
	    	</fieldset>
    	    <fieldset style="display:none;" id="task">
                <legend>დოკუმენტი</legend>
	            <span style="margin-right: 5px; margin-top: 50px;" class="hide_said_menu">x</span>
	            <table>
	               <tr>
						<td><input type="checkbox" id="ar_aqvs_gamocdileba" class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="1" style="display: inline; margin-left: 20px; margin-top: -5px; width: 16px;"/></td>
	                    <td><label>ინვოისი</label></td>
	               </tr>
				   <tr>
						<td><input type="checkbox" id="ar_aqvs_gamocdileba" class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="1" style="display: inline; margin-left: 20px; margin-top: 14px; width: 16px;"/></td>
	                    <td><label style="margin-top: 20px;">მირება-ჩაბარების აქტი</label></td>
	               </tr>
			       <tr>
						<td><input type="checkbox" id="ar_aqvs_gamocdileba" class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="1" style="display: inline; margin-left: 20px; margin-top: 14px; width: 16px;"/></td>
	                    <td><label style="margin-top: 20px;">ანგარიშ-ფაქტურა</label></td>
	               </tr>
	            </table>
            </fieldset>
        </div>
	</div>
	</div>
	<div id="tab-1">
	
	<div class="margin_top_10">           
	            <div id="button_area">
                    <button id="add_project">დამატება</button>
					<button id="delete_project">წაშლა</button>
                </div>
				<table style="margin-top: -14px;" id="table_right_menu">
					<tr>
						<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;background:#2681DC;"><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
						</td>
							<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;"><img alt="log" src="media/images/icons/log.png" height="14" width="14">
						</td>
							<td style="cursor: pointer;padding: 4px;" id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
						</td>
					</tr>
				</table>
                <table style="margin-top: 42px;" class="display" id="table_project" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">სახელი</th>
                            <th style="width: 100%;">გვარი</th>
                            <th style="width: 100%;">თანამდებობა</th>
                            <th style="width: 100%;">მობილური</th>
							<th style="width: 100%;">ტელეფონი</th>
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
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
							<th>
				                <input style="margin-left: 4px;" type="checkbox" name="check-all" id="check-all">
				            </th>
                        </tr>
                    </thead>
                </table>
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