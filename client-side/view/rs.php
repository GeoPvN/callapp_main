<html>
<head>
    
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/rs.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		    	
		$(document).ready(function () {        	
			LoadTable();	
						
			/* Add Button ID, Delete Button ID */
			SetEvents("", "", "", tName, fName, aJaxURL);
		});
        
		function LoadTable(){
			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 2, "", 0, "", 1, "desc");
    		
		}
		
		function LoadDialog(){
			var id		= $("#paytype_id").val();
			
			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 650, "auto", "");
			tinymce.init({    
			    selector: "#theacte",      
			    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|"
			});
	    	tinymce.init({    
			    selector: "#theactee",      
			    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|"
			});
			var ed = tinyMCE.get('theacte').getContent();	
			var edd = tinyMCE.get('theactee').getContent();
		}
		
	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {
		    param 			= new Object();

		    param.act		    ="save_paytype";
	    	param.id		    = $("#paytype_id").val();
	    	param.theacte		= tinyMCE.get('theacte').getContent();
	    	param.theactee		= tinyMCE.get('theactee').getContent();
	    	
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
		});

	   
    </script>
</head>

<body>
<?php require_once('includes/classes/core.php');
if($_SESSION['USERID']!=1){
    $var = "display:none;";
}else{
    $var = "";
}
?>
    <div id="dt_example" class="ex_highlight_row" style="width: 1024px; margin: 0 auto; <?php echo $var;?>">
        <div id="container">        	
            <div id="dynamic">
            	<h2 align="center">მიღება ჩაბარება</h2>
            	<div id="button_area">
        		</div>
                <table class="display" id="example">
                    <thead >
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">სახელი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                                <input type="hidden" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <h1 style="width: 355px; margin: auto;">მონაცემები ვერ მოიძებნა!!!</h1>
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="ქალაქი">
    	<!-- aJax -->
	</div>
</body>
</html>


