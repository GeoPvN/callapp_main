<html>
<head>
	<script type="text/javascript">
		var aJaxURL8	= "server-side/report/out_report.action.php";		//server side folder url
	    var aJaxURL           = "server-side/call/outgoing/outgoing_tab0.action.php";
	    var aJusURL_Actived   = "server-side/call/outgoing/outgoing_actived.action.php";
	    var aJusURL_Task      = "server-side/call/outgoing/outgoing_task.action.php";
	    var aJaxURL_contact_info = "server-side/call/outgoing/contact_info.action.php";
	    var aJaxURL_contact_info_phone = "server-side/call/outgoing/contact_info_phone.action.php";
	    var aJaxURL_contact_info_mail = "server-side/call/outgoing/contact_info_mail.action.php";
	    var aJaxURL_getmail	  = "includes/phpmailer/smtp.php";
	    var aJusURL_mail      = "server-side/call/Email_sender.action.php";
	    var aJaxURL_send_sms  = "includes/sendsms.php";
	    var tName             = "table_";
	    var dialog            = "add-edit-form";
	    var colum_number      = 12;
	    var main_act          = "get_list";
	    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
		    	
		$(document).ready(function () {        	
			LoadTable3();
			SetEvents("", "", "", "example", dialog, aJaxURL);
		});
        
		function LoadTable3(){
			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable("example", aJaxURL8, "get_list", 19, "", 0, "", 1, "desc", "", change_colum_main);
			setTimeout(function(){
    	    	$('.ColVis, .dataTable_buttons').css('display','none');
  	    	}, 90);
		}
		function LoadTable(tbl,col_num,act,change_colum,custom_param,URL){
	    	GetDataTable(tName+tbl, URL, act, col_num, custom_param, 0, "", 1, "asc", '', change_colum);
	    	setTimeout(function(){
		    	$('.ColVis, .dataTable_buttons').css('display','none');
		    	}, 120);
	    	//$('.display').css('width','100%');
	    }
		
	    function LoadDialog(fName){
	    	if(fName=='add-edit-form'){
	    	    	var buttons = {
	    					
	    		        	"cancel": {
	    			            text: "დახურვა",
	    			            id: "cancel-dialog",
	    			            click: function () {
	    			            	$(this).dialog("close");
	    			            }
	    			        }
	    			    };
	    	        GetDialog(fName, 585, "auto", buttons, 'left+43 top');
	    	        LoadTable('sms',5,'get_list',"<'F'lip>",'',aJaxURL);
	    	        LoadTable('contact_info',6,'get_list',"<'F'lip>",'outgoing_campaign_detail_id='+$('#incomming_id').val(),aJaxURL_contact_info);
	    	        SetEvents("add_contact_info", "delete_contact_info", "check-all-contact_info", tName+'contact_info', 'add-edit-form-contact_info', aJaxURL_contact_info);
	    	        LoadTable('mail',5,'get_list_mail',"<'F'lip>",'out_id='+$('#incomming_id').val(),aJaxURL);
	    	        $('#table_contact_info_length').css('top','2px');
	    	        $('select[name="table_contact_info_length"]').css('height','19px');
	    	        GetButtons("add_contact_info","delete_contact_info");
	    	        $("#client_checker,#add_sms,#add_mail,#show_all_scenario").button();
	    	        GetDate2("date_input");
	    	        GetDateTimes("task_end_date");
	    	        GetDateTimes("task_start_date");
	    			GetDateTimes1("date_time_input");
	    			$('.quest_body').css('display','none');
	    			$('.1').css('display','block');
	    			$('#next_quest').attr('next_id',$('.1').attr('id'));
	    			$('#next_quest, #back_quest').button();
	    			$('#back_quest').prop('disabled',true);
	    			$('.info').click();
	    			$('#outgoing_status').chosen({ search_contains: true });
	    			GetDateTimes("call_back");
	    	}
	    	if(fName=='add-edit-form-contact_info'){
	    		var buttons = {
	    				"save": {
	    		            text: "შენახვა",
	    		            id: "save-dialog-contact_info"
	    		        },
	    	        	"cancel": {
	    		            text: "დახურვა",
	    		            id: "cancel-dialog",
	    		            click: function () {
	    		            	$(this).dialog("close");
	    		            }
	    		        }
	    		    };
	    		GetDialog(fName, 1000, "auto", buttons, 'left+43 top');
	    		LoadTable('contact_info_phone',2,'get_list',"<'F'lip>",'outgoing_campaign_detail_contact_id='+$('#outgoing_campaign_detail_contact_id').val(),aJaxURL_contact_info_phone);
	    	    SetEvents("add_contact_info_phone", "delete_contact_info_phone", "check-all-contact_info_phone", tName+'contact_info_phone', 'add-edit-form-contact_info_phone', aJaxURL_contact_info_phone);
	    	    LoadTable('contact_info_mail',2,'get_list',"<'F'lip>",'outgoing_campaign_detail_contact_id='+$('#outgoing_campaign_detail_contact_id').val(),aJaxURL_contact_info_mail);
	    	    SetEvents("add_contact_info_mail", "delete_contact_info_mail", "check-all-contact_info_mail", tName+'contact_info_mail', 'add-edit-form-contact_info_mail', aJaxURL_contact_info_mail);
	    	    GetButtons("add_contact_info_phone","delete_contact_info_phone");
	    	    GetButtons("add_contact_info_mail","delete_contact_info_mail");
	    	    $('#table_contact_info_phone_length,#table_contact_info_mail_length').css('top','2px');
	    	    $('select[name="table_contact_info_phone_length"],select[name="table_contact_info_mail_length"]').css('height','19px');
	    	}
	    	if(fName=='add-edit-form-contact_info_phone'){
	    		var buttons = {
	    				"save": {
	    		            text: "შენახვა",
	    		            id: "save-dialog-contact_info-phone"
	    		        },
	    	        	"cancel": {
	    		            text: "დახურვა",
	    		            id: "cancel-dialog",
	    		            click: function () {
	    		            	$(this).dialog("close");
	    		            }
	    		        }
	    		    };
	    		GetDialog(fName, 230, "auto", buttons, 'left+43 top');

	    	}
	    	if(fName=='add-edit-form-contact_info_mail'){
	    		var buttons = {
	    				"save": {
	    		            text: "შენახვა",
	    		            id: "save-dialog-contact_info-mail"
	    		        },
	    	        	"cancel": {
	    		            text: "დახურვა",
	    		            id: "cancel-dialog",
	    		            click: function () {
	    		            	$(this).dialog("close");
	    		            }
	    		        }
	    		    };
	    		GetDialog(fName, 230, "auto", buttons, 'left+43 top');

	    	}
	    	if(fName=='add-edit-form-actived'){
	    		var buttons = {
	    				"save": {
	    					 text: "აქტივაცია",
	    			         id: "actived-btn"
	    		        },
	    	        	"cancel": {
	    		            text: "დახურვა",
	    		            id: "cancel-dialog",
	    		            click: function () {
	    		            	$(this).dialog("close");
	    		            }
	    		        }
	    		    };
	    	    GetDialog('add-edit-form-actived', 750, "auto", buttons, 'left+43 top');
	    	    
	    	    $.ajax({
	    	        url: aJusURL_Actived,
	    	        data: "act=get_user",
	    	        success: function(data) {
	    	            $("#user_id").html(data.user);
	    	            $('#chose_actived_form,#user_id,#actived_note').chosen({ search_contains: true });
	    	        }
	    	    });
	    	    LoadTable('actived_in',7,main_act,"<'F'lip>",'id='+$('#hidden_id').val(),aJusURL_Actived);
	    	    SetEvents("", "", "check-all-actived_in", tName+'actived_in', 'add-edit-form-actived1', aJusURL_Actived);
	    	}
	    	if(fName=='add-edit-form-task'){
	    		var buttons = {
	    				"save": {
	    					 text: "შენახვა",
	    			         id: "task-btn"
	    		        },
	    	        	"cancel": {
	    		            text: "დახურვა",
	    		            id: "cancel-dialog",
	    		            click: function () {
	    		            	$(this).dialog("close");
	    		            }
	    		        }
	    		    };
	    	    GetDialog('add-edit-form-task', 580, "auto", buttons, 'left+43 top');  
	    	    GetDateTimes("task_end_date1");
	    	    GetDateTimes("task_start_date1");
	    	    $('#task_type_id,#task_departament_id,#task_recipient_id,#task_controler_id,#task_priority_id,#task_status_id').chosen({ search_contains: true });
	    	}
	    	    }
		

	    $(document).on("click", "#fillter", function () {
	        operator    = $('#operator_id').val();
	    	status      = $('#tab_id').val();
	    	start_date  = $('#start_date').val();
	    	end_date    = $('#end_date').val();
	    	if($("#task_type").val() == 2){
	        	$("#table_index,#table_index_div,#table_actived,#table_actived_wrapper,#table_index_wrapper").css('display','none');
	        	$("#table_task").css('display','table');
	        	$('#add_button_task,#delete_button_task').css('display','block');
	    		LoadTable('task',12,main_act,change_colum_main,'task_status_id='+$("#tab_id").val(),aJusURL_Task);
	       	    SetEvents("add_button_task", "delete_button_task", "check-all-task", tName+'task', 'add-edit-form-task', aJusURL_Task);
	      	
	    	}else{
	        	if($("#tab_id").val() == 1){
	            	$('#table_index,#table_index_div,#table_index_wrapper').css('display','none');
	            	$('#table_actived,#table_actived_wrapper').css('display','table');
	         	   LoadTable('actived',4,main_act,change_colum_main,'status=1',aJaxURL);
	         	   SetEvents("add_button", "delete_button", "check-all", tName+'actived', 'add-edit-form-actived', aJusURL_Actived);
	        	}else{
	        		$('#table_index,#table_index_wrapper').css('display','table');
	        		$('#table_index_div').css('display','block');
	        		$('#table_actived,#table_actived_wrapper').css('display','none');
	        		gg('index',colum_number,main_act,change_colum_main,'start_date='+start_date+'&end_date='+end_date+'&status='+status+'&operator='+operator,aJaxURL);
	            	SetEvents("add_button", "delete_button", "check-all", tName+'index', dialog, aJaxURL);
	        	}
	    	}
	    });
	    
	    $(document).on("click", "#delete_button_task", function () {
	    	LoadTable('task',12,main_act,change_colum_main,'task_status_id='+$("#tab_id").val(),aJusURL_Task);
	    	setTimeout("$('#table_index_wrapper').css('display','none');", 20);
	    });
	    
	    $(document).on("change", "#tab_id", function () {
	        operator    = $('#operator_id').val();
	    	status      = $('#tab_id').val();
	    	start_date  = $('#start_date').val();
	    	end_date    = $('#end_date').val();
	    	$('#operator_id,#tab_id').trigger("chosen:updated");
	    	if($("#task_type").val() == 2){
	        	$("#table_index,#table_index_div,#table_actived,#table_actived_wrapper,#table_index_wrapper").css('display','none');
	        	$("#table_task").css('display','table');
	        	$('#add_button_task,#delete_button_task').css('display','block');
	    		LoadTable('task',12,main_act,change_colum_main,'task_status_id='+$("#tab_id").val(),aJusURL_Task);
	       	    SetEvents("add_button_task", "delete_button_task", "check-all-task", tName+'task', 'add-edit-form-task', aJusURL_Task);
	      	
	    	}else{
	    		$('#add_button_task,#delete_button_task').css('display','none');
	    		$("#table_task,#table_task_wrapper").css('display','none');
	        	if($("#tab_id").val() == 1){
	            	$('#table_index,#table_index_div,#table_index_wrapper').css('display','none');
	            	$('#table_actived,#table_actived_wrapper').css('display','table');
	         	   LoadTable('actived',4,main_act,change_colum_main,'status=1',aJaxURL);
	         	   SetEvents("add_button", "delete_button", "check-all", tName+'actived', 'add-edit-form-actived', aJusURL_Actived);
	        	}else{
	        		$('#table_index,#table_index_wrapper').css('display','table');
	        		$('#table_index_div').css('display','block');
	        		$('#table_actived,#table_actived_wrapper').css('display','none');
	        		gg('index',colum_number,main_act,change_colum_main,'start_date='+start_date+'&end_date='+end_date+'&status='+status+'&operator='+operator,aJaxURL);
	            	SetEvents("add_button", "delete_button", "check-all", tName+'index', dialog, aJaxURL);
	        	}
	    	}
	    });

	    $(document).on("click", ".callapp_refresh", function () {
	    	operator    = $('#operator_id').val();
	    	status      = $('#tab_id').val();
	    	start_date  = $('#start_date').val();
	    	end_date    = $('#end_date').val();
	    	if($('#task_type').val() == 1){
	    		if(status => 1){
	    			gg('index',colum_number,main_act,change_colum_main,'start_date='+start_date+'&end_date='+end_date+'&status='+status+'&operator='+operator,aJaxURL);
	        	    $('#table_actived_wrapper').css('display','none');
	        	}else{
	        		$('#table_index_wrapper').css('display','none');
	        	}
	        }else{
	        	LoadTable('task',12,main_act,change_colum_main,'task_status_id='+$("#tab_id").val(),aJusURL_Task);
	        	$('#table_actived_wrapper').css('display','none');
	        	$('#table_index_wrapper').css('display','none');
	        }
	    });

	    $(document).on("click", "input[name='person']", function () {
	        if($(this).val() == 2){
	        	$('#iuridiuli').css('display','table');
	        }else{
	        	$('#iuridiuli').css('display','none');
	        }
	    });
	    
	    $(document).on("click", "#save-dialog-contact_info", function () {
	    	param 			                   = new Object();
			param.act		                   = "save_contact_info";
			param.outgoing_campaign_detail_contact_id = $("#outgoing_campaign_detail_contact_id").val();
			param.outgoing_campaign_detail_id  = $("#incomming_id").val();
			param.type                         = $('input[name=person]:checked').val();
			param.person_gmpiri                = $('input[name=person_gmpiri]:checked').val();
			param.person_position              = $('#add-edit-form-contact_info #person_position').val();
			param.fname                        = $('#add-edit-form-contact_info #fname').val();
			param.lname                        = $('#add-edit-form-contact_info #lname').val();
			param.person_number                = $('#add-edit-form-contact_info #person_number').val();
			param.city_id                      = $('#add-edit-form-contact_info #city_id').val();
			param.addres                       = $('#add-edit-form-contact_info #addres').val();
			param.client_comment               = $('#add-edit-form-contact_info #client_comment').val();
			param.client_title                 = $('#add-edit-form-contact_info #client_title').val();
			param.client_number                = $('#add-edit-form-contact_info #client_number').val();

			$.ajax({
	            url: aJaxURL_contact_info,
	            data: param,
	            success: function(data) {
	                LoadTable('contact_info',6,'get_list',"<'F'lip>",'outgoing_campaign_detail_id='+$('#incomming_id').val(),aJaxURL_contact_info);
	            	$('#add-edit-form-contact_info').dialog('close');
	            	$('#table_contact_info_length').css('top','2px');
	                $('select[name="table_contact_info_length"]').css('height','19px');
	            }
	        });
	    });

	    $(document).on("click", "#save-dialog-contact_info-phone", function () {
	    	param 			                   = new Object();
			param.act		                   = "save_contact_info_phone";
			param.outgoing_campaign_detail_contact_id = $("#outgoing_campaign_detail_contact_id").val();
			param.outgoing_campaign_detail_contact_detail_id  = $("#outgoing_campaign_detail_contact_detail_id").val();
			param.contact_info_phone           = $('#contact_info_phone').val();

			$.ajax({
	            url: aJaxURL_contact_info_phone,
	            data: param,
	            success: function(data) {
	            	LoadTable('contact_info_phone',2,'get_list',"<'F'lip>",'outgoing_campaign_detail_contact_id='+$('#outgoing_campaign_detail_contact_id').val(),aJaxURL_contact_info_phone);
	                $('#add-edit-form-contact_info_phone').dialog('close');
	            	$('#table_contact_info_phone_length').css('top','2px');
	                $('select[name="table_contact_info_phone_length"]').css('height','19px');
	            }
	        });
	    });

	    $(document).on("click", "#save-dialog-contact_info-mail", function () {
	    	param 			                   = new Object();
			param.act		                   = "save_contact_info_mail";
			param.outgoing_campaign_detail_contact_id = $("#outgoing_campaign_detail_contact_id").val();
			param.outgoing_campaign_detail_contact_detail_id  = $("#outgoing_campaign_detail_contact_detail_id").val();
			param.contact_info_mail            = $('#contact_info_mail').val();

			$.ajax({
	            url: aJaxURL_contact_info_mail,
	            data: param,
	            success: function(data) {
	            	LoadTable('contact_info_mail',2,'get_list',"<'F'lip>",'outgoing_campaign_detail_contact_id='+$('#outgoing_campaign_detail_contact_id').val(),aJaxURL_contact_info_mail);
	                $('#add-edit-form-contact_info_mail').dialog('close');
	            	$('#table_contact_info_mail_length').css('top','2px');
	                $('select[name="table_contact_info_mail_length"]').css('height','19px');
	            }
	        });
	    });

	    $(document).on("click", "#task-btn", function () {
	    	param 			     = new Object();
			param.act		     = "save_task";
			param.id                    = $("#add-edit-form-task #id").val();
			param.task_type_id			= $("#add-edit-form-task #task_type_id").val();
			param.task_start_date		= $("#add-edit-form-task #task_start_date1").val();
			param.task_end_date			= $("#add-edit-form-task #task_end_date1").val();
			param.task_departament_id	= $("#add-edit-form-task #task_departament_id").val();
			param.task_recipient_id		= $("#add-edit-form-task #task_recipient_id").val();
			param.task_priority_id		= $("#add-edit-form-task #task_priority_id").val();
			param.task_controler_id		= $("#add-edit-form-task #task_controler_id").val();
			param.task_status_id		= $("#add-edit-form-task #task_status_id").val();
			param.task_description		= $("#add-edit-form-task #task_description").val();
			param.task_note			    = $("#add-edit-form-task #task_note").val();
			param.task_answer           = $("#add-edit-form-task #task_answer").val();
			
	        $.ajax({
	            url: aJusURL_Task,
	            data: param,
	            success: function(data) {
	            	LoadTable('task',12,main_act,change_colum_main,'task_status_id='+$("#tab_id").val(),aJusURL_Task);
	            	$('#add-edit-form-task').dialog('close');
	            }
	        });
	    });
	    
	    $(document).on("click", "#next_quest", function () {
	    	$('#back_quest').attr('back_id',$(".quest_body:visible").attr("id"));
	        var input_radio    = '';
	        var input_checkbox = '';
	        var input          = '';
	        var select         = '';
	        input_radio = $('#' + $(this).attr('next_id') + ' .radio_input:checked').attr('next_quest');
	        input_checkbox = $('#' + $(this).attr('next_id') + ' .check_input:checked').attr('next_quest');
	        input = $('#' + $(this).attr('next_id') + ' input[type="text"]').attr('next_quest');
	        select = $('#' + $(this).attr('next_id') + ' .hand_select').attr('next_quest');
	        
	        if(input_radio == undefined){
	        	
	        }else{
	        	$('.quest_body').css('display','none');
	        	$('#'+input_radio).css('display','block');
	        	$('#next_quest').attr('next_id',input_radio);
	        	$('#back_quest').prop('disabled',false);
	        	if(input_radio == 0){
	        		$('.last_quest').css('display','block');
	        		$('#next_quest').prop('disabled',true);
	        	}
	        }
	        if(input == undefined){
	        	
	        }else{
	            if(input==0){
	            	$('#next_quest').prop('disabled',true);
	            	$('.quest_body').css('display','none');
	            	$('.last_quest').css('display','block');
	            }else{
	            $('.quest_body').css('display','none');
	        	$('#'+input).css('display','block');
	        	$('#next_quest').attr('next_id',input);
	            }
	        }
	        if(input_checkbox == undefined){
	            
	        }else{
	        	$('.quest_body').css('display','none');
	        	$('#'+input_checkbox).css('display','block');
	        	$('#next_quest').attr('next_id',input_checkbox);
	        }
	        if(select == undefined){
	            
	        }else{
	        	$('.quest_body').css('display','none');
	        	$('#'+select).css('display','block');
	        	$('#next_quest').attr('next_id',select);
	        }
	    });

	    $(document).on("click", "#back_quest", function () {
	    	$('#next_quest').prop('disabled',false);
	    	var input_radio    = '';
	        var input_checkbox = '';
	        var input          = '';
	        var select         = '';
	    	input_radio = $('#' + $('.quest_body:visible #next_quest').attr('next_id') + ' .radio_input:checked').attr('next_quest');
	        input_checkbox = $('#' + $('.quest_body:visible #next_quest').attr('next_id') + ' .check_input:checked').attr('next_quest');
	        input = $('#' + $('.quest_body:visible #next_quest').attr('next_id') + ' input[type="text"]').attr('next_quest');
	        select = $('#' + $('.quest_body:visible #next_quest').attr('next_id') + ' .hand_select').attr('next_quest');
	        if(input_radio == undefined){
	            
	        }else{
	        	$('.quest_body').css('display','none');
	        	$('#'+input_radio).css('display','block');
	        	$('#next_quest').attr('next_id',input_radio);
	        	$('#back_quest').prop('disabled',false);
	        	if(input_radio == 0){
	        		$('.last_quest').css('display','block');
	        		$('#next_quest').prop('disabled',true);
	        	}
	        }
	        if(input == undefined){
	        	
	        }else{
	            if(input==0){
	            	$('#next_quest').prop('disabled',true);
	            }else{
	            $('.quest_body').css('display','none');
	        	$('#'+input).css('display','block');
	        	$('#next_quest').attr('next_id',input);
	            }
	        }
	        if(input_checkbox == undefined){
	            
	        }else{
	        	$('.quest_body').css('display','none');
	        	$('#'+input_checkbox).css('display','block');
	        	$('#next_quest').attr('next_id',input_checkbox);
	        }
	        if(select == undefined){
	            
	        }else{
	        	$('.quest_body').css('display','none');
	        	$('#'+select).css('display','block');
	        	$('#next_quest').attr('next_id',select);
	        }
	    	
	    	$('.quest_body,.last_quest').css('display','none');
	    	$('#'+$(this).attr('back_id')).css('display','block');
	    	$('#next_quest').attr('next_id',$(this).attr("back_id"));
	    });
	    
	    $(document).on("click", "#actived-btn", function () {


	    	if($('#chose_actived_form').val()==1){
	        
	        	param 			     = new Object();
	    		param.act		     = "save_actived";
	    		param.actived_number = $("#actived_number").val();
	    		param.user_id		 = $("#user_id").val();
	    		param.actived_note	 = $("#actived_note").val();
	    		
	            $.ajax({
	                url: aJusURL_Actived,
	                data: param,
	                success: function(data) {
	                	LoadTable('actived',colum_number,main_act,change_colum_main,'status=1',aJaxURL);
	                	$('#table_index_wrapper').css('display','none');
	                }
	            });

	    	}else{
	        	var ids = '';
	    		$("#table_actived_in .check:checked").map(function () {
	    			ids += this.value+',';
	            }).get();
	            
	    		param 			= new Object();
	    		param.act		= "save_actived_select";
	    		param.user_id	= $("#user_id").val();
	    		param.actived_note	 = $("#actived_note").val();
	    		param.id        = ids.slice(0,-1);
	            $.ajax({
	                url: aJusURL_Actived,
	                data: param,
	                success: function(data) {
	                	LoadTable('actived',colum_number,main_act,change_colum_main,'status=1',aJaxURL);
	                	$('#table_index_wrapper').css('display','none');
	                }
	            });
	    	}
	    	$('#add-edit-form-actived').dialog('close');
	    });
	    
	    function show_right_side(id){
	        $("#right_side fieldset").hide();
	        $(".add-edit-form-class #" + id).show();
	        $(".add-edit-form-task-class #" + id).show();
	        $(".add-edit-form-class").css("width", "1200");
	        $(".add-edit-form-task-class").css("width", "1200");
	        //$('#add-edit-form').dialog({ position: 'left top' });
	        hide_right_side();
	        var str = $("."+id).children('img').attr('src');
			str = str.substring(0, str.length - 4);
	        $(".add-edit-form-class ."+id).children('img').attr('src',str+'_blue.png');
	        $(".add-edit-form-class ."+id).children('div').css('color','#2681DC');
	        $(".add-edit-form-task-class ."+id).children('img').attr('src',str+'_blue.png');
	        $(".add-edit-form-task-class ."+id).children('div').css('color','#2681DC');
	    }

	    
	    function show_main(id,my_this){
	    	$("#client_main,#client_other").hide();
	    	$("#" + id).show();
	    	$(".client_main,.client_other").css('border','none');
	    	$(".client_main,.client_other").css('padding','6px');
	    	$(my_this).css('border','1px solid #ccc');
	    	$(my_this).css('border-bottom','1px solid #F9F9F9');
	    	$(my_this).css('padding','5px');
	    }

	    function client_status(id){
	    	$("#pers,#iuri").hide();
	    	$("#" + id).show();
	    }
	    
	    $(document).on("click", ".hide_said_menu", function () {
	    	$("#right_side fieldset").hide();    	
	    	$(".add-edit-form-class").css("width", "581");
	    	$(".add-edit-form-task-class").css("width", "581");
	        //$('#add-edit-form').dialog({ position: 'top' });
	        hide_right_side();
	    });

	    function hide_right_side(){
	    	$("#add-edit-form #side_menu").children('spam').children('div').css('color','#FFF');
	    	$("#add-edit-form-task #side_menu").children('spam').children('div').css('color','#FFF');
	        $(".info").children('img').attr('src','media/images/icons/info.png');
	        $(".scenar").children('img').attr('src','media/images/icons/scenar.png');
	        $(".task").children('img').attr('src','media/images/icons/task.png');
	        $(".sms").children('img').attr('src','media/images/icons/sms.png');
	        $(".mail").children('img').attr('src','media/images/icons/mail.png');
	        $(".record").children('img').attr('src','media/images/icons/record.png');
	        $(".file").children('img').attr('src','media/images/icons/file.png');
	        $("#record fieldset").show();
	    }

	    $(document).on("click", "#show_copy_prit_exel", function () {
	        if($(this).attr('myvar') == 0){
	            $('.ColVis,.dataTable_buttons').css('display','block');
	            $(this).css('background','#2681DC');
	            $(this).children('img').attr('src','media/images/icons/select_w.png');
	            $(this).attr('myvar','1');
	        }else{
	        	$('.ColVis,.dataTable_buttons').css('display','none');
	        	$(this).css('background','#E6F2F8');
	            $(this).children('img').attr('src','media/images/icons/select.png');
	            $(this).attr('myvar','0');
	        }
	    });
	    $(document).on("click", "#delete_contact_info_phone", function () {
	        LoadTable('contact_info_phone',2,'get_list',"<'F'lip>",'outgoing_campaign_detail_contact_id='+$('#outgoing_campaign_detail_contact_id').val(),aJaxURL_contact_info_phone);
	        $('#table_contact_info_phone_length,#table_contact_info_mail_length').css('top','2px');
	        $('select[name="table_contact_info_phone_length"],select[name="table_contact_info_mail_length"]').css('height','19px');
	    });
	    $(document).on("click", "#delete_contact_info_mail", function () {
	        LoadTable('contact_info_mail',2,'get_list',"<'F'lip>",'outgoing_campaign_detail_contact_id='+$('#outgoing_campaign_detail_contact_id').val(),aJaxURL_contact_info_mail);
	        $('#table_contact_info_phone_length,#table_contact_info_mail_length').css('top','2px');
	        $('select[name="table_contact_info_phone_length"],select[name="table_contact_info_mail_length"]').css('height','19px');
	    });
	    $(document).on("click", "#delete_contact_info", function () {
	    	LoadTable('contact_info',5,'get_list',"<'F'lip>",'outgoing_campaign_detail_id='+$('#incomming_id').val(),aJaxURL_contact_info);
	    	$('#table_contact_info_length,#table_contact_info_phone_length,#table_contact_info_mail_length').css('top','2px');
	        $('select[name="table_contact_info_length"],select[name="table_contact_info_phone_length"],select[name="table_contact_info_mail_length"]').css('height','19px');
	    });
	    $(document).on("click", "#add_sms", function () {
	    	param 			= new Object();
			param.act		= "send_sms";
	        $.ajax({
	            url: aJaxURL,
	            data: param,
	            success: function(data) {
	                $("#add-edit-form-sms").html(data.page);
	                $("#copy_phone,#sms_shablon,#send_sms").button();
	            }
	        });
	    	var buttons = {
		        	"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        }
			    };
	        GetDialog("add-edit-form-sms", 360, "auto", buttons);
	    });
	    
	    $(document).on("click", "#callapp_show_filter_button", function () {
	        if($('.callapp_filter_body').attr('myvar') == 0){
	        	$('.callapp_filter_body').css('display','block');
	        	$('.callapp_filter_body').attr('myvar',1);
	        }else{
	        	$('.callapp_filter_body').css('display','none');
	        	$('.callapp_filter_body').attr('myvar',0);
	        }        
	    });

	    $(document).on("dblclick", "#table_mail tbody tr", function () {
	    	var nTds = $("td", this);
	        var empty = $(nTds[0]).attr("class");

	        
	            var rID = $(nTds[0]).text();
	            
	            $.ajax({
	                url: aJusURL_mail,
	                type: "POST",
	                data: "act=send_mail&mail_id=" + rID + "&",
	                dataType: "json",
	                success: function (data) {
	                    if (typeof (data.error) != "undefined") {
	                        if (data.error != "") {
	                            alert(data.error);
	                        } else {
	                            
	                            if ($.isFunction(window.LoadDialog)) {
	                                //execute it
	                            	var buttons = {
	                        	        	"cancel": {
	                        		            text: "დახურვა",
	                        		            id: "cancel-dialog",
	                        		            click: function () {
	                        		            	$(this).dialog("close");
	                        		            }
	                        		        }
	                        		    };
	                                GetDialog("add-edit-form-mail", 640, "auto", buttons, 'center top');
	                               
	                                $("#add-edit-form-mail").html(data.page);
	                                $("#email_shablob,#choose_button_mail,#send_email").button();
	                                setTimeout(function(){ 
	                        			new TINY.editor.edit('editor',{
	                        				id:'input',
	                        				width:"580px",
	                        				height:"200px",
	                        				cssclass:'te',
	                        				controlclass:'tecontrol',
	                        				dividerclass:'tedivider',
	                        				controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
	                        				'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
	                        				'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
	                        				'font','size','|','image','hr','link','unlink','|','print'],
	                        				footer:true,
	                        				fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
	                        				xhtml:true,
	                        				bodyid:'editor',
	                        				footerclass:'tefooter',
	                        				resize:{cssclass:'resize'}
	                        			}); }, 100);
	                            }
	                        }
	                    }
	                }
	            });
	        
	    });
	    
	    $(document).on("click", "#email_shablob", function () {
	    	param 			= new Object();
			param.act		= "send_mail_shablon";
	        $.ajax({
	            url: aJusURL_mail,
	            data: param,
	            success: function(data) {
	                $("#add-edit-form-mail-shablon").html(data.page);                
	            }
	        });
	    	var buttons = {
		        	"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        }
			    };
	        GetDialog("add-edit-form-mail-shablon", 415, "auto", buttons,'center top');
		});
	    
	    $(document).on("click", "#add_mail", function () {
	    	param 			= new Object();
			param.act		= "send_mail";
			param.out_id	= $('#incomming_id').val();
	        $.ajax({
	            url: aJusURL_mail,
	            data: param,
	            success: function(data) {
	                $("#add-edit-form-mail").html(data.page);
	                $("#email_shablob,#choose_button_mail,#send_email").button();
	                
	            }
	        });
	    	var buttons = {
		        	"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        }
			    };
	        GetDialog("add-edit-form-mail", 640, "auto", buttons, 'center top');
	        setTimeout(function(){ 
				new TINY.editor.edit('editor',{
					id:'input',
					width:"580px",
					height:"200px",
					cssclass:'te',
					controlclass:'tecontrol',
					dividerclass:'tedivider',
					controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
					'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
					'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
					'font','size','|','image','hr','link','unlink','|','print'],
					footer:true,
					fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
					xhtml:true,
					bodyid:'editor',
					footerclass:'tefooter',
					resize:{cssclass:'resize'}
				}); }, 100);
	    });

	    function pase_body(id,head,real_id,file_id,file_date,file_real_name,file_rand_name){
	        $('#mail_text').val(head);
	        $("#mail_shabl_id").val(real_id);
	    	$("iframe").contents().find("body").html($('#'+id).html());
	    	$('#add-edit-form-mail-shablon').dialog('close');
	    	$("#paste_files1").html('<div id="first_div">'+file_date+'</div><div id="two_div">'+file_real_name+'</div><div id="tree_div" onclick="download_file(\''+file_rand_name+'\',\''+file_real_name+'\')">ჩამოტვირთვა</div><div id="for_div" onclick="delete_file1(\''+file_id+'\')">-</div>');
	    }

	    $(document).on("click", "#send_email", function () {
			  	param 			= new Object();

			  	param.mail_shabl_id     = $("#mail_shabl_id").val();
			  	param.source_id         = $("#source_id").val();
		    	param.address		    = $("#mail_address").val();
		    	param.cc_address		= $("#mail_address1").val();
		    	param.bcc_address		= $("#mail_address2").val();
		    	
		    	param.subject			= $("#mail_text").val();
		    	param.send_mail_id	    = $("#send_email_hidde").val();
				param.incomming_call_id	= $("#sms_inc_increm_id").val();
				param.body				= $("iframe").contents().find("body").html();
				
		    	$.ajax({
				        url: aJaxURL_getmail,
					    data: param,
					   
				        success: function(data) {
							if(data.status=='true'){
								alert('შეტყობინება წარმატებით გაიგზავნა!');
								$("#mail_text").val('');
								$("iframe").contents().find("body").html('');
								$("#file_div_mail").html('');
								CloseDialog("add-edit-form-mail");
								LoadTable('mail',5,'get_list_mail',"<'F'lip>",'out_id='+$('#incomming_id').val(),aJaxURL);
							}else{
								alert('შეტყობინება არ გაიგზავნა!');
								LoadTable('mail',5,'get_list_mail',"<'F'lip>",'out_id='+$('#incomming_id').val(),aJaxURL);
							}
						}
				    });
				});
	    
	    function listen(file){ 
	        var url = 'http://'+location.hostname+':8000/' + file;
	        $("audio source").attr('src',url);
	        $("audio").load();
	    }
	    
	    $(document).on("click", "#choose_button_mail", function () {
		    $("#choose_mail_file").click();
		});

	    $(document).on("change", "#choose_mail_file", function () {
	        var file_url  = $(this).val();
	        var file_name = this.files[0].name;
	        var file_size = this.files[0].size;
	        var file_type = file_url.split('.').pop().toLowerCase();
	        var path	  = "../../media/uploads/file/";

	        if($.inArray(file_type, ['pdf','png','xls','xlsx','jpg','docx','doc','csv']) == -1){
	            alert("დაშვებულია მხოლოდ 'pdf', 'png', 'xls', 'xlsx', 'jpg', 'docx', 'doc', 'csv' გაფართოება");
	        }else if(file_size > '15728639'){
	            alert("ფაილის ზომა 15MB-ზე მეტია");
	        }else{
	        	$.ajaxFileUpload({
			        url: "server-side/upload/file.action.php",
			        secureuri: false,
	     			fileElementId: "choose_mail_file",
	     			dataType: 'json',
				    data: {
						act: "file_upload",
						button_id: "choose_mail_file",
						table_name: 'outgoing',
						file_name: Math.ceil(Math.random()*99999999999),
						file_name_original: file_name,
						file_type: file_type,
						file_size: file_size,
						path: path,
						table_id: $("#incomming_id").val(),

					},
			        success: function(data) {			        
				        if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								var tbody = '';
								for(i = 0;i <= data.page.length;i++){
									tbody += "<div id=\"first_div\">" + data.page[i].file_date + "</div>";
									tbody += "<div id=\"two_div\">" + data.page[i].name + "</div>";
									tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "','"+data.page[i].name+"')\">ჩამოტვირთვა</div>";
									tbody += "<div id=\"for_div\" onclick=\"delete_file1('" + data.page[i].id + "')\">-</div>";
									$("#paste_files1").html(tbody);								
								}							
							}						
						}					
				    }
			    });
	        }
	    });
	    
	    $(document).on("click", "#upload_file", function () {
		    $('#file_name').click();
		});
	    $(document).on("change", "#file_name", function () {
	        var file_url  = $(this).val();
	        var file_name = this.files[0].name;
	        var file_size = this.files[0].size;
	        var file_type = file_url.split('.').pop().toLowerCase();
	        var path	  = "../../media/uploads/file/";

	        if($.inArray(file_type, ['pdf','png','xls','xlsx','jpg','docx','doc','csv']) == -1){
	            alert("დაშვებულია მხოლოდ 'pdf', 'png', 'xls', 'xlsx', 'jpg', 'docx', 'doc', 'csv' გაფართოება");
	        }else if(file_size > '15728639'){
	            alert("ფაილის ზომა 15MB-ზე მეტია");
	        }else{
	        	$.ajaxFileUpload({
			        url: "server-side/upload/file.action.php",
			        secureuri: false,
	     			fileElementId: "file_name",
	     			dataType: 'json',
				    data: {
						act: "file_upload",
						button_id: "file_name",
						table_name: 'outgoing',
						file_name: Math.ceil(Math.random()*99999999999),
						file_name_original: file_name,
						file_type: file_type,
						file_size: file_size,
						path: path,
						table_id: $("#hidden_id").val(),

					},
			        success: function(data) {			        
				        if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								var tbody = '';
								for(i = 0;i <= data.page.length;i++){
									tbody += "<div id=\"first_div\">" + data.page[i].file_date + "</div>";
									tbody += "<div id=\"two_div\">" + data.page[i].name + "</div>";
									tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "','"+data.page[i].name+"')\">ჩამოტვირთვა</div>";
									tbody += "<div id=\"for_div\" onclick=\"delete_file('" + data.page[i].id + "', 'outgoing')\">-</div>";
									$("#add-edit-form #paste_files").html(tbody);
								}							
							}						
						}					
				    }
			    });
	        }
	    });

	    $(document).on("click", "#upload_file1", function () {
		    $('#file_name1').click();
		});
	    $(document).on("change", "#file_name1", function () {
	        var file_url  = $(this).val();
	        var file_name = this.files[0].name;
	        var file_size = this.files[0].size;
	        var file_type = file_url.split('.').pop().toLowerCase();
	        var path	  = "../../media/uploads/file/";

	        if($.inArray(file_type, ['pdf','png','xls','xlsx','jpg','docx','doc','csv']) == -1){
	            alert("დაშვებულია მხოლოდ 'pdf', 'png', 'xls', 'xlsx', 'jpg', 'docx', 'doc', 'csv' გაფართოება");
	        }else if(file_size > '15728639'){
	            alert("ფაილის ზომა 15MB-ზე მეტია");
	        }else{
	            var id = '';
	            if($("#id").val() == ''){
	                id = $("#id_inc").val();
	            }else{
	                id = $("#id").val();
	            }
	        	$.ajaxFileUpload({
			        url: "server-side/upload/file.action.php",
			        secureuri: false,
	     			fileElementId: "file_name1",
	     			dataType: 'json',
				    data: {
						act: "file_upload",
						button_id: "file_name1",
						table_name: 'task',
						file_name: Math.ceil(Math.random()*99999999999),
						file_name_original: file_name,
						file_type: file_type,
						file_size: file_size,
						path: path,
						table_id: id,

					},
			        success: function(data) {			        
				        if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								var tbody = '';
								for(i = 0;i <= data.page.length;i++){
									tbody += "<div id=\"first_div\">" + data.page[i].file_date + "</div>";
									tbody += "<div id=\"two_div\">" + data.page[i].name + "</div>";
									tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "','"+data.page[i].name+"')\">ჩამოტვირთვა</div>";
									tbody += "<div id=\"for_div\" onclick=\"delete_file('" + data.page[i].id + "', 'task')\">-</div>";
									$("#add-edit-form-task #paste_files").html(tbody);
								}							
							}						
						}					
				    }
			    });
	        }
	    });

	    function download_file(file,original_name){
	        var download_file	= "media/uploads/file/"+file;
	    	var download_name 	= original_name;
	    	SaveToDisk(download_file, download_name);
	    }

	    function delete_file1(id){
	    	$.ajax({
	            url: "server-side/upload/file.action.php",
	            data: "act=delete_file&file_id="+id+"&table_name=outgoing",
	            success: function(data) {
	               
	            	var tbody = '';
	            	if(data.page.length == 0){
	            		$("#paste_files1").html('');
	            	};
					for(i = 0;i <= data.page.length;i++){
						tbody += "<div id=\"first_div\">" + data.page[i].file_date + "</div>";
						tbody += "<div id=\"two_div\">" + data.page[i].name + "</div>";
						tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "','"+data.page[i].name+"')\">ჩამოტვირთვა</div>";
						tbody += "<div id=\"for_div\" onclick=\"delete_file('" + data.page[i].id + "')\">-</div>";
						$("#add-edit-form #paste_files1").html(tbody);
					}	
	            }
	        });
	    }
	    
	    function delete_file(id,tbl){
	    	$.ajax({
	            url: "server-side/upload/file.action.php",
	            data: "act=delete_file&file_id="+id+"&table_name="+tbl,
	            success: function(data) {
	               
	            	var tbody = '';
	            	if(data.page.length == 0){
	            		$("#add-edit-form #paste_files").html('');
	            		$("#add-edit-form-task #paste_files").html('');
	            	}else{
	    				for(i = 0;i <= data.page.length;i++){
	    					tbody += "<div id=\"first_div\">" + data.page[i].file_date + "</div>";
	    					tbody += "<div id=\"two_div\">" + data.page[i].name + "</div>";
	    					tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "','"+data.page[i].name+"')\">ჩამოტვირთვა</div>";
	    					tbody += "<div id=\"for_div\" onclick=\"delete_file('" + data.page[i].id + "','"+tbl+"')\">-</div>";
	    					$("#add-edit-form-task #paste_files").html(tbody);
	    					$("#add-edit-form #paste_files").html(tbody);
	    				}
	            	}
	            }
	        });
	    }

	    function SaveToDisk(fileURL, fileName) {
//	         // for non-IE
//	         if (!window.ActiveXObject) {
//	             var save = document.createElement('a');
//	             save.href = fileURL;
//	             save.target = '_blank';
//	             save.download = fileName || 'unknown';

//	             var event = document.createEvent('Event');
//	             event.initEvent('click', true, true);
//	             save.dispatchEvent(event);
//	             (window.URL || window.webkitURL).revokeObjectURL(save.href);
//	         }
//	 	     // for IE
//	         else if ( !! window.ActiveXObject && document.execCommand)     {
//	             var _window = window.open(fileURL, "_blank");
//	             _window.document.close();
//	             _window.document.execCommand('SaveAs', true, fileName || fileURL)
//	             _window.close();
//	         }
	    	var iframe = document.createElement("iframe"); 
	        iframe.src = fileURL; 
	        iframe.style.display = "none"; 
	        document.body.appendChild(iframe);
	        return false;
	    }

	    $(document).on("click", "#send_sms", function (fName) {
		    param 			= new Object();

		    param.sms_hidde_id		= sms_id;
	    	param.phone			= $("#sms_phone").val();
	    	param.text			= $("#sms_text").val();
	    	param.sms_inc_increm_id	= $("#sms_inc_increm_id").val();
	    	
	    	 $.ajax({
			        url: aJaxURL_send_sms,
				    data: param,
			        success: function(data) {
	                    $("#sms_text").val('');
	                    alert('SMS წარმატებით გაიგზავნა');
	                    CloseDialog("sms_dialog");
				    }
			    });
	 	    });
	    
	    $(document).on("click", ".open_dialog", function () {
	    	var queoue = $($(this).siblings())[0];
	    	queoue = $(queoue).text();
	        $.ajax({
	            url: aJaxURL,
	            type: "POST",
	            data: "act=get_edit_page&id=&open_number=" + $(this).text() + "&queue=" + queoue,
	            dataType: "json",
	            success: function (data) {
	                if (typeof (data.error) != "undefined") {
	                    if (data.error != "") {
	                        alert(data.error);
	                    } else {
	                        $("#add-edit-form").html(data.page); 
	                    	LoadDialog('add-edit-form');
	                    }
	                }
	            }
	        });        
	    });
	    
	    $(document).on("click", "#show_all_scenario", function () {
	    	if($(this).attr('who') == 0){            
	            //$('#scenar').css('overflow-y','scroll');
	            $('.quest_body').css('display','block');
	            $('#next_quest').prop('disabled', true);
	            $(this).attr('who',1);
	            $('#show_all_scenario span').text('სცენარის მიხედვით');
	            $('#back_quest,#next_quest').css('display','none');
	            $('.quest_body').attr('style','min-height: 170px;border: 1px solid #CCCCCC;padding: 0 10px;float: left;margin-right: 5px;width: 260px;margin-top: 5px;');
	            $('.myhr,.last_quest').css('display','none');
	            }else{
	            	$('#next_quest').attr('next_id',$('.1').attr('id'));
	            	$('.quest_body').attr('style','');
	            	//$('#scenar').css('overflow-y','visible');
	                $('.quest_body').css('display','none');
	                $('.1').css('display','block');
	                $('#next_quest').prop('disabled', false);
	                $(this).attr('who',0);
	                $('#show_all_scenario span').text('ყველას ჩვენება');
	                $('#back_quest,#next_quest').css('display','block');
	                $('.myhr').css('display','block');
	            }
	    });

	    $(document).on("click", "#save-dialog", function () {
			   
			param 				= new Object();
			param.act			= "save_incomming";
				
			// --------------------------------------------------
			var items          = {};
	    	var checker        = {};
	    	var inp_checker    = {};
	    	var radio_checker  = {};
	    	var date_checker   = {};
	    	var date_date_checker = {};
	    	var select ={};
	    	
	    	$('#add-edit-form .check_input:checked').each(function() {
		    	
	    		key      = this.name;
	    		value    = this.value;
	    		ansver_val    = $(this).attr('ansver_val');
	    		
	    		checker[key] = checker[key] + "," + value;

	    	});
	    	
	    	items.checker = checker;
	    	
	        $('#add-edit-form .inputtext').each(function() {
		    	
	    		inp_key      = this.id;
	    		inp_value    = this.value;
	    		inp_q_id     = $(this).attr('q_id');
	    		
	    	    if(inp_value != ''){
	    		 inp_checker[inp_key] = inp_checker[inp_key] + "," + inp_value;
	    	    }
	    	});
	    	
	    	items.input   = inp_checker;

	        $('#dialog-form .radio_input:checked').each(function() {
		    	
	    		radio_key      = this.name;
	    		radio_value    = this.value;
	    		ansver_val     = $(this).attr('ansver_val');
	    		
	    		radio_checker[radio_key] = checker[radio_key] + "," + radio_value;

	    	});
	    	
	    	items.radio = radio_checker;

	        $('#add-edit-form .date_input').each(function() {
		    	
	        	date_key      = this.id;
	    		date_value    = this.value;
	    	    if(date_value != ''){
	    	    	date_checker[date_key] = date_checker[date_key] + "," + date_value;
	    	    }
	    	});
	    	
	    	items.date   = date_checker;

	        $('#add-edit-form .date_time_input').each(function() {
		    	
	        	date_time_key      = this.id;
	        	date_time_value    = this.value;
	    	    if(date_time_value != ''){
	    	    	date_date_checker[date_time_key] = date_date_checker[date_time_key] + "," + date_time_value;
	    	    }
	    	});
	    	
	    	items.date_time   = date_date_checker;

	        $('#add-edit-form .hand_select').each(function() {

		    	//alert($("option:selected",this).val());
	        	select_key      = this.id;
	        	select_value    = $("option:selected",this).val();
	    		
	        	select[select_key] = select[select_key] + "," + select_value;

	    	});
	    	
	    	items.select_op   = select;

			//----------------------------------------------------
			
			// Incomming Vars
	    	param.incomming_id          = $("#add-edit-form #incomming_id").val();
			param.incomming_date        = $("#add-edit-form #incomming_date").val();
			param.incomming_date_up		= $("#add-edit-form #incomming_date_up").val();
			param.call_comment		    = $("#add-edit-form #call_comment").val();
			param.call_res              = $("#add-edit-form #call_res").val();
			param.outgoing_status       = $("#add-edit-form #outgoing_status").val();

			// Incomming Client Vars
			param.client_status			= $('#add-edit-form input[name=client_status]:checked').val();
			param.client_person_number	= $("#add-edit-form #client_person_number").val();
			param.client_person_lname	= $("#add-edit-form #client_person_lname").val();
			param.client_person_fname	= $("#add-edit-form #client_person_fname").val();
			param.client_person_phone1	= $("#add-edit-form #client_person_phone1").val();
			param.client_person_phone2	= $("#add-edit-form #client_person_phone2").val();
			param.client_person_mail1	= $("#add-edit-form #client_person_mail1").val();
	    	param.client_person_mail2	= $("#add-edit-form #client_person_mail2").val();
	    	param.client_person_addres1	= $("#add-edit-form #client_person_addres1").val();
			param.client_person_addres2	= $("#add-edit-form #client_person_addres2").val();
			param.client_person_note	= $("#add-edit-form #client_person_note").val();
			param.call_back             = $("#add-edit-form #call_back").val();
			
			param.client_number			= $("#add-edit-form #client_number").val();
			param.client_name	        = $("#add-edit-form #client_name").val();
			param.client_phone1			= $("#add-edit-form #client_phone1").val();
			param.client_phone2			= $("#add-edit-form #client_phone2").val();
			param.client_mail1	        = $("#add-edit-form #client_mail1").val();
			param.client_mail2			= $("#add-edit-form #client_mail2").val();
			param.client_note			= $("#add-edit-form #client_note").val();
			param.info1			        = $("#add-edit-form #info1").val();

			param.task_type_id			= $("#add-edit-form #task_type_id").val();
			param.task_start_date		= $("#add-edit-form #task_start_date").val();
			param.task_end_date			= $("#add-edit-form #task_end_date").val();
			param.task_departament_id	= $("#add-edit-form #task_departament_id").val();
			param.task_recipient_id		= $("#add-edit-form #task_recipient_id").val();
			param.task_priority_id		= $("#add-edit-form #task_priority_id").val();
			param.task_controler_id		= $("#add-edit-form #task_controler_id").val();
			param.task_status_id		= $("#add-edit-form #task_status_id").val();
			param.task_description		= $("#add-edit-form #task_description").val();
			param.task_note			    = $("#add-edit-form #task_note").val();
			
			var link = GetAjaxData(param);		
		    	$.ajax({
			        url: aJaxURL,
				    data: link + "&checker=" + JSON.stringify(items.checker) + "&input=" + JSON.stringify(items.input)  + "&radio=" + JSON.stringify(items.radio) + "&date=" + JSON.stringify(items.date) + "&date_time=" + JSON.stringify(items.date_time) + "&select_op=" + JSON.stringify(items.select_op),
			        success: function(data) {       
						if(typeof(data.error) != "undefined"){
							if(data.error != ""){
								alert(data.error);
							}else{
								gg('index',colum_number,main_act,change_colum_main,'task_type='+$('#task_type').val()+'&status='+$('#tab_id').val()+'&operator='+<?php echo $_SESSION['USERID'];?>,aJaxURL);
							    CloseDialog("add-edit-form");
							}
						}
			    	}
			   });
		});

	    $(document).on("click", ".playthis", function () {
	    	str = $(this).attr('clickvalue');
	    	play(str);
	    });
	    $(document).on("change", "#chose_actived_form", function () {
	        if($(this).val()==2){
	            $('#raodenoba').css('display','none');
	        }else{
	     	    $('#raodenoba').css('display','block');
	        }
	    });
	    function imnote(id){
	        if($("#imnote_"+id).css('display')=='none'){
	            $("#imnote_"+id).css('display','table-cell');
	        }else{
	        	$("#imnote_"+id).css('display','none');
	        }
	    }

	    function runAjax() {
	        $.ajax({
	        	async: false,
	        	dataType: "html",
	            url: 'AsteriskManager/liveStatemini.php',
	            data: 'sesvar=hideloggedoff&value=true&stst=1',
	            success: function(data) {
	        		$("#flesh_panel_table_mini").html(data);						
	            }
	        }).done(function(data) {
	        setTimeout(runAjax, 1000);
	        });
		}
	    function play(str){
	    	$('audio').each(function(){
	    	    this.pause(); // Stop playing
	    	    this.currentTime = 0; // Reset time
	    	});
	    	var buttons = {
	            	"cancel": {
	    	            text: "დახურვა",
	    	            id: "cancel-dialog",
	    	            click: function () {
	    	            	$('audio').each(function(){
	    	            	    this.pause(); // Stop playing
	    	            	    this.currentTime = 0; // Reset time
	    	            	}); 
	    	            	$(this).dialog("close");
	    	            }
	    	        }
	    	    };
	    	GetDialog("play_audio", 325, "auto", buttons);

	    	$('#play_audio audio source').attr('src','http://212.72.155.176:8000/'+str);
	    	$('#play_audio audio').load();
	    }
	   
    </script>
    <style type="text/css">
        #table_right_menu{
            top: 42px;
        }        
        #example tr td{
        	word-wrap: break-word;
            white-space: normal;
        }
    </style>
