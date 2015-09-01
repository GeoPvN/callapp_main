<?php
require_once('../../includes/classes/core.php');
$action	= $_REQUEST['act'];
$error	= '';
$data	= '';

$status_id 		= $_REQUEST['id'];
$status_name  	= $_REQUEST['name'];
$call_status  	= $_REQUEST['call_status'];


switch ($action) {
	case 'get_add_page':
		$page		= GetPage();
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$template_id		= $_REQUEST['id'];
		$page		= GetPage(Getedit($status_id));
		$data		= array('page'	=> $page);

		break;
	case 'clean_base':
		    $template_id	= $_REQUEST['id'];
		    $page		= GetPageCleanBase();
		    $data		= array('page'	=> $page);
		
		break;
		case 'delete_base':
		    $clean_date  	= $_REQUEST['clean_date'];
		    mysql_query("DELETE FROM `phone`
		                 WHERE DATE_FORMAT(create_date, '%Y-%m-%d') = '$clean_date'");
		
		    break;
	case 'get_list_import' :
	    // DB table to use
	    $table = 'phone';
	    
	    // Table's primary key
	    $primaryKey = 'id';
	    
	    // Array of database columns which should be read and sent back to DataTables.
	    // The `db` parameter represents the column name in the database, while the `dt`
	    // parameter represents the DataTables column identifier. In this case simple
	    // indexes
	    $columns = array(
	        array( 'db' => 'id', 			    'dt' => 0 ),
	        array( 'db' => 'phone1', 			'dt' => 1 ),
	        array( 'db' => 'phone2',  			'dt' => 2 ),
	        array( 'db' => 'first_last_name',   'dt' => 3 ),
	        array( 'db' => 'person_n',     		'dt' => 4 ),
	        array( 'db' => 'addres',			'dt' => 5 ),
	        array( 'db' => 'city',			    'dt' => 6 ),
	        array( 'db' => 'mail',			    'dt' => 7 ),
	        array( 'db' => 'born_day',			'dt' => 8 ),
	        array( 'db' => 'sorce',			    'dt' => 9 ),
	        array( 'db' => 'create_date',		'dt' => 10 ),
	        array( 'db' => 'person_status',		'dt' => 11 ),
	        array( 'db' => 'note',		        'dt' => 12 ),
	    
	    );
	    
	    // SQL server connection information
	    $sql_details = array(
	        'user' => 'root',
	        'pass' => 'Gl-1114',
	        'db'   => 'callapp_main',
	        'host' => 'localhost'
	    );
	    
	    
	    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	     * If you just want to use the basic configuration for DataTables with PHP
	     * server-side, there is no need to edit below this line.
	    */
	    //mysql_close();
	    require( '../../includes/ssp.class.php' );
	    
	    $where_param = "";

	     $data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where_param, "disable-all");
	    
		break;
	case 'get_list_incomming' :
	    
	    // DB table to use
	    $table = 'inc';
	     
	    // Table's primary key
	    $primaryKey = 'id';
	     
	    // Array of database columns which should be read and sent back to DataTables.
	    // The `db` parameter represents the column name in the database, while the `dt`
	    // parameter represents the DataTables column identifier. In this case simple
	    // indexes
	    $columns = array(
	        array( 'db' => 'id', 			    'dt' => 0 ),
	        array( 'db' => 'phone', 			'dt' => 1 ),
	        array( 'db' => 'a',  			    'dt' => 2 ),
	        array( 'db' => 'first_name',        'dt' => 3 ),
	        array( 'db' => 's',     		    'dt' => 4 ),
	        array( 'db' => 'd',			        'dt' => 5 ),
	        array( 'db' => 'f',			        'dt' => 6 ),
	        array( 'db' => 'g',			        'dt' => 7 ),
	        array( 'db' => 'h',			        'dt' => 8 ),
	        array( 'db' => 'j',			        'dt' => 9 ),
	        array( 'db' => 'date',		        'dt' => 10 ),
	        array( 'db' => 'type',		        'dt' => 11 ),
	         
	    );
	     
	    // SQL server connection information
	    $sql_details = array(
	        'user' => 'root',
	        'pass' => 'Gl-1114',
	        'db'   => 'callapp_main',
	        'host' => 'localhost'
	    );
	     
	     
	    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	     * If you just want to use the basic configuration for DataTables with PHP
	     * server-side, there is no need to edit below this line.
	    */
	    //mysql_close();
	    require( '../../includes/ssp.class.php' );
	     
	    $where_param = "";
	    
	    $data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where_param, "disable-all");
		
		break;
	case 'get_list_all' :
	    
        $num_rows = mysql_num_rows(mysql_query("SELECT * FROM allin"));
        $num_rows1 = mysql_num_rows(mysql_query("SELECT * FROM test"));
        
        if($num_rows > $num_rows1){
            mysql_query("DROP TABLE IF EXISTS asteriskcdrdb.test;");
            mysql_query("CREATE TABLE asteriskcdrdb.test AS SELECT * FROM allin;");
            mysql_query("ALTER TABLE `test` ADD INDEX `a` (`a`);");
        }
	    
	    // DB table to use
	    $table = 'test';
	    
	    // Table's primary key
	    $primaryKey = 'a';
	    
	    // Array of database columns which should be read and sent back to DataTables.
	    // The `db` parameter represents the column name in the database, while the `dt`
	    // parameter represents the DataTables column identifier. In this case simple
	    // indexes
	    $columns = array(
	        array( 'db' => 'a', 			'dt' => 0 ),
	        array( 'db' => 's', 			'dt' => 1 ),
	        array( 'db' => 'd',  			'dt' => 2 ),
	        array( 'db' => 'f',             'dt' => 3 ),
	        array( 'db' => 'g',     		'dt' => 4 ),
	        array( 'db' => 'h',			    'dt' => 5 ),
	        array( 'db' => 'j',			    'dt' => 6 ),
	        array( 'db' => 'k',			    'dt' => 7 ),
	        array( 'db' => 'l',			    'dt' => 8 ),
	        array( 'db' => 'z',			    'dt' => 9 ),
	        array( 'db' => 'x',		        'dt' => 10 ),
	        array( 'db' => 'c',		        'dt' => 11 ),
	    
	    );
	    
	    // SQL server connection information
	    $sql_details = array(
	        'user' => 'root',
	        'pass' => 'Gl-1114',
	        'db'   => 'callapp_main',
	        'host' => 'localhost'
	    );
	    
	    
	    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	     * If you just want to use the basic configuration for DataTables with PHP
	     * server-side, there is no need to edit below this line.
	    */
	    //mysql_close();
	    require( '../../includes/ssp.class.php' );
	    
	    $where_param = "";
	     
	    $data = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $where_param, "disable-all");
	    
		break;
	case 'up_phone_base':
		$phone1 			= $_REQUEST['phone1'];
		$phone2 			= $_REQUEST['phone2'];
		$first_last_name 	= $_REQUEST['first_last_name'];
		$person_n 			= $_REQUEST['person_n'];
		$addres 			= $_REQUEST['addres'];
		$city 				= $_REQUEST['city'];
		$mail 				= $_REQUEST['mail'];
		$born_day 			= $_REQUEST['born_day'];
		$sorce 				= $_REQUEST['sorce'];
		$person_status 		= $_REQUEST['person_status'];
		$note 				= $_REQUEST['note'];
		if($status_id != ''){
			UpPhoneBase($status_id, $phone1, $phone2, $first_last_name, $person_n, $addres, $city, $mail, $born_day, $sorce, $person_status, $note);
		}else {
		    SavePhoneBase($status_id, $phone1, $phone2, $first_last_name, $person_n, $addres, $city, $mail, $born_day, $sorce, $person_status, $note);
		}	
		break;
	case 'disable':
		$status_id	= $_REQUEST['id'];
		Disablestatus($status_id);

		break;
	case 'anti_dub':
	    mysql_query("   DELETE n1 
                        FROM phone n1, phone n2 
                        WHERE n1.id < n2.id 
                        AND n1.phone1 = n2.phone1
                        AND n1.`import` =1 
                        AND n2.`import` =1 
                        AND n1.phone1 != '' 
                        AND n2.phone1 != ''");
	    
	    mysql_query("   DELETE n1
                        FROM phone n1, phone n2
                        WHERE n1.id < n2.id
                        AND n1.phone2 = n2.phone2
                        AND n1.`import` =1
                        AND n2.`import` =1
                        AND n1.phone2 != ''
                        AND n2.phone2 != ''");
	
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

function UpPhoneBase($status_id, $phone1, $phone2, $first_last_name, $person_n, $addres, $city, $mail, $born_day, $sorce, $person_status, $note)
{
	$user_id	= $_SESSION['USERID'];
	mysql_query("	UPDATE 	`phone` SET 
							`user_id`			='$user_id',  
							`phone1`			='$phone1', 
							`phone2`			='$phone2', 
							`first_last_name`	='$first_last_name', 
							`person_n`			='$person_n', 
							`addres`			='$addres', 
							`person_status`		='$person_status', 
							`mail`				='$mail', 
							`city`				='$city', 
							`born_day`			='$born_day', 
							`sorce`				='$sorce', 
							`note`				='$note'
					WHERE 	`id`				='$status_id' ");
}

function SavePhoneBase($status_id, $phone1, $phone2, $first_last_name, $person_n, $addres, $city, $mail, $born_day, $sorce, $person_status, $note)
{
    $c_date		= date('Y-m-d H:i:s');
    $user_id	= $_SESSION['USERID'];
    mysql_query("INSERT INTO `phone` 
    (`user_id`, `phone1`, `phone2`, `first_last_name`, `person_n`, `addres`, `person_status`, `mail`, `city`, `born_day`, `create_date`, `sorce`, `import`, `actived`, `note`)
    VALUES
    ('$user_id', '$phone1', '$phone2', '$first_last_name', '$person_n', '$addres', '$person_status', '$mail', '$city', '$born_day', '$c_date', '$sorce', '1', '1', '$note')");
}

function Disablestatus($status_id)
{
	mysql_query("	DELETE FROM `phone`
                    WHERE `id` = $status_id;	
	            ");
}

function Getedit($status_id)
{
	$res = mysql_fetch_assoc(mysql_query("	SELECT 	id,
											phone1,
											phone2,
											first_last_name,
											person_n,
											addres,
											city,
											mail,
											born_day,
											sorce,
											create_date,
											person_status,
											note
									FROM 	`phone`
									WHERE	id= $status_id" ));

	return $res;
}

function GetPage($res = '')
{
    $c_date		= date('Y-m-d H:i:s');
	$data = '
	<div id="dialog-form">
	    <fieldset>
	    	<legend>ძირითადი ინფორმაცია</legend>

	    	<table class="dialog-form-table">
				<tr>
					<td style="width: 130px;"><label for="CallType">ტელეფონი 1</label></td>
					<td>
						<input style="width: 120px;" type="text" id="phone1" class="idle" onblur="this.className=\'idle \'" value="' . $res['phone1'] . '" />
					</td>
					<td style="width: 130px;"><label style="margin-left:10px;" for="CallType">ტელეფონი 2</label></td>
					<td>
						<input style="width: 120px;" type="text" id="phone2" class="idle" onblur="this.className=\'idle \'" value="' . $res['phone2'] . '" />
					</td>
				</tr>
				<tr>
					<td style="width: 130px;"><label for="CallType">სახელი / გვარი</label></td>
					<td>
						<input style="width: 120px;" type="text" id="first_last_name" class="idle" onblur="this.className=\'idle \'" value="' . $res['first_last_name'] . '" />
					</td>
					<td style="width: 130px;"><label style="margin-left:10px;" for="CallType">პირადი N</label></td>
					<td>
						<input style="width: 120px;" type="text" id="person_n" class="idle" onblur="this.className=\'idle \'" value="' . $res['person_n'] . '" />
					</td>
				</tr>
				<tr>
					<td style="width: 130px;"><label for="CallType">მისამართი</label></td>
					<td>
						<input style="width: 120px;" type="text" id="addres" class="idle" onblur="this.className=\'idle \'" value="' . $res['addres'] . '" />
					</td>
					<td style="width: 130px;"><label style="margin-left:10px;" for="city">ქალაქი</label></td>
					<td>
						<input style="width: 120px;" type="text" id="city" class="idle" onblur="this.className=\'idle \'" value="' . $res['city'] . '" />
					</td>
				</tr>
				<tr>
					<td style="width: 130px;"><label for="CallType">ელ-ფოსტა</label></td>
					<td>
						<input style="width: 120px;" type="text" id="mail" class="idle" onblur="this.className=\'idle \'" value="' . $res['mail'] . '" />
					</td>
					<td style="width: 130px;"><label style="margin-left:10px;" for="CallType">დაბ. წელი</label></td>
					<td>
						<input style="width: 120px;" type="text" id="born_day" class="idle" onblur="this.className=\'idle \'" value="' . $res['born_day'] . '" />
					</td>
				</tr>
				<tr>
					<td style="width: 130px;"><label for="CallType">განყოფილება</label></td>
					<td>
						<input style="width: 120px;" type="text" id="sorce" class="idle" onblur="this.className=\'idle \'" value="' . $res['sorce'] . '" />
					</td>
					<td style="width: 130px;"><label style="margin-left:10px;" for="CallType">ფორმირების თარიღი</label></td>
					<td>
						<input disabled style="width: 120px;" type="text" id="create_date" class="idle" onblur="this.className=\'idle \'" value="' . (($res['create_date']!='')? $res['create_date']:$c_date ) . '" />
					</td>
				</tr>
				<tr>
					<td style="width: 130px;"><label for="CallType">ფიზიკური/იურიდიული</label></td>
					<td>
						<input style="width: 120px;" type="text" id="person_status" class="idle" onblur="this.className=\'idle \'" value="' . $res['person_status'] . '" />
					</td>
					<td style="width: 130px;"><label style="margin-left:10px;" for="CallType">შენიშვნა</label></td>
					<td>
						<input style="width: 120px;" type="text" id="note" class="idle" onblur="this.className=\'idle \'" value="' . $res['note'] . '" />
					</td>
				</tr>
			</table>
			<!-- ID -->
			<input type="hidden" id="status_id" value="' . $res['id'] . '" />
        </fieldset>
    </div>
    ';
	return $data;
}

function GetPageCleanBase()
{
    $data = '
	<div id="dialog-form">
	    <fieldset>
	    	<legend>ძირითადი ინფორმაცია</legend>
    
	    	<table class="dialog-form-table">
				<tr>
					<td style="width: 130px;"><label for="clean_date">თარიღი</label></td>
					<td>
						<input style="width: 120px;" type="text" id="clean_date" class="idle" onblur="this.className=\'idle \'" value="" />
					</td>
				</tr>
			</table>
        </fieldset>
    </div>
    ';
    return $data;
}

?>

