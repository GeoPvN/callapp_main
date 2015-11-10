<?php

require_once("AsteriskManager/config.php");
//include("AsteriskManager/sesvars.php");

?>

<head>
	<script type="text/javascript">					
		      
		$(document).ready(function () {  	  
	       runAjax();  
	       runAjax1();
	       $('#queue, #departament_id, #ext, #persons_id, #state').chosen({ search_contains: true });
	   });

		function runAjax() {
            $.ajax({
            	async: false,
            	dataType: "html",
		        url: 'AsteriskManager/liveState.php',
			    data: 'sesvar=hideloggedoff&value=true',
			    beforeSend: false,
	            complete: false,
		        success: function(data) {
					$("#jq").html(data);						
			    }
            }).done(function(data) { 
                //setTimeout(runAjax, 1000);
            });
		}

		function runAjax1() {
            $.ajax({
            	async: true,
            	dataType: "html",
		        url: 'server-side/call/flash_panel.action.php',
		        beforeSend: false,
	            complete: false,
		        success: function(data) {
					$("#level").html(data);						
			    }
            }).done(function(data) { 
                //setTimeout(runAjax1, 1000);
            });
		}
		
    </script>
</head>

<style type='text/css'>
#my_div{
    margin-top: 30px;
}
#my_selector{
	width: 97%;
    margin: auto;
	background: #fff;
	border-radius: 5px;
    border: 1px solid #BABDBF;
}
#flesh_table{
    width: 98%;
    margin: auto;
}
#flesh_table thead tr th{
	text-align: left;
	padding: 10px;
}
#flesh_table tbody tr td{
	height: 70px;
	padding-left: 10px;
	text-align: left;
	vertical-align: middle;	
}
#flesh_table tbody tr{
	border-top: 1px solid #E5E5E5;
}
#flesh_table tbody tr:last-child{
	border-bottom: 1px solid #E5E5E5;
}
#filter{
	padding: 10px 10px 20px 10px;
	height: 43px;
}
#filter span {
	float: left;
	margin-right: 38px;
}
.chosen-container {
	margin-top: 6px;
}
#jq{
	margin-top: 20px;
}
</style>

<body>	
<div id="tabs">
<div class="callapp_head">განყოფილებები<hr class="callapp_head_hr"></div>	
    <div id="my_div">
        <div id="my_selector">
            <div id="filter">
                <span>
                <label>რიგი</label>
                <select id="queue" style="width: 165px"></select>
                </span>
                
                <span>
                <label>დეპარტამენტი</label>
                <select id="departament_id" style="width: 165px"></select>
                </span>
                
                <span>
                <label>შიდა ნომერი</label>
                <select id="ext" style="width: 165px"></select>
                </span>
                
                <span>
                <label>თანამშრომელი</label>
                <select id="persons_id" style="width: 165px"></select>
                </span>
                
                <span style="  margin-right: 0px;">
                <label>მდგომარეობა</label>
                <select id="state" style="width: 165px"></select>
                </span>
            </div>
        </div>
    </div>
    <div id="my_div"> 
        <div id="my_selector">
            
            <div id="jq">
            </div>
        </div> 
    </div>
</body>