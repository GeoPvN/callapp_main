<?php
require_once("AsteriskManager/config.php");
include("AsteriskManager/sesvars.php");
if(isset($_SESSION['QSTATS']['hideloggedoff'])) {
    $ocultar=$_SESSION['QSTATS']['hideloggedoff'];
} else {
    $ocultar="false";
}
?>


<head>
<style type="text/css">
<?php                    		
if($_SESSION['USERID'] == 3 || $_SESSION['USERID'] == 1 ){
   
 
}else{
     echo '.dataTable_buttons{
            display:none;
        }';
}
?>
.hidden{
	display: none;
}
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

#box-table-b
{
	font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
	font-size: 12px;
	text-align: center;
	border-collapse: collapse;
	border-top: 7px solid #71A9D3;
	border-bottom: 7px solid #71A9D3;
}
#box-table-b th
{
	font-size: 13px;
	font-weight: normal;
	padding: 8px;
	background: #e8edff;
	border-right: 1px solid #71A9D3;
	border-left: 1px solid #71A9D3;
	color: #039;
}
#box-table-b td
{
	padding: 8px;
	background: #e8edff; 
	border-right: 1px solid #71A9D3;
	border-left: 1px solid #71A9D3;
	color: #669;
}
</style>
<script type="text/javascript">
		var aJaxURL					= "server-side/call/incomming.action.php";
		var aJaxURLl				= "server-side/call/incomming1.action.php";
		var upJaxURL				= "server-side/upload/file.action.php";
		var aJaxURL_my_call_now		= "server-side/call/incomming/incomming_my_call_now.action.php";
		var aJaxURL_my_call			= "server-side/call/incomming/incomming_my_call.action.php";
		var aJaxURL_call_now		= "server-side/call/incomming/incomming_call_now.action.php";
		var aJaxURL_all_call		= "server-side/call/incomming/incomming_all_call.action.php";
		var aJaxURL_miss_call		= "server-side/call/incomming/incomming_miss_call.action.php";
		var aJaxURL_work_miss_call	= "server-side/call/incomming/incomming_work_miss_call.action.php";
		var seoyURL	= "server-side/seoy/seoy.action.php";							//server side folder url
		var tName	= "example";
		var fName	= "add-edit-form";
		var tbName	= "tabs";
		var file_name = '';
		var rand_file = '';
		var tab_checker = '';

		$(document).ready(function () {
			
			GetTabs(tbName);   	
			GetTabs("tabs1");
			GetTabs("tabs2");
			GetTable0();
			runAjax();

			$("#tabel").button({
	            
		    });

		});

		$(document).on("tabsactivate", "#tabs", function() {
        	var tab = GetSelectedTab(tbName);
        	if (tab == 0) {
        		tab_checker = '';
        		GetTable0();
        	}else if(tab == 1){
        		tab_checker = '';
        		GetTable1();
            }else if(tab == 2){
            	tab_checker = '';
            	GetTable2()
            }else if(tab == 3){
            	tab_checker = '';
            	GetTable3()
            }else if(tab == 4){
            	var tab1 = GetSelectedTab("tabs1");
                if(tab1 == ''){
                	tab_checker = 4;
            		GetTable4('4');     
            		SetEvents1("", "delete_but", "check-all-my", "example4", fName, aJaxURL_miss_call);      		
                }
                
            }else if(tab == 5){
            	var tab2 = GetSelectedTab("tabs2");
                if(tab2 == ''){
                	tab_checker = 6;
            		GetTable5('6');     
            		SetEvents1("", "delete_but", "check-all-my", "example6", fName, aJaxURL_work_miss_call);     		
                }
            }
        });

		$(document).on("tabsactivate", "#tabs1", function() {
        	var tab1 = GetSelectedTab("tabs1");
        	if (tab1 == 0) {
        		tab_checker = 4;
        		GetTable4('4');
        		SetEvents1("", "delete_but", "check-all-my", "example4", fName, aJaxURL_miss_call);
				
        	}else if(tab1 == 1){
        		tab_checker = 5;
        		GetTable4('5');
        		SetEvents1("", "delete_but", "check-all-my", "example5", fName, aJaxURL_miss_call);
            }
        });

		$(document).on("tabsactivate", "#tabs2", function() {
        	var tab2 = GetSelectedTab("tabs2");
        	if (tab2 == 0) {
        		tab_checker = 6;
        		GetTable5('6');
        		SetEvents1("", "delete_but", "check-all-my", "example6", fName, aJaxURL_work_miss_call,"&miss_status=1");
				
        	}else if(tab2 == 1){
        		tab_checker = 7;
        		GetTable5('7');
        		SetEvents1("", "delete_but", "check-all-my", "example7", fName, aJaxURL_work_miss_call,"&miss_status=1");
            }
        });
		
		function GetTable0() {
            LoadTable0();
            GetButtons("add_button", "delete_but","");
			SetEvents("add_button", "", "", tName, fName, aJaxURL);
        }
        
		 function GetTable1() {
             LoadTable1(0,0);
  			 GetDate("search_start_my");
  			 GetDate("search_end_my");
   			 $("#search_start_my").val('0000-00-00');
    	     $("#search_end_my").val('0000-00-00');
  			 SetEvents("", "", "", "example1", fName, aJaxURL);
   			 var start 	= $("#search_start").val();
			 var end 	= $("#search_end").val();
         }
         
		 function GetTable2() {
			 var status	= $("input[name='status_n']:checked").val();
             LoadTable2(status);
             SetEvents("", "", "", "example2", fName, aJaxURL);
         }
         
		 function GetTable3() {
			LoadTable3(0,0);
			SetEvents("", "delete_but", "check-all-my", "example3", fName, aJaxURL);
			GetDate("search_start");
  			GetDate("search_end");
  			$("#search_start").val('0000-00-00');
  	   	    $("#search_end").val('0000-00-00');
  	   	    
			var start 	= $("#search_start").val();
			var end 	= $("#search_end").val();
         }

		 function GetTable4(tab_num) {			 
				GetDate("search_start_miss"+tab_num);
	  			GetDate("search_end_miss"+tab_num);
	  	   	    
				var start 	= $("#search_start_miss"+tab_num).val();
				var end 	= $("#search_end_miss"+tab_num).val();
				LoadTable4(start,end,tab_num);
	         }

		 function GetTable5(tab_num) {			 
				GetDate("search_start_miss"+tab_num);
	  			GetDate("search_end_miss"+tab_num);
	  	   	    
				var start 	= $("#search_start_miss"+tab_num).val();
				var end 	= $("#search_end_miss"+tab_num).val();
				LoadTable5(start,end,tab_num);
	         }


		function LoadTable0(){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL_my_call_now, "get_list",10, "", 0, "", 1, "desc");
		}
		
		function LoadTable1(start, end, status){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable("example1", aJaxURL_my_call, "get_list",10, "start=" + start + "&end=" + end + "&status="+status, 0, "", 1, "desc");
		}
		
		function LoadTable2(status){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable("example2", aJaxURL_call_now, "get_list&status="+status, 10, "", 0, "", 1, "desc");
		}
		
		function LoadTable3(start, end, status){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable("example3", aJaxURL_all_call, "get_list", 10, "start=" + start + "&end=" + end + "&status="+status, 0, "", 1, "desc");
		}

		function LoadTable4(start, end, tab_num){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable("example"+tab_num, aJaxURL_miss_call, "get_list", 15, "start=" + start + "&end=" + end + "&tab_num="+tab_num, 0, "", 1, "desc");
		}

		function LoadTable5(start, end, tab_num){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable("example"+tab_num, aJaxURL_work_miss_call, "get_list", 15, "start=" + start + "&end=" + end + "&tab_num="+tab_num, 0, "", 1, "desc");
		}

		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end").val();
	    	var status	= '';
	    	status = $("input[name='status_all_call']:checked").val();
	    	LoadTable3(start, end, status);
	    });
	    
	    $(document).on("change", "#search_end", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $(this).val();
	    	var status	= '';
	    	status = $("input[name='status_all_call']:checked").val();
	    	LoadTable3(start, end, status);
	    });

	    $(document).on("change", "#search_start_miss4", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end_miss"+tab_checker).val();
	    	LoadTable4(start, end, tab_checker);
	    });
	    
	    $(document).on("change", "#search_end_miss4", function () {
	    	var start	= $("#search_start_miss"+tab_checker).val();
	    	var end		= $(this).val();
	    	LoadTable4(start, end, tab_checker);
	    });
	    

	    $(document).on("change", "#search_start_miss5", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end_miss"+tab_checker).val();
	    	LoadTable4(start, end, tab_checker);
	    });
	    
	    $(document).on("change", "#search_end_miss5", function () {
	    	var start	= $("#search_start_miss"+tab_checker).val();
	    	var end		= $(this).val();
	    	LoadTable4(start, end, tab_checker);
	    });

	    //
	    $(document).on("change", "#search_start_miss6", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end_miss"+tab_checker).val();
	    	LoadTable5(start, end, tab_checker);
	    });
	    
	    $(document).on("change", "#search_end_miss6", function () {
	    	var start	= $("#search_start_miss"+tab_checker).val();
	    	var end		= $(this).val();
	    	LoadTable5(start, end, tab_checker);
	    });
	    

	    $(document).on("change", "#search_start_miss7", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end_miss"+tab_checker).val();
	    	LoadTable5(start, end, tab_checker);
	    });
	    
	    $(document).on("change", "#search_end_miss7", function () {
	    	var start	= $("#search_start_miss"+tab_checker).val();
	    	var end		= $(this).val();
	    	LoadTable5(start, end, tab_checker);
	    });

	    $(document).on("change", "#search_start_my", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end_my").val();
	    	var status	= '';
	    	status = $("input[name='status_my_call']:checked").val();
	    	LoadTable1(start, end, status);
	    });
	    
	    $(document).on("change", "#search_end_my", function () {
	    	var start	= $("#search_start_my").val();
	    	var end		= $(this).val();
	    	var status	= '';
	    	status = $("input[name='status_my_call']:checked").val();
	    	LoadTable1(start, end, status);
	    });

		$(document).on("change", "input[name='status_my_call']", function () {
			var start	= $("#search_start_my").val();
			var end		= $("#search_end_my").val();
	    	var status = $("input[name='status_my_call']:checked").val();
	    	LoadTable1(start, end, status);
	    });

		$(document).on("change", "input[name='status_call_now']", function () {
	    	var status = $("input[name='status_call_now']:checked").val();
	    	LoadTable2(status);
	    });

		$(document).on("change", "input[name='status_all_call']", function () {
			var start	= $("#search_start").val();
			var end		= $("#search_end").val();
	    	var status = $("input[name='status_all_call']:checked").val();
	    	LoadTable3(start, end, status);
	    });

		$(document).on("click", "#button_calls", function () {
			LoadDialogCalls();
			$('#refresh-dialog').click(); 
		});

		$(document).on("click", ".download", function () {
            var link = $(this).attr("str");
            link = "http://109.234.117.182:8181/records/" + link + ".wav";

            var newWin = window.open(link, "JSSite", "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");
            newWin.focus();
        });

		$(document).on("click", ".download_out", function () {
            var link = $(this).attr("str");
            link = "http://109.234.117.182:8181/records/" + link;

            var newWin = window.open(link, "JSSite", "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");
            newWin.focus();
        });

		$(document).on("click", "#add_button_product", function () {
        	var buttons = {
			        "save": {
			            text: "შენახვა",
			            id: "save_chosse_product"
			        }, 
		        	"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        }
			    };
        	LoadTable6();
		    GetDialog("add_product_chosse", 400, "auto", buttons);
		    var notes = $("#content_3").val();
        	$.ajax({
  	            url: "server-side/call/incomming/add_chosse_product.php",
  	            type: "POST",
  	            data: "act=get_table&notes="+notes,
  	            dataType: "json", 
  	            success: function (data) {
  	            	
					$("#add_product_chosse").html(data.page);
					SeoY("production_name", seoyURL, "production_name", "", 0);
  	            }
  	        });
        	$(document).on("keydown", "#production_name", function(event) {
            	if (event.keyCode == $.ui.keyCode.ENTER) {
            		GetProductionInfo(this.value);
                	event.preventDefault();
            	}
        	});
        	
        });
        
		$(document).on("click", ".combobox", function(event) {
            var i = $(this).text();
            $("#" + i).autocomplete("search", "");
        });
        
		function GetProductionInfo(name) {
            $.ajax({
                url: "server-side/call/incomming/add_chosse_product.php",
                data: "act=get_product_info&name=" + name,
                success: function(data) {
              
                            $("#genre").val(data.genre);
                            $("#category").val(data.category);
                            $("#description").val(data.description);
                            $("#price").val(data.price);
                            $("#product_id").val(data.id);
                     
                }
            });
        }

		$(document).on("click", "#save_chosse_product", function () {
        	var inc_id 			= $("#id").val();
        	var product_id		= $("#product_id").val();
        	$.ajax({
  	            url: "server-side/call/incomming/add_chosse_product.php",
  	            type: "POST",
  	            data: "act=add_product&inc_id="+inc_id+"&product_id="+product_id,
  	            dataType: "json", 
  	            success: function (data) {
  	            	$("#add_product_chosse").dialog("close");
  	            	LoadTable6();
  	            }
  	        });
        });

		/* Disable Event */
        $(document).on("click", "#delete_button_product", function () {
            var data = $(".check_p:checked").map(function () { //Get Checked checkbox array
                return this.value;
            }).get();

            for (var i = 0; i < data.length; i++) {
                $.ajax({
                    url: "server-side/call/incomming/add_chosse_product.php",
                    type: "POST",
                    data: "act=disable&delete_prod_id=" + data[i],
                    dataType: "json",
                    success: function (data) {
                        if (data.error != "") {
                            alert(data.error);
                        } else {
                            $("#check-all_p").attr("checked", false);
                        }
                    }
                });
            }
            LoadTable6();
           
        });

		function LoadTable6(){		
			var inc_id = $("#id").val();
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTableproduct("sub1", "server-side/call/incomming/add_chosse_product.php", "get_list&inc_id="+inc_id, 5, "", 0, "", 1, "asc", "");
			
		}

		function LoadDialog(){

			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 1200, "auto", "");
			var id = $("#incomming_id").val();
			var cat_id = $("#category_parent_id").val();
			$( ".calls" ).button({
			      icons: {
			        primary: " ui-icon-contact"
			      }
			});
			
			$("#read_more").button({
	            
		    });

			$("#add_product").button({
	            
		    });
		    
			$("#choose_button").button({
	            
		    });

			$(".download").button({
	            
		    });

			$(".download_out").button({
	            
		    });
		    
			$(".save-dialog").button({
	            
		    });

			$("#add_button_product").button({
	            
		    });

		    $("#delete_button_product").button({
	            
		    });
			
			LoadTable6();

			GetDateTimes("done_start_time");
			GetDateTimes("done_end_time");
		    
			$(document).on("click", "#read_more", function () {
				var button = {
						"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				                $(this).dialog("close");
				            }
				        }
					};
				GetDialog("read_more_dialog", 1000, "auto", button);
				$.ajax({
		            url: aJaxURLl,
		            type: "POST",
		            data: "act=get_add_page",
		            dataType: "json",
		            success: function (data) {
		                if (typeof (data.error) != "undefined") {
		                    if (data.error != "") {
		                        alert(data.error);
		                    } else {
		                        $("#" + "read_more_dialog").html(data.page);
		                        if ($.isFunction(window.LoadDialog)) {
		                            //execute it
		                        	GetDataTable("all_sell", aJaxURLl, "get_list", 11,"", 0, "", 1, "asc", "");
		                        }
		                    }
		                }
		            }
		        });
			});
		}

		function CloseDialog(){
			$("#" + fName).dialog("close");
		}

	    // Add - Save
	    $(document).on("click", "#save-dialog", function () {
	    	$('#save-dialog').attr('disabled','disabled');
		    param 			= new Object();
		    
		    param.act						= "save_incomming";

	    	param.id_h							= $("#h_id").val();
	    	param.miss_date                     = $("#miss_date").val();
	    	param.miss_status                   = $("#miss_status").val();
	    	param.id_p							= $("#id").val();
	    	param.c_date						= $("#c_date").val();
	    	param.phone							= $("#phone").val();
	    	param.person_name					= $("#person_name").val();
	    	param.type_id						= $("input[name='x']:checked").val();
	    	param.call_type_id					= $("input[name='xx']:checked").val();
	    	param.product_type_id				= $("input[name='xxx']:checked").val();
	    	param.card_id						= $("input[name='xxxx']:checked").val();
	    	param.source_id						= $("#source_id").val();
	    	param.department_id					= $("#department_id").val();
	    	param.information_category_id		= $("#information_category_id").val();
	    	param.information_sub_category_id	= $("#information_sub_category_id").val();
	    	param.production_category_id		= $("#production_category_id").val();
	    	param.genre_id						= $("#genre_id").val();
	    	param.production_id					= $("#production_id").val();
	    	param.content						= $("#content").val();
	    	param.sum_pirce						= $("#sum_pirce").val();
	    	param.shipping_id					= $("#shipping_id").val();
	    	param.module_id						= $("#module_id").val();
	    	param.call_comment					= $("#call_comment").val();
	    	param.call_status_id				= $("#call_status_id").val();
	    	param.task_type_id					= $("#task_type_id").val();
	    	param.task_department_id			= $("#task_department_id").val();
	    	param.persons_id					= $("#persons_id").val();
	    	param.priority_id					= $("#priority_id").val();
	    	param.done_start_time				= $("#done_start_time").val();
	    	param.done_end_time					= $("#done_end_time").val();
	    	param.comment						= $("#comment").val();
	    	param.rand_file						= rand_file;
	    	param.file_name						= file_name;
	    	param.hidden_inc					= $("#hidden_inc").val();
	    	

	    	// Personal Info
	    	param.personal_phone				= $("#personal_phone").val();
	    	param.personal_id					= $("#personal_id").val();
	    	param.personal_first_name			= $("#personal_first_name").val();
	    	param.personal_last_name			= $("#personal_last_name").val();
	    	param.personal_d_date				= $("#personal_d_date").val();
	    	param.personal_city					= $("#personal_city").val();
	    	param.personal_mail					= $("#personal_mail").val();
	    	param.personal_addres				= $("#personal_addres").val();
	    	param.personal_status				= $("#personal_status").val();
	    	param.personal_profession			= $("#personal_profession").val();

    	    if(param.miss_date === undefined){
    	    	var url_ch = aJaxURL;
    	    }else{
    	    	var url_ch = aJaxURL_miss_call;
    	    }
	    	
			if(param.phone == "" && (param.source_id == 1 || param.source_id == 0)){
				alert("შეავსეთ ტელეფონის ნომერი!");
			}else {
			    $.ajax({
			    	url: url_ch,
				    data: param,
			        success: function(data) {
						if(typeof(data.error) != 'undefined'){
							if(data.error != ''){
								alert(data.error);
							}else{
								LoadTable0();
								GetTable4('4');
								GetTable4('5');
								GetTable5('6');
								GetTable5('7');
				        		CloseDialog();
				        		
							}
						}
				    }
			    });
			}
		});



	    function run(number){

	    	param 			= new Object();
		 	param.act		= "get_add_page";
		 	param.number	= number;

	    	$.ajax({
		        url: aJaxURL,
			    data: param,
		        success: function(data) {
					if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
							$("#add-edit-form").html(data.page);
							LoadDialog();
						}
					}
			    }
		    });
		    }

	    function runAjax() {
            $.ajax({
            	async: true,
            	dataType: "html",
		        url: 'AsteriskManager/liveState.php',
			    data: 'sesvar=hideloggedoff&value=true',
		        success: function(data) {
							$(".jq").html(data);
			    }
            }).done(function(data) {
                setTimeout(runAjax, 1000);
            });
        }

	    $(document).on("click", ".number", function () {
	    	var number = $(this).attr("number");
	    	if(number != ""){
	    		run(number);
	    		console.log(number);
		    }
	    });

	    $(document).on("click", ".insert", function () {
	    	var phone = $(this).attr("number");
	    	console.log(phone);
	    	if(phone != ""){
	    		$('#phone').val(phone);
		    }
	    });

	    $(document).on("click", "input[name='xxx']:checked", function () {
	    	var phone = $("input[name='xxx']:checked").val()
	    	console.log(phone);
	    	if(phone == 1){
	    		$("#show_all").removeClass('dialog_hidden');
		    }else{
		    	$("#show_all").addClass('dialog_hidden');
		    }
	    });


	    $(document).on("change", "#information_category_id",function(){
		    var information_category_id = $("#information_category_id").val();
		    param 			= new Object();
		    param.act		= "category_change";
		    param.information_category_id_check		= information_category_id;
 	    	$.ajax({
 		    url: aJaxURL,
 			data: param,
 		    success: function(data) {
 				if(typeof(data.error) != 'undefined'){
 					if(data.error != ''){
 						alert(data.error);
 					}else{
 						$("#information_sub_category_id").html(data.cat);
 					}
 				}
 			}
 		    });
        });

    	$(document).on("change", "#category_parent_id",function(){
     	 	param 			= new Object();
 		 	param.act		= "sub_category";
 		 	param.cat_id   	= this.value;
 	    	$.ajax({
 		        url: aJaxURL,
 			    data: param,
 		        success: function(data) {
 					if(typeof(data.error) != 'undefined'){
 						if(data.error != ''){
 							alert(data.error);
 						}else{
 							$("#category_id").html(data.cat);
 						}
 					}
 			    }
 		    });
        });

    	$(document).on("change", "#production_category_id",function(){
     	 	param 							= new Object();
 		 	param.act						= "production_category";
 		 	param.production_category_id   	= $("#production_category_id").val();
 		 	param.genre_id   				= $("#genre_id").val();
 	    	$.ajax({
 		        url: aJaxURL,
 			    data: param,
 		        success: function(data) {
 					if(typeof(data.error) != 'undefined'){
 						if(data.error != ''){
 							alert(data.error);
 						}else{
 							$("#production_id").html(data.page);
 						}
 					}
 			    }
 		    });
        });

    	$(document).on("change", "#genre_id",function(){
     	 	param 							= new Object();
 		 	param.act						= "production_category";
 		 	param.production_category_id   	= $("#production_category_id").val();
 		 	param.genre_id   				= $("#genre_id").val();
 	    	$.ajax({
 		        url: aJaxURL,
 			    data: param,
 		        success: function(data) {
 					if(typeof(data.error) != 'undefined'){
 						if(data.error != ''){
 							alert(data.error);
 						}else{
 							$("#production_id").html(data.page);
 						}
 					}
 			    }
 		    });
        });

    	$(document).on("change", "#category_id",function(){
			if(this.value == 423){
				$(".friend").removeClass('hidden');
			}else{
				$(".friend").addClass('hidden');
			}
        });

	    $(document).on("click", "#refresh-dialog", function () {
    	 	param 			= new Object();
		 	param.act		= "get_calls";

	    	$.ajax({
		        url: aJaxURL,
			    data: param,
		        success: function(data) {
					if(typeof(data.error) != 'undefined'){
						if(data.error != ''){
							alert(data.error);
						}else{
							$("#last_calls").html(data.calls);
							$( ".insert" ).button({
							      icons: {
							        primary: "ui-icon-plus"
							      }
							});
						}
					}
			    }
		    });

	    });
