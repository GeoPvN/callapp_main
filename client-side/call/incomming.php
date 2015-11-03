<head>
<style type="text/css">
 
</style>
<script type="text/javascript">
    var aJaxURL           = "server-side/call/incomming.action.php";
    var aJaxURL_send_sms = "includes/sendsms.php";
    var tName             = "table_";
    var dialog            = "add-edit-form";
    var colum_number      = 9;
    var main_act          = "get_list";
    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
     
    $(document).ready(function () {
    	GetButtons("add_button","delete_button");
    	LoadTable('index',colum_number,main_act,change_colum_main);
    	SetEvents("add_button", "delete_button", "", tName+'index', dialog, aJaxURL);
    	$('#operator_id,#tab_id').chosen({ search_contains: true });
    	$('.callapp_filter_body').css('display','none');
    	GetDate('start_date');
    	GetDate('end_date');

    	    $.session.clear(); 
    	    runAjax();
    });

    function LoadTable(tbl,col_num,act,change_colum){
    	GetDataTable(tName+tbl, aJaxURL, act, col_num, "", 0, "", 1, "asc", '', change_colum);
    	setTimeout(function(){
	    	$('.ColVis, .dataTable_buttons').css('display','none');
	    	}, 50);
    }
    
    function LoadDialog(fName){
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
        GetDialog(fName, 575, "auto", buttons, 'left+43 top');
        LoadTable('sms',5,'get_list',"<'F'lip>");
        LoadTable('mail',5,'get_list',"<'F'lip>");
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

    $(document).on("click", ".callapp_refresh", function () {
    	LoadTable('index',colum_number,main_act,change_colum_main);
    });
    
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
        //alert(input_radio);
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
    });

    $(document).on("click", "#back_quest", function () {
    	$('#next_quest').prop('disabled',false);
    	$('#next_quest').attr('next_id',$(".quest_body:visible").attr("id"));
    	
    	var str = $(".quest_body:visible").attr("class");
    	if(str == undefined){
    		var res = parseInt($(this).attr('back_id')) + 1;
    	}else{
    		var res = str.replace("quest_body ", "");
    	}
    	back_id = (res-1);
    	if(back_id<1){
    		back_id = 1;
    		$('#back_quest').prop('disabled',true);
    	}
    	$('.quest_body,.last_quest').css('display','none');
    	$('.'+back_id).css('display','block');
    });

    $(document).on("change", "#operator_id", function () {
        if($(this).val() != 0){
            $.session.set("operator_id", "on");
        }else{
            $.session.remove('operator_id');
        }
    	my_filter();
    });
    $(document).on("change", "#tab_id", function () {
    	if($(this).val() != 0){
    	    $.session.set("tab_id", "on");
    	}else{
            $.session.remove('tab_id');
        }
    	my_filter();
    });
    $(document).on("click", "close", function () {
        var id = $(this).attr('cl');
        $.session.remove($(this).attr('cl'));
        $( "#"+id ).click();
        my_filter();
    });
    $(document).on("click", "#filter_1", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_1", "on");
    	}else{
    		$.session.remove('filter_1');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_2", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_2", "on");
    	}else{
    		$.session.remove('filter_2');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_3", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_3", "on");
    	}else{
    		$.session.remove('filter_3');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_4", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_4", "on");
    	}else{
    		$.session.remove('filter_4');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_5", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_5", "on");
    	}else{
    		$.session.remove('filter_5');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_6", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_6", "on");
    	}else{
    		$.session.remove('filter_6');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_7", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_7", "on");
    	}else{
    		$.session.remove('filter_7');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_8", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_8", "on");
    	}else{
    		$.session.remove('filter_8');
    	}
    	my_filter();
    });
    $(document).on("click", "#filter_9", function () {
    	if ($(this).is(':checked')) {
    	    $.session.set("filter_9", "on");
    	}else{
    		$.session.remove('filter_9');
    	}
    	my_filter();
    });

    function my_filter(){
    	var myhtml = '';
    	if($.session.get("operator_id")=='on'){
    		myhtml += '<span>ოპერატორი<close cl="operator_id">X</close></span>';
    	}
    	if($.session.get("tab_id")=='on'){
    		myhtml += '<span>ტაბი<close cl="tab_id">X</close></span>';
    	}
    	if($.session.get("filter_1")=='on'){
    		myhtml += '<span>შე. დამუშავებული<close cl="filter_1">X</close></span>';
    	}
    	if($.session.get("filter_2")=='on'){
    		myhtml += '<span>შე. დაუმუშავებელი<close cl="filter_2">X</close></span>';
    	}
    	if($.session.get("filter_3")=='on'){
    		myhtml += '<span>შე. უპასუხო<close cl="filter_3">X</close></span>';
    	}
    	if($.session.get("filter_4")=='on'){
    		myhtml += '<span>გა. დამუშავებული<close cl="filter_4">X</close></span>';
    	}
    	if($.session.get("filter_5")=='on'){
    		myhtml += '<span>გა. დაუმუშავებელი<close cl="filter_5">X</close></span>';
    	}
    	if($.session.get("filter_6")=='on'){
    		myhtml += '<span>გა. უპასუხო<close cl="filter_6">X</close></span>';
    	}
    	if($.session.get("filter_7")=='on'){
    		myhtml += '<span>ში. დამუშავებული<close cl="filter_7">X</close></span>';
    	}
    	if($.session.get("filter_8")=='on'){
    		myhtml += '<span>ში. დაუმუშავებელი<close cl="filter_8">X</close></span>';
    	}
    	if($.session.get("filter_9")=='on'){
    		myhtml += '<span>ში. უპასუხო<close cl="filter_9">X</close></span>';
    	}
    	$('.callapp_tabs').html(myhtml);
    }
    
    function show_right_side(id){
        $("#right_side fieldset").hide();
        $("#" + id).show();
        $(".add-edit-form-class").css("width", "1200");
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
    	$(my_this).css('border-bottom','1px solid #F1F1F1');
    	$(my_this).css('padding','5px');
    }

    function client_status(id){
    	$("#pers,#iuri").hide();
    	$("#" + id).show();
    }
    
    $(document).on("click", ".hide_said_menu", function () {
    	$("#right_side fieldset").hide();    	
    	$(".add-edit-form-class").css("width", "575");
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
        	$(this).css('background','#E6F2F8');
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
        var url = location.origin + "/records/" + file;
        $("audio source").attr('src',url);
        $("audio").load();
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
                    LoadTable1_1();
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
    
    $(document).on("click", "#show_flesh_panel", function () {
        //$('#flesh_panel').css('width','425px');
        $( "#flesh_panel" ).animate({
            width: "425px"
          }, 1000 );
        $('#show_flesh_panel').attr('src','media/images/icons/arrow_right.png');
        $('#show_flesh_panel').attr('id','show_flesh_panel_right');
        $('#flesh_panel_table_mini').css('display','none');
        $('#flesh_panel_table').css('display','block');
        $('#flesh_panel').css('z-index','99');
        $('#show_flesh_panel_right').attr('title','პანელის დაპატარევება');
    });
    $(document).on("click", "#show_flesh_panel_right", function () {
        //$('#flesh_panel').css('width','150px');
        $( "#flesh_panel" ).animate({
            width: "150px"
          }, 300 );
        $('#show_flesh_panel_right').attr('src','media/images/icons/arrow_left.png');
        $('#show_flesh_panel_right').attr('id','show_flesh_panel');
        $('#flesh_panel_table').css('display','none');
        $('#flesh_panel_table_mini').css('display','block');
        $('#flesh_panel').css('z-index','99');
        $('#show_flesh_panel').attr('title','პანელის გადიდება');
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
		param.inc_status_id         = $("#inc_status_id").val();

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
		param.client_addres1        = $("#client_addres1").val();
		param.client_addres2        = $("#client_addres2").val();

		param.task_type_id			= $("#task_type_id").val();
		param.task_start_date		= $("#task_start_date").val();
		param.task_end_date			= $("#task_end_date").val();
		param.task_departament_id	= $("#task_departament_id").val();
		param.task_recipient_id		= $("#task_recipient_id").val();
		param.task_priority_id		= $("#task_priority_id").val();
		param.task_controler_id		= $("#task_controler_id").val();
		param.task_status_id		= $("#task_status_id").val();
		param.task_description		= $("#task_description").val();
		param.task_note			    = $("#task_note").val();
		
		var link = GetAjaxData(param);		
	    	$.ajax({
		        url: aJaxURL,
			    data: link + "&checker=" + JSON.stringify(items.checker) + "&input=" + JSON.stringify(items.input)  + "&radio=" + JSON.stringify(items.radio) + "&date=" + JSON.stringify(items.date) + "&date_time=" + JSON.stringify(items.date_time) + "&select_op=" + JSON.stringify(items.select_op),
		        success: function(data) {       
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							alert(data.error);
						}else{
							LoadTable('index',colum_number,main_act,change_colum_main);
						    CloseDialog("add-edit-form");
						}
					}
		    	}
		   });
	});
    function runAjax() {    	
        $.ajax({
        	async: false,
        	dataType: "html",
	        url: 'AsteriskManager/liveState.php',
		    data: 'sesvar=hideloggedoff&value=true&stst=1',
	        success: function(data) {
				$("#flesh_panel_table").html(data);	
				$.ajax({
		        	async: false,
		        	dataType: "html",
			        url: 'AsteriskManager/liveStatemini.php',
				    data: 'sesvar=hideloggedoff&value=true&stst=1',
			        success: function(data) {
						$("#flesh_panel_table_mini").html(data);						
				    }
		        });
		    }
        }).done(function(data) { 
            setTimeout(runAjax, 1000);
        });        
	}
