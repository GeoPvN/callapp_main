<?php 

include 'includes/classes/core.php';

if($_REQUEST['act'] = 'get_checker'){

    $user_id	= $_SESSION['USERID'];
    if($user_id == 1){
        $check_count = '';
    }else{
        $check_count = "AND responsible_user_id = $user_id";
    }
    
    $task_now_count = mysql_fetch_row(mysql_query(" SELECT COUNT(*)
                                                    FROM `task`
                                                    WHERE task.`status` = 1 $check_count"));
    
    $task_callcenter_count = mysql_fetch_row(mysql_query(" SELECT COUNT(*)
                                                           FROM `task`
                                                           WHERE DATE(date) = DATE(NOW()) AND task.`status` = 5 $check_count"));
    
    $task_elva_count = mysql_fetch_row(mysql_query(" SELECT COUNT(*)
                                                     FROM `task`
                                                     WHERE DATE(date) = DATE(NOW()) AND task.`status` = 6 $check_count"));
    
    $action_now_count = mysql_fetch_row(mysql_query("   SELECT COUNT(*)
                                                        FROM `action`
                                                        WHERE DATE(create_date) = DATE(NOW()) AND actived = 1"));
    $count = "";
    if($task_now_count[0] > 0){
        
            $count = "<div id=\"news\"><span>თქვენ გაქვთ $task_now_count[0] ახალი დავალება</span></div>";
        
    }
    
    if($action_now_count[0] > 0){
        
            $count .= "<div id=\"news_action\"><span>დაემატა $action_now_count[0] ახალი სიახლე</span></div>";
        
    }
    
    if($task_callcenter_count[0] > 0){
    
        $count .= "<div id=\"news_call\"><span>ქოლცენტრის დაზუსტება $task_callcenter_count[0] რ-ბა</span></div>";
    
    }
    
    if($task_elva_count[0] > 0){
    
        $count .= "<div id=\"news_elva\"><span>დაემატა $task_elva_count[0] ახალი სიახლე</span></div>";
    
    }
    
    $data = array('count'=>$count);
    
    echo json_encode($data);
}

?>