//
	    $(document).on("keydown", "#personal_pin", function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER) {

            	param 			= new Object();
    		 	param.act		= "get_add_info";
    		 	param.pin		= $("#personal_pin").val();

    	    	$.ajax({
    		        url: aJaxURL,
    			    data: param,
    		        success: function(data) {
    					if(typeof(data.error) != 'undefined'){
    						if(data.error != ''){
    							alert(data.error);
    						}else{
    							$("#additional_info").html(data.info);
    						}
    					}
    			    }
    		    });
                
                event.preventDefault();
            }
        });
//
	    $(document).on("keydown", "#personal_id", function(event) {
            if (event.keyCode == $.ui.keyCode.ENTER) {

            	param 					= new Object();
    		 	param.act				= "get_add_info1";
    		 	param.personal_id		= $("#personal_id").val();

    	    	$.ajax({
    		        url: aJaxURL,
    			    data: param,
    		        success: function(data) {
    					if(typeof(data.error) != 'undefined'){
    						if(data.error != ''){
    							alert(data.error);
    						}else{
    							$("#additional_info").html(data.info1);
    						}
    					}
    			    }
    		    });
                
                event.preventDefault();
            }
        });

	    function LoadDialogCalls(){
			var button = {
               		"save": {
               			text: "განახლება",
               			id: "refresh-dialog",
               			click: function () {
               			}
               		}
				};

			/* Dialog Form Selector Name, Buttons Array */
			GetDialogCalls('last_calls', 330, 550, button);
		}

	    // გადმოწერა
	    $(document).on("click", "#download", function () {
	    	var download_file	= $(this).val();
	    	var download_name 	= download_file.substr(19);
	    	SaveToDisk(download_file, download_name);
	    });

	    function SaveToDisk(fileURL, fileName) {
	        // for non-IE
	        if (!window.ActiveXObject) {
	            var save = document.createElement('a');
	            save.href = fileURL;
	            save.target = '_blank';
	            save.download = fileName || 'unknown';

	            var event = document.createEvent('Event');
	            event.initEvent('click', true, true);
	            save.dispatchEvent(event);
	            (window.URL || window.webkitURL).revokeObjectURL(save.href);
	        }
		     // for IE
	        else if ( !! window.ActiveXObject && document.execCommand)     {
	            var _window = window.open(fileURL, "_blank");
	            _window.document.close();
	            _window.document.execCommand('SaveAs', true, fileName || fileURL)
	            _window.close();
	        }
	    } 
	    
	    $(document).on("click", "#delete", function () {
	    	var delete_id	= $(this).val();
	    	
	    	$.ajax({
		        url: aJaxURL,
			    data: {
					act: "delete_file",
					delete_id: delete_id,
					edit_id: $("#id").val(),
				},
		        success: function(data) {
			        $("#file_div").html(data.page);
			    }
		    });	
		});
		
	    $(document).on("click", "#choose_button", function () {
		    $("#choose_file").click();
		});
		
	    $(document).on("change", "#choose_file", function () {
	    	var file		= $(this).val();	    
	    	var files 		= this.files[0];
		    var name		= uniqid();
		    var path		= "../../media/uploads/file/";
		    
		    var ext = file.split('.').pop().toLowerCase();
	        if($.inArray(ext, ['pdf','png','xls','xlsx','jpg','docx','doc','csv']) == -1) { //echeck file type
	        	alert('This is not an allowed file type.');
                this.value = '';
	        }else{
	        	file_name = files.name;
	        	rand_file = name + "." + ext;
	        	$.ajaxFileUpload({
	    			url: upJaxURL,
	    			secureuri: false,
	    			fileElementId: "choose_file",
	    			dataType: 'json',
	    			data:{
						act: "upload_file",
						path: path,
						file_name: name,
						type: ext
					},
	    			success: function (data, status){
	    				if(typeof(data.error) != 'undefined'){
    						if(data.error != ''){
    							alert(data.error);
    						}
    					}
    							
	    				$.ajax({
					        url: aJaxURL,
						    data: {
								act: "up_now",
								rand_file: rand_file,
					    		file_name: file_name,
								edit_id: $("#id").val(),

							},
					        success: function(data) {
						        $("#file_div").html(data.page);
						    }
					    });	   					    				
    				},
    				error: function (data, status, e)
    				{
    					alert(e);
    				}    				
    			});
	        }
		});
			  
	     function LoadDialogCalls(){
				var button = {
	               		"save": {
	               			text: "განახლება",
	               			id: "refresh-dialog",
	               			click: function () {
	               			}
	               		}
					};

				/* Dialog Form Selector Name, Buttons Array */
				GetDialogCalls('last_calls', 330, 550, button);
			}

    </script>
