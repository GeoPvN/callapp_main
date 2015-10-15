<?php
$user_id = $_SESSION['USERID'];

$result = mysql_query("
						SELECT 		`menu_detail`.page_id,
									`menu_detail`.title,
									`menu_detail`.metro_icon,
									`menu_detail`.metro_tile_type
						FROM 		`users`
						LEFT JOIN   `group` ON `group`.id = `users`.`group_id`
						LEFT JOIN   `group_permission` ON `group`.id = `group_permission`.`group_id`
						LEFT JOIN   `menu_detail` ON `group_permission`.`page_id` = `menu_detail`.`page_id`
						WHERE 		`users`.`id` = $user_id AND metro_tile_type != 0
						ORDER BY	`menu_detail`.metro_tile_type DESC
					");

?>

<html>
<head>
		<link href="media/css/main/header.css" rel="stylesheet" type="text/css" />
    	<link href="media/css/main/mainpage.css" rel="stylesheet" type="text/css" />
    	<link href="media/css/main/tooltip.css" rel="stylesheet" type="text/css" />
    	<script type="text/javascript">
    	</script>
</head>
<body onselectstart='return false;'>
<div id="tabs" style="width: 90%">
<div class="callapp_head">მთავარი<hr class="callapp_head_hr"></div>
    <div id="ContentHolder">
        <?php 
        $user_id	= $_SESSION['USERID'];
        if($user_id == 1 || $user_id == 3){
            $check_count = '';
        }else{
            $check_count = "AND task.responsible_user_id = '$user_id'";
        }
            $task_now_count = mysql_fetch_row(mysql_query("   SELECT IF(COUNT(*)>0,CONCAT('<span style=\"color:red;\">',COUNT(*),'</span>'), COUNT(*)),
                                                                      COUNT(*)
                                                              FROM `task`
                                                              WHERE task.`status` = 1 $check_count"));
            $task_process_count = mysql_fetch_row(mysql_query("   SELECT COUNT(*)
                                                                  FROM `task`
                                                                  WHERE task.`status` = 2 $check_count"));
            $task_done_count = mysql_fetch_row(mysql_query("   SELECT COUNT(*)
                                                               FROM `task`
                                                               WHERE task.`status` = 3 $check_count"));
            $task_cancel_count = mysql_fetch_row(mysql_query("   SELECT COUNT(*)
                                                               FROM `task`
                                                               WHERE task.`status` = 4 $check_count"));
            $row = mysql_fetch_row(mysql_query("SELECT users.group_id
                                                FROM `users`
                                                WHERE users.id = '$user_id'"));
            if($task_now_count[1] > 0){
                $new_task = '<span style="background-color: red; border-radius: 2px 2px 2px 2px; color: #FFFFFF; padding: 1px 2px; position: absolute; top: -5px; right: -6px">NEW</span>';
            }
            $my_task_hide = '';
                if($row[0] < 999 && $row[0] != 8){
                    $my_task_hide = '
     <div id="ctl00_ContentPlaceHolder1_tile_Declarations_NEW" class="tile_small" style="background: none repeat scroll 0 0 #1E94DE; position: relative; padding: 0 !important; top: 5px;">
        <p style="display: block!important;margin:8px 0 10px;">ჩემი დავალება</p>

            '.$new_task.'
        
            <div onclick="location.href=\'index.php?pg=33#tab-1\'" class="tile_waybill_notification tt-wrapper" title="გადაცემულია გასარკვევად" style="float: left; cursor: pointer;">
                <span id="ctl00_ContentPlaceHolder1_lblSavedDecl">'.$task_now_count[0].'</span>
            </div>
            <div onclick="location.href=\'index.php?pg=33#tab-2\'" class="tile_waybill_notification tt-wrapper" title="გარკვევის პროცესშია" style="float: left; cursor: pointer;">
                <span id="ctl00_ContentPlaceHolder1_lblSavedDecl">'.$task_process_count[0].'</span>
            </div>
            <div onclick="location.href=\'index.php?pg=33#tab-3\'" class="tile_waybill_notification tt-wrapper" title="მოგვარებულია" style="float: left; margin-top: 5px; cursor: pointer;">
                <span id="ctl00_ContentPlaceHolder1_lblSavedDecl">'.$task_done_count[0].'</span>
            </div>
            <div onclick="location.href=\'index.php?pg=33#tab-4\'" class="tile_waybill_notification tt-wrapper" title="გაუქმებულია" style="float: left; margin-top: 5px; cursor: pointer;">
                <span id="ctl00_ContentPlaceHolder1_lblSavedDecl">'.$task_cancel_count[0].'</span>
            </div>
    </div>
                                    ';
                }else {
                    $my_task_hide = "";
                }
                echo $my_task_hide;
        ?>
    
    <div class="content">
        <table class="tiles">
        <?php
        $user_id	= $_SESSION['USERID'];
        $row = mysql_fetch_row(mysql_query("SELECT users.group_id
                                            FROM `users`
                                            WHERE users.id = '$user_id'"));
            if($row[0] <= 2){
       echo '<tbody>
                <tr>
                    <td>
                    
					   <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=32\'">
			             <p style="font-size: 16px;">ტაბელი</p>
			           </div>
			           <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=37\'">
			             <p style="font-size: 16px;">ჩანაწერები</p>
			           </div>
			           <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=24\'">
			             <p style="font-size: 16px;">სცენარები</p>
			           </div>
					   <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=17\'">
			             <p style="font-size: 16px;">პროდუქტი</p>
			           </div>
						
                    </td>

                    <td>
                 
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=44\'">
			                 <p style="font-size: 16px;">ჩემი გრაფიკები</p>
			            </div>
			            <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=42\'">
			                 <p style="font-size: 16px;">ცვლები</p>
			            </div>
			            <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=45\'">
			                 <p style="font-size: 16px;">WFM</p>
			            </div>
			            <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=43\'">
			                 <p style="font-size: 16px;">გაიდლაინი</p>
			            </div>
			            
				
                    </td>

                    <td>
                   
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=38\'">
			               <p style="font-size: 16px;">სატელეფონო ბაზები</p>
			            </div>
			            <div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=24\'">
			               <p style="font-size: 16px;">სცენარები</p>
			            </div>
			            
						
                    </td>
                </tr>
            </tbody>';
            }elseif($row[0] == 3 || $row[0] == 15){
                echo '<tbody>
                <tr>
                    <td>
                
					   <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=32\'">
			             <p style="font-size: 16px;">ტაბელი</p>
			           </div>
                
                    </td>
                
                    <td>
         
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=44\'">
			                 <p style="font-size: 16px;">ჩემი გრაფიკები</p>
			            </div>
                
                    </td>
                
                    <td>
          
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=43\'">
			               <p style="font-size: 16px;">გაიდლაინი</p>
			            </div>			     
                
                    </td>
                </tr>
            </tbody>';
            }elseif($row[0] == 7){
                echo '<tbody>
                <tr>
                    
                
                    <td>
         
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=35\'">
			                 <p style="font-size: 16px;">განყოფილებების მიხედვით</p>
			            </div>
                        <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>	
                
                    </td>
                
                    <td>
                   
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>			            
						
                    </td>
                
                   
                </tr>
            </tbody>';
            }elseif($row[0] == 8){
                echo '<tbody>
                <tr>
                    <td>
                
					   <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=36\'">
			             <p style="font-size: 16px;">შინაარსობრივი რეპორტი ზარების მიხედვით</p>
			           </div>
					   <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=35\'">
			             <p style="font-size: 16px;">შინაარსობრივი რეპორტი განყოფილებების მიხედვით</p>
			           </div>
                       <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=47\'">
			             <p style="font-size: 16px;">გაყიდვები</p>
			           </div>
                       
                
                    </td>
                
                    <td>
         
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=49\'">
			                 <p style="font-size: 16px;">შემომავალი ზარი - ტექნიკური რეპორტი</p>
			            </div>
					    <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=41\'">
			                 <p style="font-size: 16px;">გამავალი ზარი - ტექნიკური რეპორტი</p>
			            </div>
                
                    </td>
                    
                    <td>
         
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=52\'">
			             <p style="font-size: 16px;">ბიბლუსის სამომხმარებლო კვლევა</p>
			            </div>
					    <div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=48\'">
			                 <p style="font-size: 16px;">გამავალი ზარები დავალებების მიხედვით</p>
			            </div>
                
                    </td>
                
                   
                </tr>
            </tbody>';
            }elseif($row[0] == 9){
                echo '<tbody>
                <tr>
                    <td>
                
					  
					   <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=35\'">
			             <p style="font-size: 16px;">განყოფილებების მიხედვით</p>
			           </div>
                
                    </td>
                
                    <td>
                   
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>			            
						
                    </td>
			        
			        <td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>			            
						
                    </td>
                </tr>
            </tbody>';
            }elseif($row[0] == 10){
                echo '<tbody>
                <tr>
                                    
                    <td>
                   
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>			            
						
                    </td>
                </tr>
            </tbody>';
            }elseif($row[0] == 5){
                echo '<tbody>
                <tr>
                                    
                    <td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>			            
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>
                        
                    </td>
			        
			        <td>
         
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=35\'">
			                 <p style="font-size: 16px;">ქვე–განყოფილებების მიხედვით</p>
			            </div>
                
                    </td>
			                     
			        <td>
         
						<div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=47\'">
			                 <p style="font-size: 16px;">გაყიდვები</p>
			            </div>
                
                    </td>
			                     
                </tr>
            </tbody>';
            }elseif($row[0] == 6){
                echo '<tbody>
                <tr>
                                    
                    <td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=47\'">
			               <p style="font-size: 16px;">გაყიდვები</p>
			            </div>	
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>			            
						
                    </td>
			                     
                </tr>
            </tbody>';
            }elseif($row[0] == 11){
                echo '<tbody>
                <tr>
                                    
                    <td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>			            
						
                    </td>
					
					<td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>			            
						
                    </td>
			                     
                </tr>
            </tbody>';
            }elseif($row[0] == 13){
                echo '<tbody>
                <tr>
                                    
                    <td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>
			            <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>			            
						
                    </td>
					       
					<td>
                   
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=55\'">
			               <p style="font-size: 16px;">Readersland</p>
			            </div>			            
						
                    </td>
					       
					<td>
         
						<div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=35\'">
			                 <p style="font-size: 16px;">განყოფილებების მიხედვით</p>
			            </div>
                        <div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=48\'">
			                 <p style="font-size: 16px;">გამავალი ზარები დავალებების მიხედვით</p>
			            </div>
                    </td>
			                     
                </tr>
            </tbody>';
            }elseif($row[0] == 12){
                echo '<tbody>
                <tr>
                                    
                    <td>
                   
						<div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=13\'">
			               <p style="font-size: 16px;">პორტალი</p>
			            </div>
			            <div  class="tile_small" style="background: #008BBA;" onclick="location.href=\'index.php?pg=33\'">
			               <p style="font-size: 16px;">დავალებები</p>
			            </div>			            
						
                    </td>
					       
					<td>
                   
						<div  class="tile_small" style="background: #DB3340;" onclick="location.href=\'index.php?pg=52\'">
			               <p style="font-size: 16px;">კვლევა</p>
			            </div>			            
						
                    </td>
					       
					<td>
         
						<div  class="tile_small" style="background: #E8B71A;" onclick="location.href=\'index.php?pg=35\'">
			                 <p style="font-size: 16px;">განყოფილებების მიხედვით</p>
			            </div>
                        
                    </td>
			                     
                </tr>
            </tbody>';
            }
        ?>
        </table>
    </div>
        </div>
</body>
</html>
