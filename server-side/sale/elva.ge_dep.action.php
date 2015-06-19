<?php

require_once ('../../includes/classes/core.php');


$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';
$start		= $_REQUEST['start'];
$end		= $_REQUEST['end'];

switch ($action) {
	case 'ccc' :
		$count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
		$cash_ch = 		$_REQUEST['cash_ch'];
		
		if ($cash_ch != 'undefined') {
		    $chash_id = "AND elva_sale.cash = '$cash_ch'";
		}else{
		    $chash_id = "";
		}
		
	  	$rResult = mysql_query("

					  			SELECT 			elva_sale.id,
												elva_sale.name_surname,
	  	                                        city.`name` as city_name,
	  	                                        elva_sale.address,
												DATE_FORMAT(elva_sale.call_date,'%d-%m-%Y %H:%i:%s') AS `call_date`,
	  	                                        DATE_FORMAT(elva_sale.send_date,'%d-%m-%Y') AS `send_date`,
	  	                                        elva_sale.callceenter_comment,
	  	                                        IF(elva_status.`name` = 'გაუქმებული',0,elva_sale.sum_price),
	  	                                        persons.`name` as operator_id,
	  	                                        elva_status.`name`,
												elva_sale.coordinator_id,
												elva_sale.coordinator_comment,
	  	                                        elva_sale.cancel_comment,
												elva_sale.elva_status,
	  	                                        CONCAT('<button class=\"myact ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" onclick=\"openmyact(\'',elva_sale.task_id,'\',\'',elva_sale.custom_prod,'\')\"><span class=\"ui-button-text\">აქტი</span></button>') as `button`
												FROM `elva_sale`
												JOIN users ON elva_sale.operator_id = users.id
	  	                                        LEFT JOIN elva_status ON elva_sale.`status` = elva_status.id
												JOIN persons ON users.person_id = persons.id
	  	                                        JOIN task_scenar ON elva_sale.task_id = task_scenar.task_detail_id
	  	                                        JOIN city ON elva_sale.city_id = city.id
								WHERE 			DATE(elva_sale.call_date) >= '$start' AND DATE(elva_sale.call_date) <= '$end'  $chash_id
	  			");

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
	case 'get_list' :
	    $count = 		$_REQUEST['count'];
	    $hidden = 		$_REQUEST['hidden'];
	    $data = array(
	        "aaData"	=> array()
	    );
	    
	    $rResult = mysql_query(	"SELECT 			elva_sale.id,
    												elva_sale.name_surname,
	                                                city.`name` as city_name,
    	  	                                        elva_sale.address,
    												DATE_FORMAT(elva_sale.call_date,'%d-%m-%Y %H:%i:%s') AS `call_date`,
    	  	                                        DATE_FORMAT(elva_sale.send_date,'%d-%m-%Y') AS `send_date`,
    	  	                                        elva_sale.callceenter_comment,
    	  	                                        IF(elva_status.`name` = 'გაუქმებული',0,elva_sale.sum_price),
    	  	                                        persons.`name` as operator_id,
    	  	                                        elva_status.`name` as status_name,
    												elva_sale.coordinator_id,
    												elva_sale.coordinator_comment,
	                                                elva_sale.elva_status,
	                                                st_p.`name` as status_name_p,
    												elva_sale.coordinator_id_p,
    												elva_sale.coordinator_comment_p,
	                                                elva_sale.elva_status_p,
    	  	                                        elva_sale.cancel_comment,    												
	                                                elva_sale.custom_prod,
	                                                elva_sale.task_id,
	                                                task_scenar.product_ids
    												FROM `elva_sale`
    												JOIN users ON elva_sale.operator_id = users.id
    	  	                                        JOIN elva_status ON elva_sale.`status` = elva_status.id
	                                                JOIN elva_status as st_p ON elva_sale.`status_p` = st_p.id
    												JOIN persons ON users.person_id = persons.id
    	  	                                        JOIN task_scenar ON elva_sale.task_id = task_scenar.task_detail_id
	                                                JOIN city ON elva_sale.city_id = city.id
    								WHERE 			DATE(elva_sale.call_date) >= '$start' AND DATE(elva_sale.call_date) <= '$end'");
	    while ($res = mysql_fetch_assoc( $rResult )){

	    if($res[task_id] != 0){
	    
	        $last =  preg_split("/[,]+/",$res[product_ids]);
	        foreach ($last as $test){
	            $dato = explode('^',$test,2);
	            if($dato[0] != 0){
	            $tt .= $dato[0].',';
	            $ttt .= $dato[1].'-';
	            }
	        }
	        $myarr = preg_split("/[-]+/",$ttt);
	        $cvladi = substr($tt,0, -1);
	    }else{
	        $last =  preg_split("/[,]+/",$res[custom_prod]);
	        foreach ($last as $test){
	            $dato = explode('^',$test,2);
	            if($dato[0] != 0){
	            $tt .= $dato[0].',';
	            $ttt .= $dato[1].'-';
	            }
	        }
	        $myarr = preg_split("/[-]+/",$ttt);
	        $cvladi = substr($tt,0, -1);
	    }
	    
	    if($_REQUEST[dep_id] != 0){
	        $chch = "AND production.production_category_id = $_REQUEST[dep_id]";
	    }else{
	        $chch = "";
	    }
	    $query11 = mysql_query("SELECT 	`production`.`name`,production.`price`,production.`id`,department.`name`,production.unicid,production.buy_pirce,department.`id`
                    	        FROM 	`production`
                    	        JOIN    `department` ON production.production_category_id = department.id
                    	        WHERE 	`production`.`id` in ($cvladi) $chch
                    	        ORDER BY FIELD(production.id, $cvladi)");
	    $cvladi = '';
	    $ttt ='';
	    $tt='';
	    $r=0;
	    while ($row_prod1 = mysql_fetch_row($query11)) {
	        $number = $row_prod1[2];
	        $book_name = $row_prod1[0];
	        $book_price = $row_prod1[1];
	        $book_dep = $row_prod1[3];
	        $unicid = $row_prod1[4];
	        $buy_pirce = $row_prod1[5];
	        $total_sum = (($myarr[0]=='')?'1':$myarr[$r++]);
	        
	        if($book_dep == 'პალიტრა L'){
	            $deep_p = $res[status_name_p];
	            if($res[status_name_p] == 'გაუქმებული'){
	                $book_price = 0;
	            }else{
	                $book_price = $row_prod1[1];
	            }
	        }else{
	            $deep_p = '';
	        }
	        if($book_dep == 'ელვა.ჯი'){
	            $deep = $res[status_name];
	            if($res[status_name] == 'გაუქმებული'){
	                $book_price = 0;
	            }else{
	                $book_price = $row_prod1[1];
	            }
	        }else{
	            $deep = '';
	        }
	        
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            if($i == 0){
	                $row[] = $number;
	            }elseif($i == 1){
	                $row[] = $res[name_surname];
	            }elseif($i == 2){
	                $row[] = $res[city_name];
	            }elseif($i == 3){
	                $row[] = $res[address];
	            }elseif($i == 4){
	                $row[] = $res[call_date];
	            }elseif($i == 5){
	                $row[] = $res[send_date];
	            }elseif($i == 6){
	                $row[] = $book_name;
	            }elseif($i == 7){
	                $row[] = $unicid;
	            }elseif($i == 8){
	                $row[] = $book_dep;
	            }elseif($i == 9){
	                $row[] = $total_sum;
	            }elseif($i == 10){
	                $row[] = number_format(((float)$buy_pirce * (float)$total_sum), 2, '.', '');
	            }elseif($i == 11){
	                $row[] = $book_price;
	            }elseif($i == 12){
	                $row[] = number_format(((float)$book_price * (float)$total_sum), 2, '.', '');
	            }elseif($i == 13){
	                $row[] = $res[operator_id];
	            }elseif($i == 14){
	                $row[] = $deep;
	            }elseif($i == 15){
	                $row[] = $res[coordinator_id];
	            }elseif($i == 16){
	                $row[] = $res[coordinator_comment];
	            }elseif($i == 17){
	                $row[] = $res[elva_status];
	            }elseif($i == 18){
	                $row[] = $deep_p;
	            }elseif($i == 19){
	                $row[] = $res[coordinator_id_p];
	            }elseif($i == 20){
	                $row[] = $res[coordinator_comment_p];
	            }elseif($i == 21){
	                $row[] = $res[elva_status_p];
	            }elseif($i == 22){
	                $row[] = $res[cancel_comment];
	            }
	            //$row[] = $aRow[$i];
	        }
	        $data['aaData'][] = $row;

	    }
	    }
	    break;   	
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

?>