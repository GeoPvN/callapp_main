<head>
<style type="text/css">
 
</style>
<script type="text/javascript">
    var aJaxURL           = "server-side/call/outgoing/outgoing_tab0.action.php";
    var aJusURL_Actived   = "server-side/call/outgoing/outgoing_actived.action.php";
    var aJaxURL_send_sms  = "includes/sendsms.php";
    var tName             = "table_";
    var dialog            = "add-edit-form";
    var colum_number      = 8;
    var main_act          = "get_list";
    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
     
    $(document).ready(function () {
    	param 			= new Object();
		param.act		= "ststus";
		param.type      = 1;
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                $("#tab_id").html(data.page);
                $("#operator_id").html(data.user);
                $('#operator_id,#tab_id').trigger("chosen:updated");
            }
        }).done(function() {
    	GetButtons("add_button","delete_button");
    	if($("#tab_id").val() == 1){
        	$('#table_index').css('display','none');
     	   LoadTable('actived',4,main_act,change_colum_main,'status=1',aJaxURL);
     	   SetEvents("add_button", "delete_button", "check-all", tName+'actived', 'add-edit-form-actived', aJusURL_Actived);
    	}else{
    		$('#table_actived').css('display','none');
    		LoadTable('index',colum_number,main_act,change_colum_main,'status=2&operator='+<?php echo $_SESSION['USERID'];?>,aJaxURL);
        	SetEvents("add_button", "delete_button", "check-all", tName+'index', dialog, aJaxURL);
    	}
    	$('#operator_id,#tab_id,#task_type').chosen({ search_contains: true });
    	$('.callapp_filter_body').css('display','none');
    	GetDate('start_date');
    	GetDate('end_date');

    	    $.session.clear();
    	    
        });
    });

    function LoadTable(tbl,col_num,act,change_colum,custom_param,URL){
    	GetDataTable(tName+tbl, URL, act, col_num, custom_param, 0, "", 1, "asc", '', change_colum);
    	setTimeout(function(){
	    	$('.ColVis, .dataTable_buttons').css('display','none');
	    	}, 50);
    }
    
    function LoadDialog(fName){
if(fName=='add-edit-form'){
    	var buttons = {
				"save": {
		            text: "შენახვა",
		            id: "save-dialog"
		        },
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
        LoadTable('mail',5,'get_list',"<'F'lip>",'',aJaxURL);
        $("#client_checker,#add_sms,#add_mail,#show_all_scenario").button();
        GetDate2("date_input");
        GetDate1("task_end_date");
        GetDate1("task_start_date");
		GetDateTimes1("date_time_input");
		$('.quest_body').css('display','none');
		$('.1').css('display','block');
		$('#next_quest').attr('next_id',$('.1').attr('id'));
		$('#next_quest, #back_quest').button();
		$('#back_quest').prop('disabled',true);
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
    GetDialog('add-edit-form-actived', 225, "auto", buttons, 'left+43 top');
    
    $.ajax({
        url: aJusURL_Actived,
        data: "act=get_user",
        success: function(data) {
            $("#user_id").html(data.user);
        }
    });
    LoadTable('actived_in',7,main_act,"<'F'lip>",'id='+$('#hidden_id').val(),aJusURL_Actived);
    SetEvents("", "", "check-all-actived", tName+'actived', 'add-edit-form-actived', aJusURL_Actived);
}
    }


    $(document).on("change", "#incomming_cat_1", function () {
    	param 			= new Object();
		param.act		= "cat_2";
		param.cat_id    = $('#incomming_cat_1').val();
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                $("#incomming_cat_1_1").html(data.page);
            }
        });
    });
    $(document).on("change", "#incomming_cat_1_1", function () {
    	param 			= new Object();
		param.act		= "cat_3";
		param.cat_id    = $('#incomming_cat_1_1').val();
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                $("#incomming_cat_1_1_1").html(data.page);
            }
        });
    });

    $(document).on("change", "#task_type", function () {
    	param 			= new Object();
		param.act		= "ststus";
		param.type      = $(this).val();
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                $("#tab_id").html(data.page);
                $('#operator_id,#tab_id').trigger("chosen:updated");
            }
        });
    });

    $(document).on("click", "#fillter", function () {
        operator    = $('#operator_id').val();
    	status      = $('#tab_id').val();
    	start_date  = $('#start_date').val();
    	end_date    = $('#end_date').val();
    	if($("#tab_id").val() == 1){
        	$('#table_index,#table_index_wrapper').css('display','none');
        	$('#table_actived,#table_actived_wrapper').css('display','block');
     	   LoadTable('actived',4,main_act,change_colum_main,'status=1',aJaxURL);
     	   SetEvents("add_button", "delete_button", "check-all", tName+'actived', 'add-edit-form-actived', aJusURL_Actived);
    	}else{
    		$('#table_index,#table_index_wrapper').css('display','block');
    		$('#table_actived,#table_actived_wrapper').css('display','none');
    		LoadTable('index',colum_number,main_act,change_colum_main,'start_date='+start_date+'&end_date='+end_date+'&status='+status+'&operator='+operator,aJaxURL);
        	SetEvents("add_button", "delete_button", "check-all", tName+'index', dialog, aJaxURL);
    	}
    });
    
    $(document).on("click", ".callapp_refresh", function () {
    	operator    = $('#operator_id').val();
    	status      = $('#tab_id').val();
    	start_date  = $('#start_date').val();
    	end_date    = $('#end_date').val();
    	LoadTable('index',colum_number,main_act,change_colum_main,'start_date='+start_date+'&end_date='+end_date+'&status='+status+'&operator='+operator,aJaxURL);
    });
    
    $(document).on("click", "#next_quest", function () {
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
        }
        if(input == undefined){
        	
        }else{
            if(input==0){
            	$('#next_quest').prop('disabled',true);
            }else{
        	
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
    	$('#next_quest').attr('next_id',$(".quest_body:visible").attr("id"));
    	
    	var str = $(".quest_body:visible").attr("class");
    	var res = str.replace("quest_body ", "");
    	back_id = (res-1);
    	if(back_id<1){
    		back_id = 1;
    		$('#back_quest').prop('disabled',true);
    	}
    	$('.quest_body').css('display','none');
    	$('.'+back_id).css('display','block');
    });
    
    $(document).on("click", "#actived-btn", function () {


    	if($('#chose_actived_form').val()==1){
        
        	param 			     = new Object();
    		param.act		     = "save_actived";
    		param.actived_number = $("#actived_number").val();
    		param.user_id		 = $("#user_id").val();
    		
            $.ajax({
                url: aJusURL_Actived,
                data: param,
                success: function(data) {
                	LoadTable('actived',7,main_act,"<'F'lip>",'',aJusURL_Actived);
                	LoadTable('index',colum_number,main_act,change_colum_main,'status=1',aJaxURL);
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
    		param.id        = ids.slice(0,-1);
            $.ajax({
                url: aJusURL_Actived,
                data: param,
                success: function(data) {
                	LoadTable('actived',7,main_act,"<'F'lip>",'',aJusURL_Actived);
                	LoadTable('index',colum_number,main_act,change_colum_main,'status=1',aJaxURL);
                }
            });
    	}
    });
    
    function show_right_side(id){
        $("#right_side fieldset").hide();
        $("#" + id).show();
        $(".add-edit-form-class").css("width", "1210");
        //$('#add-edit-form').dialog({ position: 'left top' });
        hide_right_side();
        var str = $("."+id).children('img').attr('src');
		str = str.substring(0, str.length - 4);
        $("."+id).children('img').attr('src',str+'_blue.png');
        $("."+id).children('div').css('color','#2681DC');
    }

    function hide_right_side(){
    	$("#side_menu").children('spam').children('div').css('color','#FFF');
        $(".info").children('img').attr('src','media/images/icons/info.png');
        $(".scenar").children('img').attr('src','media/images/icons/scenar.png');
        $(".task").children('img').attr('src','media/images/icons/task.png');
        $(".sms").children('img').attr('src','media/images/icons/sms.png');
        $(".mail").children('img').attr('src','media/images/icons/mail.png');
        $(".record").children('img').attr('src','media/images/icons/record.png');
        $(".file").children('img').attr('src','media/images/icons/file.png');
        $("#record fieldset").show();
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
        //$('#add-edit-form').dialog({ position: 'top' });
        hide_right_side();
    });

    $(document).on("click", "#show_copy_prit_exel", function () {
        if($(this).attr('myvar') == 0){
            $('.ColVis,.dataTable_buttons').css('display','block');
            $(this).css('background','#2681DC');
            $(this).children('img').attr('src','media/images/icons/select_w.png');
            $(this).attr('myvar','1');
        }else{
        	$('.ColVis,.dataTable_buttons').css('display','none');
        	$(this).css('background','#FAFAFA');
            $(this).children('img').attr('src','media/images/icons/select.png');
            $(this).attr('myvar','0');
        }
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
    
    $(document).on("click", "#add_mail", function () {
    	param 			= new Object();
		param.act		= "send_mail";
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                $("#add-edit-form-mail").html(data.page);
                $("#copy_phone,#sms_shablon,#send_mail").button();
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
        GetDialog("add-edit-form-mail", 610, "auto", buttons);
    });

    function listen(file){
        var url = location.origin + "/records/" + file
        $("audio source").attr('src',url)
    }
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
					table_name: 'incomming_call',
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
								tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "')\">ჩამოტვირთვა</div>";
								tbody += "<div id=\"for_div\" onclick=\"delete_file('" + data.page[i].id + "')\">-</div>";
								$("#paste_files").html(tbody);
							}							
						}						
					}					
			    }
		    });
        }
    });

    function download_file(file){
        var download_file	= "media/uploads/file/"+file;
    	var download_name 	= file;
    	SaveToDisk(download_file, download_name);
    }
    
    function delete_file(id){
    	$.ajax({
            url: "server-side/upload/file.action.php",
            data: "act=delete_file&file_id="+id+"&table_name=incomming_call",
            success: function(data) {
               
            	var tbody = '';
            	if(data.page.length == 0){
            		$("#paste_files").html('');
            	};
				for(i = 0;i <= data.page.length;i++){
					tbody += "<div id=\"first_div\">" + data.page[i].file_date + "</div>";
					tbody += "<div id=\"two_div\">" + data.page[i].name + "</div>";
					tbody += "<div id=\"tree_div\" onclick=\"download_file('" + data.page[i].rand_name + "')\">ჩამოტვირთვა</div>";
					tbody += "<div id=\"for_div\" onclick=\"delete_file('" + data.page[i].id + "')\">-</div>";
					$("#paste_files").html(tbody);
				}	
            }
        });
    }

    function SaveToDisk(fileURL, fileName) {
        // for non-IE
        if (!window.ActiveXObject) {
            var save = document.createElement('a');
            save.href = fileURL;
            save.target = '_blank';
            save.download = fileName || 'unknown';

            var event = document.createEvent('Event');
            event.initEvent('click', true, true);
            save.dispatchEvent(event);
            (window.URL || window.webkitURL).revokeObjectURL(save.href);
        }
	     // for IE
        else if ( !! window.ActiveXObject && document.execCommand)     {
            var _window = window.open(fileURL, "_blank");
            _window.document.close();
            _window.document.execCommand('SaveAs', true, fileName || fileURL)
            _window.close();
        }
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
        $('#scenar').css('overflow-y','scroll');
        $('.quest_body').css('display','block');
        $('#next_quest').prop('disabled', true);
        $(this).attr('who',1);
        $('#show_all_scenario span').text('დამალვა');
        }else{
        	$('#scenar').css('overflow-y','visible');
            $('.quest_body').css('display','none');
            $('.1').css('display','block');
            $('#next_quest').prop('disabled', false);
            $(this).attr('who',0);
            $('#show_all_scenario span').text('ყველას ჩვენება');
        }
    });

    $(document).on("click", "#save-dialog", function () {
		   
		param 				= new Object();
		param.act			= "save_incomming";
	    	
		param.id					= $("#hidden_id").val();
			
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
    	param.incomming_id          = $("#incomming_id").val();
		param.hidden_id				= $("#hidden_id").val();
		param.incomming_phone		= $("#incomming_phone").val();
		param.incomming_date        = $("#incomming_date").val();
		param.incomming_cat_1		= $("#incomming_cat_1").val();
		param.incomming_cat_1_1		= $("#incomming_cat_1_1").val();
		param.incomming_cat_1_1_1	= $("#incomming_cat_1_1_1").val();
		param.incomming_comment		= $("#incomming_comment").val();
		param.scenario_id           = $("#scenario_id").val();

		// Incomming Client Vars
		param.client_status			= $('input[name=client_status]:checked').val();
		param.client_person_number	= $("#client_person_number").val();
		param.client_person_lname	= $("#client_person_lname").val();
		param.client_person_fname	= $("#client_person_fname").val();
		param.client_person_phone1	= $("#client_person_phone1").val();
		param.client_person_phone2	= $("#client_person_phone2").val();
		param.client_person_mail1	= $("#client_person_mail1").val();
    	param.client_person_mail2	= $("#client_person_mail2").val();
    	param.client_person_addres1	= $("#client_person_addres1").val();
		param.client_person_addres2	= $("#client_person_addres2").val();
		param.client_person_note	= $("#client_person_note").val();
		
		param.client_number			= $("#client_number").val();
		param.client_name	        = $("#client_name").val();
		param.client_phone1			= $("#client_phone1").val();
		param.client_phone2			= $("#client_phone2").val();
		param.client_mail1	        = $("#client_mail1").val();
		param.client_mail2			= $("#client_mail2").val();
		param.client_note			= $("#client_note").val();
		
		var link = GetAjaxData(param);		
	    	$.ajax({
		        url: aJaxURL,
			    data: link + "&checker=" + JSON.stringify(items.checker) + "&input=" + JSON.stringify(items.input)  + "&radio=" + JSON.stringify(items.radio) + "&date=" + JSON.stringify(items.date) + "&date_time=" + JSON.stringify(items.date_time) + "&select_op=" + JSON.stringify(items.select_op),
		        success: function(data) {       
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							alert(data.error);
						}else{
							LoadTable('index',colum_number,main_act,change_colum_main,'',aJaxURL);
						    CloseDialog("add-edit-form");
						}
					}
		    	}
		   });
	});

    
    $(document).on("change", "#chose_actived_form", function () {
        if($(this).val()==1){
        	$('#select_number').css('display','none');
        	$('#rando_number').css('display','block');
        	$('.add-edit-form-actived-class').css('width','225px');
        }else{
        	$('#select_number').css('display','block');
        	$('#rando_number').css('display','none');
        	$('.add-edit-form-actived-class').css('width','750px');
        }
    });
