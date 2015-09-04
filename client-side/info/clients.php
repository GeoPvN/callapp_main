<head>
<style type="text/css">

</style>
<script type="text/javascript">
    var aJaxURL           = "server-side/info/clients.action.php";
    var aJaxURL_object    = "server-side/info/project.action.php";
    var aJaxURL_client    = "server-side/info/sub_clients.action.php";
    var aJaxURL_sub_project    = "server-side/info/sub_project.action.php";
    var aJaxURL_send_sms  = "includes/sendsms.php";
    var tbName1			  = "tabs1";
    var tName             = "table_";
    var dialog            = "add-edit-form";
    var colum_number      = 6;
    var main_act          = "get_list";
    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
   
    $(document).ready(function () {
        
    	GetButtons("add_button","delete_button");
    	LoadTable('index',colum_number,main_act,change_colum_main);
    	SetEvents("add_button", "delete_button", "", tName+'index', dialog, aJaxURL);
    	
    });

    function LoadTable(tbl,col_num,act,change_colum){
        
        client_id	= $("#hidden_client_id").val();
        project_id	= $("#hidden_project_id").val();
        
    	GetDataTable(tName+tbl, aJaxURL, act, col_num, "client_id="+client_id+"&project_id="+project_id, 0, "", 1, "desc", '', change_colum);
    	setTimeout(function(){
    		$('.ColVis, .dataTable_buttons').css('display','none');
    	}, 10);
    }
    
    function LoadDialog(fName){
    	switch(fName){
			case "add-edit-form":
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
		        GetDialog(fName, 789, "auto", buttons, 'left top');
		        GetTabs(tbName1);
		        
		  
		        $(document).on("tabsactivate", "#tabs1", function() {
		        	var tab = GetSelectedTab(tbName1);
		            console.log(tab);
			        if(tab==1){
				       
			        	$("#right_side fieldset").hide();
			        	$(".add-edit-form-class").css("width", "789");
			            //$('#add-edit-form').dialog({ position: 'top' });
			            hide_right_side();
				    }
		        });
		        LoadTable('project',5,'get_list_project',"<'scrol_table1't>");
		        LoadTable('client',6,'get_list_person',"<'scrol_table't>");
		        SetEvents("add_project", "delete_project", "", tName+'project', "add-edit-form-project", aJaxURL_object);
		        SetEvents("add_client", "delete_client", "", tName+'client', "add-edit-form-client", aJaxURL_client);
		        $("#choose_button, #client_check, #add_client, #delete_client, #add_project, #delete_project").button(); 
	       break;
		   case "add-edit-form-project":
		    	var buttons = {
						"save": {
				            text: "შენახვა",
				            id: "save-project"
				        },
			        	"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				            	$(this).dialog("close");
				            }
				        }
				    };
		        GetDialog("add-edit-form-project", 401, "auto", buttons, 'left top');
		        LoadTable('number',5,'get_list_number',"<'scrol_table2't>");
		        SetEvents("add_number", "delete_number", "", tName+'number', "add-edit-form-number", aJaxURL_sub_project);
		        $("#add_number, #delete_number").button(); 
		        GetDate1('project_add_date');
		   break;
		   case "add-edit-form-client":
		    	var buttons = {
						"save": {
				            text: "შენახვა",
				            id: "save-client_person"
				        },
			        	"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				            	$(this).dialog("close");
				            }
				        }
				    };
		        GetDialog("add-edit-form-client", 500, "auto", buttons, 'left top');
		   break;
		   case "add-edit-form-number":
		    	var buttons = {
						"save": {
				            text: "შენახვა",
				            id: "save-number"
				        },
			        	"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				            	$(this).dialog("close");
				            }
				        }
				    };
		        GetDialog("add-edit-form-number", 370, "auto", buttons, 'left top');
		   break;  
		}
    }
    
    function show_right_side(id){
        $("#right_side fieldset").hide();
        $("#" + id).show();
        $(".add-edit-form-class").css("width", "1244");
        hide_right_side();
        var str = $("."+id).children('img').attr('src');
		str = str.substring(0, str.length - 4);
        $("."+id).children('img').attr('src',str+'_blue.png');
        $("."+id).children('div').css('color','#2681DC');
        GetDate1('add_date');
    	GetDate1('contract_start_date');
    	GetDate1('contract_end_date');
    }
    
    function show_right_side1(id){
        $("#right_side_project fieldset").hide();
        $("#" + id).show();
        $(".add-edit-form-project-class").css("width", "900");
        //$('#add-edit-form').dialog({ position: 'left top' });
        hide_right_side1();
        var str = $("."+id).children('img').attr('src');
		str = str.substring(0, str.length - 4);
        $("."+id).children('img').attr('src',str+'_blue.png');
        $("."+id).children('div').css('color','#2681DC');
    }
    
    function hide_right_side(){
    	$("#side_menu").children('spam').children('div').css('color','#FFF');
        $(".info").children('img').attr('src','media/images/icons/info.png');
        $(".task").children('img').attr('src','media/images/icons/task.png');
        $(".sms").children('img').attr('src','media/images/icons/sms.png');
        $(".mail").children('img').attr('src','media/images/icons/mail.png');
        $(".record").children('img').attr('src','media/images/icons/record.png');
        $(".file").children('img').attr('src','media/images/icons/file.png');
    }
    function hide_right_side1(){
    	$("#side_menu1").children('spam').children('div').css('color','#FFF');
        $(".phone").children('img').attr('src','media/images/icons/info.png');
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
    	$(".add-edit-form-class").css("width", "789");
        //$('#add-edit-form').dialog({ position: 'top' });
        hide_right_side();
    });
    $(document).on("click", "#hide_said_menu_number", function () {
    	$("#right_side_project fieldset").hide();
    	$(".add-edit-form-project-class").css("width", "401");
        //$('#add-edit-form').dialog({ position: 'top' });
        hide_right_side1();
    });

    $(document).on("click", "#show_copy_prit_exel", function () {
        
        if($(this).attr('myvar') == 0){
            $('.ColVis,.dataTable_buttons,#table_right_menu_content').css('display','block');
            $(this).css('background','#2681DC');
            $(this).children('img').attr('src','media/images/icons/select_w.png');
            $(this).attr('myvar','1');
        }else{
        	$('.ColVis,.dataTable_buttons,#table_right_menu_content').css('display','none');
        	$(this).css('background','#FFF');
            $(this).children('img').attr('src','media/images/icons/select.png');
            $(this).attr('myvar','0');
        }
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
					table_name: 'client_contract',
					file_name: Math.ceil(Math.random()*99999999999),
					file_name_original: file_name,
					file_type: file_type,
					file_size: file_size,
					path: path,
					table_id: $("#hidden_clientcontract_id").val(),

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
    //ufload image//
    $(document).on("click", "#choose_button", function () {
	    $("#choose_file").click();
	});
    $(document).on("change", "#choose_file", function () {
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
     			fileElementId: "choose_file",
     			dataType: 'json',
			    data: {
					act: "file_upload",
					button_id: "choose_file",
					table_name: 'client',
					file_name: Math.ceil(Math.random()*99999999999),
					file_name_original: file_name,
					file_type: file_type,
					file_size: file_size,
					path: path,
					table_id: $("#hidden_client_id").val(),

				},
		        success: function(data) {			        
			        if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
							$("#upload_img").attr("src", "media/uploads/images/worker/" + data.name);
							console.log(data.page[1].name)	;					
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
            data: "act=delete_file&file_id="+id+"&table_name=client_contract",
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

    // Add - Save
	$(document).on("click", "#save-dialog", function () {
		param = new Object();

        //Action
    	param.act	= "save_client";

	    param.id				= $("#hidden_id").val();

	    param.identity_code		= $("#identity_code").val();
	    param.client_name		= $("#client_name").val();
	    param.jurid_address		= $("#jurid_address").val();
	    param.fact_address		= $("#fact_address").val();

	    //კონტრაქტი//
	    param.contract_number		= $("#contract_number").val();
	    param.add_date				= $("#add_date").val();
	    param.contract_start_date	= $("#contract_start_date").val();
	    param.contract_end_date		= $("#contract_end_date").val();
	    param.contract_price		= $("#contract_price").val();
	    param.angarish_period		= $("#angarish_period").val();
	    param.angarish_period1		= $("#angarish_period1").val();

	    //დოკუმენტი//
	    param.invois			= $("input[id='invois']:checked").val();
	    param.migeba_chabareba	= $("input[id='migeba_chabareba']:checked").val();
	    param.angarishfaqtura	= $("input[id='angarishfaqtura']:checked").val();
	   
	   
	   if(param.identity_code == ""){
			alert("შეავსეთ საიდენტიპიკაციო კოდი!");
		}else if(param.client_name == ""){
			alert("შეავსეთ  დასახელება!");
		}else{
		    $.ajax({
		        url: aJaxURL,
			    data: param,
		        success: function(data) {
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							alert(data.error);
						}else{
							LoadTable('index',colum_number,main_act,change_colum_main);
							$("#add-edit-form").dialog("close");
						}
					}
			    }
		    });
		}

	});

	$(document).on("click", "#save-client_person", function () {
		param = new Object();

        //Action
    	param.act	= "save-client_person";

	    param.hidden_client_id	= $("#hidden_client_id").val();
	    param.hidden_id	= $("#person_hidden_id").val();
	    
	    param.person_name		= $("#person_name").val();
	    param.person_surname	= $("#person_surname").val();
	    param.person_posityon	= $("#person_posityon").val();
	    param.person_mobile		= $("#person_mobile").val();
		param.person_phone		= $("#person_phone").val();
	    param.person_comment	= $("#person_comment").val();
	    
	   
	   
	   if(param.person_name == ""){
			alert("შეავსეთ სახელი!");
		}else{
		    $.ajax({
		        url: aJaxURL_client,
			    data: param,
		        success: function(data) {
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							alert(data.error);
						}else{
							LoadTable('client',6,'get_list_person',"<'scrol_table't>");
							$("#add-edit-form-client").dialog("close");
						}
					}
			    }
		    });
		}

	});
	$(document).on("click", "#save-project", function () {
		param = new Object();

        //Action
    	param.act	= "save-project";

	    param.hidden_client_id	= $("#hidden_client_id").val();
	    param.project_hidden_id	= $("#project_hidden_id").val();
	    
	    param.project_name		= $("#project_name").val();
	    param.project_type		= $("#project_type").val();
	    param.project_add_date	= $("#project_add_date").val();
	   
	    
	   
	   
	   if(param.person_name == ""){
			alert("შეავსეთ სახელი!");
		}else{
		    $.ajax({
		        url: aJaxURL_object,
			    data: param,
		        success: function(data) {
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							alert(data.error);
						}else{
							
							 LoadTable('project',5,'get_list_project',"<'scrol_table1't>");
							$("#add-edit-form-project").dialog("close");
						}
					}
			    }
		    });
		}

	});

	$(document).on("click", "#save-number", function () {
		param = new Object();

        //Action
    	param.act	= "save-number";

	    param.number_hidden_id	= $("#number_hidden_id").val();
	    
	    param.hidden_project_id	= $("#hidden_project_id").val();
	    
	    param.project_number	= $("#project_number").val();
	    param.project_queue		= $("#project_queue").val();
	    
	   
	    
	   
	   
	   if(param.person_name == ""){
			alert("შეავსეთ სახელი!");
		}else{
		    $.ajax({
		        url: aJaxURL_sub_project,
			    data: param,
		        success: function(data) {
					if(typeof(data.error) != "undefined"){
						if(data.error != ""){
							alert(data.error);
						}else{
							LoadTable('number',5,'get_list_number',"<'scrol_table2't>");
							$("#add-edit-form-number").dialog("close");
						}
					}
			    }
		    });
		}

	});
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
	float: right;
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
	height: 60px;
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
.scrol_table{
	overflow-y: scroll;
	height: 175px;
}
.scrol_table1{
	overflow-y: scroll;
	height: 298px;
}
.scrol_table2{
	overflow-y: scroll;
	height: 195px;
}
#table_right_menu{
    position: relative;
    float: right;
    width: 70px;
    top: 28px;
	z-index: 99;
	border: 1px solid #E6E6E6;
	padding: 4px;
}
#table_right_menu_content{
	display: none;
	height: 200px;
	width: 130px;
	position: absolute;
	background: #FFF;
	top: 163px;
	left: 900px;
	border: 1px solid #E6E6E6;
	border-left: none;
	border-radius: 0px 5px 5px 0px;
	z-index: 1;
}
.ColVis, .dataTable_buttons{
	z-index: 2;
}
#flesh_panel{
	height: 630px;
	width: 395px;
	background: #FFF;
    position: absolute;
    top: 0;
    left: 925px;
	padding: 15px;
}
</style>
</head>