</head>

<body>
<div id="tabs" style="width: 98%; margin: 0 auto; min-height: 768px; margin-top: 25px;">
		<ul>
			<li><a href="#tab-0">ჩემი ზარები დღეს</a></li>
			<li><a href="#tab-1">ჩემი ზარები</a></li>
			<li><a href="#tab-2">ზარები დღეს</a></li>
			<li><a href="#tab-3">ყველა ზარი</a></li>
			<li><a href="#tab-4">გამოტოვებული</a></li>
			<li><a href="#tab-5">უპასუხო</a></li>
		</ul>
		<div id="tab-0">
		<table style="width: 1100px; margin: 0 0 0 30px; padding-top:25px; display: block;">
		<tr style="width: 1000px">
			<td>
            	<h2 align="center" >შემომავალი ზარები</h2>
            	<div id="button_area" >
        			<button id="add_button">დამატება</button>
        			<button id="tabel" onclick="location.reload();location.href='index.php?pg=32'">ტაბელი</button>
        		</div>
                <table class="display" id="example" style="width: 800px">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 50px;" >№</th>
                            <th style="width: 140px;">თარიღი</th>
                            <th style="width: 130px;">განყოფილებები</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>                            
                            <th style="width: 90px;">სახელი</th>
                            <th style="width: 120px;">ტელეფონი</th>
                            <th style="width: 80%;">ზარის სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                            	<input style="width: 20px;" type="text" name="search_number" value="" class="search_init" style=""></th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>    
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>                         
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    <td style="width: 20px;">
		   &nbsp;
		</td>
		<td style="width: 450px;">
		   <div id="jq" class="jq" style="width: 450px; position: absolute; z-index: 9;"></div>
		</td>
	</tr>
