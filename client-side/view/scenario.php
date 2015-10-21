<html>
<head>
<style type="text/css">
.colum_hidden{
	display: none;
}
#add-edit-form{
	overflow: visible;
}
</style>
	<script type="text/javascript">
		var aJaxURL	= "server-side/view/scenario.action.php";	//server side folder url
		var tName	= "table_";								//table name
		var fName	= "add-edit-form";							//form name
		var tbName	= "tabs";
		var change_colum_main = "<'dataTable_buttons'T><'F'fipl>";
		var lenght = [[10, 30, 50, -1], [10, 30, 50, "ყველა"]];
		    	
		$(document).ready(function () {
			LoadTable('index',4,'get_list',change_colum_main,'',lenght);
                  // ServerLink,  AddButtonID,    DeleteButtonID,     CheckAllID,  DialogID,   SaveDialogID,  CloseDialogID,  DialogHeight,  DialogPosition,  DialogOpenAct,     DeleteAct        EditDialogAct        TableID  ColumNum     TableAct       TableFunction      TablePageNum     TableOtherParam    InDialogTable
	        MyEvent(   aJaxURL,  'add_button', 'delete_button', 'check-all', '', 'save-dialog', 'cancel-dialog',      835,       'center top',  'get_add_page', 'disable', 'get_edit_page',  'index',   4,        'get_list', "<'dataTable_buttons'T><'F'fipl>",      '',        'hidden_id='+$('#hidden_id').val(),1,'');
	        
		});
 
		function GetTable() {
			alert($("#quest_id").val());
			LoadTable('quest',3,'get_list_detail',"<'F'lip>",'id='+$("#quest_id").val(),lenght);			
			MyEvent(   aJaxURL,  'add_button_detail', 'delete_button_detail', 'check-all-de', '-answer', 'save-answer', 'cancel-dialog',      480,       'center top',  'get_add_page', 'disable', 'get_edit_page',  'quest',   3,        'get_list_detail', "<'F'fipl>",      lenght,        $("#quest_id").val(),'','add_id='+$("#quest_id").val(),'quest_detail_id='+$("#quest_id").val());
			$('#tab_content_2').css('display','none');
			$('#tab1').css('background','#FFF');
			
        }
        
		 function GetTable1() {
			 $.ajax({
			        url: aJaxURL,
				    data: "act=get_edit_page&id="+$("#quest_id").val(),
			        success: function(data) {			        
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								$("#xaiden").html(data.page);
								$("#add-edit-form #tab_content_2").html($("#xaiden #tab_content_2").html());
								$("#xaiden").html('');
								$('.scenarquest').chosen({ search_contains: true });
							}
						}
				    }
			    });
	    }
         

        
		function LoadTable(tbl,col_num,act,change_colum,other_act,lenght){			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName+tbl, aJaxURL, act, col_num, other_act, 0, '', 0, "desc", '', change_colum);
			setTimeout(function(){
    	    	$('.ColVis, .dataTable_buttons').css('display','none');    	    	
  	    	}, 90);
		}
		
		

		$(document).on("change", ".scenarquest", function () {
			$("#dest_checker").val(1);
		});
		
	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {	
	    	param 			= new Object();

	    	var dest_checker = $("#dest_checker").val();
	    	
		    param.act		       = "save_quest";
	    	param.id	           = $("#quest_id").val();
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
								LoadTable('index',4,'get_list',change_colum_main,'',lenght);
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

	    $(document).on("click", "#tab1", function () {
		    $('#tab_content_1').css('display','block');
		    $('#tab_content_2').css('display','none');
		    $(this).css('background','#FFF');
		    $('#tab2').css('background','#F9F9F9');
	    });

	    $(document).on("click", "#tab2", function () {
		    $('#tab_content_2').css('display','block');
		    $('#tab_content_1').css('display','none');
		    $(this).css('background','#FFF');
		    $('#tab1').css('background','#F9F9F9');
		    GetTable1();
	    });
	    

	    $(document).on("click", "#save-answer", function () {	
	    	param 			= new Object();

		    param.act		        = "save_answer";
		    param.add_id	        = $("#add-edit-form-answer #add_id").val();
		    param.quest_id	        = $("#add-edit-form-answer #quest_id").val();
	    	param.quest_detail_id   = $("#add-edit-form-answer #quest_detail_id").val();
	    	param.quest_id1         = $("#add-edit-form-answer #quest_id1").val();
	    	
	    	
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
								LoadTable('quest',3,'get_list_detail',"<'F'lip>",'id='+$("#quest_id").val(),lenght);
								CloseDialog("add-edit-form-answer");
							}
						}
				    }
			    });
			}	    					
		});	    

	    $(document).on("change", "#cat", function () {
	    	$.ajax({
		        url: aJaxURL,
			    data: "act=get_scen_cat&cat_id="+$("#cat").val(),
		        success: function(data) {			        
					if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
						    $("#le_cat").html(data.cat);
						    $('#le_cat').trigger("chosen:updated");
						}
					}
			    }
		    });	    	
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
#callapp_tab{
	background-color: #fff;
    border-radius: 5px 5px 0 0;
    padding: 12px 5px;
}

#callapp_tab span{
    border: 1px solid #EDEDED;
    border-radius: 4px;
    padding: 5px;
    margin-right: 3px;
	cursor: pointer;
	font-size: 12px;
	background: #F9F9F9;
}
#callapp_tab span:HOVER{
	background: #FFF;
}
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

#table_quest_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_quest_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
</style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">სცენარი<hr class="callapp_head_hr"></div>

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
<table class="display" id="table_index">
    <thead >
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width: 100%;">დასახელება</th>
            <th style="width: 100%;">კატეგორია</th>
            <th style="width: 100%;">ქვე-კატეგორია</th>
            <th class="check" style="width: 20px;"></th>
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
            	<div class="callapp_checkbox">
                    <input type="checkbox" id="check-all" name="check-all" />
                    <label for="check-all"></label>
                </div>
            </th>
        </tr>
    </thead>
</table>
    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="სცენარი">
    	<!-- aJax -->
	</div>
	
	<div id="add-edit-form-answer" class="form-dialog" title="კითხვა">
    	<!-- aJax -->
	</div>
	
	<div style="display: none;" id="xaiden"></div>
</body>
</html>