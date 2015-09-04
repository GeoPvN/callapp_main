<?php
// MySQL Connect Link
require_once('../../includes/classes/core.php');

// Main Strings
$action                     = $_REQUEST['act'];
$error                      = '';
$data                       = '';

// Incomming Call Dialog Strings
//კლიენტი//
$hidden_id       = $_REQUEST['id'];
$identity_code   = $_REQUEST['identity_code'];
$client_name     = $_REQUEST['client_name'];
$jurid_address   = $_REQUEST['jurid_address'];
$fact_address    = $_REQUEST['fact_address'];

//კონტრაქტი//
$contract_number       	= $_REQUEST['contract_number'];
$add_date   			= $_REQUEST['add_date'];
$contract_start_date    = $_REQUEST['contract_start_date'];
$contract_end_date   	= $_REQUEST['contract_end_date'];
$contract_price    		= $_REQUEST['contract_price'];
$angarish_period       	= $_REQUEST['angarish_period'];
$angarish_period1   	= $_REQUEST['angarish_period1'];


//კლიენტი//
$invois    			= $_REQUEST['invois'];
$migeba_chabareba   = $_REQUEST['migeba_chabareba'];
$angarishfaqtura    = $_REQUEST['angarishfaqtura'];


switch ($action) {
	case 'get_add_page':
		$page		= GetPage('',increment($hidden_id));
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(Getclient($hidden_id));
		$data		= array('page'	=> $page);

		break;

	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
	  	$rResult = mysql_query("SELECT  `id`,
	  									`id`,
	  									`name`,
										identity_code,
										juridical_address,
										physical_address
								FROM 	client
								WHERE 	actived=1");
	  
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
					$row[] = '<input type="checkbox" name="check_' . $aRow[$hidden] . '" class="check" value="' . $aRow[$hidden] . '" />';
				}
			}
			$data['aaData'][] = $row;
		}
	
	    break;
    case 'get_list_person':
    	$count = 		$_REQUEST['count'];
    	$hidden = 		$_REQUEST['hidden'];
    	$client_id = 	$_REQUEST['client_id'];
    	$rResult = mysql_query("SELECT  id,
    									`name`,
										lastname,
										position,
										phone,
										email
								FROM `client_person`
								WHERE client_id='$client_id' and actived=1");
    	 
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
    				$row[] = '<input type="checkbox" name="check_' . $aRow[$hidden] . '" class="check" value="' . $aRow[$hidden] . '" />';
    			}
    		}
    		$data['aaData'][] = $row;
    	}
    
    	break;
    	case 'get_list_project':
    		$count = 		$_REQUEST['count'];
    		$hidden = 		$_REQUEST['hidden'];
    		$client_id = 	$_REQUEST['client_id'];
    		$rResult = mysql_query("SELECT 	project.`id`,
											project.`name`,
											call_type.`name`,
											create_date,
											(SELECT GROUP_CONCAT(project_number.number) AS `number`
											 FROM project_number
											 WHERE project_number.project_id=project.id
											) AS `number`
									
									FROM `project`
									LEFT JOIN call_type ON project.type_id=call_type.id
									WHERE actived=1 AND client_id='$client_id'");
    	
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
    					$row[] = '<input type="checkbox" name="check_' . $aRow[$hidden] . '" class="check" value="' . $aRow[$hidden] . '" />';
    				}
    			}
    			$data['aaData'][] = $row;
    		}
    	
    		break;
    	case 'get_list_number':
    			$count  = 		$_REQUEST['count'];
    			$hidden = 		$_REQUEST['hidden'];
    			
    			$project_id =  $_REQUEST['project_id'];
    			$rResult   = mysql_query("SELECT project_number.id,
    											 project_number.number,
												 queue.`name`,
												 queue.number,
												 ''
											FROM project_number
											LEFT JOIN queue ON queue.id=project_number.queue_id
											WHERE project_number.actived=1 AND project_number.project_id='$project_id'");
    			 
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
    						$row[] = '<input  type="checkbox" name="check_' . $aRow[$hidden] . '" class="check" value="' . $aRow[$hidden] . '" />';
    					}
    				}
    				$data['aaData'][] = $row;
    			}
    			 
    			break;
    case 'save_client':
    	$hidden_id       = $_REQUEST['id'];
    	
    	if($hidden_id==''){
    		Addclient($identity_code, $client_name, $jurid_address, $fact_address, $contract_number, $add_date, $contract_start_date, $contract_end_date, $contract_price, $angarish_period, $angarish_period1, $invois, $migeba_chabareba, $angarishfaqtura);
    	}else{
    		Saveclient($hidden_id, $identity_code, $client_name, $jurid_address, $fact_address, $contract_number, $add_date, $contract_start_date, $contract_end_date, $contract_price, $angarish_period, $angarish_period1, $invois, $migeba_chabareba, $angarishfaqtura);
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
function Addclient($identity_code, $client_name, $jurid_address, $fact_address, $contract_number, $add_date, $contract_start_date, $contract_end_date, $contract_price, $angarish_period, $angarish_period1, $invois, $migeba_chabareba, $angarishfaqtura){
	$user = $_SESSION['USERID'];
	
	mysql_query("INSERT INTO `client` 
				(`user_id`, `name`, `identity_code`, `juridical_address`, `physical_address`, `image_id`, `actived`) 
		VALUES 
				('$user', '$client_name', '$identity_code', '$jurid_address', '$fact_address', '', '1')");
		
	$client_id = mysql_insert_id();
	
	if ($contract_number !='') {
		mysql_query("INSERT INTO `client_contract` 
								(`user_id`, `client_id`, `number`, `create_date`, `validity_period_start`, `validity_period_end`, `price`, `reporting_period_type`, `reporting_period_count`, `file_id`, `actived`) 
						VALUES 
								('$user', '$client_id', '$contract_number', '$add_date', '$contract_start_date', '$contract_end_date', '$angarish_period1', '', '$angarish_period', '', '1')");
	}
	if ($invois==1 || $migeba_chabareba==1 || $angarishfaqtura==1) {
		mysql_query("INSERT INTO `client_documents` 
							(`user_id`, `client_id`, `invoice`, `taking_over_act`, `report_invoice`, `actived`) 
						VALUES 
							('$user', '$client_id', '$invois', '$migeba_chabareba', '$angarishfaqtura', '1')");
	}
}
function Saveclient($hidden_id, $identity_code, $client_name, $jurid_address, $fact_address, $contract_number, $add_date, $contract_start_date, $contract_end_date, $contract_price, $angarish_period, $angarish_period1, $invois, $migeba_chabareba, $angarishfaqtura){
	$user = $_SESSION['USERID'];
	
	mysql_query("	UPDATE 	`client`  
						SET `user_id`			='$user', 
							`name`				='$client_name', 
							`identity_code`		='$identity_code', 
							`juridical_address`	='$jurid_address', 
							`physical_address`	='$fact_address', 
							`image_id`			='0', 
							`actived`			='1' 
					WHERE `id`='$hidden_id'");
	
	$res=mysql_query("	SELECT *
						FROM client_contract
						WHERE client_id='$hidden_id'
						LIMIT 1
					 ");
	$check=mysql_num_rows($res);
	if ($check==1) {
		mysql_query("UPDATE `client_contract` 
						SET 
							`user_id`='$user', 
							`number`='$contract_number', 
							`create_date`='$add_date', 
							`validity_period_start`='$contract_start_date', 
							`validity_period_end`='$contract_end_date', 
							`price`='$contract_price', 
							`reporting_period_type`='$angarish_period1', 
							`reporting_period_count`='$angarish_period', 
							`file_id`='0' 
					  WHERE `client_id`='$hidden_id'");
	}else {
		mysql_query("INSERT INTO `client_contract`
							(`user_id`, `client_id`, `number`, `create_date`, `validity_period_start`, `validity_period_end`, `price`, `reporting_period_type`, `reporting_period_count`, `file_id`, `actived`)
						VALUES
							('$user', '$hidden_id', '$contract_number', '$add_date', '$contract_start_date', '$contract_end_date', '$contract_price', '$angarish_period1', '$angarish_period', '', '1')");
	}
	
	$res1=mysql_query("	SELECT *
						FROM client_documents
						WHERE client_id='$hidden_id'
						LIMIT 1
			");
	$check1=mysql_num_rows($res1);
	if ($check1==1) {
		mysql_query("UPDATE `client_documents` 
								SET 
									`user_id`='$user', 
									`client_id`='$hidden_id', 
									`invoice`='$invois', 
									`taking_over_act`='$migeba_chabareba', 
									`report_invoice`='$angarishfaqtura'
									 
						WHERE `client_id`='$hidden_id'");
	}else {
		mysql_query("INSERT INTO `client_documents` 
							(`user_id`, `client_id`, `invoice`, `taking_over_act`, `report_invoice`, `actived`) 
						VALUES 
							('$user', '$hidden_id', '$invois', '$migeba_chabareba', '$angarishfaqtura', '1')");
	}
		
}


function Get_reporting_period_type($type){
	$data = '';
	$req = mysql_query("SELECT id, `name`
						FROM `reporting_period_type`
						");

	$data .= '<option value="0" selected="selected">----</option>';
	while( $res = mysql_fetch_assoc($req)){

		if($res['id'] == $type){
			$data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
		}else{
			$data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
		}
	}
	return $data;
}
function Get_reporting_period_count($count){
	$data = '';
	$req = mysql_query("SELECT id,`name` 
						FROM `reporting_period_count`");

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
function Getclient($hidden_id)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT  client.`id`,
													client.`name`,
													client.identity_code,
													client.juridical_address,
													client.physical_address,
													client_contract.create_date,
													client_contract.id AS contract_id,
													client_contract.number,
													client_contract.price,
													client_contract.reporting_period_count,
													client_contract.reporting_period_type,
													client_contract.validity_period_end,
													client_contract.validity_period_start,
													client_documents.invoice,
													client_documents.report_invoice,
													client_documents.taking_over_act
													
											FROM 	client
											LEFT JOIN client_contract ON client.id=client_contract.client_id
											LEFT JOIN client_documents ON client_documents.client_id=client.id
											WHERE 	client.id='$hidden_id'"));
	return $res;
}

function GetPage($res,$increment){
	
	
	if ($res[id]=='') {
		$hid_id=increment(client);
		$hid_contract_id=increment(client_contract);
	}else{
		$hid_id=$res[id];
		$hid_contract_id=$res[id];
	}
	
	$image = $res['image'];
	if(empty($image)){
		$image = '0.jpg';
	}
	if ($res[invoice]==1) {
		$inv_check="checked";
	}else{
		$inv_check="";
	}
	if ($res[report_invoice]==1) {
		$report_check="checked";
	}else {
		$report_check="";
	}
	if ($res[taking_over_act]==1) {
		$taking_check="checked";
	}else {
		$taking_check="";
	}
	$data  .= '
	<div id="tabs1" style="width: auto; height: 557px;">
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
						<img style="margin-left: 5px;;" id="upload_img" src="media/uploads/images/worker/'.$image.'" />
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
						<div style="margin-top:10px; width: 127px; margin-left: -5px;" class="file-uploader">
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
						<input type="text" id="identity_code" style="width: 300px;" value="'.$res['identity_code'].'"/>
					</td>
				    <td>
						<button style="float:right;" id="client_check" style="width: 60px;">შეამოწმე</button>
					</td>
				</tr>
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1_1">დასახელება</label></td>
	           </tr>
	           <tr>
	               <td colspan="2"><input id="client_name" style="resize: vertical;width: 415px;" value="'.$res['name'].'"/></td>
	           </tr>
	           <tr>
	               <td colspan="2"><label for="incomming_cat_1_1_1">იურიდიული მისამართი</label></td>
    	       </tr>
	           <tr>
	               <td colspan="2"><input id="jurid_address" type="text" style="width: 415px;" value="'.$res['juridical_address'].'"/></td>
    	       </tr>
	       		<tr>
	               <td colspan="2"><label for="incomming_comment">ფაქტიური მისამართი</label></td>
	           </tr>
	           <tr>
	               <td colspan="2"><input id="fact_address" style="resize: vertical;width: 415px;" value="'.$res['physical_address'].'"/></td>
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
				<table class="display" id="table_client">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">სახელი</th>
                            <th style="width: 100%;">გვარი</th>
                            <th style="width: 103px;">თანამდებობა</th>
                            <th style="width: 100%;">მობილური</th>
							<th style="width: 100%;">ტელეფონი</th>
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
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
							<th>
				                <input style="margin-left: 9px;" type="checkbox" name="check-all" id="check-all">
				            </th>
                        </tr>
                    </thead>
                </table>
	            </div>
         </fieldset>
	    
	    
        <div id="side_menu" style="float: left;height: 495px;width: 80px;margin-left: 10px; background: #272727; color: #FFF;margin-top: 6px;">
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
                                <td><input style="margin-top: 10px;" id="contract_number" type="text" value="'.$res[number].'"></td>
        	                    <td><input style="margin-top: 10px;" id="add_date" type="text" value="'.$res[create_date].'"></td>
                            </tr>
    	                    <tr>
        	                    <td colspan="2"><label style="margin-left: 135px; margin-top: 20px;" for="client_person_mail2">მოქმედების პერიოდი</label></td>
                            </tr>
    	                    <tr>
                                <td><input style="margin-top: 10px;" id="contract_start_date" type="text" value="'.$res[validity_period_start].'">
									
								</td>
        	                    <td><input style="margin-top: 10px;" id="contract_end_date" type="text" value="'.$res[validity_period_end].'"></td>
                            </tr>
	                        <tr>
                                <td colspan="2"><label style="margin-top: 20px;" for="client_person_addres2">ხელშეკრულების ღირებულება</label></td>
                            </tr>
    	                    <tr>
								<tdcolspan="2">
									<td>
										<input style="margin-top: 10px;" style="width: 216px;" id="contract_price" type="text" value="'.$res[price].'">
									</td>
									<td><label style="margin-left: -58px; margin-top: 16px;">-ლარი</label></td>
								</td>
                            </tr>
							<tr>
                                <td colspan="2"><label style="margin-left: 141px; margin-top: 20px;" for="client_person_phone2">საანგარიშო პერიოდი</label></td>
                            </tr>
    	                    <tr>
                                <td>
									<select style="margin-top: 10px;"  id="angarish_period">'. Get_reporting_period_count($res[reporting_period_count]).'</select>
								</td>
        	                    <td>
									<select style="margin-top: 10px;"  id="angarish_period1">'. Get_reporting_period_type($res[reporting_period_type]).'</select>
								</td>
                            </tr>
							<tr>
								<td colspan="2">
									'.show_file($res).'
								</td>
							</tr>				
                        </table>
				 </div>
											
				<fieldset>
			</fieldset>
    	    <fieldset style="display:none;" id="task">
                <legend>დოკუმენტი</legend>
	            <span style="margin-right: 5px; margin-top: 50px;" class="hide_said_menu">x</span>
	            <table>
	               <tr>
						<td><input type="checkbox" id="invois" class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="1" style="display: inline; margin-left: 20px; margin-top: -5px; width: 16px;" '.$inv_check.'/></td>
	                    <td><label>ინვოისი</label></td>
	               </tr>
				   <tr>
						<td><input type="checkbox" id="migeba_chabareba" class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="1" style="display: inline; margin-left: 20px; margin-top: 14px; width: 16px;" '.$taking_check.'/></td>
	                    <td><label style="margin-top: 20px;">მირება-ჩაბარების აქტი</label></td>
	               </tr>
			       <tr>
						<td><input type="checkbox" id="angarishfaqtura" class="idle" onblur="this.className=\'idle\'" onfocus="this.className=\'activeField\'" value="1" style="display: inline; margin-left: 20px; margin-top: 14px; width: 16px;" '.$report_check.'/></td>
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
				<table class="display" id="table_project" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">დასახელება</th>
                            <th style="width: 100%;">ტიპი</th>
                            <th style="width: 100%;">შექმნის თარიღი</th>
                            <th style="width: 100%;">ნომრები</th>
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
	</div>
	</div>
	<input type="hidden" value="'.$res[id].'" id="hidden_id">
	<input type="hidden" value="'.$hid_id.'" id="hidden_client_id">
	<input type="hidden" value="'.$hid_contract_id.'" id="hidden_clientcontract_id">';

	return $data;
}

function show_file($res){
	$file_incomming = mysql_query(" SELECT `name`,
											`rand_name`,
											`file_date`,
											`id`
									FROM   `file`
									WHERE  `client_contract_id` = $res[contract_id] AND `actived` = 1");
	while ($file_res_incomming = mysql_fetch_assoc($file_incomming)) {
		$str_file_contract .= '<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 137px;float:left;">'.$file_res_incomming[file_date].'</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 110px;float:left;">'.$file_res_incomming[name].'</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;width: 110px;float:left;" onclick="download_file(\''.$file_res_incomming[rand_name].'\')">ჩამოტვირთვა</div>
                            	<div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;cursor: pointer;width: 20px;float:left;" onclick="delete_file(\''.$file_res_incomming[id].'\')">-</div>';
	}
	$data = '<div style="margin-top: 45px;">
                    <div style="width: 100%; border:1px solid #CCC;float: left;">
    	                   <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 137px;float:left;">თარიღი</div>
                    	   <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 110px;float:left;">დასახელება</div>
                    	   <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 110px;float:left;">ჩამოტვირთვა</div>
                           <div style="border: 1px solid #CCC;padding: 5px;text-align: center;vertical-align: middle;width: 20px;float:left;">-</div>
    	                   <div style="border: 1px solid #CCC;text-align: center;vertical-align: middle;float: left;width: 421px;"><button id="upload_file" style="cursor: pointer;background: none;border: none;width: 100%;height: 25px;padding: 0;margin: 0;">აირჩიეთ ფაილი</button><input style="display:none;" type="file" name="file_name" id="file_name"></div>
                           <div id="paste_files">
                           '.$str_file_contract.'
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
    mysql_query("ALTER TABLE '$table' AUTO_INCREMENT=$next_increment");

    return $increment;
}

?>