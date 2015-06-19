<?php

require_once ('../../includes/classes/core.php');


$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';
$start		= $_REQUEST['start'];
$end		= $_REQUEST['end'];

switch ($action) {
	case 'get_list' :
	    $count = 		$_REQUEST['count'];
	    $hidden = 		$_REQUEST['hidden'];
	    $data = array(
	        "aaData"	=> array()
	    );
	    
	    $rResult = mysql_query(	"SELECT 			elva_sale.id,
    												DATE_FORMAT(elva_sale.call_date,'%d-%m-%Y %H:%i:%s') AS `call_date`,
                                        	        DATE_FORMAT(elva_sale.send_date,'%d-%m-%Y') AS `send_date`,
                                        	        DATE_FORMAT(elva_sale.send_client_date,'%d-%m-%Y') AS `send_client_date`,
	                                                elva_sale.custom_prod,
	                                                elva_sale.task_id,
	                                                task_scenar.product_ids
    												FROM `elva_sale`
    												JOIN task_scenar ON elva_sale.task_id = task_scenar.task_detail_id
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
	    $query11 = mysql_query("SELECT 	`production`.`name`,
                            	        production.`buy_pirce`,
                            	        production.`id`,
                            	        department.`name`,
                            	        production.unicid
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
	        $total_sum = (($myarr[0]=='')?'1':$myarr[$r++]);
	        
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            if($i == 0){
	                $row[] = $number;
	            }elseif($i == 1){
	                $row[] = $res[call_date];
	            }elseif($i == 2){
	                $row[] = $res[send_date];
	            }elseif($i == 3){
	                $row[] = $res[send_client_date];
	            }elseif($i == 4){
	                $row[] = $row_prod1[4];
	            }elseif($i == 5){
	                $row[] = $book_name;
	            }elseif($i == 6){
	                $row[] = $total_sum;
	            }elseif($i == 7){
	                $row[] = $book_price;
	            }elseif($i == 8){
	                $row[] = number_format(((float)$book_price * (float)$total_sum), 2, '.', '');
	            }elseif($i == 9){
	                $row[] = $book_dep;
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