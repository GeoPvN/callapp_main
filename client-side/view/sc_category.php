<html>
<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/sc_category.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		var change_colum_main = "<'dataTable_buttons'T><'F'fipl>";
		
		$(document).ready(function () {        	
			LoadTable(tName,3,'get_list',change_colum_main);	
						
			/* Add Button ID, Delete Button ID */
			GetButtons("add_button", "delete_button");			
			SetEvents("add_button", "delete_button", "check-all", tName, fName, aJaxURL);
		});
         
		function LoadTable(tbl,col_num,act,change_colum){
	    	GetDataTable(tName, aJaxURL, act, col_num, "", 0, "", 1, "asc", '', change_colum);
	    	setTimeout(function(){
    	    	$('.ColVis, .dataTable_buttons').css('display','none');
  	    	}, 90);
	    }
		
		function LoadDialog(){
			var id		= $("#cat_id").val();
			
			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 600, "auto", "");
			$('#parent_id').chosen({ search_contains: true });
			$('#add-edit-form, .add-edit-form-class').css('overflow','visible');
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
		
	    $(document).on("click", "#show_copy_prit_exel", function () {
	        if($(this).attr('myvar') == 0){
	            $('.ColVis,.dataTable_buttons').css('display','block');
	            $(this).css('background','#2681DC');
	            $(this).children('img').attr('src','media/images/icons/select_w.png');
	            $(this).attr('myvar','1');
	        }else{
	        	$('.ColVis,.dataTable_buttons').css('display','none');
	        	$(this).css('background','#FAFAFA');
	            $(this).children('img').attr('src','media/images/icons/select.png');
	            $(this).attr('myvar','0');
	        }
	    });  
	   
    </script>
    
    <style type="text/css">
    
#table_right_menu{
    position: relative;
    float: right;
    width: 70px;
    top: 42px;
	z-index: 99;
	border: 1px solid #E6E6E6;
	padding: 4px;
}

.ColVis, .dataTable_buttons{
	z-index: 100;
}
.callapp_head{
	font-family: pvn;
	font-weight: bold;
	font-size: 20px;
	color: #2681DC;
}
    </style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">სცენარის კატეგორია<hr class="callapp_head_hr"></div>
<div style="margin-bottom: 5px;">
<div id="instruqcia">ინსტრუქცია</div>
<table id="stepby">
<tr>
<td  onclick="location.href='index.php?pg=18';" >კითხვა/პასუხი >></td><td style="color: #FFF;background: #2681DC;" onclick="location.href='index.php?pg=17';" >სცენარის კატეგორია >></td><td onclick="location.href='index.php?pg=16';">სცენარი >></td><td onclick="location.href='index.php?pg=15';">რიგი >></td><td onclick="location.href='index.php?pg=14';">კლიენტები</td>
</tr>
</table>
</div>
<div id="button_area">
	<button id="add_button">დამატება</button>
	<button id="delete_button">წაშლა</button>
</div>
<table id="table_right_menu">
<tr>
<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;background:#2681DC;"><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;"><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td style="cursor: pointer;padding: 4px;" id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>
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
            	<div class="callapp_checkbox">
                    <input type="checkbox" id="check-all" name="check-all" />
                    <label for="check-all"></label>
                </div>
            </th>
        </tr>
    </thead>
</table>
        
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="ინფორმაციის კატეგორიები">
    	<!-- aJax -->
	</div>
</body>
</html>
