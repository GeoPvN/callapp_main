<html>
<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/report/research.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		    	
		$(document).ready(function () {        	
			LoadTable();	
			GetDate("search_start_my");
			GetDate("search_end_my");
 			$("#search_start_my").val('0000-00-00');
  		    $("#search_end_my").val('0000-00-00');
			/* Add Button ID, Delete Button ID */		
			SetEvents("", "", "", tName, fName, "server-side/call/outgoing/outgoing_tab0.action.php");
		});
		
		$(document).on("click", ".download", function () {
            var link = $(this).attr("str");
            link = "http://109.234.117.182:8181/records/" + link;

            var newWin = window.open(link, "JSSite", "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");
            newWin.focus();
        });

		function LoadDialog(){
			var buttons = {
		        	"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        } 
			    };
				GetDialog("add-edit-form", 1150, "auto", buttons);
		}
        
		function LoadTable(start, end){
			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 11, "start=" + start + "&end=" + end, 0, "", 2, "desc");
    		
		}

		$(document).on("change", "#search_start_my", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end_my").val();
	    	LoadTable(start, end);
	    });
	    
	    $(document).on("change", "#search_end_my", function () {
	    	var start	= $("#search_start_my").val();
	    	var end		= $(this).val();
	    	LoadTable(start, end);
	    });
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row" style="width: 98%; margin: 0 auto;">
        <div id="container" style="width: 98%;">        	
            <div id="dynamic">
            	<h2 align="center">კვლევა</h2>
            	<div id="button_area">
	            	<div class="left" style="width: 200px;">
	            		<label for="search_start_my" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 70px; margin-left: 5px; height: 13px;" type="text" name="search_start_my" id="search_start_my" class="inpt left"/>
	            	</div>
	            	<div class="right" style="">
	            		<label for="search_end_my" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 70px; margin-left: 5px; height: 13px;" type="text" name="search_end_my" id="search_end_my" class="inpt right" />
            		</div>	
            	</div>
                <table class="display" id="example" >
                    <thead >
                        <tr id="datatable_header">
                            <th>ინტერვიუერი</th>
                            <th style="width: 100%;">ინტერვიუერი</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">მომხმარებელი</th>
                            <th style="width: 100%;">ფილიალი</th>
                            <th style="width: 100%;">სცენარი</th>
                            <th style="width: 100%;">ტელეფონი</th>
                            <th style="width: 100%;">ტელეფონი</th>
                            <th style="width: 100%;">რჩევები</th>
                            <th style="width: 100%;">პერსონალის შეფასება</th>
                            <th style="width: 100%;">ზარის დაზუსტება</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>                            
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                          	<th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input style="width: 100px" type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="ქალაქი">
    	<!-- aJax -->
	</div>
</body>
</html>


