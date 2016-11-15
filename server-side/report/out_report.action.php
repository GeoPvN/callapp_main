<?php
require_once('../../includes/classes/core.php');
$action	= $_REQUEST['act'];
$error	= '';
$data	= '';
 
switch ($action) {
	case 'get_list' :
		$count	= $_REQUEST['count'];
		$hidden	= $_REQUEST['hidden'];
		 
		$rResult = mysql_query("SELECT  outgoing_campaign_detail.id,
                                        project.`name` AS `project_name`,
                                        outgoing_campaign_detail.update_date AS `change_date`,
                                        phone_base_detail.client_name AS `client_name`,
                                        phone_base_detail.note AS `category`,
                                        task_status.`name` AS `status`,
                                        outgoing_campaign_detail.call_comment AS `about_call`,
                                        outgoing_campaign_detail.call_res AS `call_res`,
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 11),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 12),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 13),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 14),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 15),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 16),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 17),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 18),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 19),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                        FROM  `scenario_results`
                                        JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                        WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 20),
                                        (SELECT GROUP_CONCAT(question_detail.answer)
                                FROM  `scenario_results`
                                JOIN question_detail ON scenario_results.question_detail_id = question_detail.id
                                WHERE scenario_results.outgoing_campaign_detail_id = outgoing_campaign_detail.id AND `scenario_results`.`question_id` = 21)
                                FROM `outgoing_campaign`
                                JOIN outgoing_campaign_detail ON outgoing_campaign.id = outgoing_campaign_detail.outgoing_campaign_id
                                JOIN phone_base_detail ON phone_base_detail.id = outgoing_campaign_detail.phone_base_detail_id
                                JOIN project ON outgoing_campaign.project_id = project.id
                                JOIN scenario_results ON outgoing_campaign_detail.id = scenario_results.outgoing_campaign_detail_id
                                JOIN task_status ON outgoing_campaign_detail.`status` = task_status.id
                                GROUP BY outgoing_campaign_detail.id");

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


/* ******************************
 *	Category Functions
* ******************************
*/

?>
