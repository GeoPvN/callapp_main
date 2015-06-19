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
		

		//------------
		
		if ($cash_ch != 'undefined') {
		    $chash_id = "AND elva_sale.cash = '$cash_ch'";
		}else{
		    $chash_id = "";
		}
		
		if($_REQUEST[date_type] == 1){
		    $date_type = 'send_date';
		}else{
		    $date_type = 'call_date';
		}
		
$rResult = mysql_query("
SELECT 			elva_sale.id AS `id`,
				elva_sale.name_surname,
				city.`name` as city_name,
				elva_sale.address,
				IF(date(elva_sale.call_date) != '0000-00-00',DATE_FORMAT(elva_sale.call_date,'%d.%m.%Y %H:%i:%s'),'') AS `call_date`,
				IF(date(elva_sale.send_date) != '0000-00-00',DATE_FORMAT(elva_sale.send_date,'%d.%m.%Y'),'') AS `send_date`,
				IF(date(elva_sale.send_client_date) != '0000-00-00',DATE_FORMAT(elva_sale.send_client_date,'%d.%m.%Y'),'') AS `send_client_date`,
				elva_sale.callceenter_comment,
				prod_cat.`name` as `prod_cat_name`,
				IF(elva_status.`name` = 'გაუქმებული',0,elva_sale.sum_price) AS `price`,
				persons.`name` as operator_id,
				elva_status.`name` AS `status_name`,
				elva_sale.coordinator_id,
				elva_sale.coordinator_comment,
				elva_sale.cancel_comment,
				elva_sale.elva_status,
				CONCAT('<button class=\"myact ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only\" onclick=\"openmyact(\'',elva_sale.task_id,'\',\'',elva_sale.custom_prod,'\',\'',elva_sale.id,'\',\'0\')\"><span class=\"ui-button-text\">აქტი</span></button>') as `button`,
                task_scenar.product_ids,
                elva_sale.task_id,
                elva_sale.custom_prod,
                elva_sale.main_status,
                elva_sale.main_status1,
                IF(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(elva_sale.send_date) <= 172800 && UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(elva_sale.send_date) >= 0,TRUE,FALSE) AS `color_red`,
                IF(UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(elva_sale.send_date) <= 345600 && UNIX_TIMESTAMP(NOW()) - UNIX_TIMESTAMP(elva_sale.send_date) >= 0,TRUE,FALSE) AS `light_color_red`,
                status_p_P.`name` AS `status_name_p`
				FROM `elva_sale`
				JOIN users ON elva_sale.operator_id = users.id
				JOIN elva_status ON elva_sale.`status` = elva_status.id
                JOIN elva_status as status_p_P ON elva_sale.`status_p` = status_p_P.id
				JOIN persons ON users.person_id = persons.id
				JOIN task_scenar ON elva_sale.task_id = task_scenar.task_detail_id
				JOIN city ON elva_sale.city_id = city.id
				LEFT JOIN prod_cat ON elva_sale.prod_cat = prod_cat.id
WHERE 			DATE(elva_sale.$date_type) >= '$start' AND DATE(elva_sale.$date_type) <= '$end'  $chash_id");
	    while ($res = mysql_fetch_assoc( $rResult )){

	    if($res[task_id] != 0){
	    
	        $last =  preg_split("/[,]+/",$res[product_ids]);
	        foreach ($last as $test){
	            $dato = explode('^',$test,2);
	            if($dato[0] != 0){
	            $tt .= $dato[0].',';
	            $ttt .= $dato[1].'-';
	            }
	        }
	        $myarr = preg_split("/[-]+/",$ttt);
	        $cvladi = substr($tt,0, -1);
	    }else{
	        $last =  preg_split("/[,]+/",$res[custom_prod]);
	        foreach ($last as $test){
	            $dato = explode('^',$test,2);
	            if($dato[0] != 0){
	            $tt .= $dato[0].',';
	            $ttt .= $dato[1].'-';
	            }
	        }
	        $myarr = preg_split("/[-]+/",$ttt);
	        $cvladi = substr($tt,0, -1);
	    }
	    
	    if($_REQUEST[dep_id] != 0){
	        $chch = $_REQUEST[dep_id];
	        $chch1 = $_REQUEST[dep_id];
	    }else{
	        $chch = 21;
	        $chch1 = 25;
	    }
	    
	    $query11 = mysql_query("SELECT 	`production`.`name`,
                            	        production.`price` AS `price`,
                            	        production.`id`,
                            	        department.`name`
                    	        FROM 	`production`
                    	        JOIN    `department` ON production.production_category_id = department.id
                    	        WHERE 	`production`.`id` in ($cvladi)
	                            GROUP BY department.id
                    	        ORDER BY FIELD(production.id, $cvladi)");
	    
	    $query111 = mysql_query("SELECT 	`production`.`name`,
                            	        production.`price` AS `price`,
                            	        production.`id`,
                            	        department.`name`
                    	        FROM 	`production`
                    	        JOIN    `department` ON production.production_category_id = department.id
                    	        WHERE 	`production`.`id` in ($cvladi)
                    	        ORDER BY FIELD(production.id, $cvladi)");
	    
	    
	    
	    
	    $cvladi = '';
	    $ttt ='';
	    $tt='';
	    $r=0;
	    $book_price =0;
	    $book_price_p =0;
	    $total_sum=0;
	    while ($row_prod1 = mysql_fetch_array($query11)) {
	        $number = $row_prod1[2];
	        $book_name = $row_prod1[0];	        
	        $book_dep = $row_prod1[3];  
	        while ($row_prod11 = mysql_fetch_array($query111)){
	            $total_sum = (($myarr[0]=='')?'1':$myarr[$r++]);
	            if(($res[main_status] == $_REQUEST[tab_num] || $_REQUEST[tab_num] == 7) && $row_prod11[3] == 'ელვა.ჯი'){
	                if($chch == 21){
    	                if($res[status_name] == 'გაუქმებული'){
    	                    $book_price = 0;
    	                }else{
    	                    $book_price += ($row_prod11[1] * $total_sum);
    	                }
	                }
	            }
	            if(($res[main_status1] == $_REQUEST[tab_num] || $_REQUEST[tab_num] == 7) && $row_prod11[3] == 'პალიტრა L'){
	                if($chch1 == 25){
    	                if($res[status_name_p] == 'გაუქმებული'){
    	                    $book_price_p = 0;
    	                }else{
    	                    $book_price_p += ($row_prod11[1] * $total_sum);
    	                }
	                }
	            }
	        }
	        if($_REQUEST[tab_num] == 0 && $res[color_red] == 1 && $res[city_name] == 'თბილისი'){
	            $mycolor = 'background:red;color:#fff;';
	        }else{
	            if($_REQUEST[tab_num] == 0 && $res[light_color_red] == 1 && $res[city_name] == 'რაიონი'){
	               $mycolor = 'background:red;color:#fff;';
	            }else{
	                $mycolor = '';
	            }
	        }	        
	        
	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {
	            if(($res[main_status] == $_REQUEST[tab_num] || $_REQUEST[tab_num] == 7) && $book_dep == 'ელვა.ჯი'){
	                if($chch == 21){
	            if($i == 0){
	                $row[] = $res[id];
	            }elseif($i == 1){
	                $row[] = $res[name_surname];
	            }elseif($i == 2){
	                $row[] = $res[city_name];
	            }elseif($i == 3){
	                $row[] = $res[address];
	            }elseif($i == 4){
	                $row[] = $res[call_date];
	            }elseif($i == 5){
	                $row[] = '<span style="display:block; height:100%; witdh: 100%; '.$mycolor.' padding:7px 0 0 6px;">'.$res[send_date].'</span>';
	            }elseif($i == 6){
	                $row[] = $res[send_client_date];
	            }elseif($i == 7){
	                $row[] = $res[callceenter_comment];
	            }elseif($i == 8){
	                $row[] = $book_dep;
	            }elseif($i == 9){
	                $row[] = $res[prod_cat_name];
	            }elseif($i == 10){
	                $row[] = number_format($book_price, 2, '.', '');
	            }elseif($i == 11){
	                $row[] = $res[operator_id];
	            }elseif($i == 12){
	                $row[] = $res[status_name];
	            }elseif($i == 13){
	                $row[] = $res[coordinator_id];
	            }elseif($i == 14){
	                $row[] = $res[coordinator_comment];
	            }elseif($i == 15){
	                $row[] = $res[cancel_comment];
	            }elseif($i == 16){
	                $row[] = $res[elva_status];
	            }elseif($i == 17){
	                $row[] = $res[button];
	            }elseif($i == 18){
	                $row[] = '<input type="checkbox" name="check_' . $res[id] . '" class="check" value="' . $res[id] . '" dep="0" />';
	            }
	                }
	            }
	            if(($res[main_status1] == $_REQUEST[tab_num] || $_REQUEST[tab_num] == 7) && $book_dep == 'პალიტრა L'){
	                if($chch1 == 25){
	                    if($user_cheker != 5){
	                if($i == 0){
	                    $row[] = $res[id];
	                }elseif($i == 1){
	                    $row[] = $res[name_surname];
	                }elseif($i == 2){
	                    $row[] = $res[city_name];
	                }elseif($i == 3){
	                    $row[] = $res[address];
	                }elseif($i == 4){
	                    $row[] = $res[call_date];
	                }elseif($i == 5){
	                    $row[] = '<span style="display:block; height:100%; witdh: 100%; '.$mycolor.' padding:7px 0 0 6px;">'.$res[send_date].'</span>';
	                }elseif($i == 6){
	                    $row[] = $res[send_client_date];
	                }elseif($i == 7){
	                    $row[] = $res[callceenter_comment];
	                }elseif($i == 8){
	                    $row[] = $book_dep;
	                }elseif($i == 9){
	                    $row[] = $res[prod_cat_name];
	                }elseif($i == 10){
	                    $row[] = number_format($book_price_p, 2, '.', '');
	                }elseif($i == 11){
	                    $row[] = $res[operator_id];
	                }elseif($i == 12){
	                    $row[] = $res[status_name_p];
	                }elseif($i == 13){
	                    $row[] = $res[coordinator_id];
	                }elseif($i == 14){
	                    $row[] = $res[coordinator_comment];
	                }elseif($i == 15){
	                    $row[] = $res[cancel_comment];
	                }elseif($i == 16){
	                    $row[] = $res[elva_status];
	                }elseif($i == 17){
	                    $row[] = $res[button];
	                }elseif($i == 18){
	                    $row[] = '<input type="checkbox" name="check_' . $res[id] . '" class="check" value="' . $res[id] . '" dep="1" />';
	                }
	                }
	                }
	            }	            
	        }
	        if(($res[main_status1] == $_REQUEST[tab_num] || $_REQUEST[tab_num] == 7) && $book_dep == 'პალიტრა L'){
	            if($chch1 == 25){
	                if($user_cheker != 5){
	        $data['aaData'][] = $row;
	                }
	            }
	        }
	        if(($res[main_status] == $_REQUEST[tab_num] || $_REQUEST[tab_num] == 7) && $book_dep == 'ელვა.ჯი'){
	            if($chch == 21){
	            $data['aaData'][] = $row;
	            }
	        }

	    }
	   
	    }

		break;
	case 'disable' :
	    $id		= $_REQUEST['id'];
	    $user_id = $_SESSION['USERID'];
	    mysql_query("UPDATE `elva_sale` SET `user_id`='$user_id' WHERE `id`='$id';");
	    mysql_query("DELETE FROM elva_sale
                     WHERE id = '$id'");
		break;
		
	case 'send_book' :
	    $id		= $_REQUEST['id'];
	    $dep	= $_REQUEST['dep'];
	    if($dep == 0){
	        mysql_query("UPDATE `elva_sale` SET `main_status`='1' WHERE (`id`='$id');");
	    }elseif($dep == 1){
	        mysql_query("UPDATE `elva_sale` SET `main_status1`='1' WHERE (`id`='$id');");
	    }
	    
	    break;
	case 'save_prod' :
	    $rr = mysql_fetch_array(mysql_query("SELECT elva_sale.custom_prod,
                                	                task_scenar.product_ids,
                                	                elva_sale.task_id
                                	         FROM   elva_sale
                                	         JOIN   task_scenar ON elva_sale.task_id = task_scenar.task_detail_id
                                	         WHERE  elva_sale.id = $_REQUEST[elva_id]"));
	    
	    if($rr[2] == 0){
	        if($rr[0] != ''){	            
	            if($_REQUEST[change] == ''){
	                $last_prod = ','.$_REQUEST[prod_id];
	                $up = "`custom_prod`=CONCAT(custom_prod,'$last_prod')";
	            }else{
	                $last_prod = str_replace($_REQUEST[change],0,$rr[0]);
	                $last_prod .= ','.$_REQUEST[prod_id];
	                $up = "`custom_prod`='$last_prod'";
	            }
	        }else{	                   
	            if($_REQUEST[change] == ''){	                
	                $up = "`custom_prod`='$_REQUEST[prod_id]'";
	            }else{
	                $last_prod = str_replace($_REQUEST[change],0,$rr[0]);
	                $up = "`custom_prod`=CONCAT(custom_prod,'$last_prod')";	                
	            }
	        }
	        mysql_query("UPDATE `elva_sale` SET
            	                $up
            	         WHERE  `id`=$_REQUEST[elva_id]");
	    }else{
	        if($_REQUEST[change] == ''){
	            $last_prod = ','.$_REQUEST[prod_id];
	            $up = "`product_ids`=CONCAT(product_ids,'$last_prod')";
	        }else{
	            $last_prod = str_replace($_REQUEST[change],0,$rr[1]);
	            $last_prod .= ','.$_REQUEST[prod_id];
	            $up = "`product_ids`='$last_prod'";
	        }	  
    	        mysql_query("UPDATE `task_scenar` SET
            	                    $up
                	         WHERE  `task_detail_id`=$rr[2]");
	    }
	    break;
	case 'get_add_page':
	    $page = pagee();
	    $data		= array('page'	=> $page);
	    
	    break;
	case 'get_add_pagee':
	    if($_REQUEST['prod_id'] != ''){
	        $my = mysql_fetch_array(mysql_query("SELECT 	`id`,
                                            				`name`
                                                 FROM 		`production`
                                                 WHERE 	    `id` = $_REQUEST[prod_id]"));
	    }
	    $page = pageee($my);
	    $data		= array('page'	=> $page);
	         
	    break;
    case 'get_product_info':
        $name 			= $_REQUEST['name'];
        $res 			= GetProductInfo($name);
        if(!$res){
            $error = 'პროდუქტი ვერ მოიძებნა!';
        }else{
            $data = array('id' => $res['id']);
        }
    
        break;
	case 'get_edit_page' :
	    $page = pagee();
	    $data		= array('page'	=> $page);

	    break;
	case 'get_my_prod' :
	    $count = 		$_REQUEST['count'];
	    $hidden = 		$_REQUEST['hidden'];
	    $my_dep = $_REQUEST[my_dep];
	    $data = array(
	        "aaData"	=> array()
	    );
	    
	    $rResult = mysql_query(	"SELECT elva_sale.id,
	        elva_sale.person_id,
	        elva_sale.name_surname,
	        elva_sale.mail,
	        elva_sale.address,
	        elva_sale.phone,
	        elva_sale.phone1,
	        shipping.`name` AS `period`,
	        elva_sale.books,
	        elva_sale.call_date,
	        IF(elva_sale.`status` = 1, 0 , elva_sale.sum_price) as sum_price,
	        elva_sale.callceenter_comment,
	        persons.`name` as operator_id,
	        elva_sale.oder_send_date,
	        elva_sale.`status`,
	        elva_sale.coordinator_id,
	        elva_sale.coordinator_comment,
	        elva_sale.task_id,
	        elva_sale.elva_status,
	        elva_sale.period AS `period_id`,
	        elva_sale.send_date,
	        elva_sale.cancel_comment,
	        elva_sale.cash,
	        elva_sale.street_done,
	        elva_sale.custom_prod
	        FROM    `elva_sale`
	        left JOIN shipping ON elva_sale.period = shipping.id
	        JOIN users ON elva_sale.operator_id = users.id
	        JOIN persons ON users.person_id = persons.id
	        WHERE elva_sale.id='$_REQUEST[id]'");
	    $res = mysql_fetch_array( $rResult );
	    
	    
	    if($res[task_id] != 0){
	        $query_list1 = mysql_fetch_row(mysql_query("SELECT 	product_ids,
	            gift_ids
	            FROM 	`task_scenar`
	            WHERE 	task_detail_id = '$res[task_id]'"));
	    
	        $last =  preg_split("/[,]+/",$query_list1[0]);
	        foreach ($last as $test){
	            $dato = explode('^',$test,2);
	            if($dato[0] != 0){
	            $tt .= $dato[0].',';
	            $ttt .= $dato[1].'-';
	            }
	        }
	        $myarr = preg_split("/[-]+/",$ttt);
	        $cvladi = substr($tt,0, -1);
	    }else{
	        $last =  preg_split("/[,]+/",$res[custom_prod]);
	        foreach ($last as $test){
	            $dato = explode('^',$test,2);
	            if($dato[0] != 0){
	            $tt .= $dato[0].',';
	            $ttt .= $dato[1].'-';
	            }
	        }
	        $myarr = preg_split("/[-]+/",$ttt);
	        $cvladi = substr($tt,0, -1);
	    }
	    $query11 = mysql_query("SELECT 	`production`.`name`,production.`price`,production.`id`,department.`name`,production.unicid
	        FROM 	`production`
	        JOIN    `department` ON production.production_category_id = department.id
	        WHERE 	`production`.`id` in ($cvladi)
	        ORDER BY FIELD(production.id, $cvladi)");

	    $r=0;
	    $total_sum=0;
	    while ($row_prod1 = mysql_fetch_row($query11)) {
	        $number = $row_prod1[2];
	        $book_name = $row_prod1[0];
	        $book_price = $row_prod1[1];
	        $book_dep = $row_prod1[3];
	        $total_sum = (($myarr[0]=='')?'1':$myarr[$r++]);
	        $unicid = $row_prod1[4];

	        $row = array();
	        for ( $i = 0 ; $i < $count ; $i++ )
	        {	   
	            if($my_dep == $book_dep || $my_dep == ''){       
	            if($i == 0){
	                $row[] = $number;
	            }elseif($i == 1){
	                $row[] = $unicid;
	            }elseif($i == 2){
	                $row[] = $res[call_date];
	            }elseif($i == 3){
	                $row[] = $res[name_surname];
	            }elseif($i == 4){
	                $row[] = $book_name;
	            }elseif($i == 5){
	                $row[] = $total_sum;
	            }elseif($i == 6){
	                $row[] = $book_price;
	            }elseif($i == 7){
	                $row[] = number_format(((float)$book_price * (float)$total_sum), 2, '.', '');
	            }elseif($i == 8){
	                $row[] = $book_dep;
	            }elseif($i == 9){
	                $row[] = '<input type="checkbox" name="check_' . $number . '" class="check" value="' . $number . '" />';;
	            }	
	            }            
	        }
	        if($my_dep == $book_dep || $my_dep == ''){
	        $data['aaData'][] = $row;
	        }
	    }
	     
	    break;
	case 'disable_prod':
        $rr = mysql_fetch_array(mysql_query("SELECT elva_sale.custom_prod,
                                                    task_scenar.product_ids,
                                                    elva_sale.task_id
                                             FROM   elva_sale
                                             JOIN   task_scenar ON elva_sale.task_id = task_scenar.task_detail_id
                                             WHERE  elva_sale.id = $_REQUEST[elva_id]"));
        
        if($rr[2] == 0){
            $last_prod = str_replace($_REQUEST[id],0,$rr[0]);
            mysql_query("UPDATE `elva_sale` SET 
                                `custom_prod`='$last_prod'
                         WHERE  `id`=$_REQUEST[elva_id]");
        }else{
            $last_prod = str_replace($_REQUEST[id],0,$rr[1]);
            mysql_query("UPDATE `task_scenar` SET
                                `product_ids`='$last_prod'
                         WHERE  `task_detail_id`=$rr[2]");
        }
        
	    break;
   	case 'save_dialog' :
   		
   	    
   		$per_id = mysql_fetch_row(mysql_query("	SELECT id
										   		FROM shipping
										   		WHERE `name` = '$_REQUEST[period]'"));

   		if($_REQUEST[id] != ''){
   		  $book = addslashes($_REQUEST[book]);
   		  if($_REQUEST[main_status] != ''){
   		      $main_s = "`main_status`           ='$_REQUEST[main_status]'";
   		      
   		  }else{
   		      $main_s = "`main_status1`          ='$_REQUEST[main_status1]'";
   		  }
   		  $user_id = $_SESSION['USERID'];
		  mysql_query("UPDATE   `elva_sale` SET 
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
    							$main_s
    					WHERE (`id`='$_REQUEST[id]')");
   	    }else{
   	        $book = addslashes($_REQUEST[book]);
   	        mysql_query("INSERT INTO `elva_sale` 
                        (`person_id`, `name_surname`, `mail`, `address`, `phone`, `phone1`, `period`, `books`, `call_date`, `sum_price`, `callceenter_comment`, `operator_id`, `oder_send_date`, `status`, `coordinator_id`, `coordinator_comment`, `elva_status`, `task_id`, `send_date`, `cancel_comment`, `cash`, `street_done`,`custom_prod`,`city_id`,`send_client_date`,`prod_cat`,`status_p`,`oder_send_date_p`,`coordinator_id_p`,`coordinator_comment_p`,`elva_status_p`,`main_status`,`main_status1`)
                        VALUES
                        ('$_REQUEST[person_id]', '$_REQUEST[name_surname]', '$_REQUEST[mail]', '$_REQUEST[addres]', '$_REQUEST[phone]', '$_REQUEST[phone1]', '$_REQUEST[period]', '$book', '$_REQUEST[date]', '$_REQUEST[sum_price]', '$_REQUEST[c_coment]', '$_SESSION[USERID]', '$_REQUEST[oder_date]', '$_REQUEST[status]', '$_REQUEST[cooradinator]', '$_REQUEST[k_coment]', '$_REQUEST[elva]', '', '$_REQUEST[send_date]', '$_REQUEST[cancel_comment]', '$_REQUEST[cash_id]', '$_REQUEST[street_done]', '', '$_REQUEST[city_id]', '$_REQUEST[send_client_date]', '$_REQUEST[prod_cat]','$_REQUEST[status_p]','$_REQUEST[oder_date_p]','$_REQUEST[cooradinator_p]','$_REQUEST[k_coment_p]','$_REQUEST[elva_p]','$_REQUEST[main_status]','$_REQUEST[main_status1]')");
   	        $rr = mysql_fetch_array(mysql_query("   SELECT id
                                                    FROM `elva_sale`
                                                    ORDER BY id DESC
                                                    LIMIT 1"));
   	        $data[id] = $rr[0];
   	    }
   		break;
   	case 'add_rs' :
   	    $rp = mysql_fetch_array(mysql_query("SELECT id FROM elva_rs WHERE elva_id = '$_REQUEST[counter_rs]'"));
   	    if($rp == ''){
   	        mysql_query("INSERT INTO `elva_rs` (`elva_id`, `head`, `footer`) VALUES ('$_REQUEST[counter_rs]', '$_REQUEST[theacte]', '$_REQUEST[theactee]');");
   	    }
   	    break;
    case 'choose_dep' :
        
        
        if($_REQUEST[custom_prod] == ''){
            $query_list1 = mysql_fetch_array(mysql_query("  SELECT 	`product_ids`,
                                                                    `gift_ids`
                                                            FROM 	`task_scenar`
                                                            WHERE 	`task_detail_id` = '$_REQUEST[task_id]'"));
            $last =  preg_split("/[,]+/",$query_list1[0]);
            foreach ($last as $test){
                $dato = explode('^',$test,2);
                if($dato[0] != 0){
                    $tt .= $dato[0].',';
                    $ttt .= $dato[1].'-';
                }
            }
            $myarr = preg_split("/[-]+/",$ttt);
            $cvladi = substr($tt,0, -1);
        }else{
            $last =  preg_split("/[,]+/",$_REQUEST[custom_prod]);
            $i = 0;
            foreach ($last as $test){
                $dato = explode('^',$test,2);
                if($dato[0] != 0){
                    $tt .= $dato[0].',';
                    $ttt .= $dato[1].'-';
                }
            }
        
            $myarr = preg_split("/[-]+/",$ttt);
            $cvladi = substr($tt,0, -1);
        }
        $query11 = mysql_query("SELECT 	department.id,department.`name`
                                FROM 	`production`
                                JOIN    `department` ON production.production_category_id = department.id
                                WHERE 	`production`.`id` in ($cvladi)
                                GROUP BY department.`name`
                                ORDER BY FIELD(`production`.`id`, $cvladi)");

        $page = '<select id="myfirstdep" style="width: 100%; margin-top: 13px;"><option value="0">----</option>';
        while ($myqu = mysql_fetch_assoc($query11)) {
            $page .= '<option value="'.$myqu['id'].'">' . $myqu['name'] . '</option>';
        }
        
        $page .= '</select>            
            <input id="task_id" type="hidden" value="'.$_REQUEST[task_id].'">
            <input id="custom_prod" type="hidden" value="'.$_REQUEST[custom_prod].'">
            <input id="sale_id" type="hidden" value="'.$_REQUEST[sale_id].'">';
        $data		= array('page'	=> $page);
        break;
   	case 'product_list' :

   	    $elva_rs = mysql_fetch_assoc(mysql_query("SELECT head,footer FROM `elva_rs` WHERE elva_id = '$_REQUEST[sale_id]'"));
   	    $elva_sale = mysql_fetch_assoc(mysql_query("SELECT name_surname,person_id,address,phone,phone1,DATE_FORMAT(DATE(send_client_date),'%d.%m.%Y') as `c_date` FROM `elva_sale` WHERE id = '$_REQUEST[sale_id]'"));
   	    $counter_rs = mysql_num_rows(mysql_query("SELECT id FROM `elva_rs` WHERE elva_id"));
        $date = date("d.m.Y");
        if($elva_sale[phone] != '' && $elva_sale[phone1] != ''){
            $phone = $elva_sale[phone].'/'.$elva_sale[phone1];
        }else{
            if($elva_sale[phone] != ''){
                $phone = $elva_sale[phone];
            }else{
                $phone = $elva_sale[phone1];
            }
        }
        $counter_rs = $counter_rs+1;
        $head = '<textarea style="width: 100%; height: 180px;" id="theacte">';
        $footer = '<textarea style="width: 100%; height: 370px;" id="theactee">';
   	    if($elva_rs == ''){
   	        $rs = mysql_fetch_assoc(mysql_query("SELECT head,footer FROM `rs`"));
       	    $head   .= $rs[head];
       	    $footer .= $rs[footer];
       	    $head = str_replace("თარიღი", $elva_sale[c_date], $head);
       	    $head = str_replace("სახელი გვარი", $elva_sale[name_surname], $head);
   	        $head = str_replace("პირადი ნომერი", $elva_sale[person_id], $head);
   	        $head = str_replace("მიღება-ჩაბარების აქტი #", "მიღება-ჩაბარების აქტი #$counter_rs", $head);
   	        
   	        $footer = str_replace("თარიღი", $elva_sale[c_date], $footer);
   	        $footer = str_replace("სახელი გვარი", $elva_sale[name_surname], $footer);
   	        $footer = str_replace("პირადი ნომერი", $elva_sale[person_id], $footer);
   	        $footer = str_replace("ტელეფონი/ტელეფონები", $phone, $footer);
   	        $footer = str_replace("მისამართი", $elva_sale[address], $footer);
   	    }else{
   	        $head   .= $elva_rs[head];
   	        $footer .= $elva_rs[footer];
   	        $head = str_replace("თარიღი", $elva_sale[c_date], $head);
   	        $head = str_replace("სახელი გვარი", $elva_sale[name_surname], $head);
   	        $head = str_replace("პირადი ნომერი", $elva_sale[person_id], $head);
   	        
   	        $footer = str_replace("თარიღი", $elva_sale[c_date], $footer);
   	        $footer = str_replace("სახელი გვარი", $elva_sale[name_surname], $footer);
   	        $footer = str_replace("პირადი ნომერი", $elva_sale[person_id], $footer);
   	        $footer = str_replace("ტელეფონი/ტელეფონები", $phone, $footer);
   	        $footer = str_replace("მისამართი", $elva_sale[address], $footer);
   	    }
   	    
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
   	    if($_REQUEST[custom_prod] == ''){
        $query_list1 = mysql_fetch_array(mysql_query("SELECT 	`product_ids`,
                                                                `gift_ids`
                                                      FROM 	    `task_scenar`
                                                      WHERE 	`task_detail_id` = '$_REQUEST[task_id]'"));
        $last =  preg_split("/[,]+/",$query_list1[0]);
        foreach ($last as $test){
            $dato = explode('^',$test,2);
            if($dato[0] != 0){
            $tt .= $dato[0].',';
            $ttt .= $dato[1].'-';
            }
        }
        $myarr = preg_split("/[-]+/",$ttt);
        $cvladi = substr($tt,0, -1);
   	    }else{
   	        $last =  preg_split("/[,]+/",$_REQUEST[custom_prod]);
   	        $i = 0;
   	        foreach ($last as $test){
   	            $dato = explode('^',$test,2);
   	            if($dato[0] != 0){
   	            $tt .= $dato[0].',';
   	            $ttt .= $dato[1].'-';
   	            }
   	        }
   	        
   	        $myarr = preg_split("/[-]+/",$ttt);
   	        $cvladi = substr($tt,0, -1);
   	    }
        $query11 = mysql_query("SELECT 	`production`.`name`,production.`price`,department.`name`,department.id
                                FROM 	`production`
                                JOIN    `department` ON production.production_category_id = department.id
                                WHERE 	`production`.`id` in ($cvladi)
                                ORDER BY FIELD(`production`.`id`, $cvladi)");
   	    $i=1;
   	    $total = 0;
   	    $r=0;
        while ($row_prod1 = mysql_fetch_row($query11)) {
            
            $book_name = $row_prod1[0];
            $book_price = $row_prod1[1];
            //$book_dep = $row_prod1[3];
            if($myarr[0]==''){
                $count_prod = 1;
            }else{
                $count_prod = $myarr[$r++];
            }
            
            if($row_prod1[3] == $_REQUEST[choose_dep]){
            $total += ($book_price * $count_prod);
            $page .= '<tr>
                         <td style="border:1px solid #111; padding:1px; text-align: center;">'.$i++.'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: center;">'.$book_name.'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: center;">'.$count_prod.'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: right;">'.$book_price.'</td>
           	             <td style="border:1px solid #111; padding:1px; text-align: right;">'.number_format(($book_price * $count_prod), 2, '.', '').'</td>
       	             </tr>
   	                 ';
            }
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
                        </audio></td>
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
    
    $rResult = mysql_query("SELECT  elva_sale.id,
                                    elva_sale.person_id,
                                    elva_sale.name_surname,
                                    elva_sale.mail,
                                    elva_sale.address,
                                    elva_sale.phone,
                                    elva_sale.phone1,
                                    shipping.`name` AS `period`,
                                    elva_sale.books,
                                    elva_sale.call_date,
                                    IF(elva_sale.`status` = 1, 0 , elva_sale.sum_price) as sum_price,
                                    elva_sale.callceenter_comment,
                                    persons.`name` as operator_id,
                                    elva_sale.oder_send_date,
                                    elva_sale.`status`,
                                    elva_sale.coordinator_id,
                                    elva_sale.coordinator_comment,
                                    elva_sale.task_id,
                                    elva_sale.elva_status,
                                    elva_sale.period AS `period_id`,
                                    elva_sale.send_date,
                                    elva_sale.cancel_comment,
                                    elva_sale.cash,
                                    elva_sale.street_done,
                                    elva_sale.city_id,
                                    elva_sale.custom_prod,
                                    elva_sale.send_client_date,
                                    elva_sale.prod_cat,
                                    `status_p`,
                                    `oder_send_date_p`,
                                    `coordinator_id_p`,
                                    `coordinator_comment_p`,
                                    `elva_status_p`,
                                    elva_sale.main_status,
                                    elva_sale.main_status1
                            FROM    `elva_sale`
                            left JOIN shipping ON elva_sale.period = shipping.id
                            JOIN users ON elva_sale.operator_id = users.id
                            JOIN persons ON users.person_id = persons.id
                            WHERE elva_sale.id='$_REQUEST[id]'");
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
							<legend>საჩუქარი</legend>
				                <div id="dt_example" class="inner-table">
					        <div style="width:100%;" id="container" >        	
					            <div id="dynamic">
					            	<div id="button_area">
					            		<button id="add_prod_but_gif">დამატება</button>
		  								<button id="delete_prod_but_gif">წაშლა</button>
				        			</div>
					                <table id="sub2" style="width: 100%;">
					                    <thead>
											<tr  id="datatable_header">
												<th style="width:5%;>#</th>
												<th style="width:20%;">თარიღი</th>
												<th style="width:20%;">მყიდველი</th>
												<th style="width:100%;">პროდუქტი</th>
												<th style="width:100%;">რაოდენობა</th>
		  										<th style="width:100%;">ერთის ფასი</th>
												<th style="width:100%;">ს. ფასი</th>
												<th style="width:100%;">დეპარტამენტი</th>
												<th style="width:5%;">#</th>
											</tr>
										</thead>
										<thead>
											<tr class="search_header">
												<th>
													<input style="width:20px;" type="text" name="search_overhead" value="" class="search_init" />
												</th>
		  										<th>
													<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
                									<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
                								</th>	
												<th>
													<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
												</th>
												<th>
													<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
												</th>
		  										<th>
                									<input type="checkbox" name="check-all" id="check-all">
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

function pageee($my){
    $data = '
			<div id="dialog-form">
		 	    <fieldset>
					<legend>პროდუქტი</legend>
					<table>
						<tr>
							  <td style="width:120px;">დასახელება</td>
                              <td>
            						<div class="seoy-row" id="goods_name_seoy">
            							<input type="text" id="production_name" class="idle seoy-address" onblur="this.className=\'idle seoy-address\'" onfocus="this.className=\'activeField seoy-address\'" value="'.$my[1].'" />
                						<button id="goods_name_btn" class="combobox">production_name</button>
                					</div>
                			  </td>
                        </tr>
                        <tr>
                              <td style="width:120px;">რაოდენობა</td>
                              <td>
            						<input style="width: 40px;" type="number" id="prod_count" value="1">
                			  </td>
                		</tr>	
            		</table>
		        </fieldset>
						<input  type="hidden" id="hidden_prod_id" value="'.$my[0].'"/>
                        <input  type="hidden" id="hidden_prod_id_or" value="'.$my[0].'"/>
                        <input  type="hidden" id="change" value="'.$my[0].'"/>
                        
						
		    </div> ';
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