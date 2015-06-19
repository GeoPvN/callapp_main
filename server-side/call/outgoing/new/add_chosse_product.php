<?php 
require_once ('../../../../includes/classes/core.php');
$action = $_REQUEST['act'];


switch ($action){
	case 'get_table':
		$page		= GetProductDialog($_REQUEST[sale_detail_id]);
		$data		= array('page'	=> $page);
	
		break;
	case 'add_product':		
	    $user_id			= $_SESSION['USERID'];
		$product_id         = $_REQUEST['product_id'];
		$task_detail_id		= $_REQUEST['task_scenar_id'];
		$porod_count        = $_REQUEST['porod_count'];
		$sale_detail_id     = $_REQUEST['sale_detail_id'];
		$cur_date 	        = date('Y-m-d H:i:s');
		$task_checker = mysql_num_rows(mysql_query("SELECT id FROM task_scenar WHERE task_detail_id = $task_detail_id"));
		$product_detail = mysql_fetch_assoc(mysql_query("SELECT id,production_category_id,price FROM `production` WHERE id = $product_id"));
		if($task_checker == 0){
		mysql_query("INSERT INTO `task_scenar`
            		(`user_id`, `date`, `task_detail_id`, `hello_comment`, `hello_quest`, `info_comment`, `info_quest`, `result_comment`, `result_quest`, `send_date`, `payment_comment`, `payment_quest`, `preface_name`, `preface_quest`, `d1`, `d2`, `d3`, `d4`, `d5`, `d6`, `d7`, `d8`, `d9`, `d10`, `d11`, `d12`, `q1`, `product_ids`, `gift_ids`, `b1`, `b2`, `result_quest1`, `result_comment1`)
            		VALUES
            		('$user_id', '$cur_date', '$task_detail_id', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')");
		}
		if($sale_detail_id == ''){
		    $checker_prod = mysql_num_rows(mysql_query("SELECT id FROM sale_details WHERE task_scenar_id = $task_detail_id AND production_id = $product_id AND actived = 1"));
		    if($checker_prod == 0){
    		mysql_query("INSERT INTO `sale_details`
            		    ( `user_id`, `elva_sale_id`, `task_scenar_id`, `production_id`, `department_id`, `quantity`, `price`, `actived`)
            		    VALUES
            		    ( '$user_id', '1', '$task_detail_id', '$product_id', '$product_detail[production_category_id]', '$porod_count', '$product_detail[price]', '1');");
		    }else{
		        $data		= array('hint'	=> "ესეთი პროდუქტი უკვე დამატებულია, თუ გსურთ შეცვალეთ რაოდენობა!");
		    }
		}else{
		    mysql_query("UPDATE `sale_details` SET
                                `user_id`='$user_id',
                                `quantity`='$porod_count'
                         WHERE (`id`='$sale_detail_id');");
		}
		
		break;
    case 'get_list':
    	$count			= $_REQUEST['count'];
    	$hidden			= $_REQUEST['hidden'];
    	$scenar_name	= $_REQUEST['scenar_name'];
    	$task_id        = $_REQUEST['task_id'];
    	
    	$rResult = mysql_query("SELECT 	`sale_details`.`id`,
                        				`production`.`name`,
                        				`sale_details`.`quantity`,
                        				`production`.`price`,
                        				(`sale_details`.`price` * `sale_details`.`quantity`),
                        				`production`.`description`,
                        				`production`.`comment`
                                FROM 	`sale_details`
                                JOIN	`production` ON `sale_details`.`production_id` = `production`.`id`
                                WHERE	`task_scenar_id` = $task_id AND `sale_details`.`actived` = 1");
    	 
    	
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
    				$row[] ='<input  type="checkbox" id="p' . $aRow[0] . '" name="check_' . $aRow[0] . '" class="check_p" value="' . $aRow[0] . '" />';
    			}
    		}
    		$data['aaData'][] = $row;
    	}
    
    	break;    
    default:
       $error = 'Action is Null';
}

echo json_encode($data);

///////////////////////////////////////

function getproduct($prod_id)
{
	$res = mysql_query("SELECT  production.id,
                    			production.`name`
            			FROM    production
            			WHERE   production.actived = 1
            			");
	$data = '<option value="0">-------</option>';
    while ($req = mysql_fetch_array($res)){
        if($prod_id == $req[0]){
            $data .= '<option value="'.$req[0].'" selected>'.$req[1].'</option>';
        }else {
            $data .= '<option value="'.$req[0].'">'.$req[1].'</option>';
        }
    }

	return $data;
}

function GetProductDialog($sale_detail_id){
    $my_req = mysql_fetch_array(mysql_query("SELECT production_id,quantity FROM `sale_details` WHERE id = $sale_detail_id"));
    if($my_req[1] == ''){
        $quantity = 1;
        $disable = '';
        $show = 'style="display:none;"';
        $show1 = '';
    }else{
        $quantity = $my_req[1];
        $disable = 'disabled';
        $show1 = 'style="display:none;"';
        $show = '';
    }
	$data = '
			<div id="dialog-form">';
	if($my_req[1] == ''){
	    $quantity = 1;
	    $disable = '';
	    $show = 'style="display:none;"';
	    $show1 = '';
		 	   $data .= '<fieldset '.$show1.'>
					<legend>პროდუქტი</legend>
                    <div id="dt_example" class="inner-table" style="overflow: auto;">
			        <div style="width:100%;" id="container" >        	
		            <div id="dynamic">
	            	<div id="button_area">
        			</div>
					<table class="" id="sub3" style="width: 100%;">
	                    <thead>
							<tr  id="datatable_header">
								<th style="width:4%;">#</th>
								<th style="width:100px;">პროდუქტი</th>
		                        <th style="width:30px;">რ-ბა</th>
								<th style="width:30px;">ერთ. ფასი</th>
		                        <th style="width:30px;">სულ ფასი</th>
								<th style="width:100%">აღწერილობა</th>
								<th style="width:100%">შენიშვნა</th>
								<th style="width:5%;">#</th>
							</tr>
						</thead>
						<thead>
							<tr class="search_header">
								<th>
									<input style="width:20px;" type="text" name="search_overhead" id="clickme1" value="" class="search_init" />
								</th>
								<th>
									<input style="width:100px;" type="text" name="search_overhead" id="clickme2" value="" class="search_init" />
								</th>
								<th>
									<input style="width:20px;" type="text" name="search_partner" id="clickme3" value="" class="search_init" />
								</th>
								<th>
									<input style="width:20px;" type="text" name="search_overhead" id="clickme4"value="" class="search_init" />
								</th>
								<th>
									<input style="width:20px;" type="text" name="search_partner" id="clickme5" value="" class="search_init" />
								</th>
		                        <th>
									<input style="width:100px;" type="text" name="search_partner" id="clickme6" value="" class="search_init" />
								</th>
		                        <th>
									<input style="width:100px;" type="text" name="search_partner" id="clickme7" value="" class="search_init" />
								</th>
								<th>
									<input type="checkbox" name="check-all" id="check-all_p">
								</th>
							</tr>
						</thead>
	                </table>
	                   </div>
		            <div class="spacer">
		            </div>
		        </div>
		        </fieldset>
		 	        <input type="hidden" value="'.$sale_detail_id.'" id="sale_detail_id">
		    </div> <script>$(document).ready(function () {$(".add_product_chosse-class").css("top","0");});</script>';
		 	   }else{
		 	       $quantity = $my_req[1];
		 	       $disable = 'disabled';
		 	       $show1 = 'style="display:none;"';
		 	       $show = '';
		 	   
	           $data.='<fieldset '.$show.'>
					<legend>პროდუქტი</legend>
					<table>
						<tr>
							  <td style="width:120px; padding-top: 5px;">დასახელება</td>
                              <td>
            						<select id="production_name" class="idle" '.$disable.'>'.getproduct($my_req[0]).'</select>
    				          </td>
				    	</tr>
						<tr>
							<td style="padding-top: 25px;">რაოდენობა</td>
							<td style="padding-top: 20px;"><input onclick="$(this).keydown(false);" type="number" style="margin-bottom: 10px; width: 40px;" id="porod_count" class="idle"  onblur="this.className=\'idle\'" value="'.$quantity.'" min="1"/></td>
						</tr>						
					</table>
		        </fieldset>
            	<input type="hidden" value="'.$sale_detail_id.'" id="sale_detail_id">
		    </div> <script>$(document).ready(function () {$(".add_product_chosse-class").css("top","0");});</script>';
		 	   }
	return $data;
}

?>