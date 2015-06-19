<head>
<style type="text/css">
<?php                    		
if($_SESSION['USERID'] == 3 || $_SESSION['USERID'] == 1 || $_SESSION['USERID'] == 35){
   
 
}else{
     echo '.dataTable_buttons{
            display:none;
        }';
}
?>
#example td:nth-child(14){
	text-align: right;
}
#example td:nth-child(13){
	text-align: right;
}
#example td:nth-child(12){
	text-align: right;
}
#example td:nth-child(11){
	text-align: right;
}
#example td:nth-child(10){
	text-align: center;
}
#example1 td:nth-child(4){
    text-align: center;
}
#example1 td:nth-child(5){
    text-align: right;
}
#example1 td:nth-child(6){
    text-align: right;
}

</style>
	<script type="text/javascript">
		var aJaxURL	= "server-side/sale/elva.ge_dep_new.action.php";	//server side folder url
		var tName	= "example";
		var tbName	= "tabs";

		$(document).ready(function () {
			GetTabs(tbName);
			GetDate("search_start");
			GetDate("search_end");		
			$('#dep_id').chosen({ search_contains: true });		
			
			var start 	= $("#search_start").val();
			var end 	= $("#search_end").val();
			var dep_id  = $('#dep_id').val();
			LoadTable(start,end,dep_id,'','get_list');
			LoadTable(start,end,dep_id,1,'ccc');
		});
		
		$(document).on("tabsactivate", "#tabs", function() {
        	var tab = GetSelectedTab(tbName);
        	if (tab == 0) {
        		var start 	= $("#search_start").val();
    			var end 	= $("#search_end").val();
    			var dep_id  = $('#dep_id').val();
    			LoadTable(start,end,dep_id,'','get_list');
        	}else{
        		var start 	= $("#search_start").val();
    			var end 	= $("#search_end").val();
    			var dep_id  = $('#dep_id').val();
    			LoadTable(start,end,dep_id,1,'ccc');
        	}
		});
		
		function LoadTable(start, end, dep_id, num, get){
			
			if(num == 1){
				var total=[5];
			    list_num = 6;
			}else{
				list_num = 15;
				var total=[11,13];
			}
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTableReload(tName+num, aJaxURL, get, list_num, "start=" + start + "&end=" + end + "&dep_id=" + dep_id, 0, "", 0, "desc", total);
		}

		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end").val();
	    	var dep_id  = $('#dep_id').val();
	    	LoadTable(start, end, dep_id,'','get_list');
	    	LoadTable(start, end, dep_id,1,'ccc');
	    });
 
	    $(document).on("change", "#search_end", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $(this).val();
	    	var dep_id  = $('#dep_id').val();
	    	LoadTable(start, end, dep_id,'','get_list');
	    	LoadTable(start, end, dep_id,1,'ccc');
	    });

	    $(document).on("change", "#dep_id", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var dep_id  = $('#dep_id').val();
	    	LoadTable(start, end, dep_id,'','get_list');
	    	LoadTable(start, end, dep_id,1,'ccc');
	    });

    </script>
    <style type="text/css">

    </style>
</head>

<body>
<div id="button_area" style="margin-top:25px;">
	<div class="left" style="width: 175px;">
		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start" class="inpt left"/>
	</div>
	<div class="left" style="">
		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end" class="inpt right" />
	</div>
	
	
	<div class="right" style="">
		<label for="dep_id" class="left" style="margin: 5px 5px 0 9px;">დეპარტამენტი</label>
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
<div id="tabs" style="width: 100%; margin: 0 auto; min-height: 768px; margin-top: 60px;">
		<ul>
		    <li><a href="#tab-1">გაყიდვები დეპარტამენტების მიხედვით</a></li>
		    <li><a href="#tab-2">გაყიდვები შეკვეთების მიხედვით</a></li>
		</ul>
    <div id="tab-1" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 20px;"  >
            <div id="dynamic" style="width: 100%; ">            
                <table class="display" id="example" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 35%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 60%">პროდუქტი</th>	
							<th style="width: 30%">შტრიხკოდი</th>							
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 18%">რ-ბა</th>	
							<th style="width: 22%">შესყ. ფასი</th>		
							<th style="width: 22%">შესყ. სულ ფასი</th>						
							<th style="width: 22%">ერთ. ფასი</th>	
							<th style="width: 22%">სულ ფასი</th>
							<th style="width: 40%">ოპერატორი</th>							
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
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px;"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 150px; text-align: right;"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>		
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    <div id="tab-2">
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 20px;"  >
            <div id="dynamic" style="width: 100%; ">            
                <table class="display" id="example1" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>							
							<th style="width: 100%">შტრიხკოდი</th>	
							<th style="width: 100%">პროდუქტი</th>		
							<th style="width: 100%">რ-ბა</th>	
							<th style="width: 100%">ერთ. შესყიდვის ფასი</th>							
							<th style="width: 100%">სულ შესყიდვის ფასი</th>					
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
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th> 
                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>					
							<th style="width: 150px"></th>
							<th style="width: 150px;"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    </div>
</body>
