<?php
require_once 'includes/classes/core.php';


$action = $_REQUEST['act'];
$error	= '';
$data	= '';

switch ($action) {
	case 'get_logout':
	    $res = mysql_query("SELECT id,`name` FROM `work_activities` WHERE actived = 1");
	    $option = '<option value="0">----</option>';
	    while ($req = mysql_fetch_assoc($res)){
	        $option .= '<option value="'.$req[id].'">'.$req[name].'</option>';
	    }
	    $data['page'] = '<div id="dialog-form">
        	               <fieldset style="height: auto;">
	                           <table class="dialog-form-table">
	                                <tr>
                    					<td>	
                    						<label for="logout_actions">აქტივობა</label>
                    					</td>
                    			    </tr>
                    				<tr>
                    					<td>	
                    						<select id="logout_actions" style="width:200px;">'.$option.'</select>
                    					</td>
                    			   </tr>
	                               <tr>
                    					<td>	
                    						<label for="logout_comment">კომენტარი</label>
                    					</td>
                    			   </tr>
	                               <tr>
                    					<td>	
                    						<textarea id="logout_comment" style="width:300px; height:100px;background: #fff;"></textarea>
                    					</td>
                    			   </tr>
                    		   </table>
            	           </fieldset>
            		     </div>';
		break;
	case 'add_user_log':
	    $date           = date("Y-m-d H:i:s");
	    $user_id        = $_SESSION['USERID'];
	    $logout_actions = $_REQUEST['logout_actions'];
	    $logout_comment = $_REQUEST['logout_comment'];
	    
	    mysql_query("UPDATE `user_log` SET
        	                `logout_date`='$date',
	                        `comment`='$logout_comment',
	                        `work_activities_id`='$logout_actions'
        	         WHERE  `user_id` = '$user_id' AND ISNULL(logout_date)");

	    unset($_SESSION['USERID']);
	    unset($_SESSION['lifetime']);

	    break;
    default:
       $error = 'Action is Null';
}
$data['error'] = $error;

echo json_encode($data);

?>