</table>
</div>
<div id="tab-1">
		<table style="width: 1100px; margin: 0 0 0 30px; padding-top:25px; display: block;">
		<tr style="width: 1000px">
			<td>
				<h2 align="center">ჩემი ზარები</h2>
				<table style="position: absolute; width: 350px;">
				<tr>
				<td><input style="float: left;" type="radio" name="status_my_call" value="1" ><span style="margin-top:5px; display:block;">ინფორმაცია</span></td>
				<td><input style="float: left;" type="radio" name="status_my_call" value="2" ><span style="margin-top:5px; display:block;">პრეტენზია</span></td>
				<td><input style="float: left;" type="radio" name="status_my_call" value="3" ><span style="margin-top:5px; display:block;">სხვა</span></td>
				</tr>
				</table>
            	<div id="button_area" style="margin-top: 50px;">
	            	<div class="left" style="width: 250px;">
	            		<label for="search_start_my" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_start_my" id="search_start_my" class="inpt left"/>
	            	</div>
	            	<div class="right" style="">
	            		<label for="search_end_my" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_end_my" id="search_end_my" class="inpt right" />
            		</div>	
            	</div>
                <table class="display" id="example1" style="width: 800px">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 50px;" >№</th>
                            <th style="width: 140px;">თარიღი</th>
                            <th style="width: 130px;">განყოფილებები</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>                            
                            <th style="width: 90px;">სახელი</th>
                            <th style="width: 120px;">ტელეფონი</th>
                            <th style="width: 80%;">ზარის სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                            	<input style="width: 20px;" type="text" name="search_number" value="" class="search_init" style=""></th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>    
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>    
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>                     
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    <td style="width: 20px;">
		   &nbsp;
		</td>
		<td style="width: 450px;">
		   <div id="jq" class="jq" style="width: 450px; position: absolute; z-index: 9;"></div>
		</td>
	</tr>
