<html>
<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/sc_category.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		var change_colum_main = "<'dataTable_buttons'T><'H'lfrt><'dataTable_content't><'F'ip>";
		
		$(document).ready(function () {        	
			LoadTable(tName,3,'get_list',change_colum_main);	
						
			/* Add Button ID, Delete Button ID */
			GetButtons("add_button", "delete_button");			
			SetEvents("add_button", "delete_button", "check-all", tName, fName, aJaxURL);
		});
        
		function LoadTable(tbl,col_num,act,change_colum){
	    	GetDataTable(tName, aJaxURL, act, col_num, "", 0, "", 1, "asc", '', change_colum);
	    }
		
		function LoadDialog(){
			var id		= $("#cat_id").val();
			
			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 600, "auto", "");
		}
		
	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {
		    param 			= new Object();

		    param.act		="save_category";
	    	param.id		= $("#cat_id").val();
	    	param.cat		= $("#category").val();
	    	param.par_id	= $("#parent_id").val();
			
			if(param.cat == ""){
				alert("შეავსეთ პროდუქტის კატეგორია!");
			}else {
			    $.ajax({
			        url: aJaxURL,
				    data: param,
			        success: function(data) {			        
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								LoadTable(tName,3,'get_list',change_colum_main);
				        		CloseDialog(fName);
							}
						}
				    }
			    });
			}
		});

	   
    </script>
</head>

<body>
    <div id="dt_example" >
        <div id="container" >        	
            <div id="dynamic">
            	<h2 align="center">სცენარის კატეგორიები</h2>
            	<div id="button_area">
        			<button id="add_button">დამატება</button>
        			<button id="delete_button">წაშლა</button>
        		</div>
                <table  class="display" id="example">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 50%;">ინფორმაციის ქვე კატეგორია</th>
                            <th style="width: 50%;">ინფორმაციის კატეგორია</th>
                            <th class="check" style="width: 20px;">#</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_sub_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                            	<input type="checkbox" name="check-all" id="check-all">
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
	</div>
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="ინფორმაციის კატეგორიები">
    	<!-- aJax -->
	</div>
</body>
</html>
