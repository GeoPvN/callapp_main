<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/report/report_done_undone.action.php";	//server side folder url
		var tName	= "example";											//table name
		
		$(document).ready(function () {
			GetDate("search_start");

			var start 	= $("#search_start").val();
			var ext     = $("#ext").val();
			LoadTable(start, ext);
		});

		function LoadTable(start, ext){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 10, "start=" + start + "&ext=" + ext, 0, "", 1, "desc");
		}

		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var ext     = $("#ext").val();
	    	LoadTable(start, ext);
	    });

	    $(document).on("change", "#ext", function () {
	    	var start	= $("#search_start").val();
	    	var ext     = $("#ext").val();
	    	LoadTable(start, ext);
	    });

	    function opendialog(ext, result_quest){
	    	var start	= $("#search_start").val();
	    	var buttons = {						
		        	"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        }
			    };
	    	GetDialog("opendialog", 1060, "auto", buttons);
	    	$.ajax({
	            url: aJaxURL,
	            type: "POST",
	            data: "act=get_page",
	            dataType: "json",
	            success: function (data) {	                
	            	   $("#opendialog").html(data.page);
	            	   GetDataTable("example1", aJaxURL, "get_out_call", 9, "start=" + start + "&ext=" + ext + "&result_quest=" + result_quest, 0, "", 1, "desc");
	            	   SetEvents("", "", "", "example1", "add-edit-form1", "server-side/call/outgoing/outgoing_tab0.action.php");
	            }
	        });
	    }

	    $(document).on("click", ".download", function () {
	    	link = 'http://109.234.117.182:8181/records/' + $(this).attr('str');
			var newWin = window.open(link, 'newWin','width=420,height=200');
            newWin.focus();
	    });
	    
	    function LoadTable5(){		
		    var scenar_name =	$("#shabloni").val();
			GetButtons("add_button_product","delete_button_product");
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTableproduct("sub1", "server-side/call/outgoing/suboutgoing/outgoing_tab1.action.php", "get_list&scenar_name="+scenar_name, 5, "", 0, "", 1, "asc", "");
		}
		
	    function LoadDialog(fName){
			switch(fName){				
				case "add-edit-form1":
					var buttons = {						
			        	"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				            	$(this).dialog("close");
				            }
				        }
				    };
					GetDialog("add-edit-form1", 1150, "auto", buttons);
					$(".download").button({
			            
				    });
					$(".done").button({
			            
				    });
					$(".next").button({
			            
				    });
					$(".back").button({
			            
				    });
					$("#add_button_product").button({
			            
				    });
					$("#add_button_gift").button({
					    
					});
					$("#complete").button({
					    
					});
					LoadTable5();
					GetDateTimes("set_start_time");
					GetDateTimes("set_done_time");
					GetDateTimes("send_time");
			        
				break;	
			}
		
		}

	    function seller(id){
			if(id == '0'){
				$('#seller-0').removeClass('dialog_hidden');
	            $('#0').addClass('seller_select');
	            $('#seller-1').addClass('dialog_hidden');
	            $('#seller-2').addClass('dialog_hidden');
	            $('#1').removeClass('seller_select');
	            $('#2').removeClass('seller_select');
			}else if(id == '1'){
				$('#seller-1').removeClass('dialog_hidden');
	            $('#1').addClass('seller_select');
	            $('#seller-0').addClass('dialog_hidden');
	            $('#seller-2').addClass('dialog_hidden');
	            $('#0').removeClass('seller_select');
	            $('#2').removeClass('seller_select');
			}else if(id == '2'){
				$('#seller-2').removeClass('dialog_hidden');
	            $('#2').addClass('seller_select');
	            $('#seller-1').addClass('dialog_hidden');
	            $('#seller-0').addClass('dialog_hidden');
	            $('#1').removeClass('seller_select');
	            $('#0').removeClass('seller_select');
			}
		}

		function research(id){
			if(id == 'r0'){
				$('#research-0').removeClass('dialog_hidden');
	            $('#r0').addClass('seller_select');
	            $('#research-1').addClass('dialog_hidden');
	            $('#research-2').addClass('dialog_hidden');
	            $('#r1').removeClass('seller_select');
	            $('#r2').removeClass('seller_select');
			}else if(id == 'r1'){
				$('#research-1').removeClass('dialog_hidden');
	            $('#r1').addClass('seller_select');
	            $('#research-0').addClass('dialog_hidden');
	            $('#research-2').addClass('dialog_hidden');
	            $('#r0').removeClass('seller_select');
	            $('#r2').removeClass('seller_select');
			}else if(id == 'r2'){
				$('#research-2').removeClass('dialog_hidden');
	            $('#r2').addClass('seller_select');
	            $('#research-1').addClass('dialog_hidden');
	            $('#research-0').addClass('dialog_hidden');
	            $('#r1').removeClass('seller_select');
	            $('#r0').removeClass('seller_select');
			}
		}
	    
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 85%;">        	
            <div id="dynamic">
            	<h2 align="center">შემდგარი და შეუმდგარი ზარები</h2>
            	<div id="button_area">
	            	<div class="left" style="width: 200px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">თარიღი</label>
	            		<input style="height: 13px; width: 100px;" type="text" name="search_start" id="search_start" class="inpt right"/>
	            	</div>	            		
            		<div class="right" style="">
	            		<label for="ext" class="left" style="margin: 5px 0 0 9px;">ოპერატორები</label>
	            		<select id="ext" style="margin-left: 5px;">
	            		<?php
                		include '../../includes/classes/core.php';
                		$users = mysql_query(" SELECT   users.ext,
                                                		persons.`name`
                                                FROM    users
                                                JOIN    persons ON persons.id = users.person_id
                                                WHERE   users.group_id in(15,3) AND users.ext != 'NULL'");
                		$option = '<option value="0">----</option>';
                		while ($res = mysql_fetch_array($users)){
                		    $option .= '<option value="'.$res[0].'">'.$res[1].'</option>';
                		}
                		echo $option;
                		?>
	            		</select>
            		</div>
            	</div>
                <table class="display" id="example">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">სულ ზარი</th>
                            <th style="width: 100%;">ნაპასუხები ზარი</th>
                            <th style="width: 100%;">ნაპასუხები  (ხანგრძლივობა)</th>
                            <th style="width: 100%;">უპასუხო ზარი</th>
                            <th style="width: 100%;">უპასუხო  (ხანგრძლივობა)</th>
                            <th style="width: 100%;">დადებითი</th>
                            <th style="width: 100%;">უარყოფითი</th>
                            <th style="width: 100%;">მოიფიქრებს</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style=""></th>
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
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 90px;"/>
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
    <div id="opendialog" class="form-dialog" title="test">    
	</div>
	<div id="add-edit-form1" class="form-dialog" title="test">    
	</div>
</body>