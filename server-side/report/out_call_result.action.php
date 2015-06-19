<?php

require_once('../../includes/classes/core.php');

$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';

switch ($action) {
	case 'get_list' :
		$count        = $_REQUEST['count'];
		$hidden       = $_REQUEST['hidden'];
		$scenario_id  = $_REQUEST['scenario_id'];
		$datetime     =	$_REQUEST['datetime'];
		
		$rr = mysql_query(" SELECT  `scenario_detail`.`quest_id`
                            FROM    `scenario_detail`
                            JOIN    `quest_detail` ON `scenario_detail`.`quest_id` = `quest_detail`.`quest_id`
                            WHERE   `scenario_id` = $scenario_id
                            GROUP BY `scenario_detail`.`quest_id`");
		
		$join = "JOIN    `scenar_$scenario_id` ON `task_detail`.`id` = `scenar_$scenario_id`.`task_detail_id`";
		
		while ($rRes = mysql_fetch_array($rr)) {
		    $rRow .= "scenar_$scenario_id.answer_$rRes[0],";
		}
		
		$rRow = substr($rRow, 0, -1);
		
	  	$rResult = mysql_query("SELECT	`task_detail`.`id` AS `id`,
                                		`task`.`date` AS `task_date`,
                                		`scenario`.`name` AS `shabloni_name`,
                                		`sc_cat`.`name` AS `main_cat`,
                                		`sc_le_cat`.`name` AS `le_cat`,
                                		`phone`.`addres` AS `addres`,
                                		`phone`.`first_last_name` AS `first_last_name`,			
                                		`phone`.`phone1` as `phone1`,
				                        `phone`.`phone2` as `phone2`,
	  	                                `persons`.`name` AS `person_name`,
	  	                                $rRow
                                FROM	`task`
                                JOIN    `task_detail` ON `task`.`id` = `task_detail`.`task_id`
	  	                        $join
                                JOIN    `scenario` ON `task`.`template_id` = `scenario`.`id`
                                JOIN    `scenario_category` AS sc_cat ON `scenario`.`scenario_cat_id` = `sc_cat`.`id`
                                JOIN    `scenario_category` AS sc_le_cat ON `scenario`.`scenario_le_cat_id` = `sc_le_cat`.`id`
                                LEFT JOIN `incomming_call` ON	`task_detail`.`phone_base_inc_id` = `incomming_call`.`id`
                                JOIN    `phone` ON `task_detail`.`phone_base_id` = `phone`.`id`
                                JOIN    `users` ON	`task_detail`.`responsible_user_id` = `users`.`id`
                                JOIN    `persons` ON `users`.`person_id` = `persons`.`id`
	  	                        WHERE   `task_detail`.`status` = 3 AND `scenario`.`id` = $scenario_id AND DATE(`task`.`date`) = '$datetime'");
	  
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
			}
			$data['aaData'][] = $row;
		}

		break;
	case 'get_colum' :
	    $rResult = mysql_query("SELECT 	CONCAT('<option value=\"',`id`,'\">',`name`,'</option>') AS `colum`
                                FROM 	`scenario`
                                WHERE 	`actived` = 1");
	     
	    $data = array(
	        "colum"	=> array()
	    );
	    $data['colum'][] = "<option value=\"0\">----</option>'";
	    while ( $aRow = mysql_fetch_array( $rResult ) )
	    {
	        $data['colum'][] = $aRow[0];
	    }
	    break;
    case 'get_colum_list' :
        $get_sc = $_REQUEST['get_sc'];
        $rResult = mysql_query("SELECT concat('<th style=\"width: 100%;\">',quest_1.`name`,'</th>') AS cl_lis
                                FROM `scenario_detail`
                                JOIN quest_1 ON scenario_detail.quest_id = quest_1.id
                                WHERE scenario_id =  $get_sc");
    
        $data = array(
            "colum_list"	=> array(),
            "count"         => array()
        );
        $data['colum_list'][] = '   <th>ID</th>
                                    <th style="width: 100%;">თარიღი</th>
                                    <th style="width: 100%;">სცენარი</th>
                                    <th style="width: 100%;">სცენარის კატეგორია</th>
                                    <th style="width: 100%;">სცენარის ქვე-კატეგორია</th>
                                    <th style="width: 100%;">მისამართი</th>                            
                                    <th style="width: 100%;">სახელი და გვარი</th>
                                    <th style="width: 100%;">ტელეფონი 1</th>
                                    <th style="width: 100%;">ტელეფონი 2</th>
                                    <th style="width: 100%;">შემსრულებელი</th>';
        $i = 10;
        $data_l = '';
        $data_s = '';
        while ( $aRow = mysql_fetch_array( $rResult ) )
        {
            $data_l .= $aRow[0];
            $data_s .= '<th>
                        	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="width: 90px;">
                        </th>';
            $i++;
        }
        $data['count'] = $i;
        
        $data['colum_list'] = '<table class="display" id="example">
                                <thead>
                                    <tr id="datatable_header">
                                        <th>ID</th>
                                        <th style="width: 100%;">თარიღი</th>
                                        <th style="width: 100%;">სცენარი</th>
                                        <th style="width: 100%;">სცენარის კატეგორია</th>
                                        <th style="width: 100%;">სცენარის ქვე-კატეგორია</th>
                                        <th style="width: 100%;">მისამართი</th>                            
                                        <th style="width: 100%;">სახელი და გვარი</th>
                                        <th style="width: 100%;">ტელეფონი 1</th>
                                        <th style="width: 100%;">ტელეფონი 2</th>
                                        <th style="width: 100%;">შემსრულებელი</th>
                                        '.$data_l.'
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="search_header">
                                        <th class="colum_hidden">
                                        	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                                        </th>
                                        <th>
                                        	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="width: 90px;">
                                        </th>
                                        <th>
                                            <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                                        </th>                            
                                        <th>
                                            <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                                        </th>
                                        <th>
                                            <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 90px;"/>
                                        </th>
                                        <th>
                                            <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                                        </th>
                                        <th>
                                            <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                                        </th>                            
                                        <th>
                                            <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                                        </th>
                                        <th>
                                            <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                                        </th>
                                         <th>
                                            <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                                        </th>                           
                                        '.$data_s.'
                                    </tr>
                                </thead>
                                <table/>';
        
        
        break;
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

?>