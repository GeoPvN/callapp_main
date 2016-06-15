<html>
<head>
<script type="text/javascript">
var aJaxURL	= "server-side/info/user_info.action.php";

$(document).ready(function(){
	$('#year_month').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm',
        
    });
    
	param 			= new Object();
	param.act		= "get_project";
    $.ajax({
        url: aJaxURL,
        data: param,
        success: function(data) {
            $("#project_id").html(data.project);
            $("#operator_id").html(data.user_id);
            $('#project_id,#operator_id').chosen({ search_contains: true });
            param 			= new Object();
        	param.act		= "get_cycle_start_date";
        	param.year_month	= $("#year_month").val();
            $.ajax({
                url: aJaxURL,
                data: param,
                success: function(data) {
                    $("#cycle_start_date").html(data.cycle_start_date);
                }
            });
        }
    });
});

function load_table(){
	param 			    = new Object();
	param.act		    = "get_24_hour";
	param.project_id	= $("#project_id").val();
	param.year_month	= $("#year_month").val();
	param.operator_id   = $("#operator_id").val();
    $.ajax({
        url: aJaxURL,
        data: param,
        success: function(data) {
            $("#time_line").html(data.page);

        }
    });
}

$(document).on("change", "#project_id", function () {
	load_table();
});

$(document).on("change", "#operator_id", function () {
	load_table();
});

$(document).on("change", "#year_month", function () {
	load_table();
});

$(document).on("click", "#goexcel", function (e) {
	var table = 'work_table';

	var tableToExcel = (function() {
          var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
          return function(table, name) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            window.location.href = uri + base64(format(template, ctx))
          }
        })();
	tableToExcel(table, 'excel export')
});

</script>

<style type="text/css">
::-webkit-scrollbar {
    width: 12px;
	height: 15px;
}  
::-webkit-scrollbar-track {
    background-color: #CBD9E6;
    border-left: 1px solid #ccc;
}
::-webkit-scrollbar-thumb {
    background-color: #2681DC;
	border-radius: 12px;
}
::-webkit-scrollbar-thumb:hover {  
    background-color: #aaa;  
}  
#time_line td,#time_line1 td{   
   border:solid 1px #A3D0E4;
}
#work_table{
	width: 700px;
}
#work_table td, #work_table th {
    border: 1px solid;
    font-size: 11px;
    font-weight: normal;
    text-align: center;
	padding: 3px;
}
#fastlink{
	float: right;
}
#fastlink span{
    margin-right: 10px;
    display: block;
    width: 24px;
    height: 24px;
    float: left;
	cursor: pointer;
}
</style>
</head>
<body>
<div id="tabs" style="width: 98%">
    <div class="callapp_head"><div id="fastlink"><span id="mypage" style="background: url('media/images/monitor.png');"></span><span id="workgrafic" style="background: url('media/images/hand.png');"></span><span id="activitis" style="background: url('media/images/folder.png');"></span></div>WFM<hr class="callapp_head_hr"></div>

    <div id="container" style="width:100%;margin-bottom: 70px;">
    
        <select style="width: 210px;padding: 2px;border: solid 1px #85b1de;margin-right: 15px;"  id="project_id"></select>
        <select style="width: 210px;padding: 2px;border: solid 1px #85b1de;margin-right: 15px;"  id="operator_id"></select>
        <input style="width: 75px;display: inline-block; height: 13px; position: relative;" id="year_month" value="<?php echo date('Y-m')?>" class="date1 inpt" placeholder="თარიღი"/>
        <br/>
        
        <div id="time_line" style="margin-top: 20px;"><div style="color: #2681DC;text-align: center; font-size: 14px; font-weight: bold;">აირჩიეთ პროექტი და თარიღი!</div></div>

    </div>
<div id="test"></div>
<div id="add-edit-form" class="form-dialog" title="ცვლის დამატება">
<div id="dialog-form">
    <fieldset>
        <legend>ცვლა</legend>
        <select style="width: 160px;" id="shift_id"></select>
    </fieldset>
</div>
</div>
<div id="start_date" class="form-dialog" title="ციკლის დაწყების თარიღი">
<div id="dialog-form">
    <fieldset>
        <legend>ციკლის დაწყების თარიღი</legend>
        <select style="width: 190px;" id="cycle_start_date"></select>
    </fieldset>
</div>
</div>
<div id="wfm_hour" class="form-dialog" title="საათების მიხედვით">
</div>
<div id="add_break" class="form-dialog" title="შესვენების დამატება">
</div>
<div id="add-edit-form-user" class="form-dialog" title="შესვენების დამატება">
</div>
</body>
</html>