</script>
<style type="text/css">
.callapp_tabs{
	margin-top: 5px;
	margin-bottom: 5px;
	float: right;
	width: 100%;
	height: 43px;
}
.callapp_tabs span{
	color: #FFF;
    border-radius: 5px;
    padding: 5px;
	float: left;
	margin: 0 3px 0 3px;
	background: #2681DC;
	font-weight: bold;
	font-size: 11px;
    margin-bottom: 2px;
}

.callapp_tabs span close{
	cursor: pointer;
	margin-left: 5px;
}

.callapp_head{
	font-family: pvn;
	font-weight: bold;
	font-size: 20px;
	color: #2681DC;
}
.callapp_head_hr{
	border: 1px solid #2681DC;
}
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
	height: 83px;
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
	top: -17px;
}
.callapp_filter_header{
	color: #2681DC;
	font-family: pvn;
	font-weight: bold;
}

.ColVis, .dataTable_buttons{
	z-index: 50;
}
#flesh_panel{
    height: 630px;
    width: 150px;
    position: absolute;
    top: 0;
    padding: 15px;
    right: 2px;
	z-index: 49;
	background: #FFF;
}
#table_sms_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_sms_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_sms_paginate{
	margin: 0;
}
#table_mail_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_mail_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_mail_paginate{
	margin: 0;
}
</style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">შემომავალი ზარი<span class="callapp_refresh"><img alt="refresh" src="media/images/icons/refresh.png" height="14" width="14">   განახლება</span><hr class="callapp_head_hr"></div>
<div class="callapp_tabs">