</script>
<style type="text/css">
.callapp_refresh{
    padding: 5px;
    border-radius:3px;
    color:#FFF;
    background: #9AAF24;
    float: right;
    font-size: 13px;
    cursor: pointer;
}
.callapp_filter_show{
	margin-bottom: 50px;
	float: right;
	width: 100%;
}
.callapp_filter_show button{
    margin-bottom: 10px;
	border: none;
    background-color: white;
	color: #2681DC;
	font-weight: bold;
	cursor: pointer;
}
.callapp_filter_body{
	width: 100%;
	height: 25px;
	padding: 5px;
	margin-bottom: 0px;
}
.callapp_filter_body span {
	float: left;
    margin-right: 10px;
	height: 22px;
}
.callapp_filter_body span label {
	color: #555;
    font-weight: bold;
	margin-left: 20px;
}
.callapp_filter_body_span_input {
	position: relative;
	top: -13px;
}
.callapp_filter_header{
	color: #2681DC;
	font-family: pvn;
	font-weight: bold;
}
#table_right_menu{
    position: relative;
    float: right;
    width: 70px;
    top: 28px;
	z-index: 50;
	border: 1px solid #E6E6E6;
	padding: 4px;
}

.ColVis, .dataTable_buttons{
	z-index: 50;
}
#table_sms_length,
#table_mail_length,
#table_actived_in_length
{
	position: inherit;
    width: 0px;
	float: left;
}
#table_sms_length label select,
#table_mail_length label select,
#table_actived_in_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_sms_paginate,
#table_mail_paginate,
#table_actived_in_paginate{
	margin: 0;
}

