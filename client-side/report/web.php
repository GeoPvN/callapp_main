<html>
<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/report/web.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
		    	
		$(document).ready(function () {        	
			
			GetDate("search_start_my");
			GetDate("search_end_my");
			$("#fillter").button();
			LoadTable();
			//$("#operatori").chosen();	
 			//SetEvents("", "", "check-all", tName, fName, aJaxURL);
		});
        
		function LoadTable(){
			var start	= $("#search_start_my").val();
	    	var end		= $("#search_end_my").val();
	    	var agent	= $("#operatori").val();
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 5, "start=" + start + "&end="+end +"&agent="+agent, 0, "", 1, "desc", "", change_colum_main);
			setTimeout(function(){
    	    	$('.ColVis, .dataTable_buttons').css('display','none');
  	    	}, 90);
		}
		
		$(document).on("click", "#fillter", function () {
			LoadTable();
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
        #table_right_menu{
            position: relative;
            float: right;
            width: 70px;
            top: 42px;
        	z-index: 99;
        	border: 1px solid #E6E6E6;
        	padding: 4px;
        }
        
        .ColVis, .dataTable_buttons{
        	z-index: 100;
        }
        .callapp_head{
        	font-family: pvn;
        	font-weight: bold;
        	font-size: 20px;
        	color: #2681DC;
        }
    </style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">WEB რეპორტი<hr class="callapp_head_hr"></div>
<div style=" margin-top: 35px;" id="button_area">
	<div class="right" style="">            	    
       	<label for="operatori" class="left" style="margin: 5px 0 0 9px;">ოპერატორი</label>
    	<select id="operatori" class="inpt right" style="margin-left: 5px; width: 190px;">
             <option value="0">ყველა</option>
             <option value="203">agent1</option>
             <option value="204">agent2</option>
       	</select>
       	<button id="fillter" style="width: 90px; float: right; margin-right: -301px;height: 25px;">ფილტრი</button>                        
	</div>
	<div class="right" style="">
		<label for="search_end_my" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
		<input style="width: 75px; margin-left: 5px; height: 18px;" type="text" name="search_end_my" id="search_end_my" class="inpt right" />
	</div>
	<div class="right" style="width: 200px;">
		<label for="search_start_my" class="left" style="margin: 5px 0 0 35px;">დასაწყისი</label>
		<input style="width: 75px; margin-left: 5px; height: 18px;" type="text" name="search_start_my" id="search_start_my" class="inpt right"/>
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
    <table class="display" id="example">
        <thead>
            <tr id="datatable_header">
                <th>ID</th>
                <th style="width: 300px%;">ზარის რაოდენობა</th>
            	<th style="width: 300px;">გაგზავნილი მეილების რაოდენობა</th>
            	<th style="width: 300px;">საიტზე შესვლა</th>
            	<th style="width: 300px;">ფასი ნახა</th>
            </tr>
        </thead>
        <thead>
            <tr class="search_header">
                <th class="colum_hidden">
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
    <div id="add-edit-form" class="form-dialog" title="განყოფილებები">
    	<!-- aJax -->
	</div>
</body>
</html>

