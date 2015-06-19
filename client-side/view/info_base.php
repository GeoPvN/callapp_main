<html>
<head>
<style type="text/css">
table.display tbody td
{
	word-break: break-all !important;
	word-wrap: break-word !important;
	text-overflow: ellipsis !important;
	overflow: hidden !important;
	-ms-word-break: break-all;
     word-break: break-all;
     word-break: break-word;
	-webkit-hyphens: auto;
   -moz-hyphens: auto;
        hyphens: auto;
	white-space: normal !important;
	vertical-align: middle !important;
}
</style>
<script src="http://www.tinymce.com/js/tinymce_3_x/jscripts/tiny_mce/tiny_mce_jquery.js"></script>
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/info_base.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		    	
		$(document).ready(function () {        	
			LoadTable();	
			GetButtons("add_button", "delete_button");
			/* Add Button ID, Delete Button ID */
			SetEvents("add_button", "delete_button", "check-all", tName, fName, aJaxURL);
		});
        
		function LoadTable(){
			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 2, "", 0, "", 1, "desc");
    		
		}
		
		function LoadDialog(){
			var id		= $("#status_id").val();
			
			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 750, "auto", "");
			tinymce.init({    
			    selector: "#call_status",               
			    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|"
			});
			var ed = tinyMCE.get('call_status').getContent();
		}
		
	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {
		    param 			= new Object();
		    var ed = tinyMCE.get('call_status').getContent();

		    param.act			="save_status";
	    	param.id			= $("#status_id").val();
	    	param.name			= $("#name").val();
	    	param.call_status	= ed;
	    	
			if(param.name == ""){
				alert("შეავსეთ ველი!");
			}else {
			    $.ajax({
			        url: aJaxURL,
				    data: param,
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
			}
		});

	   
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row" style="width: 1024px; margin: 0 auto;">
        <div id="container">        	
            <div id="dynamic">
            	<h2 align="center">გაიდლაინი</h2>
            	<div id="button_area">
        			<button id="add_button">დამატება</button>
        			<button id="delete_button">წაშლა</button>
        		</div>
            	<table class="display" id="example">
                    <thead >
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 40%;">სათაური</th>
                        	<th class="check">#</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
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
    <div id="add-edit-form" class="form-dialog" title="ოჯახური სტატუსი">
    	<!-- aJax -->
	</div>
</body>
</html>