<body>
	<div id="tabs" style="width: 90%;">
		<div class="callapp_head">კლიენტები<span class="callapp_refresh">
			<img alt="refresh" src="media/images/icons/refresh.png" height="14" width="14">განახლება</span><hr class="callapp_head_hr">
		</div>
		
		<div class="callapp_tabs">
		</div>
		
		<div class="callapp_filter_show">
		
			<button id="add_button">დამატება</button>
			<button id="delete_button">წაშლა</button>
		  
			<table style="margin-top: 10px;" id="table_right_menu">
				<tr>
					<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;background:#2681DC;">
						<img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
					</td>
					<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;">
						<img alt="log" src="media/images/icons/log.png" height="14" width="14">
					</td>
					<td style="cursor: pointer;padding: 4px;" id="show_copy_prit_exel" myvar="0">
						<img alt="link" src="media/images/icons/select.png" height="14" width="14">
					</td>
				</tr>
			</table>
		
			<table class="display" id="table_index">
			    <thead>
			        <tr id="datatable_header">
			            <th>ID</th>
			            <th style="width: 20px;">№</th>
			            <th style="width: 100%;">დასახელება</th>
			            <th style="width: 100%;">საიდენტიფიკაციო კოდი</th>
			          	<th style="width: 100%;">იურიდიული მისამართი</th>                            
			            <th style="width: 100%;">ფაქტიური მისამართი</th>
			            <th style="width: 11px;" class="check"></th>
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
			                <input type="checkbox" name="check-all" id="check-all">
			            </th>
			        </tr>
			    </thead>
			</table>
		</div>
	</div>

	<!-- jQuery Dialog -->
	<div  id="add-edit-form" class="form-dialog" title="კლიენტი-მანიმენი">
	</div>
	
	<div  id="add-edit-form-client" class="form-dialog" title="კლიენტი">
	</div>
	
	<div  id="add-edit-form-project" class="form-dialog" title="პროექტი">
	</div>
	
	<div  id="add-edit-form-number" class="form-dialog" title="ნომერი">
	</div>

</body>