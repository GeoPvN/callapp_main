<?php
// MySQL Connect Link
require_once('../../includes/classes/core.php');

// Main Strings
$action                     = $_REQUEST['act'];
$error                      = '';
$data                       = '';

// Incomming Call Dialog Strings
$hidden_id                  = $_REQUEST['id'];
$incomming_id               = $_REQUEST['incomming_id'];
$incomming_date             = $_REQUEST['incomming_date'];
$incomming_phone            = $_REQUEST['incomming_phone'];
$incomming_cat_1            = $_REQUEST['incomming_cat_1'];
$incomming_cat_1_1          = $_REQUEST['incomming_cat_1_1'];
$incomming_cat_1_1_1        = $_REQUEST['incomming_cat_1_1_1'];
$incomming_comment          = $_REQUEST['incomming_comment'];


switch ($action) {
	case 'get_add_page':
		$page		= GetPage('',increment(incomming_call));
		$data		= array('page'	=> $page);

		break;
	case 'get_edit_page':
		$page		= GetPage(Getincomming($hidden_id));
		$data		= array('page'	=> $page);

        break;
	case 'get_list':
        $count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
	  	$rResult = mysql_query("SELECT  id,
                            	  	    id,
                            	  	    date,
                            	  	    phone,
                            	  	    cat_1
                    	  	    FROM    `incomming_call`;");
	  
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
    case 'get_list_ext':
        $count = 		$_REQUEST['count'];
        $hidden = 		$_REQUEST['hidden'];
        $rResult = mysql_query("SELECT  id,
                        	  	    id,
                        	  	    date,
                        	  	    phone,
                        	  	    cat_1
                	  	    FROM    `incomming_call`;");
         
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
	default:
		$error = 'Action is Null';
}

$data['error'] = $error;

echo json_encode($data);


/* ******************************
 *	Request Functions
* ******************************
*/

function Getincomming($hidden_id)
{
	$res = mysql_fetch_assoc(mysql_query("SELECT  incomming_call.id AS id,
												  incomming_call.`date` AS call_date,
												  DATE_FORMAT(incomming_call.`date`,'%y-%m-%d') AS `date`,
												  incomming_call.`phone`														
										  FROM 	  incomming_call
										  where   incomming_call.id =  $hidden_id"));
	return $res;
}

function GetPage($res,$increment)
{
	$data  .= '
	<div id="dialog-form">
	    <fieldset style="width: 275px;  float: left;">
	       <legend>ძირითადი ინფორმაცია</legend>
	       <table class="dialog-form-table">
    	       <tr>
	               <td style="width: 210px;"><label for="queue_name">დასახელება</label></td>
	               <td><input id="queue_name" type="text" value=""></td>
    	       </tr>
	           <tr>
	               <td><label for="queue_phone">ნომერი</td>
	               <td><input id="queue_phone" type="text" value=""></td>
    	       </tr>
	       </table>
	    </fieldset>
	    
	    
        <div id="side_menu" style="float: left;height: 346px;width: 80px;margin-left: 10px; background: #272727; color: #FFF;margin-top: 6px;">
	       <spam class="info" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'info\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/info.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">შიდა ნომერი</div></spam>
	       <spam class="task" style="display: block;padding: 10px 5px;  cursor: pointer;" onclick="show_right_side(\'task\')"><img style="padding-left: 22px;padding-bottom: 5px;" src="media/images/icons/task.png" alt="24 ICON" height="24" width="24"><div style="text-align: center;">სცენარი</div></spam>
        </div>
	    
	    <div style="width: 445px;float: left;margin-left: 10px;" id="right_side">
            <fieldset style="display:none;" id="info">
                <legend>შიდა ნომერი</legend>
	            <span class="hide_said_menu">x</span>
	            <div style="margin: 15px 0;">
                    <button id="add_button_ext">დამატება</button>
                    <button id="delete_button_ext">წაშლა</button>
                </div>
	            <table class="display" id="table_ext">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">დასახელება</th>
                            <th style="width: 100%;">ნომერი</th>
                            <th class="check">#</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                        	   <input type="text" name="search_id" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>                         
                            <th>
                            	<input type="checkbox" name="check-all" id="check-all">
                            </th>           
                        </tr>
                    </thead>
                </table>
            </fieldset>
    	     
            <fieldset style="display:none;" id="task">
                <legend>სცენარი</legend>
	            <span class="hide_said_menu">x</span>
	            <table class="dialog-form-table">
                    <tr>
                       <td style="width: 210px;"><label for="queue_scenar">დასახელება</label></td>                   
                    </tr>
    	            <tr>
                       <td><select id="queue_scenar"></select></td>
                    </tr>
	            </table>
	    <style>
	    #work_table{
	    
	    width: 100%;
	    margin-top:5px;
	    }
	    #work_table td{
	    border: 1px solid;
	    }
	    .im_border{
	    border:1px solid;
	    }
	    </style>
	            <table class="dialog-form-table" id="work_table">
                    <tr>
                        <td style="width: ;"></td>
                	    <td style="width: ;">0</td>
                	    <td style="width: ;">1</td>
                	    <td style="width: ;">2</td>
                	    <td style="width: ;">3</td>
                	    <td style="width: ;">4</td>
                	    <td style="width: ;">5</td>
                	    <td style="width: ;">6</td>
                	    <td style="width: ;">7</td>
                	    <td style="width: ;">8</td>
                	    <td style="width: ;">9</td>
                	    <td style="width: ;">10</td>
                	    <td style="width: ;">11</td>
                	    <td style="width: ;">12</td>
                	    <td style="width: ;">13</td>
                	    <td style="width: ;">14</td>
	                    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
    	            <tr>
                        <td style="width: ;">ორშ</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	                <tr>
                        <td style="width: ;">სამ</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	                <tr>
                        <td style="width: ;">ოთხ</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	                <tr>
                        <td style="width: ;">ხუთ</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	                <tr>
                        <td style="width: ;">პარ</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	                <tr>
                        <td style="width: ;">შაბ</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	                <tr>
                        <td style="width: ;">კვი</td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
                	    <td style="width: ;"></td>
	    <td style="width: ;">15</td>
                	    <td style="width: ;">16</td>
                	    <td style="width: ;">17</td>
                	    <td style="width: ;">18</td>
                	    <td style="width: ;">19</td>
	                    <td style="width: ;">20</td>
                	    <td style="width: ;">21</td>
                	    <td style="width: ;">22</td>
                	    <td style="width: ;">23</td>
                    </tr>
	            </table>
	            <table class="dialog-form-table">
                    <tr>
                       <td style="width: 210px;"><label for="queue_scenar">საანგარიშო პერიოდი</label></td>    
	                   <td></td>              
                    </tr>
    	            <tr>
                       <td><select id="queue_scenar"></select></td>
	                   <td><select id="queue_scenar"></select></td>
                    </tr>
	            </table>
	            <table class="dialog-form-table">
                    <tr>
	                   <td><input id="" type="checkbox"></td>
                       <td style="width: ;"><label for="queue_scenar">დღესასწაულები</label></td>
                	   <td style="width: ;"><input style="width: 100px;" id="" type="text"></td>
                	   <td style="width: ;"><input style="width: 100px;" id="" type="text"></td>
	                   <td style="width: ;"><button>დამატება</button></td>
                    </tr>
    	            <tr>
                       <td></td>
	                   <td></td>
	                   <td class="im_border">თარიღი</td>
	                   <td class="im_border">კომენტარი</td>
	                   <td></td>
                    </tr>
	                <tr>
                       <td></td>
	                   <td></td>
	                   <td class="im_border">01.01.2016</td>
	                   <td class="im_border">ახალი წელი</td>
	                   <td>X</td>
                    </tr>
	            </table>
            </fieldset>

	    </div>
	</div><input type="hidden" value="'.(($res[id]=='')?$increment:$res[id]).'" id="hidden_id">';

	return $data;
}


function increment($table){

    $result   		= mysql_query("SHOW TABLE STATUS LIKE '$table'");
    $row   			= mysql_fetch_array($result);
    $increment   	= $row['Auto_increment'];
    $next_increment = $increment+1;
    mysql_query("ALTER TABLE $table AUTO_INCREMENT=$next_increment");

    return $increment;
}

?>