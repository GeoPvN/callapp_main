<head>
<style type="text/css">

</style>
<script type="text/javascript">
    var aJaxURL           = "server-side/info/queue.action.php";
    var tName             = "table_";
    var dialog            = "add-edit-form";
    var colum_number      = 5;
    var main_act          = "get_list";
    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
    var lenght = [[10, 30, 50, -1], [10, 30, 50, "ყველა"]];
    
    $(document).ready(function () {
    	GetButtons("add_button","delete_button");
    	LoadTable('index',colum_number,main_act,change_colum_main,lenght,'');
    	SetEvents("add_button", "delete_button", "check-all", tName+'index', dialog, aJaxURL, '', 'index',colum_number,main_act,change_colum_main,lenght,'');
    });

    function LoadTable(tbl,col_num,act,change_colum,lenght,other_act){
    	GetDataTable(tName+tbl, aJaxURL, act, col_num, other_act, 0, lenght, 1, "asc", '', change_colum);
    	setTimeout(function(){
	    	$('.ColVis, .dataTable_buttons').css('display','none');
	    }, 10);
    }
    
    function LoadDialog(fName){
    	var buttons = {
				"save": {
		            text: "შენახვა",
		            id: "save_queue"
		        },
	        	"cancel": {
		            text: "დახურვა",
		            id: "cancel-dialog",
		            click: function () {
		            	$(this).dialog("close");
		            }
		        }
		    };
        GetDialog(fName, 420, "auto", buttons, 'left top');
        LoadTable('ext',3,'get_list_ext',"<'F'lip>",'','hidden_id='+$('#hidden_id').val());
              // ServerLink,  AddButtonID,    DeleteButtonID,     CheckAllID,  DialogID,   SaveDialogID,  CloseDialogID,  DialogHeight,  DialogPosition,  DialogOpenAct,     DeleteAct        EditDialogAct        TableID  ColumNum     TableAct       TableFunction      TablePageNum     TableOtherParam
        MyEvent(   aJaxURL,  'add_button_ext', 'delete_button_ext', 'check-all', '-in_num', 'save_in_num', 'cancel-dialog',      270,       'center top',  'get_in_num_page', 'disable_ext', 'get_edit_in_num_page',  'ext',   3,        'get_list_ext', "<'F'lip>",      '',        'hidden_id='+$('#hidden_id').val());
    }



    function show_right_side(id){
        $("#right_side fieldset").hide();
        $("#" + id).show();
        $(".add-edit-form-class").css("width", "1000");
        hide_right_side();
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
    	$(".add-edit-form-class").css("width", "420");
        hide_right_side();
    });

    $(document).on("click", "#save_queue", function () {
        param 			= new Object();
        
        param.act		    = 'save_queue';
	    param.hidden_id		= $('#hidden_id').val();
	    param.global_id		= $('#global_id').val();
    	param.queue_name	= $('#queue_name').val();
    	param.queue_number	= $('#queue_number').val();
    	
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                CloseDialog('add-edit-form');
                LoadTable('index',colum_number,main_act,change_colum_main,lenght);
            }
        });
    });

    $(document).on("click", "#save_in_num", function () {
        param 			= new Object();
        
        param.act		  = 'save_in_num';
        param.hidden_id	  = $('#hidden_id').val();
        param.global_id	  = $('#global_id').val();
        param.id_in_up	  = $('#id_in_up').val();
	    param.in_num_name = $('#in_num_name').val();
	    param.in_num_num  = $('#in_num_num').val();
	    
        $.ajax({
            url: aJaxURL,
            data: param,
            success: function(data) {
                CloseDialog('add-edit-form-in_num');
                $('#global_id').val(data.global_id);
                var myId = '';
                if(data.global_id !== null){
                	myId = data.global_id;
                }else{
                	myId = $('#hidden_id').val();
                }
                LoadTable('ext',3,'get_list_ext',"<'F'lip>",'','hidden_id='+myId);
            }
        });
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
</script>
<style type="text/css">
.callapp_head{
	font-family: pvn;
	font-weight: bold;
	font-size: 20px;
	color: #2681DC;
}
.callapp_head_hr{
	border: 1px solid #2681DC;
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
.ColVis, .dataTable_buttons{
	z-index: 100;
} 
#table_ext_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_ext_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_ext_info{
	width: 32%;
}
#table_ext_paginate{
	margin-left: 0px;
}
</style>
</head>

<body>
<div id="tabs" style="width: 90%">
<div class="callapp_head">რიგი<hr class="callapp_head_hr"></div>
    
    <div style="margin-top: 15px;">
        <button id="add_button">დამატება</button>
        <button id="delete_button">წაშლა</button>
    </div>
    
<div class="callapp_filter_show">    
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
            <th style="width: 100%;">დასახელება</th>
            <th style="width: 100%;">ნომერი</th>
            <th style="width: 100%;">შიდა ნომრები</th>
            <th style="width: 100%;">სცენარი</th>
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
            	<div class="callapp_checkbox">
                    <input type="checkbox" id="check-all" name="check-all" />
                    <label for="check-all"></label>
                </div>
            </th>           
        </tr>
    </thead>
</table>
</div>
<style>
.ui-widget-header{
	box-shadow: 0px 0px 7px #888888;
}
.display{
	box-shadow: 0px -2px 10px #888888;
}
</style>


<!-- jQuery Dialog -->
<div  id="add-edit-form" class="form-dialog" title="შემომავალი ზარი">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-in_num" class="form-dialog" title="შიდა ნომერი">
</div>

</body>