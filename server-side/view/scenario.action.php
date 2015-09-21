<?php
require_once('../../includes/classes/core.php');
$action	= $_REQUEST['act'];
$error	= '';
$data	= '';

$user_id	       = $_SESSION['USERID'];
$quest_id          = $_REQUEST['id'];
$quest_detail_id   = $_REQUEST['quest_detail_id'];
$add_id            = $_REQUEST['add_id'];
$name              = $_REQUEST['name'];
$note              = $_REQUEST['note'];
$answer            = $_REQUEST['answer'];
$quest_type_id     = $_REQUEST['quest_type_id'];
$quest_id1         = $_REQUEST['quest_id1'];

$cat               = $_REQUEST['cat'];
$le_cat            = $_REQUEST['le_cat'];

switch ($action) {
	case 'get_add_page':
		$page		= GetPage(GetList($add_id));
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(GetList($quest_id,$quest_detail_id));
		$data		= array('page'	=> $page);

		break;
	case 'get_list' :
		$count	= $_REQUEST['count'];
		$hidden	= $_REQUEST['hidden'];
			
		$rResult = mysql_query("SELECT 	`scenario`.`id`,
                        				`scenario`.`name`,
                        				`cat`.`name`,
                        				`le_cat`.`name`
                                FROM 	`scenario`
                                JOIN    `scenario_category` AS `cat` ON `scenario`.`scenario_cat_id` = `cat`.`id`
                                JOIN    `scenario_category` AS `le_cat` ON `scenario`.`scenario_le_cat_id` = `le_cat`.`id`
                                WHERE 	`scenario`.`actived` = 1");

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
	case 'get_list_detail' :
	    $count	= $_REQUEST['count'];
	    $hidden	= $_REQUEST['hidden'];
	    	
	    $rResult = mysql_query("SELECT 	`scenario_detail`.`id`,
	                                    `scenario_detail`.`sort`,
                        				`question`.`name`
                                FROM 	`scenario_detail`
                                LEFT JOIN question ON scenario_detail.quest_id = question.id
                                WHERE 	`scenario_detail`.`actived` = 1 AND `scenario_detail`.`scenario_id` = $quest_id");
	
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
	case 'save_quest':
	    if($quest_id == ''){
	       save($user_id, $name, $cat, $le_cat);
	    }else{
	       update($quest_id, $name, $cat, $le_cat);
	    }	    
	    
	    if($_REQUEST[dest_checker] == 1){
	        $checker     = json_decode($_REQUEST[checker]);
    	    foreach ($checker as $key => $value) {
    	         $quest_id = str_replace("scenarquest","",$key);
    	         $val = substr($value,10);
    	         $twoinone = preg_split("/[\s|]+/",$quest_id);

                 $rr = mysql_fetch_array(mysql_query("  SELECT id
                                                        FROM `scenario_destination`
                                                        WHERE scenario_detail_id  = $twoinone[1] AND answer_id = $twoinone[2]"));
                 
                 if($rr[0] == ''){
                     mysql_query("INSERT INTO `scenario_destination`
                                 (`scenario_detail_id`, `destination`, `answer_id`)
                                 VALUES
                                 ( '$twoinone[1]', '$val', '$twoinone[2]');");
                 }else{
                     mysql_query("  UPDATE `scenario_destination`
                                    SET `destination`=$val
                                    WHERE `id`=$rr[0]");
                 }

    	    }
	    }
		break;
	case 'save_answer':
	    if($_REQUEST['quest_detail_id'] == ''){
	        save_answer($user_id, $quest_id1, $add_id);
	    }else{
	        update_answer($quest_detail_id, $quest_id1, $_REQUEST['quest_id']);
	    }
		
		break;
	case 'disable':
	    if($quest_detail_id != ''){
		    disable_det($quest_detail_id);
	    }else{
	        disable($quest_id);
	    }

		break;
	case 'get_scen_cat':
	    $data['cat'] = GetLeCat($_REQUEST['cat_id'],'');
		
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

function save($user_id, $name, $cat, $le_cat)
{
    global $error;
    $name_cheker = mysql_num_rows(mysql_query("SELECT id FROM scenario WHERE `name` = '$name'"));
    if($name_cheker == 0){
        mysql_query("INSERT INTO `scenario`
                    (`user_id`,`name`,`scenario_cat_id`,`scenario_le_cat_id`)
                    VALUES
                    ('$user_id','$name','$cat','$le_cat')");
        
    }else{
        $error = 'ესეთი სახელი უკვე არსებობს!';
    }
    return $error;
}

function update($quest_id, $name, $cat, $le_cat)
{
    mysql_query("	UPDATE  `scenario`
                    SET     `name`                  = '$name',
                            `scenario_cat_id`       = '$cat',
                            `scenario_le_cat_id`    = '$le_cat'
                    WHERE	`id`   = $quest_id");
}

function save_answer($user_id, $quest_id1, $add_id)
{
    global $error;
    $name_cheker = mysql_num_rows(mysql_query("SELECT id FROM scenario_detail WHERE `quest_id` = '$quest_id1' AND `scenario_id` = '$add_id'"));
    if($name_cheker == 0){
    
    $sort = mysql_fetch_array(mysql_query(" SELECT  `sort`
                                            FROM 	`scenario_detail`
                                            WHERE 	`scenario_id` = $add_id
                                            ORDER BY `id` DESC
                                            LIMIT 1"));
    if($sort[0] == ''){
        $sort_key = 1;
    }else{
        $sort_key = $sort[0]+1;
    }
    
    $answer_check = mysql_num_rows(mysql_query("SELECT question.id
                                                FROM `question`
                                                JOIN question_detail ON question.id = question_detail.quest_id
                                                WHERE question.id = $quest_id1"));
    
    if($answer_check > 0){
    mysql_query("INSERT INTO `scenario_detail`
                (`user_id`,`quest_id`,`scenario_id`,`sort`)
                VALUES
                ('$user_id','$quest_id1','$add_id','$sort_key')");

    }else{
        $error = 'ამ კითხვას არ აქვს პასუხები! ჯერ პასუხები შეავსეთ და მერე დაამატეტ კითხვა სცენარში!';
    }    
    }else{
        $error = 'ესეთი სახელი უკვე არსებობს!';
    }
 return $error;
}

function update_answer($quest_detail_id, $quest_id1, $quest_id)
{
    mysql_query("	UPDATE  `scenario_detail`
                    SET     `quest_id`      = '$quest_id1',
                            `scenario_id`   = '$quest_id'
                    WHERE	`id`            =  $quest_detail_id");
}

function disable($quest_id)
{
    mysql_query("	UPDATE  `scenario`
                    SET     `actived` = 0
                    WHERE	`id`      = $quest_id");
}

function disable_det($quest_detail_id)
{
    mysql_query("	UPDATE  `scenario_detail`
                    SET     `actived` = 0
                    WHERE	`id`      = $quest_detail_id");
}

function GetQuest($quest_detail_id, $rr)
{
    $rrr = mysql_fetch_array(mysql_query("  SELECT  `question`.`id`
                                            FROM 	`scenario`
                                            LEFT JOIN scenario_detail ON scenario.id = scenario_detail.scenario_id
                                            LEFT JOIN question ON scenario_detail.quest_id = question.id
                                            WHERE 	`scenario_detail`.`id` = $rr"));
    
    $req = mysql_query("	SELECT 	`question`.`id`,
                                    `question`.`name`
                            FROM 	`question`
                            WHERE 	`question`.`actived` = 1" );

    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $rrr[0]){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function GetCat($cat_id)
{
    $req = mysql_query("	SELECT  `id`,
                                    `name`
                            FROM    `scenario_category`
                            WHERE   `parent_id` = 0 AND `actived` = 1" );

    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $cat_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function GetLeCat($cat_id,$le_cat_id)
{
    $req = mysql_query("	SELECT  `id`,
                                    `name`
                            FROM    `scenario_category`
                            WHERE   `parent_id` = $cat_id AND `actived` = 1" );

    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $le_cat_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function GetAlScenQuest($scenarquest,$dest)
{
    $req = mysql_query("	SELECT  `question`.`id`,
                    				`question`.`name`
                            FROM    `scenario`
                            JOIN 	`scenario_detail` ON `scenario`.`id` = `scenario_detail`.`scenario_id`
                            JOIN 	`question` ON `scenario_detail`.`quest_id` = `question`.`id`
                            WHERE 	`scenario`.`id` = $scenarquest AND scenario_detail.actived = 1 AND scenario.actived = 1" );

    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $dest){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
}

function GetList($quest_id,$quest_detail_id)
{
    if($quest_id != ''){
        $checker = "scenario.`id` = $quest_id";
    }
    if($quest_detail_id != ''){
        $checker = "scenario_detail.`id` = $quest_id";
    }
	$res = mysql_fetch_assoc(mysql_query("	SELECT  `scenario`.`id` AS `scenario_id`,
                                    				`scenario`.`name` AS `scenario_name`,
                                    				`scenario_detail`.`id` AS `sc_detal_id`,
	                                                `scenario_detail`.`quest_id` AS `quest_id`,
                                    				`question`.`name` AS `quest_name`,
                                                    `scenario`.`scenario_cat_id`,
                                    				`scenario`.`scenario_le_cat_id`
                                            FROM 	`scenario`
                                            LEFT JOIN scenario_detail ON scenario.id = scenario_detail.scenario_id
                                            LEFT JOIN question ON scenario_detail.quest_id = question.id
                                            WHERE 	$checker"));

	return $res;
}



function GetPage($res = '')
{	
    $data = '
	<div id="dialog-form">
	    <fieldset>
	    	<legend>ძირითადი ინფორმაცია</legend>
    
	    	<table class="dialog-form-table" style="margin:0 0 10px 0;">
				<tr>
					<td style="width: 170px;"><label for="name">სახელი</label></td>
					<td>
						<textarea type="text" id="name" style="margin: 0px; width: 226px; resize:vertical;">' . $res['scenario_name'] . '</textarea>
					</td>
				</tr>
                <tr>
					<td style="width: 170px;"><label for="">კატეგორია</label></td>
					<td>
						<select style="width: 231px;" id="cat" class="idls object">'. GetCat($res[scenario_cat_id]).'</select>
					</td>
				</tr>
			    <tr>
					<td style="width: 170px;"><label for="">ქვე-კატეგორია</label></td>
					<td>
						<select style="width: 231px;" id="le_cat" class="idls object">'. GetLeCat($res[scenario_cat_id],$res[scenario_le_cat_id]).'</select>
					</td>
				</tr>
			</table>';
			if($_REQUEST['id'] != ''){
			    if($_REQUEST['quest_detail_id'] == ''){
    			    $data .=  ' <div id="taab" style="margin: 0 auto; margin-top: 25px;">
                            	<div id="callapp_tab">
                            		<span id="tab1">დიალოგური ფანჯარა</span>
                            		<span id="tab2">კითხვების რიგითობა</span>
                            	</div>
                            	<div id="tab_content_1">
    			        
    			                <div id="button_area">
                    			    <button id="add_button_detail">დამატება</button>
                    			    <button id="delete_button_detail">წაშლა</button>
                			    </div>
                			    <table class="" id="table_quest" style="background-color: #FFF;">
                    			    <thead >
                        			    <tr id="datatable_header">
                            			    <th style="display:none;">ID</th>
    			                            <th style="width: 60px;">#</th>
                            			    <th style="width: 100%;">დასახელება</th>
                            			    <th class="check"></th>
                        			    </tr>
                    			    </thead>
                    			    <thead>
                        			    <tr class="search_header">
                            			    <th class="colum_hidden" style="display:none;"></th>		    
                            			    <th>
                            			    </th>
    			                            <th>
                            			         <input style="width: 100%;" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            			    </th>
                            			    <th>
                            			         <input type="checkbox" name="check-all" id="check-all-de">
                            			    </th>
                        			    </tr>
                    			    </thead>
                			    </table>
    			             </div>
                        	<div id="tab_content_2">';
                			    $i = 1;
                			    
                			  $query = mysql_query("SELECT 	    `question`.id,
                                            			        `question`.`name`,
                                            			        `question`.note,
                                            			        `scenario`.`name`
                                			        FROM        `scenario`
                                			        JOIN        scenario_detail ON scenario.id = scenario_detail.scenario_id
                                			        JOIN        question ON scenario_detail.quest_id = question.id
                                			        WHERE       scenario.id = $res[scenario_id] AND scenario_detail.actived = 1
                                			        ORDER BY    scenario_detail.sort ASC");
                			  
                			  $query2 = mysql_query(" SELECT 	`destination`,
                                            		            `answer_id`
                                            		    FROM 	`scenario_destination`
                                            		    JOIN 	`scenario_detail` ON scenario_destination.scenario_detail_id = scenario_detail.id
                                            		    JOIN 	`scenario` ON scenario_detail.scenario_id = scenario.id
                                            		    WHERE 	`scenario`.id = $res[scenario_id] AND scenario_destination.destination != 0");
                			  
                			  while ($rame = mysql_fetch_array($query2)){
                			      $destination .= ', '.$rame[0];
                			      $answer_id .= ', '.$rame[1];
                			  }
                			  $destination = substr($destination, 1);
                			  $answer_id = substr($answer_id, 1);
                			        //$row_scen = mysql_fetch_array($query);
                			    $data .= '<div id="dialog-form" style="width:102%; overflow-y:scroll; max-height:400px;">
                                <fieldset>
                                    <legend>კითხვები</legend>';
                			    
            		while ($row = mysql_fetch_array($query)) {
            		    
            		    
            		    if($answer_id==''){
            		        $answer_id = 0;
            		    }
                			    		$query1 = mysql_query(" SELECT 	CASE 	WHEN question_detail.quest_type_id = 1 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input',IF(question_detail.id in($answer_id) ,' checked',''), ' class=\"check_input\" style=\"float:left;\" type=\"checkbox\" name=\"checkbox', question.id, '\" value=\"', question_detail.id, '\"><label style=\"float:left; padding: 7px;\">', question_detail.answer, '</label></td>')
                                                    							WHEN question_detail.quest_type_id = 2 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input value=\"\" class=\"inputtext\"style=\"float:left;\" type=\"text\" id=\"input|', question.id, '|', question_detail.id, '\" /> <label style=\"float:left; padding: 7px;\" for=\"input|', question.id, '|', question_detail.id, '\">',question_detail.answer,'</label></td>')
                                                    							WHEN question_detail.quest_type_id = 4 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input',IF(question_detail.id in($answer_id),' checked',''), ' class=\"radio_input\" style=\"float:left;\" type=\"radio\" name=\"radio', question.id, '\" value=\"', question_detail.id, '\"><label style=\"float:left; padding: 7px;\">', question_detail.answer, '</label></td>')
                                                    							WHEN question_detail.quest_type_id = 5 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input value=\"\" class=\"date_input\"style=\"float:left;\" type=\"text\" id=\"input|', question.id, '|', question_detail.id, '\" /> <label style=\"float:left; padding: 7px;\" for=\"input|', question.id, '|', question_detail.id, '\">',question_detail.answer,'</label></td>')
                                                    							WHEN question_detail.quest_type_id = 6 THEN CONCAT('<tr><td style=\"width:707px; text-align:left;\"><input value=\"\" class=\"date_time_input\"style=\"float:left;\" type=\"text\" id=\"input|', question.id, '|', question_detail.id, '\" /> <label style=\"float:left; padding: 7px;\" for=\"input|', question.id, '|', question_detail.id, '\">',question_detail.answer,'</label></td>')
                                                    				    END AS `ans`,
                                                                		question_detail.quest_type_id,
                			    		                                IF(question_detail.id in($answer_id) ,question_detail.id,'') AS `checked_quest`,
                			    		                                scenario_detail.id as sc_id,
                			    		                                question_detail.id as as_id,
                			    		                                scenario_destination.destination as dest
                                                                FROM `question_detail`
                                                                JOIN  question ON question_detail.quest_id = question.id
                                                                LEFT JOIN scenario_detail ON question.id = scenario_detail.quest_id
                			    		                        LEFT JOIN scenario_destination ON scenario_detail.id = scenario_destination.scenario_detail_id AND scenario_destination.answer_id = question_detail.id
                                                                LEFT JOIN scenario ON scenario_detail.scenario_id = scenario.id 
                                                                WHERE question_detail.quest_id = $row[0] AND question_detail.actived = 1 AND scenario.id = $res[scenario_id]
                                                                GROUP BY question_detail.id
                                                                ORDER BY question.id, question_detail.quest_type_id ASC");
                			    			
                			    		
                			    
                			    		$data .= '<textarea style="width: 704px; height:100px; resize: none; background: #EBF9FF;" class="idle">'. $row[2] .'</textarea>
                			    		<table class="dialog-form-table">
                			    		<tr>
                			    		<td style="font-weight:bold;">'.$i++.'. '. $row[1] .'</td>
                			    		</tr>
                			    		
                			    		';
                			    		while ($row1 = mysql_fetch_array($query1)) {
                			    		$q_type = $row1[1];
                			    		$dest = $row1[5];
                			    		if($row1[1] == 3){
                			    		$tr .= $row1[0];
                			    		$data1 = ' <style>
                			    
                			    		#prod{
                			    		border:2px solid #85B1DE; width:100%;
                			    		}
                			    		#prod #prodtr{
                			    		background:#F2F2F2;
                			    }
                			    #prod th{
                			    width:0%; padding:5px; border:1px solid #85B1DE;
                                                      }
                			        #prod td{
                			        border:1px solid #85B1DE; padding:2px;
                                                      }
                                                      #prod tr{
                			                                                  background: #FEFEFE
                			    		}
                			    
                			    		</style>
                			    		<table id="prod">
                			    		<tr id="prodtr">
                			    		<th>დასახელება</th>
                			    		    <th>ფასი</th>
                			    		<th>აღწერა</th>
                			    		    <th>კომენტარი</th>
                			    		<th>#</th>
                			    		</tr>
                			    		'.$tr.'
                                                  </table>';
                                              }else{                                                                                                   
                                                  $data .= $row1[0];
                                                  $data .= '
                			    		                       <td style="float:left; width: 350px;"><select style="width: 231px;" id="scenarquest|'.$row1[3].'|'.$row1[4].'" class="idls object scenarquest">'. GetAlScenQuest($res[scenario_id],$dest).'</select></td>
                			    		                   </tr>'; 
                                              }
                			    
                                        }
                                        
                                if($q_type == 3){
                                    $data .= $data1;
                                }
                                $data .= '</table>
                                <hr><br>';
            		}
                			    
            		$data .= '</fieldset>
            		</div>';
    			    
                        	$data .= '</div>    			            
                            </div>
    			        ';
			    }
			}
			if($_REQUEST['quest_detail_id'] != '' || $_REQUEST['add_id'] != ''){
			    $data .=  ' <table class="dialog-form-table">  
			                    <tr>
                					<td style="width: 170px;"><label for="quest_id1">კითხვა</label></td>
                					<td>
                						<select style="width: 231px;" id="quest_id1" class="idls object">'. GetQuest($res['quest_id'],$_REQUEST['id']).'</select>
                					</td>
                				</tr>                				
                			</table>
                			<script>$("#name, #cat, #le_cat").prop("disabled", true);</script>';
			}
			$data .=  '<!-- ID -->
			<input type="hidden" id="quest_id" value="' . $res['scenario_id'] . '" />
			<input type="hidden" id="quest_detail_id" value="'.$_REQUEST['id'].'" />
			<input type="hidden" id="add_id" value="' . $_REQUEST['add_id'] . '" />
			<input type="hidden" id="dest_checker" value="0" />
        </fieldset>
    </div>
    ';
	return $data;
}

?>

