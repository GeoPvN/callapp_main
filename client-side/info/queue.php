<head>
<style type="text/css">

</style>
<script type="text/javascript">
    var aJaxURL           = "server-side/info/queue.action.php";
    var aJaxURL_send_sms = "includes/sendsms.php";
    var tName             = "table_";
    var dialog            = "add-edit-form";
    var colum_number      = 5;
    var main_act          = "get_list";
    var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
    var lenght = [[10, 30, 50, -1], [10, 30, 50, "ყველა"]];
    
    $(document).ready(function () {
    	GetButtons("add_button","delete_button");
    	LoadTable('index',colum_number,main_act,change_colum_main,lenght);
    	SetEvents("add_button", "delete_button", "check-all", tName+'index', dialog, aJaxURL);

    	    setTimeout(function(){
    	    	$('.ColVis, .dataTable_buttons').css('display','none');
  	    	}, 10);
    });

    function LoadTable(tbl,col_num,act,change_colum,lenght){
    	GetDataTable(tName+tbl, aJaxURL, act, col_num, "", 0, lenght, 1, "asc", '', change_colum);
    	
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
        GetDialog(fName, 420, "auto", buttons, 'left top');
        var lenght_1 = [[-1, 30, 50, -1], [-1, 30, 50, "ყველა"]];
        LoadTable('ext',3,'get_list_ext',"<'scrol_table't>",lenght_1);
        GetButtons("add_button_ext","delete_button_ext");
    }

    function show_right_side(id){
        $("#right_side fieldset").hide();
        $("#" + id).show();
        $(".add-edit-form-class").css("width", "871");
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
.scrol_table{
	overflow-y: scroll;
	height: 260px;
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
            <th class="check">#</th>
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
            	<input type="checkbox" name="check-all" id="check-all">
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
<div  id="add-edit-form-sms" class="form-dialog" title="ახალი SMS">
</div>
<!-- jQuery Dialog -->
<div  id="add-edit-form-mail" class="form-dialog" title="ახალი E-mail">
</div>

</body>