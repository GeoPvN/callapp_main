<html>
<head>
<style type="text/css">
.colum_hidden{
	display: none;
}
</style>
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/quest.action.php";		//server side folder url
		var seoyURL	= "server-side/seoy/seoy.action.php";		//server side folder url
		var tName	= "example";								//table name
		var fName	= "add-edit-form";							//form name
		var change_colum_main = "<'dataTable_buttons'T><'H'lfrt><'dataTable_content't><'F'ip>";
		    	
		$(document).ready(function () {
			LoadTable('',3,'get_list',change_colum_main,'');
			
			GetButtons("add_button", "delete_button");			
			MyEvent("add_button", "delete_button", "check-all", tName, fName, aJaxURL, "", "quest_id");			
		});

        
		function LoadTable(tbl,col_num,act,change_colum,custom_link){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName+tbl, aJaxURL, act, col_num, "", 0, custom_link, 1, "asc", '', change_colum);    		
		}
		
		function LoadDialog(fname){	
			/* Dialog Form Selector Name, Buttons Array */
			if(fname == "add-edit-form"){
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
    			GetDialog(fName, 480, "auto", but);
    			//LoadTable('1',4,'get_list_detail',change_colum,"quest_id="+$("#quest_id").val());
    			GetDataTable("example1", aJaxURL, "get_list_detail", 4, "quest_id="+$("#quest_id").val(), 0, "", 1, "asc",'',change_colum_main);
    			GetButtons("add_button_detail", "delete_button_detail");
    			MyEvent("add_button_detail", "delete_button_detail", "check-all-de", "example1", "add-answer", aJaxURL, "", "quest_detail_id", "add_id="+$("#quest_id").val());    			
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
				$("#add-answer #name").val($("#add-edit-form #name").val());
				$("#add-answer #name").prop('disabled', true);
				
				 SeoY("production_name", seoyURL, "production_name", "", 0);
                 
                 $("#title").keypress(function(event) {
         		    if (event.which === 13) {
         		    	var title = $("#title").val();
             		    	
            		    	$.ajax({
       		                url: aJaxURL,
       		                type: "POST",
       		                data: "act=get_product_search&title="+title,
       		                dataType: "json",
       		                success: function (data) {
       		                    if (typeof (data.error) != "undefined") {
       		                        if (data.error != "") {
       		                            alert(data.error);
       		                        } else {
       		                            $("#add_product_dialog").html(data.page);
       		                        }
       		                    }
       		                }
       		            });
         		    }
         		});
                 SeoY("production_name", seoyURL, "production_name", "", 0);
                 showHiden();
			}
		}
		
	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {	
	    	param 			= new Object();

		    param.act		       = "save_quest";
	    	param.quest_id	       = $("#quest_id").val();
	    	param.quest_detail_id  = $("#quest_detail_id").val();
	    	param.name		       = $("#name").val();
	    	param.note             = $("#note").val();
	    	
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
								LoadTable('',3,'get_list',change_colum_main,'');
				        		CloseDialog(fName);
							}
						}
				    }
			    });
			}	    					
		});

	    $(document).on("click", "#save-answer", function () {	
	    	param 			= new Object();

		    param.act		        = "save_answer";
		    param.add_id	        = $("#add-answer #add_id").val();
		    param.quest_id	        = $("#add-answer #quest_id").val();
	    	param.quest_detail_id   = $("#add-answer #quest_detail_id").val();
	    	param.quest_type_id	    = $("#add-answer #quest_type_id").val();
	    	param.answer		    = $("#add-answer #answer").val();
	    	param.hidden_product_id	= $("#add-answer #hidden_product_id").val();
	        var ar_daamato = 0;
	    	$('#example1 td:nth-child(4)').each(function(){
	    		if($(this).text() == 'რადიო-ბოქსი' && $("#quest_type_id option:selected").text() == 'ჩეკ-ბოქსი'){
	    			ar_daamato = 1;
	    		}
	    		
	    	    if($(this).text() == 'ჩეკ-ბოქსი' && $("#quest_type_id option:selected").text() == 'რადიო-ბოქსი'){	    	        
	    	       ar_daamato = 1;
	    	    }
	    	});
	    	
			if(param.name == ""){
				alert("შეავსეთ ველი!");
			}else{
				if(ar_daamato == 0){
			    $.ajax({
			        url: aJaxURL,
				    data: param,
			        success: function(data) {			        
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								//LoadTable('1',4,'get_list_detail',change_colum,"quest_id="+$("#quest_id").val());
								GetDataTable("example1", aJaxURL, "get_list_detail", 4, "quest_id="+$("#quest_id").val(), 0, "", 1, "asc",'',change_colum_main);
				        		CloseDialog("add-answer");
							}
						}
				    }
			    });
				}else{
					alert('ჩეკ-ბოქის და რადიო-ბოქსის ერთად დამატება აკრძალულია!');
				} 
			}   					
		});	    

	    $(document).on("click", ".combobox", function(event) {
            var i = $(this).text();
            $("#" + i).autocomplete("search", "");
        });

	$(document).on("keydown", "#production_name", function(event) {
        if (event.keyCode == $.ui.keyCode.ENTER) {
        	GetProductionInfo(this.value);
            event.preventDefault();
        }
    });


	 function GetProductionInfo(name) {
            $.ajax({
                url: aJaxURL,
                data: "act=get_product_info&name=" + name,
                success: function(data) {
                    if (typeof(data.error) != "undefined") {
                        if (data.error != "") {
                            alert(data.error);
                        } else {
                            $("#genre").val(data.genre);
                            $("#category").val(data.category);
                            $("#description").val(data.description);
                            $("#price").val(data.price);
                            $("#hidden_product_id").val(data.id);
                        }
                    }
                }
            });
        }

	 $(document).on("change", "#quest_type_id", function(event) {
		 showHiden();
	 });

     function showHiden(){
         var type = $("#quest_type_id").val();
         if(type == 3){
        	 $('#product').removeClass('dialog_hidden');
             $('#answer').addClass('dialog_hidden');
             $('#qlabel').addClass('dialog_hidden');
         }else{
             $('#answer').removeClass('dialog_hidden');
        	 $('#qlabel').removeClass('dialog_hidden');
             $('#product').addClass('dialog_hidden');
         }
     }
	   
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row" style="width: 1024px; margin: 0 auto;">
        <div id="container">        	
            <div id="dynamic">
            	<h2 align="center">კითხვა/პასუხი</h2>
            	<div id="button_area">
        			<button id="add_button">დამატება</button>
        			<button id="delete_button">წაშლა</button>
        		</div>
                <table class="display" id="example">
                    <thead >
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">დასახელება</th>
                            <th style="width: 100%;">მინიშნება</th>
                            <th class="check" style="width: 20px;">#</th>
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
                            	<input type="checkbox" name="check-all" id="check-all">
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="კითხვა">
    	<!-- aJax -->
	</div>
	
	<div id="add-answer" class="form-dialog" title="პასუხი">
    	<!-- aJax -->
	</div>
</body>
</html>