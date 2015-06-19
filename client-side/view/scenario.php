<html>
<head>
<style type="text/css">
.colum_hidden{
	display: none;
}
</style>
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/scenario.action.php";	//server side folder url
		var tName	= "example";								//table name
		var fName	= "add-edit-form";							//form name
		var tbName	= "tabs";
		    	
		$(document).ready(function () {
			LoadTable();			
			/* Add Button ID, Delete Button ID */
			GetButtons("add_button", "delete_button");			
			MyEvent("add_button", "delete_button", "check-all", tName, fName, aJaxURL, "", "quest_id");			
			
		});

		$(document).on("tabsactivate", "#tabs", function() {
        	var tab = GetSelectedTab(tbName);
        	if (tab == 0) {
        		GetTable0();
        	}else if(tab == 1){
        		GetTable1();
            }else if(tab == 2){
        		GetTable2();
            }else if(tab == 3){
        		GetTable3();
            }
		});

		function GetTable0() {
			GetDataTable("example2", aJaxURL, "get_list_detail", 3, "quest_id="+$("#quest_id").val(), 0, "", 1, "asc");
			GetButtons("add_button_detail", "delete_button_detail");
			MyEvent("add_button_detail", "delete_button_detail", "check-all-de", "example2", "add-answer", aJaxURL, "", "quest_detail_id", "add_id="+$("#quest_id").val());
        }
        
		 function GetTable1() {
			 $.ajax({
			        url: aJaxURL,
				    data: "act=get_edit_page&quest_id="+$("#quest_id").val(),
			        success: function(data) {			        
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								//alert(data.page);
								$("#xaiden").html(data.page);
								$("#add-edit-form #tab-1").html($("#xaiden #tab-1").html());
								$("#xaiden").html('');
							}
						}
				    }
			    });
	    }
         
        function GetTable2() {
                     
        }
         
        function GetTable3() {
            
        }
        
		function LoadTable(){			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 4, "", 0, "", 0, "desc");    		
		}
		
		function LoadDialog(fname){	
			/* Dialog Form Selector Name, Buttons Array */			
			if(fname == "add-edit-form"){
				GetTabs(tbName); 
				var but = {
    		        "save": {
    		            text: "შენახვა",
    		            id: "save-dialog",
    		            click: function () {
    		            }
    		        },
    		        "cancel": {
    		            text: "დახურვა",
    		            id: "cancel-dialog",
    		            click: function () {
    		                $(this).dialog("close");
    		            }
    		        }
				};
    			GetDialog(fName, 835, "auto", but);
    			var name_check = $("#add-edit-form #name").val();
    			if(name_check != ''){
    				$(".add-edit-form-class .ui-dialog-title").html(name_check);
    			}    			
    			GetDataTable("example2", aJaxURL, "get_list_detail", 3, "quest_id="+$("#quest_id").val(), 0, "", 1, "asc");
    			GetButtons("add_button_detail", "delete_button_detail");
    			MyEvent("add_button_detail", "delete_button_detail", "check-all-de", "example2", "add-answer", aJaxURL, "", "quest_detail_id", "add_id="+$("#quest_id").val());   
    			GetDate2("date_input");
				GetDateTimes1("date_time_input"); 			
			}
			if(fname == "add-answer"){
				var but = {
	    		        "save": {
	    		            text: "შენახვა",
	    		            id: "save-answer",
	    		            click: function () {
	    		            }
	    		        },
	    		        "cancel": {
	    		            text: "დახურვა",
	    		            id: "cancel-dialog",
	    		            click: function () {
	    		                $(this).dialog("close");
	    		            }
	    		        }
				};
				GetDialog("add-answer", 480, "auto", but);
				var select_check = $("#add-answer #quest_id1").find(":selected").text();
				if(select_check != '----'){
    				$(".add-answer-class .ui-dialog-title").html(select_check);
    			}   
				$("#add-answer #name").val($("#add-edit-form #name").val());
				$("#add-answer #name").prop('disabled', true);
				$("#add-answer #cat").prop('disabled', true);
				$("#add-answer #le_cat").prop('disabled', true);
			}
		}

		$(document).on("change", ".scenarquest", function () {
			$("#dest_checker").val(1);
		});
		
	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {	
	    	param 			= new Object();

	    	var dest_checker = $("#dest_checker").val();
	    	
		    param.act		       = "save_quest";
	    	param.quest_id	       = $("#quest_id").val();
	    	param.quest_detail_id  = $("#quest_detail_id").val();
	    	param.name		       = $("#name").val();
	    	param.cat	           = $("#cat").val();
	    	param.le_cat           = $("#le_cat").val();
	    	param.dest_checker     = dest_checker;

	    	
	    	var items          = {};
	    	var checker        = {};
	    	
	    	if(dest_checker == 1){
    	    	$('.scenarquest').each(function() {	
    		    	
    	    		key      = this.id;
    	    		value    = this.value;
    
    	    		checker[key] = checker[key] + "," + value;
    
    	    	});
	    	}
	    	
	    	items.checker = checker;
	    	
	    	var link = GetAjaxData(param);
	    	
			if(param.name == ""){
				alert("შეავსეთ ველი!");
			}else{				
				if($("#cat").val() > 0 && $("#le_cat").val() > 0){
			    $.ajax({
			        url: aJaxURL,
				    data: link + "&checker=" + JSON.stringify(items.checker),
			        success: function(data) {			        
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								LoadTable();
				        		CloseDialog(fName);
							}
						}
				    }
			    });
				}else{
					alert('კატეგორია ან ქვე-კატეგორია არ არის შევსებული!');
				}
			}	    					
		});
    

	    $(document).on("click", "#save-answer", function () {	
	    	param 			= new Object();

		    param.act		        = "save_answer";
		    param.add_id	        = $("#add-answer #add_id").val();
		    param.quest_id	        = $("#add-answer #quest_id").val();
	    	param.quest_detail_id   = $("#add-answer #quest_detail_id").val();
	    	param.quest_id1         = $("#add-answer #quest_id1").val();
	    	
	    	
			if(param.name == ""){
				alert("შეავსეთ ველი!");
			}else{
			    $.ajax({
			        url: aJaxURL,
				    data: param,
			        success: function(data) {			        
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								GetDataTable("example2", aJaxURL, "get_list_detail", 3, "quest_id="+$("#quest_id").val(), 0, "", 1, "asc");
				        		CloseDialog("add-answer");
							}
						}
				    }
			    });
			}	    					
		});	    

	    $(document).on("click", "#cat", function () {
	    	$.ajax({
		        url: aJaxURL,
			    data: "act=get_scen_cat&cat_id="+$("#cat").val(),
		        success: function(data) {			        
					if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
						    $("#le_cat").html(data.cat);
						}
					}
			    }
		    });	    	
	    });
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row" style="width: 1024px; margin: 0 auto;">
        <div id="container">        	
            <div id="dynamic">
            	<h2 align="center">სცენარი</h2>
            	<div id="button_area">
        			<button id="add_button">დამატება</button>
        			<button id="delete_button">წაშლა</button>
        		</div>
                <table class="display" id="example">
                    <thead >
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">დასახელება</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>
                            <th class="check">#</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden"></th>
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
                            	<input type="checkbox" name="check-all" id="check-all">
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="სცენარი">
    	<!-- aJax -->
	</div>
	
	<div id="add-answer" class="form-dialog" title="კითხვა">
    	<!-- aJax -->
	</div>
	
	<div style="display: none;" id="xaiden"></div>
</body>
</html>