</div>
<div class="callapp_filter_show">
<button id="callapp_show_filter_button">ფილტრი v</button>
    <div class="callapp_filter_body" myvar="0">
    <div style="float: left; width: 292px;">
        <span>
        <label for="start_date" style="margin-left: 110px;">-დან</label>
        <input class="callapp_filter_body_span_input" type="text" id="start_date" style="width: 100px;">
        </span>
        <span>
        <label for="end_date" style="margin-left: 110px;">-მდე</label>
        <input class="callapp_filter_body_span_input" type="text" id="end_date" style="width: 100px;">
        </span>
        <span style="margin-top: 15px;">
        <select id="operator_id" style="width: 285px;">
        <option value="0">ყველა ოპერატორი</option>
        <option>დათო პაპალაშვილი</option>
        </select>
        </span>
        <span style="margin-top: 15px;">
        <select id="tab_id" style="width: 285px;">
        <option value="0">ყველა ზარი</option>
        <option value="1">გადაცემულია გასარკვევად</option>
        <option value="2">გარკვევის პროცესშია</option>
        <option value="3">დასრულებულია</option>
        </select>
        </span>
    </div>
    <div style="float: left; width: 170px; margin-left: 20px;">
        <span >
        <div class="callapp_filter_header"><img alt="inc" src="media/images/icons/inc_call.png" height="14" width="14">  შემომავალი ზარი</div>
        </span>
        <span style="margin-left: 15px">        
        <label for="filter_1">დამუშავებული</label>
        <input class="callapp_filter_body_span_input" id="filter_1" type="checkbox">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_2" style="">დაუმუშავებელი</label>
        <input class="callapp_filter_body_span_input" id="filter_2" type="checkbox">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_3">უპასუხო</label>
        <input class="callapp_filter_body_span_input" id="filter_3" type="checkbox">
        </span>        
        </div>
    <div style="float: left; width: 170px;">
        <span >
        <div class="callapp_filter_header"><img alt="out" src="media/images/icons/out_call.png" height="14" width="14">  გამავალი ზარი</div>
        </span>
        <span style="margin-left: 15px">
        <label for="filter_4">დამუშავებული</label>
        <input class="callapp_filter_body_span_input" id="filter_4" type="checkbox">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_5">დაუმუშავებელი</label>
        <input class="callapp_filter_body_span_input" id="filter_5" type="checkbox">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_6">უპასუხო</label>
        <input class="callapp_filter_body_span_input" id="filter_6" type="checkbox">
        </span>
        
        </div>
    <div style="float: left; width: 145px;">
        <span>
        <div class="callapp_filter_header"><img alt="inner" src="media/images/icons/inner_call_1.png" height="14" width="14">  შიდა ზარი</div>
        </span>
        <span style="margin-left: 15px">        
        <label for="filter_7">დამუშავებული</label>
        <input class="callapp_filter_body_span_input" id="filter_7" type="checkbox">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_8">დაუმუშავებელი</label>
        <input class="callapp_filter_body_span_input" id="filter_8" type="checkbox">
        </span>
        <span style="margin-left: 15px">
        <label for="filter_9">უპასუხო</label>
        <input class="callapp_filter_body_span_input" id="filter_9" type="checkbox">
        </span>
    </div>
