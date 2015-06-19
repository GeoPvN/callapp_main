<head>
<style type="text/css">
<?php                    		
if($_SESSION['USERID'] == 3 || $_SESSION['USERID'] == 1 ){
   
 
}else{
     echo '.dataTable_buttons{
            display:none;
        }';
}
?>
#example td:nth-child(7){
	text-align: center;
}
#example td:nth-child(8){
	text-align: right;
}
#example td:nth-child(9){
	text-align: right;
}
</style>
	<script type="text/javascript">
		var aJaxURL	= "server-side/sale/buy_list.action.php";	//server side folder url
		var tName	= "example";

		$(document).ready(function () {
			GetDate("search_start");
			GetDate("search_end");				
			
			var start 	= $("#search_start").val();
			var end 	= $("#search_end").val();
			var dep_id  = $('#dep_id').val();
			LoadTable(start,end,dep_id);
		});
		
		function LoadTable(start, end, dep_id){
			var total=[7,8];
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTableReload(tName, aJaxURL, "get_list", 10, "start=" + start + "&end=" + end + "&dep_id=" + dep_id, 0, "", 0, "desc", total);
		}

		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end").val();
	    	var dep_id  = $('#dep_id').val();
	    	LoadTable(start, end, dep_id);
	    });
 
	    $(document).on("change", "#search_end", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $(this).val();
	    	var dep_id  = $('#dep_id').val();
	    	LoadTable(start, end, dep_id);
	    });

	    $(document).on("change", "#dep_id", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var dep_id  = $('#dep_id').val();
	    	LoadTable(start, end, dep_id);
	    });

    </script>
    <style type="text/css">

    </style>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row">
    <h2 style="position: absolute; top: 80px; margin-left: 50%;">შესყიდვა</h2>
        <div id="container" style="width: 100%; margin-top: 90px;"  >
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end" class="inpt right" />
            		</div>
            		
            		
            		<div class="right" style="">
	            		<label for="dep_id" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id" style="margin-left: 5px;">
	            		<?php
                		include '../../includes/classes/core.php';
                		$r = mysql_query(" SELECT  `id`,
                                            	   `name`
                                            FROM   `department`
                                            WHERE  `actived` = 1");
                		$data = '<option value="0">ყველა</option>';
                		while ($rr = mysql_fetch_array($r)){
                		  $data .= '<option value="'.$rr[0].'">'.$rr[1].'</option>';
                		}
                		echo $data;
                		?> 
	            		</select>
	            	</div>
	            	
            		   		
            	</div>
                <table class="display" id="example" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">დარეკვის თარიღი</th>
							<th style="width: 50%">გაგზავნის თარიღი</th>
							<th style="width: 50%">მოტანის თარიღი</th>
							<th style="width: 50%">შტრიხკოდი</th>
							<th style="width: 50%">პროდუქტი</th>	
							<th style="width: 50%">რ-ბა</th>	
							<th style="width: 50%">ასაღები ფასი</th>	
							<th style="width: 50%">სულ ფასი</th>						
							<th style="width: 50%">დეპარტამენტი</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                                                     

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>	
							<th style="width: 150px; text-align: right;"></th>
							<th style="width: 150px;"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
</body>
