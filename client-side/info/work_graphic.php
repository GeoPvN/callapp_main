<html>
<head>

<script type="text/javascript">
var aJaxURL	= "server-side/info/work_graphic.action.php";
var dey=2;
var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
$(document).ready(function(){

	GetButtons("add", "dis");
	LoadTable();


	$(".menun").click(function(){
		dey=this.id;
		LoadTable();
		title=$(this).html();
		$("#add-edit-form").attr('title', title);
		$("#wek_h").html("'"+title+"'");


});
	SetEvents("add", "dis", "check-all", "example", "add-edit-form", aJaxURL);
	});
function LoadDialog(f){
	GetDialog(f,450,240);
	$('.time').timepicker({
		hourMax: 23,
		hourMin: 0,
		stepMinute: 60,		
		minuteGrid: 60,
		hourGrid: 3

	});
	$("#save-dialog").click(function(){
		var param= new Object();
			param.act 			= "save_dialog";
			param.id 			= $("#id").val();
			param.week_day_id   = dey;
			param.start 		= $("#start").val();
			param.end			= $("#end").val();
			if(param.start!="" && param.end!=""){
			$.getJSON(aJaxURL, param, function(json) {
				LoadTable();
				$("#add-edit-form").dialog("close");
		});} else alert('მიუთითეთ კორექტული დრო');


	});
	$("#hidden").focus();
};
function LoadTable(){
	GetDataTable("example",aJaxURL+'?dey='+dey,"get_list",4,'',0, "", 1, "asc", "", change_colum_main);
	setTimeout(function(){
    	$('.ColVis, .dataTable_buttons').css('display','none');
    }, 90);
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
</script>

<style type="text/css">
.ui_tpicker_minute_label,.ui_tpicker_minute{
	display: none;
}
#table_right_menu{
	top: 56px;
}
.menun{
		cursor:pointer;
		padding: 6px 10px;
		width: 100px !important;
		display: block;
		margin: -3px;
}</style>
</head>
<body>
<div id="tabs" style="width: 90%">
<div class="callapp_head">სამუშაო გრაფიკები<hr class="callapp_head_hr"></div>

<div id="button_area" style="margin-top: 15px;">
<button id="add">დამატება</button>
<button id="dis">წაშლა</button>
</div>

<div class="callapp_filter_show">
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
<table class="display" id="example">
    <thead>
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width:50%">მუშაობის დასაწყისი</th>
            <th style="width:50%">სამუშაოს დასასრული</th>
            <th style="width: 30px">#</th>
        </tr>
    </thead>
    <thead>
        <tr class="search_header">
            <th class="colum_hidden">
            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
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

    </thead>
</table>
</div>

<div  id="add-edit-form" class="form-dialog" title="შეარჩიეთ გრაფიკი">
</div>
</body>
</html>