#fillter:HOVER {
	color: #FFF;
	background: #2681DC;
}
</style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">გამავალი ზარი<span class="callapp_refresh"><img alt="refresh" src="media/images/icons/refresh.png" height="14" width="14">   განახლება</span><hr class="callapp_head_hr"></div>

<div class="callapp_filter_show">
<button id="callapp_show_filter_button">ფილტრი v</button>
    <div class="callapp_filter_body" myvar="0">
    <div style="float: left; width: 100%;">
        <span>
        <label for="start_date" style="margin-left: 110px;">-დან</label>
        <input class="callapp_filter_body_span_input" type="text" id="start_date" style="width: 100px;">
        </span>
        <span>
        <label for="end_date" style="margin-left: 110px;">-მდე</label>
        <input class="callapp_filter_body_span_input" type="text" id="end_date" style="width: 100px;">
        </span>
        <span>
        <select id="task_type" style="width: 130px;">
        <option value="1">გამავალი</option>
        <option value="2">დავალება</option>
        </select>
        </span>
        <span>
        <select id="tab_id" style="width: 240px;">
        </select>
        </span>
        <span>
        <select id="operator_id" style="width: 240px;">
        </select>
        </span>
        <span>
        <button id="fillter" style="padding: 2px 4px 4px 4px; border: 1px solid; margin: 0;">გაფილტვრა</button>
        </span>
        
    </div>
