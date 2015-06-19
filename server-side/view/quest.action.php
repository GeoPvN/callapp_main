<?php
require_once('../../includes/classes/core.php');
$action	= $_REQUEST['act'];
$error	= '';
$data	= '';

$user_id	       = $_SESSION['USERID'];
$quest_id          = $_REQUEST['quest_id'];
$quest_detail_id   = $_REQUEST['quest_detail_id'];
$add_id            = $_REQUEST['add_id'];
$name              = $_REQUEST['name'];
$note              = $_REQUEST['note'];
$answer            = $_REQUEST['answer'];
$quest_type_id     = $_REQUEST['quest_type_id'];
$hidden_product_id = $_REQUEST['hidden_product_id'];

switch ($action) {
	case 'get_add_page':
		$page		= GetPage();
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(GetList($quest_id,$quest_detail_id));
		$data		= array('page'	=> $page);

		break;
	case 'get_list' :
		$count	= $_REQUEST['count'];
		$hidden	= $_REQUEST['hidden'];
			
		$rResult = mysql_query("SELECT 	`quest_1`.`id`,
                        				`quest_1`.`name`,
                        				`quest_1`.`note`
                                FROM 	`quest_1`
                                WHERE 	`quest_1`.`actived` = 1");

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
	    
	    mysql_query("SET @i = 0;");
	    $rResult = mysql_query("SELECT 	`quest_detail`.`id`,
	                                    @i := @i+1 AS `order_id`,
                        				IF(quest_detail.quest_type_id = 3,`production`.`name`,`quest_detail`.`answer`) AS `answer`,
                        				`quest_type`.`name` AS `quest_type`
                                FROM 	`quest_detail`
                                JOIN	`quest_1` ON quest_detail.quest_id = quest_1.id
                                JOIN	`quest_type` ON quest_detail.quest_type_id = quest_type.id
                                LEFT JOIN `production` ON `quest_detail`.`product_id` = `production`.`id`
                                WHERE 	`quest_detail`.`actived` = 1 AND quest_1.id = $quest_id");
	
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
	       save($user_id, $name, $note);
	    }else{
	       update($quest_id, $name, $note);
	    }

		break;
	case 'save_answer':
	    if($quest_detail_id == ''){
	        save_answer($user_id, $answer, $quest_type_id, $add_id, $hidden_product_id);
	    }else{
	        update_answer($quest_detail_id,  $answer, $quest_type_id, $quest_id, $hidden_product_id);
	    }
		
		break;
	case 'disable':
	    if($quest_detail_id != ''){
		    disable_det($quest_detail_id);
	    }else{
	        disable($quest_id);
	    }

		break;
	case 'get_product_info':
		    $name 			= $_REQUEST[name];
		    $res 			= GetProductInfo($name);
		    if(!$res){
		        $error = 'პროდუქტი ვერ მოიძებნა!';
		    }else{
		        $data = array(  'genre'	                => $res['genre'],
            		            'category'	     		=> $res['category'],
            		            'description'	 		=> $res['description'],
            		            'price'	        		=> $res['price'],
            		            'id'	    			=> $res['id']);
		    }
		
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

function save($user_id, $name, $note)
{
    global $error;
    $name_cheker = mysql_num_rows(mysql_query("SELECT id FROM quest_1 WHERE `name` = '$name'"));
    if($name_cheker == 0){
    mysql_query("INSERT INTO `quest_1`
                (`user_id`,`name`,`note`)
                VALUES
                ('$user_id','$name','$note')");
    }else{
        $error = 'ესეთი სახელი უკვე არსებობს!';
    }
    return $error;
}

function update($quest_id, $name, $note)
{
    mysql_query("	UPDATE  `quest_1`
                    SET     `name` = '$name',
                            `note` = '$note'
                    WHERE	`id`   = $quest_id");
}

function save_answer($user_id, $answer, $quest_type_id, $quest_id, $hidden_product_id)
{
    global $error;
    if($answer == ''){
        $name_checker = "`product_id` = '$hidden_product_id'";
    }else{
        $name_checker = "`answer` = '$answer'";
    }
    $name_cheker = mysql_num_rows(mysql_query("SELECT id FROM quest_detail WHERE $name_checker AND `quest_id` = '$quest_id'"));
    if($name_cheker == 0){
    mysql_query("INSERT INTO `quest_detail`
                (`user_id`,`answer`,`quest_id`,`quest_type_id`,`product_id`)
                VALUES
                ('$user_id','$answer','$quest_id','$quest_type_id','$hidden_product_id')");
    }else{
        $error = 'ესეთი სახელი უკვე არსებობს!';
    }
    return $error;
}

function update_answer($quest_detail_id,  $answer, $quest_type_id, $quest_id, $hidden_product_id)
{
    mysql_query("	UPDATE  `quest_detail`
                    SET     `answer`        = '$answer',
                            `quest_id`      = '$quest_id',
                            `quest_type_id` = '$quest_type_id',
                            `product_id`    = '$hidden_product_id'
                    WHERE	`id`            =  $quest_detail_id");
}

function disable($quest_id)
{
    mysql_query("	UPDATE  `quest_1`
                    SET     `actived` = 0
                    WHERE	`id`      = $quest_id");
}

function disable_det($quest_detail_id)
{
    mysql_query("	UPDATE  `quest_detail`
                    SET     `actived` = 0
                    WHERE	`id`      = $quest_detail_id");
}

function GetList($quest_id,$quest_detail_id)
{
    if($quest_id != ''){
        $checker = "and quest_1.`id` = $quest_id";
    }
    if($quest_detail_id != ''){
        $checker = "and quest_detail.`id` = $quest_detail_id";
    }
	$res = mysql_fetch_assoc(mysql_query("	SELECT 	    `quest_1`.`id` AS `quest_id`,
                                						`quest_1`.`name`,
                                						`quest_1`.`note`,
                                						`quest_detail`.`id` AS `quest_detail_id`,
                                						`quest_detail`.`answer`,
                                						`quest_detail`.`quest_type_id`,
                                						`production`.`name` AS `product_name`,
                                						`production`.price,
                                						`production`.description,
                                						`genre`.`name` AS `genre_name`,
                                						`department`.`name` AS `dep_name`,
	                                                    `production`.`id` AS `prod_id`
                                            FROM 	    `quest_1`
                                            LEFT JOIN	`quest_detail` ON quest_1.id = quest_detail.quest_id
                                            LEFT JOIN	`quest_type` ON quest_detail.quest_type_id = quest_type.id
                                            LEFT JOIN	`production` ON quest_detail.product_id = production.id
                                            LEFT JOIN	`genre` ON production.genre_id = genre.id
                                            LEFT JOIN	`department` ON production.production_category_id = department.id
                                            WHERE 	    `quest_1`.`actived` = 1 $checker"));

	return $res;
}

function GetQuestType($quset_type_id)
{
    $req = mysql_query("	SELECT 	`quest_type`.`id`,
                                    `quest_type`.`name`
                            FROM 	`quest_type`
                            WHERE 	`quest_type`.`actived` = 1" );

    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $quset_type_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }

    return $data;
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
						<input type="text" id="name" class="idle address" onblur="this.className=\'idle address\'" onfocus="this.className=\'activeField address\'" value="' . $res['name'] . '" />
					</td>
				</tr>
    
			</table>';
			if($_REQUEST['quest_id'] != ''){
			    if($_REQUEST['quest_detail_id'] == ''){
    			    $data .=  ' <div id="dt_example" class="inner-table" style="width: 430px;">
    			                <div id="button_area">
                    			    <button id="add_button_detail">დამატება</button>
                    			    <button id="delete_button_detail">წაშლა</button>
                			    </div>
                			    <table class="" id="example1" style="width: 430px;">
                    			    <thead style="width: 430px;">
                        			    <tr id="datatable_header">
                            			    <th style="width: 10%; display:none;">ID</th>
    			                            <th style="width: 10%;">#</th>
                            			    <th style="width: 10%;">დასახელება</th>
                            			    <th style="width: 10%;">ტიპი</th>
                            			    <th class="check">#</th>
                        			    </tr>
                    			    </thead>
                    			    <thead style="width: 430px;">
                        			    <tr class="search_header">
                            			    <th class="colum_hidden" style="display:none;"></th>		    
                            			    <th>
                            			    </th>
    			                            <th>
                            			    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                            			    </th>
                            			    <th>
                            			    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                            			    </th>
                            			    <th>
                            			    <input type="checkbox" name="check-all" id="check-all-de">
                            			    </th>
                        			    </tr>
                    			    </thead>
                			    </table>
    			                </div>';
			    }
			}
			if($_REQUEST['quest_detail_id'] != '' || $_REQUEST['add_id'] != ''){
			    $data .=  ' <table class="dialog-form-table">  
			                    <tr>
                					<td style="width: 170px;"><label for="quest_type_id">ტიპი</label></td>
                					<td>
                						<select style="width: 231px;" id="quest_type_id" class="idls object">'. GetQuestType($res['quest_type_id']).'</select>
                					</td>
                				</tr>              				
                                <tr>
                					<td style="width: 170px;"><label for="answer" id="qlabel">პასუხი</label></td>
                					<td>
                						<input type="text" id="answer" class="idle address" onblur="this.className=\'idle address\'" onfocus="this.className=\'activeField address\'" value="' . $res['answer'] . '" />
                					</td>
                				</tr>                				
                			</table>
                			<table id="product">
        						<tr>
        							  <td style="width: 170px;"><label for="production_name">დასახელება</label></td>
                                      <td>
                    						<div class="seoy-row" id="goods_name_seoy">
                    							<input type="text" id="production_name" class="idle seoy-address" onblur="this.className=\'idle seoy-address\'" onfocus="this.className=\'activeField seoy-address\'" value="' . $res[product_name] . '" />
                    							<button id="goods_name_btn" class="combobox">production_name</button>
                    						</div>
            				          </td>
        				    	</tr>
        						<tr>
        							<td style="padding-top: 11px;"><label for="genre">ჟანრი</label></td>
        							<td style="padding-top: 11px;"><input type="text" style="margin-bottom: 10px;" id="genre" class="idle" disabled onblur="this.className=\'idle\'" value="'.$res[genre_name].'"/></td>
        						</tr>
        						<tr>
        							<td><label for="category">განყოფილება</label></td>
        							<td><input type="text" style="margin-bottom: 10px;" id="category" class="idle" disabled onblur="this.className=\'idle\'" value="'.$res[dep_name].'"/></td>
        						</tr>
        						<tr>
        							<td><label for="description">აღწერილობა</label></td>
        							<td><input type="text" style="margin-bottom: 10px;" id="description" class="idle" disabled onblur="this.className=\'idle\'" value="'.$res[description].'"/></td>
        						</tr>
        						<tr>
        							<td><label for="price">ფასი</label></td>
        							<td><input type="text" style="margin-bottom: 10px;" id="price" class="idle" disabled onblur="this.className=\'idle\'" value="'.$res[price].'"/></td>
        							    <input type="text" id="hidden_product_id" class="idle" onblur="this.className=\'idle\'" style="display:none;" value="'.$res[prod_id].'"/>
        						</tr>
        					</table>';
			}else{
			    $data .=  '<table class="dialog-form-table">   
			                    <tr>
			                         <td><label for="quest_type_id">მინიშნება</label></td>
			                    </tr>             				
                                <tr>			                         
			                         <td><textarea  style="width: 423px; height:60px; resize: none;" id="note" class="idle" name="note" cols="300" >'.$res['note'].'</textarea></td>
                				</tr>
                			</table>';
			}
			$data .=  '<!-- ID -->
			<input type="hidden" id="quest_id" value="' . $res['quest_id'] . '" />
			<input type="hidden" id="quest_detail_id" value="' . $res['quest_detail_id'] . '" />
			<input type="hidden" id="add_id" value="' . $_REQUEST['add_id'] . '" />
        </fieldset>
    </div>
    ';
	return $data;
}

function GetProductInfo($name)
{
    $res = mysql_query("SELECT  genre.`name` AS `genre`,
                                department.`name` AS `category`,
                                production.description,
                                production.price,
                                production.id
                        FROM    production
                        JOIN 	genre ON production.genre_id = genre.id
                        JOIN 	department ON production.production_category_id = department.id
                        WHERE   production.`name` = '$name' AND production.actived = 1
        ");

    if (mysql_num_rows($res) == 0){
        return false;
    }

    $row = mysql_fetch_assoc($res);
    return $row;
}
?>

