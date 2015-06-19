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
IF(test_scenari.sqesi = 1,'მამრობითი','მდედორბითი'),
IF(test_scenari.asaki = 1,'18 წლამდე',
IF(test_scenari.asaki = 2,'18-24',
IF(test_scenari.asaki = 3,'25-34',
IF(test_scenari.asaki = 4,'35-44',
IF(test_scenari.asaki = 5,'45-54',
IF(test_scenari.asaki = 6,'55-64',
IF(test_scenari.asaki = 7,'65+',''))))))),
SUBSTR(CONCAT(test_scenari.tematika,',', test_scenari.tematika_inp),10) AS `tematika`,
CONCAT(test_scenari.rubrika1,',',test_scenari.rubrika2,',',test_scenari.rubrika3) AS `rubrika`,
CASE 
    WHEN test_scenari.gazeti = 1 then 'ვრცელი'
    WHEN test_scenari.gazeti = 2 then 'მცირე'
    WHEN test_scenari.gazeti = 3 then 'საშუალო ზომის'
		WHEN test_scenari.gazeti = 4 then 'მოცულობას არ აქვს მნიშვნელობა'
END AS `gazeti`,
CASE 
    WHEN test_scenari.reklama = 1 then 'დიახ'
    WHEN test_scenari.reklama = 2 then 'არა'
END AS `reklama`,
CASE 
    WHEN test_scenari.yidva = 1 then 'დიახ'
    WHEN test_scenari.yidva = 2 then 'არა'
END AS `yidva`,
test_scenari.rcheva,
test_scenari.qalaqi
FROM	`task`
JOIN    `task_detail` ON `task`.`id` = `task_detail`.`task_id`
JOIN    `test_scenari` ON `task_detail`.`id` = `test_scenari`.`task_detail_id`
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

	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

?>