</table>
</div>
<div id="tab-2">
		<table style="width: 1100px; margin: 0 0 0 100px; padding-top:25px; display: block;">
		<tr style="width: 1000px">
			<td>
            	<h2 align="center">ზარები დღეს</h2>
            	<table style="position: absolute; width: 350px;">
				<tr>
				<td><input style="float: left;" type="radio" name="status_call_now" value="1" ><span style="margin-top:5px; display:block;">ინფორმაცია</span></td>
				<td><input style="float: left;" type="radio" name="status_call_now" value="2" ><span style="margin-top:5px; display:block;">პრეტენზია</span></td>
				<td><input style="float: left;" type="radio" name="status_call_now" value="3" ><span style="margin-top:5px; display:block;">სხვა</span></td>
				</tr>
				</table>
            	<div id="button_area">
        		</div>
                <table class="display" id="example2">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 140px;">თარიღი</th>
                            <th style="width: 130px;">განყოფილებები</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>
                            <th style="width: 120px;">სახელი</th>
                            <th style="width: 120px;">ტელეფონი</th>
                            <th style="width: 100%;">ზარის დაზუსტება</th>
                            <th style="width: 100%;">ზარის სტატუსი</th>
                            <th style="width: 100%;">ოპერატორი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>     
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th> 
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>  
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
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	</tr>
</table>
</div>
<div id="tab-3">
		<table style="width: 1100px; margin: 0 0 0 100px; padding-top:25px; display: block;">
		<tr style="width: 1000px">
			<td>
            	<h2 align="center"style="">ყველა ზარი</h2>
            	<table style="position: absolute; width: 350px;">
				<tr>
				<td><input style="float: left;" type="radio" name="status_all_call" value="1" ><span style="margin-top:5px; display:block;">ინფორმაცია</span></td>
				<td><input style="float: left;" type="radio" name="status_all_call" value="2" ><span style="margin-top:5px; display:block;">პრეტენზია</span></td>
				<td><input style="float: left;" type="radio" name="status_all_call" value="3" ><span style="margin-top:5px; display:block;">სხვა</span></td>
				</tr>
				</table>
            	<div id="button_area" style="margin-top: 50px;">
	            	<div class="left" style="width: 250px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_start" id="search_start" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_end" id="search_end" class="inpt right" />
            		</div>
            		<?php
            		$checker = '';
                	if($_SESSION['USERID'] == 1 || $_SESSION['USERID'] == 3){
                	    $checker = '';
                	}else{
                	    $checker = "display:none;";
                	}
                	?>
            		<button id="delete_but" style="float: left; margin-left: 5px; <?php echo $checker;?>">წაშლა</button>	
            	</div>
            	<div id="get-info" style="float : left; margin-left: 30px; margin-top: 50px;"></div>
                <table class="display" id="example3">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">განყოფილებები</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>
                            <th style="width: 120px;">სახელი</th>
                            <th style="width: 100%;">ტელეფონი</th>
                            <th style="width: 100%;">ზარის დაზუსტება</th>
                            <th style="width: 100%;">ზარის სტატუსი</th>
                            <th style="width: 100%;">ოპერატორი</th>
                            <th style="width: 20%;">#</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>  
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th> 
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
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
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
    							<input type="checkbox" name="check-all" id="check-all-my"/>
    						</th>
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    
	</tr>
