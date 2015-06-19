<?php

require_once ('../../includes/classes/core.php');


$action 	= $_REQUEST['act'];
$error		= '';
$data		= '';
$start		= $_REQUEST['start'];
$end		= $_REQUEST['end'];

switch ($action) {
	case 'get_list' :
		$count = 		$_REQUEST['count'];
		$hidden = 		$_REQUEST['hidden'];
		$cash_ch = 		$_REQUEST['cash_ch'];
		$user_id =      $_SESSION['USERID'];
		$user_cheker =  getpersgrup($user_id);
		//------------
		if($user_cheker == 5){
		    $user_query_filter = 'AND sale_details.department_id = 21';
		}else{
		    $user_query_filter = '';
		}
		//------------
        if($cash_ch == 3){
		    $chash_id = "AND (elva_sale_new.cash IS NULL OR  elva_sale_new.cash = '')";
		}elseif($cash_ch == 0){
		    $chash_id = "";
		}elseif ($cash_ch != 0) {
		    $chash_id = "AND elva_sale_new.cash = '$cash_ch'";
		}
		
		if($_REQUEST[date_type] == 1){
		    $date_type = 'call_date';
		}elseif($_REQUEST[date_type] == 2){
		    $date_type = 'send_date';
		}else{
		    $date_type = 'send_client_date';
		}
		if($_REQUEST[dep_id] == 0){
		    $dep_id = 21; 
		    $dep_id1 = 25;		    
		}else {
		    $dep_id = $_REQUEST[dep_id];
		    $dep_id1 = $_REQUEST[dep_id];
		}
		if($_REQUEST[tab_num] == 7){
		    if($_REQUEST[dep_id] == 0){
		        $check_dep = "";
		    }else{
		        $check_dep = "AND sale_details.department_id = $_REQUEST[dep_id]";
		    }
		}else{
		    $check_dep = "AND ((main_status = $_REQUEST[tab_num] AND sale_details.department_id = $dep_id) OR (main_status1 = $_REQUEST[tab_num] AND sale_details.department_id = $dep_id1))";
		}
        $rResult = mysql_query("
        SELECT 			elva_sale_new.id AS `id`,
        				CONCAT('<button style=\"width: 100%;\" class=\"myact ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" onclick=\"openmyact(\'',elva_sale_new.task_id,'\',\'',elva_sale_new.custom_prod,'\',\'',elva_sale_new.id,'\',\'0\')\"><span class=\"ui-button-text\">',elva_sale_new.name_surname,'</span></button>') as `button`,
        				city.`name` as city_name,
        				elva_sale_new.address,
        				IF(date(elva_sale_new.call_date) != '0000-00-00',DATE_FORMAT(elva_sale_new.call_date,'%d.%m.%Y %H:%i:%s'),'') AS `call_date`,
        				IF(date(elva_sale_new.send_date) != '0000-00-00',DATE_FORMAT(elva_sale_new.send_date,'%d.%m.%Y'),'') AS `send_date`,
        				IF(date(elva_sale_new.send_client_date) != '0000-00-00',DATE_FORMAT(elva_sale_new.send_client_date,'%d.%m.%Y'),'') AS `send_client_date`,
        				elva_sale_new.callceenter_comment,
        				department.`name`,
        				prod_cat.`name` as `prod_cat_name`,
        				IF(sale_details.department_id = 21, IF(elva_status.`name` = 'გაუქმებული',0,SUM(sale_details.price * sale_details.quantity)),IF(sale_details.department_id = 25, IF(status_p_P.`name` = 'გაუქმებული',0,SUM(sale_details.price * sale_details.quantity)),'')) AS `price`,
        				persons.`name` as operator_id,
        				IF(sale_details.department_id = 21,elva_status.`name`,'') as status_name,
						IF(sale_details.department_id = 21,elva_sale_new.coordinator_id,''),
						IF(sale_details.department_id = 21,elva_sale_new.coordinator_comment,''),
						IF(sale_details.department_id = 21,elva_sale_new.elva_status,''),
						IF(sale_details.department_id = 25,status_p_P.`name`,'') as status_name_p,
						IF(sale_details.department_id = 25,elva_sale_new.coordinator_id_p,''),
						IF(sale_details.department_id = 25,elva_sale_new.coordinator_comment_p,''),
						IF(sale_details.department_id = 25,elva_sale_new.elva_status_p,''),
                        elva_sale_new.cancel_comment,
                        IF(sale_details.department_id = 21,elva_monitor.name,elva_monitor1.name),
        				CONCAT('<button class=\"myact ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" onclick=\"openmyact(\'',elva_sale_new.task_id,'\',\'',elva_sale_new.custom_prod,'\',\'',elva_sale_new.id,'\',\'0\')\"><span class=\"ui-button-text\">აქტი</span></button>') as `button`
        FROM `elva_sale_new`
        JOIN users ON elva_sale_new.operator_id = users.id
        JOIN elva_status ON elva_sale_new.`status` = elva_status.id
        JOIN elva_status as status_p_P ON elva_sale_new.`status_p` = status_p_P.id
        JOIN persons ON users.person_id = persons.id
        left JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
        JOIN city ON elva_sale_new.city_id = city.id
        left JOIN department ON sale_details.department_id = department.id
        LEFT JOIN prod_cat ON elva_sale_new.prod_cat = prod_cat.id
        LEFT JOIN elva_monitor ON elva_sale_new.`monitor` = elva_monitor.id
        LEFT JOIN elva_monitor as `elva_monitor1` ON elva_sale_new.`monitor1` = elva_monitor1.id
        WHERE 			DATE(elva_sale_new.$date_type) >= '$start' AND DATE(elva_sale_new.$date_type) <= '$end'  $chash_id  $check_dep $user_query_filter
        GROUP BY elva_sale_new.id, sale_details.department_id");
        $data = array(
            "aaData"	=> array()
        );
	    while ($aRow = mysql_fetch_array( $rResult )){
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            if($aRow[8] == 'პალიტრა L'){
	                $num = 1;
	            }else{
	                $num = 2;
	            }
	            /* General output */
	            $row[] = $aRow[$i];
	            if($i == ($count-2)){
	                $row[] = '<input type="checkbox" name="check_' . $aRow[0] . '" class="check'.$_REQUEST[tab_num].'" value="' . $aRow[0] . '" dep="'.$num.'" />';
	            }
	        }
	        	
	        $data['aaData'][] = $row;
	    }

		break;
	case 'disable' :
	    $id		 = $_REQUEST['id'];
	    $user_id = $_SESSION['USERID'];
        $dep     = $_REQUEST['dep'];
        $dep_num = mysql_num_rows(mysql_query(" SELECT 	elva_sale_new.id
                                    FROM `elva_sale_new`
                                    left JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                    WHERE 			elva_sale_new.id = $id
                                    GROUP BY sale_details.department_id"));
        if($dep==2){
            $dep_id = 21;
            mysql_query("UPDATE `elva_sale_new` SET `user_id`='$user_id',
                                                `status`='',
                        						`coordinator_id`='',
                        						`coordinator_comment`='',
                        						`elva_status`=''
                         WHERE `id`='$id';");
        }else{
            $dep_id = 25;
            mysql_query("UPDATE `elva_sale_new` SET `user_id`='$user_id',
                                                `status_p`='',
                                                `coordinator_id_p`='',
                                                `coordinator_comment_p`='',
                                                `elva_status_p`=''
                         WHERE `id`='$id';");
        }
 	    
	    $res = mysql_query("SELECT sale_details.id
                            FROM `elva_sale_new`
                            left JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                            WHERE 			elva_sale_new.id = $id AND sale_details.department_id = $dep_id");
	    while ($req = mysql_fetch_array($res)) {
	        mysql_query("UPDATE `sale_details` SET `actived`='0' WHERE (`id`='$req[0]');");
	    }
	    
	    if($dep_num == 1){
	    mysql_query("DELETE FROM elva_sale_new
                     WHERE id = '$id'");
	    }

		break;
	case 'get_my_prod_gif' :
        $count = 		$_REQUEST['count'];
	    $hidden = 		$_REQUEST['hidden'];
	    if($_REQUEST[my_dep] == ''){
	        $my_dep = "";
	    }else{
	        $my_dep = "AND department.`name` = '$_REQUEST[my_dep]'";
	    }
	    $sale_detail_ids='';
	    $rResult_all = mysql_query(	"SELECT  `sale_details`.`id`
                                     FROM    `elva_sale_new`
    	                             JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id)
                                     JOIN production ON sale_details.production_id = production.id
                                     JOIN department ON sale_details.department_id = department.id
	                                 WHERE  elva_sale_new.id='$_REQUEST[id]' $my_dep");

	    while ($rr_all = mysql_fetch_array($rResult_all)) {
	        $sale_detail_ids .= $rr_all[0].',';
	    }
	    $sale_detail_ids .= 0;	    
	    $rResult = mysql_query("    SELECT  sale_details_log.id,
	                                        event_date,
                        					IF(event_type=1,'დაამატა',IF(actived_old=0 or actived_new=0,'წაიშალა',IF(event_type=2, 'შეცვალა', ''))),
                        					old_pers.`name`,
                        					persons.`name`,
                        					old_prod.`name`,
                        					production.`name`,
                        					quantity_old,
                        					quantity_new,
                        					price_old,
                        					price_new,
                                	        quantity_old * price_old,
                                	        quantity_new *price_new			
                                    FROM    `sale_details_log`
                                    LEFT JOIN users ON users.id = sale_details_log.user_id_new
                                    LEFT JOIN users AS old_user ON old_user.id = sale_details_log.user_id_old
                                    LEFT JOIN persons ON persons.id = users.person_id
                                    LEFT JOIN persons AS old_pers ON old_pers.id = old_user.person_id
                                    LEFT JOIN production ON sale_details_log.production_id_new = production.id
                                    LEFT JOIN production AS old_prod ON sale_details_log.production_id_old = old_prod.id
                            	    WHERE sale_details_log.sale_details_id in($sale_detail_ids)");
	    
	    $data = array(
	        "aaData"	=> array()
	    );
	    while ($aRow = mysql_fetch_array( $rResult )){
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            /* General output */
	            $row[] = $aRow[$i];
	    
	        }	    
	        $data['aaData'][] = $row;
	    }
	    break;	
		
	case 'send_book' :
	    $id		= $_REQUEST['id'];
	    $dep	= $_REQUEST['dep'];
	    if($dep == 2){
	        mysql_query("UPDATE `elva_sale_new` SET `main_status`='1' WHERE (`id`='$id');");
	    }elseif($dep == 1){
	        mysql_query("UPDATE `elva_sale_new` SET `main_status1`='1' WHERE (`id`='$id');");
	    }
	    
	    break;
	case 'save_prod' :
	    $data = array(
	        "hint"	=> array()
	    );
	    $user_id = $_SESSION['USERID'];
	    $prod_id = $_REQUEST[prod_id];
	    $rr = mysql_fetch_array(mysql_query("SELECT elva_sale_new.task_id
                                	         FROM   elva_sale_new
                                	         JOIN   task_scenar ON elva_sale_new.task_id = task_scenar.task_detail_id
                                	         WHERE  elva_sale_new.id = $_REQUEST[elva_id]"));
	    
	    $product = mysql_fetch_array(mysql_query("  SELECT 	`production_category_id`,
                                            				`price`
                                                    FROM 	`production`
                                                    WHERE	`id` = $_REQUEST[prod_id]"));
	    
	    $no_dubl = mysql_query("SELECT 		`sale_details`.`production_id`
                                FROM 		`elva_sale_new`
                                JOIN 		`sale_details` ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                WHERE 		`elva_sale_new`.`id` = $_REQUEST[elva_id]");
	    $update = 0;
	    while ($no_dubl_req = mysql_fetch_array($no_dubl)) {
	        if($prod_id == $no_dubl_req[0]){
	            $update = 1;
	        }
	    }

	    if($rr[0] == '0'){
	        $sale_detail_id = "elva_sale_id = $_REQUEST[elva_id]";
	        $sale_detail_id_add_e = $_REQUEST[elva_id];
	        $sale_detail_id_add = 1;
	    }else{
	        $sale_detail_id = "task_scenar_id = $rr[0]";
	        $sale_detail_id_add = $rr[0];
	        $sale_detail_id_add_e = 1;
	    }
	    
	    if($_REQUEST[change] == ''){
	        if($update == 0){
	        mysql_query("INSERT INTO `sale_details` 
                        (`user_id`, `elva_sale_id`, `task_scenar_id`, `production_id`, `department_id`, `quantity`, `price`)
                        VALUES
                        ('$user_id', '$sale_detail_id_add_e', '$sale_detail_id_add', '$_REQUEST[prod_id]', '$product[0]', '$_REQUEST[prod_count]', '$product[1]' );");
	            $data['hint'][] = 0;
	        }else{	            
	            $data['hint'][] = 'ესეთი პროდუქტი უკვე დამატებულია, თუ გსურთ შეცვალეთ რაოდენობა!';
	        }	    
	    }else{
	        mysql_query("UPDATE `sale_details` SET
                	            `user_id`='$user_id',
                	            `production_id`='$_REQUEST[prod_id]',
                	            `department_id`='$product[0]',
                	            `quantity`='$_REQUEST[prod_count]',
                	            `price`='$product[1]'
        	             WHERE $sale_detail_id AND production_id = $_REQUEST[change]");
	    }
	    //return $data;
	    break;
	case 'get_add_page':
	    $page = pagee();
	    $data		= array('page'	=> $page);
	    
	    break;
	case 'get_add_pagee':
	    if($_REQUEST['prod_id'] != ''){
	        $my = mysql_fetch_array(mysql_query("SELECT sale_details.production_id,production.`name`,sale_details.quantity
                                                FROM `elva_sale_new`
                                                JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                                JOIN production ON sale_details.production_id = production.id
                                                WHERE elva_sale_new.id = $_REQUEST[elva_id] AND sale_details.production_id = $_REQUEST[prod_id]"));
	    }
	    $page = pageee($my);
	    $data		= array('page'	=> $page);
	         
	    break;
	case 'get_edit_page' :
	    $page = pagee();
	    $data		= array('page'	=> $page);

	    break;
	case 'get_my_prod' :
	    $count = 		$_REQUEST['count'];
	    $hidden = 		$_REQUEST['hidden'];
	    if($_REQUEST[my_dep] == ''){
	        $my_dep = "";
	    }else{
	        $my_dep = "AND department.`name` = '$_REQUEST[my_dep]'";
	    }
	    $rResult = mysql_query(	"SELECT production.id,
                                        production.unicid,
                                        elva_sale_new.call_date,
                                        elva_sale_new.name_surname,
                                        production.`name`,
                                        sale_details.quantity,
                                        sale_details.price,
                                        (sale_details.price * sale_details.quantity) AS `total`,
                                        department.`name`,
	                                    sale_details.id
                                 FROM    `elva_sale_new`
	                             JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                 JOIN production ON sale_details.production_id = production.id
                                 JOIN department ON sale_details.department_id = department.id
	                             WHERE  elva_sale_new.id='$_REQUEST[id]' $my_dep");
	    
	    $data = array(
	        "aaData"	=> array()
	    );
	    while ($aRow = mysql_fetch_array( $rResult )){
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            /* General output */
	            $row[] = $aRow[$i];
	            if($i == ($count-2)){
	                $row[] = '<input type="checkbox" name="check_' . $aRow[9] . '" class="check" value="' . $aRow[9] . '" />';
	            }
	    
	        }	    
	        $data['aaData'][] = $row;
	    }
	    
	    break;
	case 'disable_prod':
	    
        mysql_query("UPDATE `sale_details` SET `actived`='0' WHERE (`id`='$_REQUEST[id]');");

	    break;
   	case 'save_dialog' :
   		
   	    
   		$per_id = mysql_fetch_row(mysql_query("	SELECT id
										   		FROM shipping
										   		WHERE `name` = '$_REQUEST[period]'"));

   		if($_REQUEST[id] != ''){
   		  $book = addslashes($_REQUEST[book]);
   		  if($_REQUEST[main_status] != ''){
   		      $main_s  = "`main_status`           ='$_REQUEST[main_status]'";
   		      $monitor = "`monitor`               ='$_REQUEST[monitor]',";
   		      
   		  }else{
   		      $main_s  = "`main_status1`          ='$_REQUEST[main_status1]'";
   		      $monitor = "`monitor1`               ='$_REQUEST[monitor1]',";
   		  }
   		  $user_id = $_SESSION['USERID'];
		  mysql_query("UPDATE   `elva_sale_new` SET 
		                        `user_id`               ='$user_id',
    							`status`				='$_REQUEST[status]', 
    							`oder_send_date`		='$_REQUEST[oder_date]', 
    							`coordinator_id`		='$_REQUEST[cooradinator]', 
    							`coordinator_comment`	='$_REQUEST[k_coment]', 
    							`elva_status`			='$_REQUEST[elva]',
    							`status_p`				='$_REQUEST[status_p]', 
    							`oder_send_date_p`		='$_REQUEST[oder_date_p]', 
    							`coordinator_id_p`		='$_REQUEST[cooradinator_p]', 
    							`coordinator_comment_p`	='$_REQUEST[k_coment_p]', 
    							`elva_status_p`			='$_REQUEST[elva_p]',
    							`person_id`				='$_REQUEST[person_id]', 
    							`name_surname`			='$_REQUEST[name_surname]', 
    							`mail`					='$_REQUEST[mail]', 
    							`address`				='$_REQUEST[addres]', 
    							`phone`					='$_REQUEST[phone]', 
    							`phone1`				='$_REQUEST[phone1]', 
    							`period`				='$_REQUEST[period]',    							
    							`call_date`				='$_REQUEST[date]', 
    							`sum_price`				='$_REQUEST[sum_price]', 
    							`callceenter_comment`	='$_REQUEST[c_coment]',
    							`send_date`				='$_REQUEST[send_date]', 
    							`cancel_comment`	    ='$_REQUEST[cancel_comment]', 
    							`street_done`			='$_REQUEST[street_done]', 
    							`cash`	                ='$_REQUEST[cash_id]',
    							`city_id`               ='$_REQUEST[city_id]',
    							`send_client_date`      ='$_REQUEST[send_client_date]',
    							`prod_cat`              ='$_REQUEST[prod_cat]',
    							$monitor $main_s
    					WHERE (`id`='$_REQUEST[id]')");
   	    }else{
   	        mysql_query("INSERT INTO `elva_sale_new` 
                        (`person_id`, `name_surname`, `mail`, `address`, `phone`, `phone1`, `period`, `books`, `call_date`, `sum_price`, `callceenter_comment`, `operator_id`, `oder_send_date`, `status`, `coordinator_id`, `coordinator_comment`, `elva_status`, `task_id`, `send_date`, `cancel_comment`, `cash`, `street_done`,`custom_prod`,`city_id`,`send_client_date`,`prod_cat`,`status_p`,`oder_send_date_p`,`coordinator_id_p`,`coordinator_comment_p`,`elva_status_p`,`main_status`,`main_status1`,`monitor`,`monitor1`)
                        VALUES
                        ('$_REQUEST[person_id]', '$_REQUEST[name_surname]', '$_REQUEST[mail]', '$_REQUEST[addres]', '$_REQUEST[phone]', '$_REQUEST[phone1]', '$_REQUEST[period]', '', '$_REQUEST[date]', '$_REQUEST[sum_price]', '$_REQUEST[c_coment]', '$_SESSION[USERID]', '$_REQUEST[oder_date]', '$_REQUEST[status]', '$_REQUEST[cooradinator]', '$_REQUEST[k_coment]', '$_REQUEST[elva]', '', '$_REQUEST[send_date]', '$_REQUEST[cancel_comment]', '$_REQUEST[cash_id]', '$_REQUEST[street_done]', '', '$_REQUEST[city_id]', '$_REQUEST[send_client_date]', '$_REQUEST[prod_cat]','$_REQUEST[status_p]','$_REQUEST[oder_date_p]','$_REQUEST[cooradinator_p]','$_REQUEST[k_coment_p]','$_REQUEST[elva_p]','$_REQUEST[main_status]','$_REQUEST[main_status1]','$_REQUEST[monitor]','$_REQUEST[monitor1]')");
   	        $rr = mysql_fetch_array(mysql_query("   SELECT id
                                                    FROM `elva_sale_new`
                                                    ORDER BY id DESC
                                                    LIMIT 1"));
   	        $data[id] = $rr[0];
   	    }
   		break;
   	case 'add_rs' :
   	    $rp = mysql_fetch_array(mysql_query("SELECT id,count FROM elva_rs WHERE elva_id = '$_REQUEST[counter_rs]'"));
   	    $count_up = $rp[1] + 1;
   	    if($rp == ''){
   	        mysql_query("INSERT INTO `elva_rs` (`elva_id`, `head`, `footer`) VALUES ('$_REQUEST[counter_rs]', '$_REQUEST[theacte]', '$_REQUEST[theactee]');");
   	    }else{
   	        mysql_query("UPDATE `elva_rs` SET `count`='$count_up' WHERE (`elva_id`='$_REQUEST[counter_rs]');");
   	    }
   	    break;
    case 'choose_dep' :
        
        $query11 = mysql_query("SELECT elva_sale_new.id,elva_sale_new.task_id,department.`name`,sale_details.department_id
                                FROM `elva_sale_new`
                                JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                JOIN department ON sale_details.department_id = department.id
                                WHERE elva_sale_new.id = $_REQUEST[sale_id]
                                GROUP BY elva_sale_new.id, sale_details.department_id");

        $page = '<select id="myfirstdep" style="width: 100%; margin-top: 13px;"><option value="0">----</option>';
        while ($myqu = mysql_fetch_assoc($query11)) {
            $page .= '<option value="'.$myqu['department_id'].'">' . $myqu['name'] . '</option>';
        }
        
        $page .= '</select>
            <input id="task_id" type="hidden" value="'.$_REQUEST[task_id].'">
            <input id="custom_prod" type="hidden" value="'.$_REQUEST[custom_prod].'">
            <input id="sale_id" type="hidden" value="'.$_REQUEST[sale_id].'">';
        $data		= array('page'	=> $page);
        break;
   	case 'product_list' :
   	    $user		= $_SESSION['USERID'];
   	    $c_date		= date('Y-m-d H:i:s');
   	    $rResult_all = mysql_query(	"SELECT  `sale_details`.`id`
                           	        FROM    `elva_sale_new`
                           	        JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id)
                           	        WHERE  elva_sale_new.id='$_REQUEST[sale_id]' AND sale_details.department_id = '$_REQUEST[choose_dep]'");
   	    
   	    while ($rr_all = mysql_fetch_array($rResult_all)) {
   	        $sale_detail_ids .= $rr_all[0].',';
   	    }
   	    $sale_detail_ids .= 0;
   	    $editor = mysql_fetch_array(mysql_query("   SELECT  event_date,
                                   	                        sale_details_log.user_id_new
                                           	        FROM    `sale_details_log`
                                                	WHERE   sale_details_log.sale_details_id in($sale_detail_ids)"));
   	    
   	    $elva_rs = mysql_fetch_assoc(mysql_query("SELECT head,footer,count as mycount FROM `elva_rs` WHERE elva_id = '$_REQUEST[sale_id]'"));
   	    $elva_sale_new = mysql_fetch_assoc(mysql_query("SELECT name_surname,person_id,address,phone,phone1,DATE_FORMAT(DATE(send_client_date),'%d.%m.%Y') as `c_date` FROM `elva_sale_new` WHERE id = '$_REQUEST[sale_id]'"));
   	    $counter_rs = mysql_num_rows(mysql_query("SELECT id FROM `elva_rs` WHERE elva_id"));
        $date = date("d.m.Y");
        if($elva_sale_new[phone] != '' && $elva_sale_new[phone1] != ''){
            $phone = $elva_sale_new[phone].'/'.$elva_sale_new[phone1];
        }else{
            if($elva_sale_new[phone] != ''){
                $phone = $elva_sale_new[phone];
            }else{
                $phone = $elva_sale_new[phone1];
            }
        }
        $counter_rs = $counter_rs+1;
        $head = '<textarea style="width: 100%; height: 180px;" id="theacte">';
        $footer = '<textarea style="width: 100%; height: 370px;" id="theactee">';
   	    
   	        $rs = mysql_fetch_assoc(mysql_query("SELECT head,footer FROM `rs`"));
       	    $head   .= $rs[head];
       	    $footer .= $rs[footer];
       	    $head = str_replace("aqvar", $user."/".$c_date."/".$editor[1]."/".$editor[0]."/".$elva_rs[mycount], $head);
       	    $head = str_replace("თარიღი", $elva_sale_new[c_date], $head);
       	    $head = str_replace("სახელი გვარი", $elva_sale_new[name_surname], $head);
   	        $head = str_replace("პირადი ნომერი", $elva_sale_new[person_id], $head);
   	        $head = str_replace("მიღება-ჩაბარების აქტი #", "მიღება-ჩაბარების აქტი #$counter_rs", $head);
   	        
   	        $footer = str_replace("თარიღი", $elva_sale_new[c_date], $footer);
   	        $footer = str_replace("სახელი გვარი", $elva_sale_new[name_surname], $footer);
   	        $footer = str_replace("პირადი ნომერი", $elva_sale_new[person_id], $footer);
   	        $footer = str_replace("ტელეფონი/ტელეფონები", $phone, $footer);
   	        $footer = str_replace("მისამართი", $elva_sale_new[address], $footer);
   	    
   	    
   	    $head .= '</textarea>';
   	    $footer .= '</textarea><input id="counter_rs" type="hidden" value="'.$_REQUEST[sale_id].'">';
   	    $page .= $head;
   	    $page .= '<div id="gela"><table style="border-collapse: collapse; border:0; width: 100%;" id="product_list">
               	    <tr>
                   	    <th style="padding:5px; border:1px solid #111;">#</th>
                   	    <th style="border:1px solid #111; padding:5px;">წიგნები</th>
                   	    <th style="border:1px solid #111; padding:5px;">რაოდენობა</th>
   	                    <th style="border:1px solid #111; padding:5px;">ფასი</th>
   	                    <th style="border:1px solid #111; padding:5px;">სულ ფასი</th>
               	    </tr>';

        $rResult = mysql_query("SELECT 
                                        production.`name`,
                                        sale_details.quantity,
                                        sale_details.price,
                                        (sale_details.price * sale_details.quantity) AS `total`
                                 FROM    `elva_sale_new`
	                             JOIN sale_details ON (elva_sale_new.task_id = sale_details.task_scenar_id OR elva_sale_new.id = sale_details.elva_sale_id) AND sale_details.actived = 1
                                 JOIN production ON sale_details.production_id = production.id
                                 JOIN department ON sale_details.department_id = department.id
	                             WHERE  elva_sale_new.id='$_REQUEST[sale_id]' AND department.`id` = '$_REQUEST[choose_dep]'");
        $i=1;
        while ($row_prod1 = mysql_fetch_assoc($rResult)) {
            
            $page .= '<tr>
                         <td style="border:1px solid #111; padding:1px; text-align: center;">'.$i++.'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: center;">'.$row_prod1[name].'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: center;">'.$row_prod1[quantity].'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: right;">'.$row_prod1[price].'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: right;">'.$row_prod1[total].'</td>
       	             </tr>
   	                 ';
            $total += $row_prod1[total];
        }
            $page .= '<tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right;">ჯამი:</td>
                        <td style="text-align: right;">'.number_format($total, 2, '.', '').'</td>
                      </tr></table></div>';
        $page .= $footer;
        $data		= array('page'	=> $page);
            
   	    break;
   	
	default:
		$error = 'Action is Null';
}

function getpersgrup($user_id){
    $data = mysql_fetch_array(mysql_query("SELECT group_id FROM `users` WHERE id = $user_id"));
    return $data[0];
}

function GetPeriod($id){
        $per_id = mysql_query("	SELECT id,name
        								FROM shipping
        								WHERE actived = 1");
        $data .= '<option value="0">---</option>';
        while( $ress = mysql_fetch_assoc($per_id)){
            if($ress['id'] == $id){
                $data .= '<option value="' . $ress['id'] . '" selected="selected">' . $ress['name'] . '</option>';
            } else {
                $data .= '<option value="' . $ress['id'] . '">' . $ress['name'] . '</option>';
            }
        }
        return $data;
}
function GetCat($id){
    $per_id = mysql_query("	SELECT id,name
							FROM prod_cat
							WHERE actived = 1");
    $data .= '<option value="0">---</option>';
    while( $ress = mysql_fetch_assoc($per_id)){
        if($ress['id'] == $id){
            $data .= '<option value="' . $ress['id'] . '" selected="selected">' . $ress['name'] . '</option>';
        } else {
            $data .= '<option value="' . $ress['id'] . '">' . $ress['name'] . '</option>';
        }
    }
    return $data;
}
function Getstatus($id){
    $per_id = mysql_query("	SELECT id,name
        					FROM elva_status
        					WHERE actived = 1");
    $data .= '<option value="0">---</option>';
    while( $ress = mysql_fetch_assoc($per_id)){
        if($ress['id'] == $id){
            $data .= '<option value="' . $ress['id'] . '" selected="selected">' . $ress['name'] . '</option>';
        } else {
            $data .= '<option value="' . $ress['id'] . '">' . $ress['name'] . '</option>';
        }
    }
    return $data;
}

function GetRecordingsSection($res)
{
    $phone = '';
    if($res['phone'] != '' && strlen($res['phone']) > 3){
        $phone_t = "`dst` LIKE '%$res[phone]%'";
    }else{
        $phone_t = "`dst` LIKE '%fmyjeans%'";
    }
    if($res['phone1'] != '' && strlen($res['phone1']) > 3) {
        $phone_o = "or `dst` LIKE '%$res[phone1]%'";
    }else{
        $phone_o = "";
    }

    $req = mysql_query("SELECT  `calldate` AS 'time',
                                SUBSTR(`userfield`, 7) as userfield
                        FROM    `cdr`
                        WHERE   (`src` in('100','101','250','150','200','201','300','301','302','303','304','305','306','400','401','402','500') && ($phone_t $phone_o))");

    $data .= '
        <fieldset style="width: 98%;">
            <legend>ჩანაწერები</legend>

            <table style="width: 65%; border: solid 1px #85b1de; margin:auto;">
                <tr style="border-bottom: solid 1px #85b1de; height: 20px;">
                    <th style="padding-left: 10px;">დრო</th>
                    <th  style="border: solid 1px #85b1de; padding-left: 10px;">ჩანაწერი</th>
                </tr>';
    if (mysql_num_rows($req) == 0){
        $data .= '<td colspan="2" style="height: 20px; text-align: center;">ჩანაწერები ვერ მოიძებნა</td>';
    }

    while( $res2 = mysql_fetch_assoc($req)){
        $link = $res2['userfield'];
        $data .= '
                <tr style="border-bottom: solid 1px #85b1de; height: 20px;">
                    <td style="vertical-align: middle; text-align: center;">' . $res2['time'] . '</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <audio controls>
  <source src="http://109.234.117.182:8181/records/'.$link.'" type="audio/mpeg">
Your browser does not support the audio element.
</audio>
                        </td>
                </tr>';
    }

    $data .= '
            </table>
        </fieldset>';

    return $data;
}

function pagee(){
    $disabled = '';
    $other_disabled = '';
    $user		= $_SESSION['USERID'];
    
    $chek_gr = mysql_fetch_row(mysql_query("SELECT `group_id` FROM `users` WHERE `id` = '$user'; "));
    
    if($chek_gr[0] == 5){
        $disabled = '';
    }else{
        $disabled = 'disabled';
    }
    
    if($chek_gr[0] != 5){
        $other_disabled = '';
    }else{
        $other_disabled = 'disabled';
    }
    
    if($user == 34 || $user == 1 || $user == 3 || $user == 35 || $user == 13){
        $disable_status = '';
    }else{
        $disable_status = 'disabled';
    }
    
    $rResult = mysql_query("SELECT  elva_sale_new.id,
                                    elva_sale_new.person_id,
                                    elva_sale_new.name_surname,
                                    elva_sale_new.mail,
                                    elva_sale_new.address,
                                    elva_sale_new.phone,
                                    elva_sale_new.phone1,
                                    shipping.`name` AS `period`,
                                    elva_sale_new.books,
                                    elva_sale_new.call_date,
                                    IF(elva_sale_new.`status` = 1, 0 , elva_sale_new.sum_price) as sum_price,
                                    elva_sale_new.callceenter_comment,
                                    persons.`name` as operator_id,
                                    elva_sale_new.oder_send_date,
                                    elva_sale_new.`status`,
                                    elva_sale_new.coordinator_id,
                                    elva_sale_new.coordinator_comment,
                                    elva_sale_new.task_id,
                                    elva_sale_new.elva_status,
                                    elva_sale_new.period AS `period_id`,
                                    elva_sale_new.send_date,
                                    elva_sale_new.cancel_comment,
                                    elva_sale_new.cash,
                                    elva_sale_new.street_done,
                                    elva_sale_new.city_id,
                                    elva_sale_new.custom_prod,
                                    elva_sale_new.send_client_date,
                                    elva_sale_new.prod_cat,
                                    `status_p`,
                                    `oder_send_date_p`,
                                    `coordinator_id_p`,
                                    `coordinator_comment_p`,
                                    `elva_status_p`,
                                    elva_sale_new.main_status,
                                    elva_sale_new.main_status1,
                                    elva_sale_new.monitor,
                                    elva_sale_new.monitor1
                            FROM    `elva_sale_new`
                            left JOIN shipping ON elva_sale_new.period = shipping.id
                            JOIN users ON elva_sale_new.operator_id = users.id
                            JOIN persons ON users.person_id = persons.id
                            WHERE elva_sale_new.id='$_REQUEST[id]'");
    $res = mysql_fetch_array( $rResult );
    $data['page'][0] = '';
    $data['page'][0] .= '<div id="tabs" style="width: 99%; margin: 0 auto; min-height: 785px;">
                    		<ul>
                    			<li><a href="#tab-0">ძირითადი ინფორმაცია</a></li>
                    			<li><a href="#tab-1">გაყიდვა</a></li>
                    			<li><a href="#tab-2">საუბრის ჩანაწერები</a></li>
                    		</ul>
                    		<div id="tab-0">
                            <div id="dialog-form">
								<div style="float: left; width: 100%;" disabled>
								<fieldset >
                                    <input type="hidden" id="custom_prod" value="'.$res[custom_prod].'" />
							    	<legend>ძირითადი ინფორმაცია</legend>
									<fieldset >
							    	<table class="dialog-form-table">
										<tr>
											<td style="width: 280px;"><label for="">პირადი №</label></td>
											<td style="width: 280px;"><label for="">სახელი გვარი</label></td>
											<td style="width: 280px;"><label for="">მეილი</label></td>
                                            <td style="width: 280px;"><label for="">ტელეფონი 1</label></td>
										</tr>
										<tr>
											<td><input id="person_id" 	 class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[person_id]. 	'" /></td>
											<td><input id="name_surname" class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[name_surname].'" /></td>
											<td><input id="mail" 		 class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[mail].       	'" /></td>
										    <td><input id="phone" class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[phone].'" /></td>
										</tr>
										<tr>
											<td style="width: 280px;"><label for="">ტელეფონი 2</label></td>
										    <td style=""><label for="">ქალაქი / რეგიონი</label></td>
											<td style=""><label for="">მისმართი</label></td>
										    <td><label for="">მისამართის დაზუსტება</label></td>
										</tr>
										<tr>
											<td><input id="phone1" class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[phone1].'" /></td>

											<td>
											    <select style="width: 206px;"  id="city_id" class="idls object" '.$other_disabled.'>'.GetCity($res['city_id']).'</select>
                                            </td>
											        
											<td><input id="addres" class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[address].'" /></td>
										    <td><input id="street_done" class="idle" style="width: 200px;" '.$other_disabled.' type="text" value="'.$res[street_done].'" /></td>
										</tr>
									</table>
								</fieldset >
									<fieldset style="margin-top: 5px;">
							    		<legend>დავალების ტიპი</legend>
											<table class="dialog-form-table" >
											<tr>
												<td style="width: 254px;"><label for="period">პერიოდი</label></td>
												<td style="width: 254px;"><label for="date">ქოლ-ცენტრის დარეკვის თარიღი</label></td>
											    <td style="width: 254px;"><label for="op_id">ოპერატორი</label></td>
											    <td style="width: 190px;"><label>გადასახდელი თანხა</label></td>
											</tr>
								    		<tr>
												<td>
											    <select style="width: 206px;"  id="period" class="idls object" '.$other_disabled.'>'.GetPeriod($res['period_id']).'</select>
												</td>
												<td><input style="width: 200px;" id="date" 		value="'.$res[call_date].'" 		class="idls object" '.$other_disabled.'></td>
											    <td><input style="width: 200px;" id="op_id" 	value="'.$res[operator_id].'" 		class="idls object" disabled></td>
											    <td><input style="width: 201px;" id="sum_price" value="'.$res[sum_price].  '" class="idls object" '.$other_disabled.'></td>
                                            </tr>
											
											</table>
											<table class="dialog-form-table" >
											<tr>
												<td style="width: 510px;"><label>ქოლცენტრის კომენტარი</label></td>
											    <td style="width: 270px;"><label>გაუქმების მიზეზი</label></td>
											</tr>
											<tr>
												<td><textarea  style="width: 456px; height:50px; resize: vertical;" id="c_coment" class="idle" name="content" cols="300" '.$other_disabled.'>'.$res[callceenter_comment].'</textarea>
										        <td><textarea  style="width: 503px; height:50px; resize: vertical;" id="cancel_comment" class="idle" cols="300" '.$other_disabled.'>'.$res[cancel_comment].'</textarea>
											</tr>
											<tr>
												<td style="width: 270px;"><label>გაგზავნის თარიღი</label>
										        <label style="margin-left: 130px;">მიტანის სასურველი დრო</label></td>
										        <td style="width: 270px;"><label>ნაღდი და უნაღდო</label>
										        <label style="margin-left: 133px;">პროდუქტის სახეობა</label></td>
											</tr>
										    <tr>
												<td><input style="width: 200px; float: left;" id="send_date" value="'.$res[send_date].  '" class="idls object" '.$other_disabled.'>
											    <input style="width: 200px;float: left; margin-left: 50px;" id="send_client_date" value="'.$res[send_client_date].  '" class="idls object" '.$other_disabled.'></td>
											    <td><div style="float:left; margin-right: 89px;">
												    <input style="float:left;" type="radio" class="cash_id" name="cash" value="1" '.$other_disabled.' '.(($res[cash]==1)?'checked':"").' ><label style="float:left;margin:8px 15px 0 0;">ნაღდი</label>
												    <input style="float:left;" type="radio" class="cash_id" name="cash" value="2" '.$other_disabled.' '.(($res[cash]==2)?'checked':"").' ><label style="float:left;margin:8px 15px 0 0;">უნაღდო</label></div>
												    <select style="width: 206px; float: left;"  id="prod_cat" class="idls object" '.$other_disabled.'>'.GetCat($res['prod_cat']).'</select>
												</td>
											</tr>
										</table>
								        <table class="dialog-form-table">
											<tr>
												<td style="width: 270px;"><label>მთავარი სტატუსი</label>
											</tr>
											<tr>
												<td>
												        '.(($_REQUEST['dep_now']=='ელვა.ჯი')?'<select style="width: 206px;"  id="main_status" class="idls object" '.$other_disabled.'>'.GetMainStatus($res['main_status']).'</select>':'<select style="width: 206px;"  id="main_status1" class="idls object" '.$other_disabled.'>'.GetMainStatus($res['main_status1']).'</select>').'

												</td>
												<td>
												        '.(($_REQUEST['dep_now']=='ელვა.ჯი')?'<select style="width: 206px;"  id="monitor" class="idls object" '.$other_disabled.'>'.GetMonitoring($res['monitor']).'</select>':'<select style="width: 206px;"  id="monitor1" class="idls object" '.$other_disabled.'>'.GetMonitoring($res['monitor1']).'</select>').'
												</td>
											</tr>
								        </table>
									</fieldset>
								<fieldset style="margin-top: 5px; '.(($_REQUEST['dep_now']=='პალიტრა L')?'display:none;':'').' ">
								    	<legend>ელვა.ჯი</legend>
								    	<table class="dialog-form-table" >
											<tr>
												<td style="width: 280px;"><label for="status">სტატუსი</label></td>
												<td style="width: 280px;"><label for="cooradinator">კოორდინატორი</label></td>
												<td style="width: 280px;"><label for="elva">ნინო (ელვა)</label></td>
												        <td style="width: 280px;"><label for="oder_date">ქვითრის გაგზავნის დღე</label></td>
											</tr>
								    		<tr>
												<td>
											    <select style="width: 206px;"  id="status" class="idls object"  >'.Getstatus($res['status']).'</select>
												</td>
												<td><select style="width: 206px;"  id="cooradinator" class="idls object" '.$disabled.'>'.GetCordin($res['coordinator_id']).'</select></td>
												<td><input style="width: 200px;" id="elva"          value="'.$res[elva_status].'" 		class="idls object" '.$disabled.'></td>
											    <td><input style="width: 200px;" id="oder_date" value="'.(($res['oder_send_date']!='')?$res['oder_send_date']:'').'" 	class="idls object" '.$disabled.'></td>
											
											</tr>
											</table>
											<table class="dialog-form-table" style="width: 720px;">
											<tr>
												<td style="width: 520px;"><label>კოოდინატორის შენიშვნა</label></td>
											</tr>
											<tr>
												<td>
													<textarea  style="width: 1015px; resize: vertical; height:80px;" id="k_coment" class="idle" name="content" cols="300" '.$disabled.'>'.$res[coordinator_comment].'</textarea>
												</td>
											</tr>
										</table>
							    </fieldset>
								<fieldset style="margin-top: 5px; '.(($_REQUEST['dep_now']=='ელვა.ჯი')?'display:none;':'').'">
								    	<legend>პალიტრა</legend>
								    	<table class="dialog-form-table" >
											<tr>
												<td style="width: 280px;"><label for="status">სტატუსი</label></td>
												<td style="width: 280px;"><label for="cooradinator">კოორდინატორი</label></td>
												<td style="width: 280px;"><label for="elva">თანხის მოტანის თარიღი</label></td>
												        <td style="width: 280px;"><label for="oder_date">ქვითრის გაგზავნის დღე</label></td>
											</tr>
								    		<tr>
												<td>
											    <select style="width: 206px;"  id="status_p" class="idls object" '.$other_disabled.' >'.Getstatus($res['status_p']).'</select>
												</td>
												<td><select style="width: 206px;"  id="cooradinator_p" class="idls object" '.$other_disabled.'>'.GetCordin($res['coordinator_id_p']).'</select></td>
												<td><input style="width: 200px;" id="elva_p"          value="'.$res[elva_status_p].'" 		class="idls object" '.$other_disabled.'></td>
											    <td><input style="width: 200px;" id="oder_date_p" value="'.(($res['oder_send_date_p']!='')?$res['oder_send_date_p']:'').'" 	class="idls object" '.$other_disabled.'></td>
											
											</tr>
											</table>
											<table class="dialog-form-table" style="width: 720px;">
											<tr>
												<td style="width: 520px;"><label>კოოდინატორის შენიშვნა</label></td>
											</tr>
											<tr>
												<td>
													<textarea  style="width: 1015px; resize: vertical; height:80px;" id="k_coment_p" class="idle" name="content" cols="300" '.$other_disabled.'>'.$res[coordinator_comment_p].'</textarea>
												</td>
											</tr>
										</table>
							    </fieldset>
							</fieldset>
							</div>
							</div>
							</div>
							<div id="tab-1">
					<div id="dialog-form">
					<fieldset>
					<legend>გაყიდვა</legend>
						<div id="dt_example" class="inner-table">
					        <div style="width:100%;" id="container" >        	
					            <div id="dynamic">
					            	<div id="button_area">
					            		<button id="add_prod_but">დამატება</button>
		  								<button id="delete_prod_but">წაშლა</button>
				        			</div>
					                <table id="sub1" style="width: 100%;">
					                    <thead>
											<tr  id="datatable_header">
												<th style="width:5%; display:none;">#</th>
												<th style="width:20%;">შტრიხკოდი</th>
												<th style="width:20%;">თარიღი</th>
												<th style="width:20%;">მყიდველი</th>
												<th style="width:100%;">პროდუქტი</th>
												<th style="width:40%;">რაოდენობა</th>
		  										<th style="width:40%;">ერთის ფასი</th>
												<th style="width:40%;">ს. ფასი</th>
												<th style="width:100%;">დეპარტამენტი</th>
												<th style="width:5%;">#</th>
											</tr>
										</thead>
										<thead>
											<tr class="search_header">
												<th style="display:none;">
													<input style="width:20px;" type="text" name="search_overhead" value="" class="search_init" />
												</th>
		  										<th>
													<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
											    <th>
													<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:80px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
                									<input style="width:75px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
                								</th>	
												<th>
													<input style="width:65px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
                									<input type="checkbox" name="check-all" id="check-all">
                								</th>				  										
											</tr>
										</thead>
										<tfoot>
                                        <tr id="datatable_header" class="search_header">
                							<th style="width: 150px; display:none;"></th>							
                							<th style="width: 150px"></th>
                							<th style="width: 150px"></th>													    
                							<th style="width: 150px"></th>
                							<th style="width: 150px"></th>
                							<th style="width: 150px"></th>                							
                							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
                							<th style="width: 100px; text-align: right;" id="my_prod_sum"></th>
											<th style="width: 150px"></th>
                							<th style="width: 150px"></th>
                                        </tr>
                                        </tfoot>
					                </table>
					            </div>
					            <div class="spacer">
					            </div>
					        </div></div>
					</fieldset>
    
			 		<fieldset>
							<legend>ცვლილებების ისტორია</legend>
				                <div id="dt_example" class="inner-table">
					        <div style="width:100%;" id="container" >        	
					            <div id="dynamic">
									<div id="button_area">
				        			</div>
					                <table id="sub2" style="width: 100%;">
					                    <thead>
											<tr  id="datatable_header">
												<th style="width:1%; display:none;"></th>
												<th style="width:25%;">რედაქტირებს თარიღი</th>
												<th style="width:20%;">ქმედება</th>
												<th style="width:100%;">ოპერატორი ძველი</th>
												<th style="width:100%;">ოპერატორი ახალი</th>
												<th style="width:100%;">პროდუქტი ძველი</th>
												<th style="width:100%;">პროდუქტი ახალი</th>
		  										<th style="width:10%;">რ-ბა ძველი</th>
												<th style="width:10%;">რ-ბა ახალი</th>
												<th style="width:10%;">ფასი ძველი</th>
												<th style="width:10%;">ფასი ახალი</th>
											    <th style="width:10%;">სულ ფასი ძველი</th>
												<th style="width:10%;">სულ ფასი ახალი</th>
											</tr>
										</thead>
										<thead>
											<tr class="search_header">
												<th style="display:none;">
												</th>
												<th>
													<input style="width:60px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
													<input style="width:60px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:60px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:60px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:60px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
                									<input style="width:60px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
                								</th>	
												<th>
													<input style="width:30px;" type="text" name="search_overhead" value="" class="search_init" />
												</th>
												<th>
													<input style="width:30px;" type="text" name="search_partner" value="" class="search_init" />
												</th>
												<th>
													<input style="width:30px;" type="text" name="search_overhead" value="" class="search_init" />
												</th>
												<th>
													<input style="width:30px;" type="text" name="search_partner" value="" class="search_init" />
												</th>
		  										<th>
													<input style="width:60px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
                									<input style="width:60px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
                								</th>	
												
											</tr>
										</thead>
					                </table>
					            </div>
					            <div class="spacer">
					            </div>
					        </div></div>
					</fieldset>
					</div>
					<input type="hidden" id="id" value="'.$_REQUEST[id].'" />
					<input type="hidden" id="my_dep" value="'.$_REQUEST[dep_now].'"/>
			</div>
		</fieldset>
								    
	    <div id="tab-2">
	    <div id="dialog-form">
	    '.GetRecordingsSection($res).'
	    </div>
	    </div></div>
	    
	    </div>';
    
    return $data['page'][0];
}

function GetProducts($id){
    $res = mysql_query("SELECT  production.id,
                    			production.`name`
            			FROM    production
            			WHERE   production.actived = 1
            			");
    $data = '<option value="0">-------</option>';
    while ($req = mysql_fetch_array($res)){
        if($id == $req[0]){
            $data .= '<option value="'.$req[0].'" selected>'.$req[1].'</option>';
        }else {
            $data .= '<option value="'.$req[0].'">'.$req[1].'</option>';
        }
    }
    
    return $data;
}

function pageee($my){
    if($my[2] == ''){
        $start = 1;
        $disable = '';
    }else{
        $start = $my[2];
        $disable = 'disabled';
    }
    $data = '
			<div id="dialog-form">
		 	    <fieldset>
					<legend>პროდუქტი</legend>
					<table>
						<tr>
							  <td style="width:120px; padding-top: 5px;">დასახელება</td>
                              <td>

            						<select style="width: 300px;" '.$disable.' id="production_name">'.GetProducts($my[0]).'</select>

                			  </td>
                        </tr>
                        <tr>
                              <td style="width:120px; padding-top: 25px;">რაოდენობა</td>
                              <td style="padding-top: 20px;">
            						<input style="width: 40px;" type="number" id="prod_count" value="'.$start.'" min="1">
                			  </td>
                		</tr>	
            		</table>
		        </fieldset>
						<input  type="hidden" id="hidden_prod_id" value="'.$my[0].'^'.$start.'"/>
                        <input  type="hidden" id="hidden_prod_id_or" value="'.$my[0].'"/>
                        <input  type="hidden" id="change" value="'.$my[0].'"/>
                        
						
		    </div> <script>$(document).ready(function () {$(".add_product-class").css("top","0");});</script>';
    return $data;
}

function GetCity($city_id)
{
    $city = mysql_query("	SELECT id,name
    						FROM city
    						WHERE actived = 1");
    $data .= '<option value="0">---</option>';
    while( $res = mysql_fetch_assoc($city)){
        if($res['id'] == $city_id){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }
    return $data;
}

function GetMainStatus($main_status){
    $mst = mysql_query("	SELECT id,name
    						FROM main_status
    						WHERE actived = 1");
    
    while( $res = mysql_fetch_assoc($mst)){
        if($res['id'] == $main_status){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }
    return $data;
}

function GetMonitoring($monitor){
    $mst = mysql_query("	SELECT id,`name` FROM `elva_monitor` WHERE actived = 1");

    $data .= '<option value="0">---</option>';
    while( $res = mysql_fetch_assoc($mst)){
        if($res['id'] == $monitor){
            $data .= '<option value="' . $res['id'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['id'] . '">' . $res['name'] . '</option>';
        }
    }
    return $data;
}

function GetCordin($cordin)
{
    $city = mysql_query("	SELECT id,name
    						FROM cordinator
    						WHERE actived = 1");
    $data .= '<option value="">---</option>';
    while( $res = mysql_fetch_assoc($city)){
        if($res['name'] == $cordin){
            $data .= '<option value="' . $res['name'] . '" selected="selected">' . $res['name'] . '</option>';
        } else {
            $data .= '<option value="' . $res['name'] . '">' . $res['name'] . '</option>';
        }
    }
    return $data;
}

function GetProductInfo($name)
{
    $res = mysql_query("SELECT  production.id
                        FROM    production
                        WHERE   production.`name` = '$name' AND production.actived = 1
                        ");

    if (mysql_num_rows($res) == 0){
        return false;
}

$row = mysql_fetch_assoc($res);
	return $row;
}

$data['error'] = $error;

echo json_encode($data);

?>