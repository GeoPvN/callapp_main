<head>
	<script type="text/javascript">
		var aJaxURL	    = "server-side/report/out_call_result.action.php";	//server side folder url
		var tName	    = "example";									    //table name
		var scenario_id = 0; 
		$(document).ready(function () {
			GetDate("datetime");
			var datetime 	= $("#datetime").val();
// 			LoadTable(scenario_id, datetime);
// 			SetEvents("", "", "", "example", "add-edit-form1", "server-side/call/outgoing/outgoing_tab0.action.php");
			$("#example").html("");
			$.ajax({
	            url: aJaxURL,
	            type: "POST",
	            data: "act=get_colum",
	            dataType: "json",
	            success: function (data) {
	                if (typeof (data.error) != "undefined") {
	                    if (data.error != "") {
	                        alert(data.error);
	                    }else{
	                        $("#scenario").html(data.colum);
	                    }
	                }
	            }
	        });
		});

		function LoadTable(scenario_id, datetime, count){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", count, "scenario_id=" + scenario_id + "&datetime=" + datetime, 0, "", 1, "desc");
		}

		function LoadDialog(fName){
            //alert(form);
			switch(fName){
				case "add-edit-form1":
					var buttons = {
						"done": {
				            text: "დასრულება",
				            id: "done-dialog1"
				        }, 
			        	"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				            	$(this).dialog("close");
				            }
				        }
				    };
					GetDialog("add-edit-form1", 1150, "auto", buttons);
					GetDate2("date_input");
					GetDateTimes1("date_time_input");
					$("#back_quest").button({
			            
				    });
				    $("#next_quest").button({
			            
				    });	       
			       	        
			        $("#back_quest").css('display', 'none');
			        $( ".quest_body" ).each(function( index ) {
			        	gela[index] = $(this).attr('id');			        	
			        });
			        $("#"+gela[0]).css('display', 'initial');	
			        $("#next_quest").attr('next_id', gela[0]);		        
				break;	
				
			}
		    
		}

		$(document).on("change", "#scenario", function () {
			var datetime      = $("#datetime").val();
	    	var scenario_id   = $(this).val();
	    	$("#gelaa").html(" ");
	    	$.ajax({
	            url: aJaxURL,
	            type: "POST",
	            data: "act=get_colum_list&get_sc="+$(this).val(),
	            dataType: "json",
	            success: function (data) {
	                if (typeof (data.error) != "undefined") {
	                    if (data.error != "") {
	                        alert(data.error);
	                    }else{
	                        $("#gelaa").html(data.colum_list);
	                        LoadTable(scenario_id, datetime, data.count);
	            			SetEvents("", "", "", "example", "add-edit-form1", "server-side/call/outgoing/new/outgoing_tab0.action.php");
	                    }
	                }
	            }
	        });
	        
			
	    });
	    
	    $(document).on("change", "#datetime", function () {
	    	var datetime      = $(this).val();
	    	var scenario_id   = $("#scenario").val();
	    	$("#gelaa").html(" ");
	    	$.ajax({
	            url: aJaxURL,
	            type: "POST",
	            data: "act=get_colum_list&get_sc="+scenario_id,
	            dataType: "json",
	            success: function (data) {
	                if (typeof (data.error) != "undefined") {
	                    if (data.error != "") {
	                        alert(data.error);
	                    }else{
	                        $("#gelaa").html(data.colum_list);
	                        LoadTable(scenario_id, datetime, data.count);
	            			SetEvents("", "", "", "example", "add-edit-form1", "server-side/call/outgoing/new/outgoing_tab0.action.php");
	                    }
	                }
	            }
	        });
	    });
	    
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 250%;">        	
            <div id="dynamic">
            	<div id="button_area">
	            	<div class="left" style="width: 280px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">სცენარი</label>
	            		<select style="width: 170px; margin-left:5px;" id="scenario" class=""></select>
	            	</div>
	            	<div class="right" style="">
	            		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">თარიღი</label>
	            		<input style="height: 13px; width: 100px; margin-left: 5px;" type="text" name="search_end" id="datetime" class="inpt right" />
            		</div>	
            	</div>
            	<div id="gelaa">
                <table class="display" id="example">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">სცენარი</th>
                            <th style="width: 100%;">სცენარის კატეგორია</th>
                            <th style="width: 100%;">სცენარის ქვე-კატეგორია</th>
                            <th style="width: 100%;">მისამართი</th>                            
                            <th style="width: 100%;">სახელი და გვარი</th>
                            <th style="width: 100%;">ტელეფონი 1</th>
                            <th style="width: 100%;">ტელეფონი 2</th>
                            <th style="width: 100%;">შემსრულებელი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="width: 90px;">
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                             <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                             <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
</body>
<div id="add-edit-form1" class="form-dialog" title="გამავალი ზარი">
<!-- aJax -->
</div>