</table>
</div>
<div id="tab-4">
<div id="tabs1" style="width: 98%; margin: 0 auto; min-height: 768px; margin-top: 25px;">
		<ul>
			<li><a href="#tab1-0">მიმდინარე</a></li>
			<li><a href="#tab1-1">დასრულებული</a></li>
		</ul>
		<div id="tab1-0">
		<table style="width: 1100px; margin: 0 0 0 100px; padding-top:25px; display: block;">
		<tr style="width: 1000px">
			<td>
            	<h2 align="center"style="">მიმდინარე</h2>            	
            	<div id="button_area" style="margin-top: 30px;">
	            	<div class="left" style="width: 250px;">
	            		<label for="search_start_miss" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_start" id="search_start_miss4" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end_miss" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_end" id="search_end_miss4" class="inpt right" />
            		</div>
            	</div>
            	<div id="get-info" style="float : left; margin-left: 30px; margin-top: 50px;"></div>
                <table class="display" id="example4">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">წყარო</th>
                            <th style="width: 100%;">ადრესატი</th>
                            <th style="width: 100%;">ლოდინის დრო</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>  
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th> 
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
                            
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    
	</tr>
</table>
</div>
<div id="tab1-1">
		<table style="padding-top:25px; display: block;">
		<tr style="width: 1100px">
			<td>
            	<h2 align="center"style="">დასრულებული</h2>            	
            	<div id="button_area" style="margin-top: 30px;">
	            	<div class="left" style="width: 250px;">
	            		<label for="search_start_miss" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_start" id="search_start_miss5" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end_miss" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_end" id="search_end_miss5" class="inpt right" />
            		</div>
            	</div>
            	<div id="get-info" style="float : left; margin-left: 30px; margin-top: 50px;"></div>
                <table class="display" id="example5">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">წყარო</th>
                            <th style="width: 100%;">ადრესატი</th>
                            <th style="width: 100%;">ლოდ. დრო</th>
                            <th style="width: 100%;">განყოფილებები</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>
                            <th style="width: 120px;">სახელი</th>
                            <th style="width: 100%;">ტელეფონი</th>
                            <th style="width: 100%;">ზარის დაზუსტება</th>
                            <th style="width: 100%;">ზარის სტატუსი</th>
                            <th style="width: 100%;">ოპერატორი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>  
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th> 
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
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
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    
	</tr>
