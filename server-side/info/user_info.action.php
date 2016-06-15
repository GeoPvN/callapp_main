<?php
require_once ('../../includes/classes/core.php');
$action 	= $_REQUEST['act'];
$user_id    = $_SESSION['USERID'];
$error		= '';
$data		= '';
switch ($action) {

    case 'get_project' :
        $option = "<option value=\"0\">----</option>";
        
        $res = mysql_query("SELECT  `id`,
            				`name`
                    FROM `project`
                    WHERE actived = 1");
        
        while ($req = mysql_fetch_array($res)){
            $option .= "<option value=\"$req[0]\">$req[1]</option>";
        }
        $data['project'] = $option;
        
        $option = "<option value=\"0\">----</option>";
        
        $res = mysql_query("SELECT 	`users`.`id`,
                    				`user_info`.`name`
                            FROM 	`users`
                            JOIN 	`user_info` ON `users`.`id` = `user_info`.`user_id`
                            WHERE 	`users`.`actived` = 1");
        
        while ($req = mysql_fetch_array($res)){
            $option .= "<option value=\"$req[0]\">$req[1]</option>";
        }
        
        $data['user_id'] = $option;
        break;
    case 'get_cycle_start_date' :
        $year_month = $_REQUEST['year_month'];
        $ym         = explode("-",$year_month);
        $month_day  = cal_days_in_month(CAL_GREGORIAN, $ym[1], $ym[0]);
        $month      = $ym[1];
        $year       = $ym[0];
        $option = "";
    
        for($i=1;$i <= $month_day;$i++){
            $option .= "<option value=\"$i\">$year-$month-$i</option>";
        }
        $data['cycle_start_date'] = $option;
        break;
    case 'get_add_page' :
        $data['page'] = get_page('');
        break;
    case 'get_edit_page' :
        $work_real_break_id = $_REQUEST['id'];
        $data['page'] = get_page(get_page_sql($work_real_break_id));
        break;
    case 'get_index' :
        $count	= $_REQUEST['count'];
		$hidden	= $_REQUEST['hidden'];
		$work_real_id = $_REQUEST['work_real_id'];
		 
		$rResult = mysql_query("SELECT  work_real_break.id,
		                                work_activities.`name`,
		                                work_real_break.start_break AS `start`,
                            			work_real_break.end_break AS `end`
                                FROM `work_real_break`
                                JOIN work_activities ON work_real_break.work_activities_id = work_activities.id
                                WHERE work_real_id = $work_real_id AND work_real_break.actived = 1");

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
					$row[] = '<div class="callapp_checkbox">
                                  <input type="checkbox" id="callapp_checkbox_'.$aRow[$hidden].'" name="check_'.$aRow[$hidden].'" value="'.$aRow[$hidden].'" class="check" />
                                  <label for="callapp_checkbox_'.$aRow[$hidden].'"></label>
                              </div>';
				}
			}
			$data['aaData'][] = $row;
		}
        break;
    case 'get_24_hour' :
        $project_id = $_REQUEST['project_id'];
        $date       = $_REQUEST['year_month'];
        $operator_id= $_REQUEST['operator_id'];
        $query = mysql_query("  SELECT  DATE_FORMAT(work_real.date,'%Y-%m-%d') AS `real_date`,
                                        CASE 
                                            WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 0 then 'ორშაბათი'
                                            WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 1 then 'სამშაბათი'
                                            WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 2 then 'ოთხშაბათი'
                                    		WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 3 then 'ხუთშაბათი'
                                    		WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 4 then 'პარასკევი'
                                    		WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 5 then 'შაბათი'
                                    		WHEN WEEKDAY(DATE_FORMAT(work_real.date,'%Y-%m-%d')) = 6 then 'კვირა'
                                        END AS `week_day`,
                                        work_shift.`name` AS `cvla_name`,
                                        '' AS `blank`,
                                        work_shift.start_date,
                                        work_shift.end_date,
                                        work_real.id
                                FROM `work_real`
                                JOIN work_shift ON work_real.work_shift_id = work_shift.id
                                WHERE work_real.project_id = $project_id AND DATE_FORMAT(work_real.date,'%Y-%m') = '$date' AND work_real.user_id = '$operator_id'");
        
        while ($query_req = mysql_fetch_assoc($query)){
            $table_body .= '<tr>
                            <td style="font-weight: bold;">'.$query_req[real_date].'</td><td style="font-weight: bold;">'.$query_req[week_day].'</td><td style="font-weight: bold;">'.$query_req[cvla_name].'</td><td></td><td style="font-weight: bold;">'.$query_req[start_date].'</td><td style="font-weight: bold;">'.$query_req[end_date].'</td>
            	            </tr>';
            $qu = mysql_query(" SELECT  work_activities.color,
                                        work_activities.`name`,
                                        work_real_break.start_break,
                                        work_real_break.end_break
                                FROM `work_real_break`
                                JOIN work_activities ON work_real_break.work_activities_id = work_activities.id
                                WHERE work_real_break.work_real_id = $query_req[id]");
            while ($qu_req = mysql_fetch_assoc($qu)){
            $table_body .= '<tr>
                            <td></td><td></td><td></td><td style="text-align: justify;width: 135px;"><div><div style="float: left;width:12px;height: 12px;background: '.$qu_req[color].';margin-right: 3px;"></div>'.$qu_req[name].'</div></td><td>'.$qu_req[start_break].'</td><td>'.$qu_req[end_break].'</td>
            	            </tr>';
            }
        }
        
        $data['page'] = '   <button id="goexcel" style="margin-bottom: 10px;">EXCEL</button>
                            <table id="work_table">
                            <tr>
                            <td>რიცხვი</td><td>დღე</td><td>ცვლა</td><td>აქტივობა</td><td>დასწყისი</td><td>დასასრული</td>
            	            </tr>
                            '.$table_body.'
            	            </table>';
    
        break;
    default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);

function get_page_sql($work_real_break_id){
    $res = mysql_fetch_assoc(mysql_query("  SELECT  work_real_break.id,
            		                                work_real_break.work_activities_id,
            		                                work_real_break.start_break AS `start`,
                                        			work_real_break.end_break AS `end`
                                            FROM `work_real_break`
                                            WHERE work_real_break.id = $work_real_break_id"));
    return $res;
}

function get_work_activities($id){
    $req = mysql_query("SELECT 	`id`,
                				`name`
                        FROM `work_activities`
                        WHERE actived = 1");
    
    $data .= '<option value="0" selected="selected">----</option>';
    while( $res = mysql_fetch_assoc($req)){
        if($res['id'] == $id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }
    
    return $data;
}

function get_page($res){
    $data = '<div id="dialog-form">
                            <fieldset>
                            <legend>საათების მიხედვით</legend>
                                <table>
                                    <tr>
                                        <td colspan=2>აქტივობა</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2><select id="work_activities_id" style="width: 100%;">'.get_work_activities($res[work_activities_id]).'</select></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 100px;">დასაწყისი</td>
                                        <td>დასასრული</td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" id="start_break" style="width: 70px;" value="'.$res[start].'"></td>
                                        <td><input type="text" id="end_break" style="width: 70px;" value="'.$res[end].'"></td>
                                    </tr>
                                </table>
                                <input type="hidden" id="b_id" value="'.$res[id].'">
                            </fieldset>
                           </div>';
    return $data;
}
?>