</head>

<body>
<div id="tabs" style="width: 155.5%;">
<div class="callapp_head">გამავალი რეპორტი<hr class="callapp_head_hr"></div>

<table id="table_right_menu" style="top: 29px;">
<tr>
<td ><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>
    <table class="display" id="example">
        <thead>
            <tr id="datatable_header">
                <th>ID</th>
                <th style="width: 20%;">პროექტი</th>
                <th style="width: 25%;">თარიღი</th>
                <th style="width: 100%;">კომპანია</th>
                <th style="width: 100%;">საქმიანობის სფერო</th>
                <th style="width: 100%;">სტატუსი</th>
                <th style="width: 100%;">ზარის შესახებ</th>
                <th style="width: 100%;">დარეკვის შედეგი</th>
                <th style="width: 100%;">K1. IVR ჩაირთო?</th>
                <th style="width: 100%;">K2. მისალმება  და კითხვა კომპეტენტურ პირზე</th>
                <th style="width: 100%;">K3. კომუნიკაციის არხები</th>
                <th style="width: 100%;">K4. ქოლცენტრი აქვთ?</th>
                <th style="width: 100%;">K5. შეთავაზება და დაინტერესება</th>
                <th style="width: 100%;">K6. მაინც არ გვეუბნება?</th>
                <th style="width: 100%;">K7. იქნებ მეილი გვითხრათ და შეთავაზებას გადმოგიგზავნით</th>
                <th style="width: 100%;">K8. შეხვედრის თარიღი და დრო</th>
                <th style="width: 100%;">K9. განმეორებითი ზარის თარიღი და დრო</th>
                <th style="width: 100%;">K10. იქნებ დამაკავშიროთ:</th>
                <th style="width: 100%;">K11. დასასრული</th>
            </tr>
        </thead>
        <thead>
            <tr class="search_header">
                <th class="colum_hidden">
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
            </tr>
        </thead>
    </table>

    
<!-- jQuery Dialog -->
<div  id="add-edit-form" class="form-dialog" title="გამავალი ზარი">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-sms" class="form-dialog" title="ახალი SMS">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-mail" class="form-dialog" title="ახალი E-mail">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-mail-shablon" class="form-dialog" title="E-mail შაბლონი">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-actived" class="form-dialog" title="პირის აქტივაცია">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-task" class="form-dialog" title="დავალება">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-contact_info" class="form-dialog" title="საკონტაქტო ინფორმაცია">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-contact_info_phone" class="form-dialog" title="ტელეფონი">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-contact_info_mail" class="form-dialog" title="ელ-ფოსტა">
</div>
<!-- jQuery Dialog -->
<div  id="play_audio" class="form-dialog" title="მოსმენა">
    <audio controls autoplay>
      <source src="" type="audio/wav">
    </audio>
</div>
</body>
</html>