</table>
</div>
</div>
</div>
<div id="tab-5">
<div id="tabs2" style="width: 98%; margin: 0 auto; min-height: 768px; margin-top: 25px;">
		<ul>
			<li><a href="#tab2-0">მიმდინარე</a></li>
			<li><a href="#tab2-1">დასრულებული</a></li>
		</ul>
		<div id="tab2-0">
		<table style="width: 1100px; margin: 0 0 0 100px; padding-top:25px; display: block;">
		<tr style="width: 1000px">
			<td>
            	<h2 align="center"style="">მიმდინარე</h2>            	
            	<div id="button_area" style="margin-top: 30px;">
	            	<div class="left" style="width: 250px;">
	            		<label for="search_start_miss" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_start" id="search_start_miss6" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end_miss" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_end" id="search_end_miss6" class="inpt right" />
            		</div>
            	</div>
            	<div id="get-info" style="float : left; margin-left: 30px; margin-top: 50px;"></div>
                <table class="display" id="example6">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">წყარო</th>
                            <th style="width: 100%;">ადრესატი</th>
                            <th style="width: 100%;">ლოდინის დრო</th>                            
                            <th style="width: 100%;">სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>  
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th> 
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    
	</tr>
</table>
</div>
<div id="tab2-1">
		<table style="padding-top:25px; display: block;">
		<tr style="width: 1100px">
			<td>
            	<h2 align="center"style="">დასრულებული</h2>            	
            	<div id="button_area" style="margin-top: 30px;">
	            	<div class="left" style="width: 250px;">
	            		<label for="search_start_miss" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_start" id="search_start_miss7" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end_miss" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 100px; margin-left: 5px; height: 18px;" type="text" name="search_end" id="search_end_miss7" class="inpt right" />
            		</div>
            	</div>
            	<div id="get-info" style="float : left; margin-left: 30px; margin-top: 50px;"></div>
                <table class="display" id="example7">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">წყარო</th>
                            <th style="width: 100%;">ადრესატი</th>
                            <th style="width: 100%;">ლოდ. დრო</th>
                            <th style="width: 100%;">განყოფილებები</th>
                            <th style="width: 100%;">კატეგორია</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>
                            <th style="width: 120px;">სახელი</th>
                            <th style="width: 100%;">ტელეფონი</th>
                            <th style="width: 100%;">ზარის დაზუსტება</th>
                            <th style="width: 100%;">ზარის სტატუსი</th>
                            <th style="width: 100%;">ოპერატორი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>  
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th> 
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 100px;"/>
                            </th>
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
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                        </tr>
                    </thead>
                </table>
	            <div class="spacer">
	         </div>
	    
	</tr>
</table>
</div>
</div>
</div>
</div>

    <!-- jQuery Dialog -->
    <div  id="add-edit-form" class="form-dialog" title="შემომავალი ზარი">
	</div>

	<!-- jQuery Dialog -->
	<div id="last_calls" title="ბოლო ზარები">
	</div>
	
	<!-- jQuery Dialog -->
	<div id="read_more_dialog" class="form-dialog" title="ყველა გაყიდვა">
	</div>
	
	<!-- jQuery Dialog -->
	<div id="add_product_chosse" class="form-dialog" title="ყველა გაყიდვა">
	</div>
	
</body>