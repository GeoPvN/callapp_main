<?php
include('../../includes/classes/core.php');
$start  	= $_REQUEST['start'];
$end    	= $_REQUEST['end'];
$count 		= $_REQUEST["count"];
$action 	= $_REQUEST['act'];
$departament= $_REQUEST['departament'];
$type       = $_REQUEST['type'];
$category   = $_REQUEST['category'];
$s_category = $_REQUEST['sub_category'];
$done 		= $_REQUEST['done']%4;
$name 		= $_REQUEST['name'];
$title 		= $_REQUEST['title'];
$text[0] 	= "შემოსული  ზარები ქვე-განყოფილებების  მიხედვით";
$text[1] 	= "'$departament'- შემოსული ზარები  ტიპების მიხედვით";
$text[2] 	= "'$departament'- შემოსული  ზარები '$type' კატეგორიების მიხედვით";
$text[3] 	= "'$departament'- შემოსული ზარები '$type' ქვე–კატეგორიის მიხედვით";
$c="3 or incomming_call.call_type_id=0";
if ($type=="ინფორმაცია")  $c=1;
elseif ($type=="პრეტენზია") $c=2;
//------------------------------------------------query-------------------------------------------
switch ($done){
	case  1:
		$result = mysql_query("	SELECT IF(incomming_call.call_type_id=1,'ინფორმაცია',IF(incomming_call.call_type_id=2,'პრეტენზია','სხვა')) as type,
										COUNT(*),
										CONCAT(ROUND(COUNT(*)/(SELECT COUNT(*) FROM incomming_call JOIN department ON incomming_call.department_id=department.id
																WHERE department.`name`='$departament' and DATE(`incomming_call`.`date`) >= '$start' AND DATE(`incomming_call`.`date`) <= '$end')*100,2),'%')
								FROM 	incomming_call
								JOIN 	department ON incomming_call.department_id=department.id
								WHERE 	department.`name`='$departament' and DATE(`incomming_call`.`date`) >= '$start' and  DATE(`incomming_call`.`date`) <= '$end'
								GROUP BY 	type");
		$text[0]=$text[1];
	break;
	case 2:
			$result = mysql_query("SELECT info_category.`name`,
											COUNT(*),
											CONCAT(ROUND(COUNT(*)/(SELECT COUNT(*)
												FROM 	incomming_call
												JOIN 	info_category ON info_category.id=incomming_call.information_category_id
												JOIN department ON incomming_call.department_id=department.id
												WHERE (incomming_call.call_type_id=$c) AND department.`name`='$departament' and DATE(`incomming_call`.`date`) >= '$start' and  DATE(`incomming_call`.`date`) <= '$end'
												)*100,2),'%')
									FROM 	incomming_call
									JOIN 	info_category ON info_category.id=incomming_call.information_category_id
									JOIN department ON incomming_call.department_id=department.id
									WHERE (incomming_call.call_type_id=$c) AND department.`name`='$departament' and DATE(`incomming_call`.`date`) >= '$start' and  DATE(`incomming_call`.`date`) <= '$end'
									GROUP BY info_category.`name`");
		$text[0]=$text[2];
	break;
	case 3:
		$result = mysql_query("SELECT 	info_category.`name` as c_name,
										COUNT(*),
										CONCAT(ROUND(
										COUNT(*)/(SELECT COUNT(*)
											FROM incomming_call
											JOIN info_category AS inf1 ON inf1.`name`='$category'
											JOIN info_category ON info_category.id=incomming_call.information_sub_category_id AND info_category.parent_id=inf1.id
											JOIN department ON incomming_call.department_id=department.id
											WHERE (incomming_call.call_type_id=$c) and DATE(`incomming_call`.`date`) >= '$start' AND DATE(`incomming_call`.`date`) <= '$end' AND department.`name`='$departament'
											)*100,2),'%')
								FROM 	incomming_call
								JOIN 	info_category AS inf1 ON inf1.`name`='$category'
								JOIN 	info_category ON info_category.id=incomming_call.information_sub_category_id AND info_category.parent_id=inf1.id
								JOIN 	department ON incomming_call.department_id=department.id
								WHERE (incomming_call.call_type_id=$c) and DATE(`incomming_call`.`date`) >= '$start' AND DATE(`incomming_call`.`date`) <= '$end' AND department.`name`='$departament'
								GROUP BY c_name");
		$text[0]=$text[3];
		break;
	default:
	    $user		= $_SESSION['USERID'];
	    $dep_filter = "";
	    if($user == 1){
	       $dep_filter = ""; 
	    }elseif($user == 28) {
	        $dep_filter = "AND department.`name` IN('სიტყვა და საქმე','საქმე.ჯი')";
	    }elseif($user == 29) {
	        $dep_filter = "AND department.`name` IN('მწვანე ციკლი')";
	    }elseif($user == 30) {
	        $dep_filter = "AND department.`name` IN('ბიბლუსი')";
	    }elseif($user == 31) {
	        $dep_filter = "AND department.`name` IN('კვირის პალიტრა')";
	    }elseif($user == 32) {
	        $dep_filter = "AND department.`name` IN('HR')";
	    }elseif($user == 26 || $user == 42 || $user == 43) {
	        $dep_filter = "AND department.`name` IN('ელვა.ჯი')";
	    }elseif($user == 16) {
	        $dep_filter = "AND department.`name` IN('Readersland')";
	    }elseif($user == 9) {
	        $dep_filter = "AND department.`name` IN('პალიტრა L')";
	    }elseif($user == 12) {
	        $dep_filter = "AND department.`name` IN('ბიბლუსი')";
	    }elseif($user == 15) {
	        $dep_filter = "AND department.`name` IN('პალიტრა მედია')";
	    }
		$result = mysql_query("SELECT 	department.`name` AS d_name,
										COUNT(*),
										CONCAT(ROUND(COUNT(*)/(SELECT COUNT(*) FROM incomming_call JOIN department ON incomming_call.department_id=department.id
										WHERE DATE(`incomming_call`.`date`) >= '$start' AND DATE(`incomming_call`.`date`) <= '$end' $dep_filter )*100,2),'%')
							FROM 		incomming_call
							JOIN 		department ON incomming_call.department_id=department.id
							WHERE DATE(`incomming_call`.`date`) >= '$start' AND DATE(`incomming_call`.`date`) <= '$end' $dep_filter
							GROUP BY 	d_name");

		break;
}
///----------------------------------------------act------------------------------------------
switch ($action) {
	case "get_list":
		$data = array("aaData"	=> array());
		while ( $aRow = mysql_fetch_array( $result ) )
		{	$row = array();
			for ( $i = 0 ; $i < $count ; $i++ )
			{
				$row[0] = '0';

				$row[$i+1] = $aRow[$i];
			}
			$data['aaData'][] =$row;
		}
		echo json_encode($data); return 0;
		break;
	case 'get_category' :
		$rows = array();
		while($r = mysql_fetch_array($result)) {
			$row[0] = $r[0];
			$row[1] = (float) $r[1];
			$rows['data'][]=$row;
		}
		$rows['text']=$text[0];
		echo json_encode($rows);
		break;
	case 'get_in_page':
		    $result = mysql_query("SELECT `incomming_call`.`id`,
		    `incomming_call`.`date`,
		    `department`.`name`,
		    `main_cat`.`name`,
		    `info_category`.`name`,
		    `incomming_call`.`first_name`,
		    `incomming_call`.`phone`,
		    `incomming_call`.`call_comment`,
		    `call_status`.`name`,
		    `persons`.`name`
		    FROM 	incomming_call
		    JOIN  	info_category as `main_cat` ON main_cat.id=incomming_call.information_category_id
		    JOIN  	info_category ON info_category.id=incomming_call.information_sub_category_id
		    left JOIN   call_status ON incomming_call.call_status_id = call_status.id
		    JOIN  	department ON incomming_call.department_id=department.id
		    JOIN    users ON incomming_call.user_id = users.id
		    JOIN    persons ON users.person_id = persons.id
		    WHERE DATE(`incomming_call`.`date`) >= '$start' AND DATE(`incomming_call`.`date`) <= '$end'
		    AND department.`name`='$departament' AND info_category.`name`='$s_category' and (incomming_call.call_type_id=$c)
		    GROUP BY incomming_call.id");
		    $data = array("aaData"	=> array());
		    while ( $aRow = mysql_fetch_array( $result ) )
		    {	$row = array();
		    $data['aaData'][] =$aRow;
		    }
		    echo json_encode($data); return 0;
		break;
	default :
		echo "Action Is Null!";
		break;

}



?>