</div>
<table id="table_right_menu">
<tr>
<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;background:#2681DC;"><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;"><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td style="cursor: pointer;padding: 4px;" id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>

<table class="display" id="table_index">
    <thead>
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width: 20px;">№</th>
            <th style="width: 100%;">თარიღი</th>
            <th style="width: 100%;">ტელეფონი 1</th>
            <th style="width: 100%;">ტელეფონი 2</th>
            <th style="width: 100%;">სახელი გვარი</th>
            <th style="width: 100%;">პირადი ნომერი</th>
            <th style="width: 100%;">პასუხისმგებელი პირი</th>
            <th class="check" style="width: 20px;"></th>
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
                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
            </th>                         
            <th>
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_phone" value="ფილტრი" class="search_init" />
            </th>
            <th>
            	<div class="callapp_checkbox">
                    <input type="checkbox" id="check-all" name="check-all" />
                    <label for="check-all"></label>
                </div>
            </th>
        </tr>
    </thead>
</table>
<table class="display" id="table_actived">
    <thead>
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width: 20px;">№</th>
            <th style="width: 100%;">შექმნის თარიღი</th>
            <th style="width: 100%;">პროექტის სახელი</th>
            <th class="check" style="width: 20px;"></th>
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
                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
            </th>
            <th>
            	<div class="callapp_checkbox">
                    <input type="checkbox" id="check-all" name="check-all" />
                    <label for="check-all"></label>
                </div>
            </th>
        </tr>
    </thead>
</table>
</div>

<!-- jQuery Dialog -->
<div  id="add-edit-form" class="form-dialog" title="შემომავალი ზარი">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-sms" class="form-dialog" title="ახალი SMS">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-mail" class="form-dialog" title="ახალი E-mail">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-actived" class="form-dialog" title="პირის აქტივაცია">
</div>

</body>