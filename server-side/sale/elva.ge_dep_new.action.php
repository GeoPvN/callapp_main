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
		$dep_id =       $_REQUEST['dep_id'];
		if($dep_id == 0){
		    $checker_dep = '';
		}else{
		    $checker_dep = "AND sale_details.department_id = $dep_id";
		}
		
	  	$rResult = mysql_query("

					  			SELECT 			elva_sale_new.id,                            						
                        						production.unicid,
  	                                            production.`name`,
                                                SUM(sale_details.quantity),
                                                production.buy_pirce,
                                                (production.buy_pirce * (SUM(sale_details.quantity)))                                                    
                            						
                                 FROM `elva_sale_new`
                                 JOIN users ON elva_sale_new.operator_id = users.id
                                 JOIN elva_status ON elva_sale_new.`status` = elva_status.id
                                 JOIN elva_status as st_p ON elva_sale_new.`status_p` = st_p.id
                                 JOIN persons ON users.person_id = persons.id
                                 JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                 JOIN city ON elva_sale_new.city_id = city.id
                                 JOIN department ON sale_details.department_id = department.id
                                 LEFT JOIN prod_cat ON elva_sale_new.prod_cat = prod_cat.id
                                 JOIN production ON sale_details.production_id = production.id
								 WHERE DATE(elva_sale_new.call_date) >= '$start' AND DATE(elva_sale_new.call_date) <= '$end' $checker_dep
	  	                         GROUP BY sale_details.production_id
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
	    $dep_id =       $_REQUEST['dep_id'];	    
	    
	    if($dep_id == 0){
	        $checker_dep = '';
	    }else{
	        $checker_dep = "AND sale_details.department_id = $dep_id";
	    }
	    
	    $rResult = mysql_query(	"SELECT 			elva_sale_new.id,
                            						elva_sale_new.name_surname,
                            						city.`name` as city_name,
                            						elva_sale_new.address,
                            						DATE_FORMAT(elva_sale_new.call_date,'%d-%m-%Y %H:%i:%s') AS `call_date`,
                            						DATE_FORMAT(elva_sale_new.send_date,'%d-%m-%Y') AS `send_date`,
                            						production.`name`,
                            						production.unicid,
                            						department.`name`,
                                                    sale_details.quantity,
                                                    production.buy_pirce,
	                                                (production.buy_pirce * sale_details.quantity),
                                                    sale_details.price,
                                                    IF(sale_details.department_id = 21, IF(elva_status.`name` = 'გაუქმებული',0,(sale_details.price * sale_details.quantity)),IF(sale_details.department_id = 25, IF(st_p.`name` = 'გაუქმებული',0,(sale_details.price * sale_details.quantity)),'')) AS `price`,
                            						persons.`name` as operator_id
                            						
                                 FROM `elva_sale_new`
                                 JOIN users ON elva_sale_new.operator_id = users.id
                                 JOIN elva_status ON elva_sale_new.`status` = elva_status.id
                                 JOIN elva_status as st_p ON elva_sale_new.`status_p` = st_p.id
                                 JOIN persons ON users.person_id = persons.id
                                 JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                 JOIN city ON elva_sale_new.city_id = city.id
                                 JOIN department ON sale_details.department_id = department.id
                                 LEFT JOIN prod_cat ON elva_sale_new.prod_cat = prod_cat.id
                                 JOIN production ON sale_details.production_id = production.id
								 WHERE DATE(elva_sale_new.call_date) >= '$start' AND DATE(elva_sale_new.call_date) <= '$end' $checker_dep");
	    $data = array(
	        "aaData"	=> array()
	    );
	    
	    while ($aRow = mysql_fetch_array( $rResult )){
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            /* General output */
	            $row[] = $aRow[$i];
	        }
	    
	        $data['aaData'][] = $row;
	    }
	    break;   	
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

?>