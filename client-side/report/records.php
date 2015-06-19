<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/report/records.action.php";	//server side folder url
		var tName	= "example";											//table name
		
		$(document).ready(function () {
			GetDate("search_start");
			GetDate("search_end");

			var start 	= $("#search_start").val();
			var end 	= $("#search_end").val();
			LoadTable(start, end);
		});

		function LoadTable(start, end){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 6, "start=" + start + "&end=" + end, 0, "", 1, "desc");
		}

		
		var record;
		function play(record){
			
			link = 'http://109.234.117.182:8181/records/' + record;
			var newWin = window.open(link, 'newWin','width=420,height=200');
            newWin.focus();
            
		}

		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end").val();
	    	LoadTable(start, end);
	    });
	    
	    $(document).on("change", "#search_end", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $(this).val();
	    	LoadTable(start, end);
	    });
	    
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row">
        <div id="container">        	
            <div id="dynamic">
            	<h2 align="center">ჩანაწერები</h2>
            	<div id="button_area">
	            	<div class="left" style="width: 200px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="height: 13px; width: 100px;" type="text" name="search_start" id="search_start" class="inpt right"/>
	            	</div>
	            	<div class="right" style="">
	            		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="height: 13px; width: 100px; margin-left: 5px;" type="text" name="search_end" id="search_end" class="inpt right" />
            		</div>	
            	</div>
                <table class="display" id="example">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                             <th style="width: 120px;">წყარო</th>
                            <th style="width: 120px;">ადრესატი</th>
                            <th style="width: 120px;">დრო</th>
                            <th style="width: 100%;">ქმედება</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init hidden-input" style=""></th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
</body>