</div>
<table id="table_right_menu">
<tr>
<td><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>

<table class="display" id="table_index">
    <thead>
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width: 20px;">№</th>
            <th style="width: 50px;">თარიღი</th>
            <th style="width: 13%;">ტელეფონი</th>
            <th style="width: 20%;">სახელი</th>
            <th style="width: 25%;">კატეგორია 1</th>
            <th style="width: 25%;">კატეგორია 1_1</th>            
            <th style="width: 25%;">კატეგორია 1_1_1</th>
            <th style="width: 50%;">კომენტარი</th>
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
                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
            </th>            
        </tr>
    </thead>
</table>
</div>
<style>
#flesh_panel_table, #flesh_panel_table_mini{
	box-shadow: 0px 0px 7px #888888;
}
#flesh_panel_table{
	display: none;
	
}
#flesh_panel_table td, #flesh_panel_table_mini td {
	height: 25px;	
	vertical-align: middle;
	text-align: left;
	padding: 0 5px;
	background: #FFF;
	width: 100%;
}
.tb_head td{
	border-right: 1px solid #E6E6E6;	
}
#show_flesh_panel,#show_flesh_panel_right{
    float: left;
	cursor: pointer;
}
.td_center{
    text-align: center !important;
}
</style>
<div id="flesh_panel">
<div class="callapp_head" style="text-align: right;"><img id="show_flesh_panel" title="პანელის გადიდება" alt="arrow" src="media/images/icons/arrow_left.png" height="18" width="18">ქოლ-ცენტრი<hr class="callapp_head_hr"></div>
<table id="flesh_panel_table">
</table>
<table id="flesh_panel_table_mini">
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

</body>