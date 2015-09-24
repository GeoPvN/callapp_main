<?php
 
require_once("AsteriskManager/config.php");
//include("AsteriskManager/sesvars.php");

?>

<head>
	<script type="text/javascript">					
		      
		$(document).ready(function () {  	  
	       runAjax();  
	       runAjax1();  		    
		});

		function runAjax() {
            $.ajax({
            	async: false,
            	dataType: "html",
		        url: 'AsteriskManager/liveState.php',
			    data: 'sesvar=hideloggedoff&value=true&stst=1',
		        success: function(data) {
					$("#flesh_panel_table").html(data);						
			    }
            }).done(function(data) { 
                setTimeout(runAjax, 1000);
            });
		}

		function runAjax1() {
            $.ajax({
            	async: true,
            	dataType: "html",
		        url: 'server-side/call/flash_panel.action.php',
		        success: function(data) {
					$(".level").html(data);						
			    }
            }).done(function(data) { 
                setTimeout(runAjax1, 1000);
            });
		}
		
    </script>
    <style type='text/css'>

#flesh_panel_table, #flesh_panel_table_mini{
	box-shadow: 0px 0px 7px #888888;
	margin-top: 20px;
}

#flesh_panel_table td, #flesh_panel_table_mini td {
	height: 25px;	
	vertical-align: middle;
	text-align: left;
	padding: 0 5px;
	background: #FFF;
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
.ui-widget-header{
	box-shadow: 0px 0px 7px #888888;
}
.display{
	box-shadow: 0px -2px 10px #888888;
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
</style>
</head>

<body>
<div id="tabs" style="width: 90%">
<div class="callapp_head">Flash Panel<hr class="callapp_head_hr"></div>
    

    
<div class="callapp_filter_show">    

    <table style=" margin: 0 auto;" border="1">
		<tr>				
			<td>		
			   <table id="flesh_panel_table">
			   </table>
			</td>
			<td style="width: 20px;">
			</td>
			<td>
				<table id="flesh_panel_table" class="level"></table>
			</td>			
		</tr>
	</table>
</div>
</body>