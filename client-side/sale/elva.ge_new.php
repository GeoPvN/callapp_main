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
#add_product, #in_page{
	  overflow: visible !important;
}
.colum_hidden{
    display: none;
}
#sub1 td:nth-child(6){
	text-align: center;
}
#sub1 td:nth-child(1){
	display: none;
}
#sub1 td:nth-child(7){
	text-align: right;
}
#sub1 td:nth-child(8){
	text-align: right;
}

#example td:nth-child(11){
	text-align: right;
}
#example1 td:nth-child(11){
	text-align: right;
}
#example2 td:nth-child(11){
	text-align: right;
}
#example3 td:nth-child(11){
	text-align: right;
}
#example4 td:nth-child(11){
	text-align: right;
}
#example5 td:nth-child(11){
	text-align: right;
}
#example6 td:nth-child(11){
	text-align: right;
}
#example7 td:nth-child(11){
	text-align: right;
}

</style>

	<script type="text/javascript">
		var aJaxURL	= "server-side/sale/elva.ge_new.action.php";	//server side folder url
		var seoyURL	= "server-side/seoy/seoy.action.php";							//server side folder url
		var tName	= "example";
		var tbName	= "tabs";											//table name

		$(document).ready(function () {
			GetTabs(tbName);
			GetTabs("tabs_main");
			GetDate("search_start");
			GetDate("search_end");
			$('#date_type, #dep_id, #cash_checker').chosen({ search_contains: true });
			var start 	= $("#search_start").val();
			var end 	= $("#search_end").val();
			var dep_id  = $('#dep_id').val();
			var date_type = $('#date_type').val();
			var cash_ch = $('#cash_checker').val();
			GetButtons("add_id","delete_id");
			LoadTable(start,end,cash_ch,7,dep_id,date_type);			
			SetEvents('add_id','','check-all-in',"example7",'in_page',aJaxURL,1);	
			$("#send_book").button();
			checkall('check-all-in7',7);
		});

		function checkall(checker_id,tname){
			if(tname==0){
				tname='';
			}
			$("#" + checker_id).on("click", function () {
		    	$("#example" + tname + " INPUT[type='checkbox']").prop("checked", $("#" + checker_id).is(":checked"));
		    });
		}

		$(document).on("click", "#delete_id", function () {
			var tab = GetSelectedTab('tabs_main');
			if(tab == 0){
				class_num = 7;
			}else{
				class_num = tab-1;
			}
			$(".check"+class_num+":checked").map(function () { //Get Checked checkbox array
				;	        

	            $.ajax({
	                url: aJaxURL,
	                type: "POST",
	                data: "act=disable&id=" + this.value + "&dep=" + $(this).attr("dep"),
	                dataType: "json",
	                success: function (data) {
	                	    $("#check-all-in" + class_num).attr("checked", false);
    	                	var start 	= $("#search_start").val();
    	        			var end 	= $("#search_end").val();
    	        			var dep_id  = $('#dep_id').val();
    	        			var date_type = $('#date_type').val();
    	        			var cash_ch = $('#cash_checker').val();
    	        	    	
	                        LoadTable(start,end,cash_ch,class_num,dep_id,date_type);
	                    
	                }
	            });
	        }).get();
		});
		
		$(document).on("tabsactivate", "#tabs_main", function() {
        	var tab = GetSelectedTab('tabs_main');
        	if(tab == 0){
            	var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
            	LoadTable(start,end,cash_ch,7,dep_id,date_type);
            	SetEvents('add_id','','check-all-in',"example7",'in_page',aJaxURL,1);
            	checkall('check-all-in7',7);
            }
        	if (tab == 1) {
        		var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
        		LoadTable(start,end,cash_ch,0,dep_id,date_type);
        		SetEvents('add_id','','check-all-in',"example",'in_page',aJaxURL,1);
        		checkall('check-all-in0',0);
        	}if(tab == 2){
        		var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
        		LoadTable(start,end,cash_ch,1,dep_id,date_type);
        		SetEvents('add_id','','check-all-in',"example1",'in_page',aJaxURL,1);	
        		checkall('check-all-in1',1);
            }if(tab == 3){
            	var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
            	LoadTable(start,end,cash_ch,2,dep_id,date_type);
            	SetEvents('add_id','','check-all-in',"example2",'in_page',aJaxURL,1);
            	checkall('check-all-in2',2);
            }if(tab == 4){
            	var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
            	LoadTable(start,end,cash_ch,3,dep_id,date_type);
            	SetEvents('add_id','','check-all-in',"example3",'in_page',aJaxURL,1);
            	checkall('check-all-in3',3);
            }if(tab == 5){
            	var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
            	LoadTable(start,end,cash_ch,4,dep_id,date_type);
            	SetEvents('add_id','','check-all-in',"example4",'in_page',aJaxURL,1);
            	checkall('check-all-in4',4);
            }if(tab == 6){
            	var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
            	LoadTable(start,end,cash_ch,5,dep_id,date_type);
            	SetEvents('add_id','','check-all-in',"example5",'in_page',aJaxURL,1);
            	checkall('check-all-in5',5);
            }if(tab == 7){
            	var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				var date_type = $('#date_type').val();
				var cash_ch = $('#cash_checker').val();
            	LoadTable(start,end,cash_ch,6,dep_id,date_type);
            	SetEvents('add_id','','check-all-in',"example6",'in_page',aJaxURL,1);
            	checkall('check-all-in6',6);
            }
        });
		
		$(document).on("tabsactivate", "#tabs", function() {
        	var tab = GetSelectedTab(tbName);
        	if (tab == 0) {
        		var str = $("#my_prod_sum").html();  
        		var gela = str.split("<br>");
        		$("#sum_price").val(gela[1]);
        	}else if(tab == 1){
        		$("#add_prod_but").button({
    	            
    		    });
        		$("#delete_prod_but").button({
    	            
    		    });
        	    $("#add_prod_but_gif").button({
    	            
    		    });
        		$("#delete_prod_but_gif").button({
    	            
    		    });
    		    
                if($("#id").val() == ''){
                    if($("#date").val() != ''){
        				
        				param = new Object();
        				param.act = "save_dialog";

        				// elva.ge
        				param.id=$("#id").val();
        				param.oder_date=$("#oder_date").val();
        				param.status=$("#status").val();
        				param.cooradinator=$("#cooradinator").val();
        				param.k_coment=$("#k_coment").val();
        				param.elva=$("#elva").val();

        				// პალიტრა
        				param.oder_date_p=$("#oder_date_p").val();
        				param.status_p=$("#status_p").val();
        				param.cooradinator_p=$("#cooradinator_p").val();
        				param.k_coment_p=$("#k_coment_p").val();
        				param.elva_p=$("#elva_p").val();

        				// Status
        				param.main_status=$("#main_status").val();
        				param.main_status1=$("#main_status1").val();

        				// all user
        				param.person_id		=$("#person_id").val();
        				param.name_surname	=$("#name_surname").val();
        				param.mail			=$("#mail").val();
        				param.phone			=$("#phone").val();
        				param.phone1		=$("#phone1").val();
        				param.addres		=$("#addres").val();
        				param.period		=$("#period").val();
        				param.book			=$("#book").val();
        				param.date			=$("#date").val();
        				param.op_id			=$("#op_id").val();
        				param.sum_price		=$("#sum_price").val();
        				param.c_coment		=$("#c_coment").val();
        				param.send_date		=$("#send_date").val();
        				param.cancel_comment=$("#cancel_comment").val();
        				param.street_done	=$("#street_done").val();
        				param.cash_id       =$('.cash_id:checked').val();
        				param.city_id       =$('#city_id').val();
        				param.send_client_date =$('#send_client_date').val();
        				param.prod_cat      =$('#prod_cat').val();	

        				$.ajax({
        	  	            url: aJaxURL,
        	  	            type: "POST",
        	  	            data: param,
        	  	            dataType: "json", 
        	  	            success: function (data) {
          	  	              $("#id").val(data.id);
        	  	            }
        				});
                    }else{
                        alert('ქოლ-ცენტრის დარეკვის თარიღი შევსებული არაა!!!');
                    }
                }
                var total=[7];
        		var dLength = [[-1,-1], [500,500]];
        		GetDataTableReload("sub1", aJaxURL, "get_my_prod", 10, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 0, "desc",total);
        		SetEvents_prod("add_prod_but", "delete_prod_but", "check-all", "sub1", "add_product", aJaxURL, "elva_id="+$("#id").val());  
        		GetDataTableReload("sub2", aJaxURL, "get_my_prod_gif", 13, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 1, "desc");
        		var str = $("#my_prod_sum").html();  
        		var gela = str.split("<br>");
        		$("#sum_price").val(gela[1]); 
            }else if(tab == 2){
        		var str = $("#my_prod_sum").html();
        		var gela = str.split("<br>");
        		$("#sum_price").val(gela[1]);
            }
         });

        
		function LoadDialog(fname){			
			GetTabs(tbName);	
			if(fname == 'add_product'){
				var buttons = {
						"save": {
				            text: "შენახვა",
				            id: "save_prod",
				            click: function () {
				            	if($("#date").val() != ''){
				            	param = new Object();
								param.act = "save_prod";
								param.elva_id    = $("#id").val();
								param.prod_id    = $("#production_name").val();
								param.prod_count = $("#prod_count").val();
								param.change     = $("#change").val();
								if(param.prod_id != 0){
								$.ajax({
					  	            url: aJaxURL,
					  	            type: "POST",
					  	            data: param,
					  	            dataType: "json", 
					  	            success: function (data) {
					  	            	var total=[7];
					  	            	var dLength = [[-1,-1], [500,500]];
					  	        		GetDataTableReload("sub1", aJaxURL, "get_my_prod", 10, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 0, "desc",total);
					  	        		GetDataTableReload("sub2", aJaxURL, "get_my_prod_gif", 13, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 1, "desc");
										$('#add_product').dialog("close");
										var str = $("#my_prod_sum").html();
						        		var gela = str.split("<br>");
						        		$("#sum_price").val(gela[1]);
						        		if(data.hint != 0){
						        		alert(data.hint);
						        		}
					  	            }
								});
								}else{
								    alert('აიღჩიეთ პროდუქტი!');
								}
				            
				            }else{
		                        alert('ქოლ-ცენტრის დარეკვის თარიღი შევსებული არაა!!!');
		                    }
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
				GetDialog("add_product","475","auto", buttons);
				$('#production_name').chosen({ search_contains: true });
				$("#production_name_chosen").css("z-index","99999");
				$("#prod_count").keydown(function(event) {
				    return false;
				});
			}else{
			var total=[7];
    		var dLength = [[-1,-1], [500,500]];
    		GetDataTableReload("sub1", aJaxURL, "get_my_prod", 10, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 0, "desc",total);
    		GetDataTableReload("sub2", aJaxURL, "get_my_prod_gif", 13, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 1, "desc");
    		SetEvents_prod("add_prod_but", "delete_prod_but", "check-all", "sub1", "add_product", aJaxURL, "elva_id="+$("#id").val());

    		var buttons1 = {
    				"save": {
    		            text: "შენახვა",
    		            id: "save-dialog",
    		            click: function () {
    		            }
			        },"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	var buttons2 = {
			        				"save": {
			        		            text: "კი",
			        		            id: "save-dialog",
			        		            click: function () {
			        		            }
			    			        },"cancel": {
			        		            text: "არა",
			        		            id: "no-cc",
			        		            click: function () {
			        		            	$('#in_page').dialog("close");
			        		            	$('#yesno').dialog("close");
			        		            	var start 	= $("#search_start").val();
			    							var end 	= $("#search_end").val();
			    							var dep_id  = $('#dep_id').val();
			    							var date_type = $('#date_type').val();
			    							var cash_ch = $('#cash_checker').val();
			    					    	
			    							LoadTable(start, end, cash_ch,0,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
			    					    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
			        		            }
			    			        }
			    			        }
			            	GetDialog("yesno","300","auto",buttons2);
			            	
			            }
		            }

			};
			GetDialog("in_page","1150","auto",buttons1);
			$('#city_id, #cooradinator, #prod_cat, #status, #status_p, #main_status, #main_status1, #period, #cooradinator_p, #monitor1, #monitor').chosen({ search_contains: true });
			GetDate1("oder_date");
			GetDate1("date");
			GetDate1("send_date");
			GetDate1("oder_date_p");
			GetDate1("elva_p");			
			GetDate1("send_client_date");			
			$(".download").button({
	            
		    });
			$(document).on("click", "#save-dialog", function () {
				var str = $("#my_prod_sum").html();  
        		var gela = str.split("<br>");
        		$("#sum_price").val(gela[1]);
				param = new Object();
				param.act = "save_dialog";

				// elva.ge
				param.id=$("#id").val();
				param.oder_date=$("#oder_date").val();
				param.status=$("#status").val();
				param.cooradinator=$("#cooradinator").val();
				param.k_coment=$("#k_coment").val();
				param.elva=$("#elva").val();

				// პალიტრა
				param.oder_date_p=$("#oder_date_p").val();
				param.status_p=$("#status_p").val();
				param.cooradinator_p=$("#cooradinator_p").val();
				param.k_coment_p=$("#k_coment_p").val();
				param.elva_p=$("#elva_p").val();

				// Status
				param.main_status=$("#main_status").val();
				param.main_status1=$("#main_status1").val();

				// Monitor
				param.monitor=$("#monitor").val();
				param.monitor1=$("#monitor1").val();

				// all user
				param.person_id		=$("#person_id").val();
				param.name_surname	=$("#name_surname").val();
				param.mail			=$("#mail").val();
				param.phone			=$("#phone").val();
				param.phone1		=$("#phone1").val();
				param.addres		=$("#addres").val();
				param.period		=$("#period").val();
				param.book			=$("#book").val();
				param.date			=$("#date").val();
				param.op_id			=$("#op_id").val();
				param.sum_price		=gela[1];
				param.c_coment		=$("#c_coment").val();
				param.send_date		=$("#send_date").val();
				param.cancel_comment=$("#cancel_comment").val();
				param.street_done	=$("#street_done").val();
				param.cash_id       =$('.cash_id:checked').val();
				param.city_id       =$('#city_id').val();
				param.send_client_date =$('#send_client_date').val();
				param.prod_cat      =$('#prod_cat').val();				

				if(param.date != ''){
				$.ajax({
	  	            url: aJaxURL,
	  	            type: "POST",
	  	            data: param,
	  	            dataType: "json", 
	  	            success: function (data) {
	  	            	var start 	= $("#search_start").val();
						var end 	= $("#search_end").val();
						var dep_id  = $('#dep_id').val();
						var date_type = $('#date_type').val();				    
						var cash_ch = $('#cash_checker').val();
				    	
						LoadTable(start, end, cash_ch,0,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
				    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
						
	  	            }
				});
 				$('#'+fname).dialog("close");
 				$('#yesno').dialog("close");
				}else{
				    alert('ქოლ-ცენტრის დარეკვის თარიღი არ არის შევსებული!!!');
				}
  				});
			}			
			};
		function LoadTable(start, end, cash_ch,tmp,dep_id,date_type){
			var total=[10];
			if(tmp != 0){
			    real_name = tName+tmp;
			}else{
				real_name = tName;
			}
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTableReload(real_name, aJaxURL, "get_list", 24, "start=" + start + "&end=" + end + "&cash_ch=" + cash_ch + "&tab_num=" + tmp + "&dep_id=" + dep_id + "&date_type=" + date_type, 0, "", 0, "desc", total);
		}

		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('#cash_checker').val();
	    	var dep_id  = $('#dep_id').val();
	    	var date_type = $('#date_type').val();
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
	    });


		 // end_date
	    $(document).on("change", "#search_end", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('#cash_checker').val();
	    	var dep_id  = $('#dep_id').val();
	    	var date_type = $('#date_type').val();
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
	    });

	    // cash
	    $(document).on("change", "#cash_checker", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('#cash_checker').val();
	    	var dep_id  = $('#dep_id').val();
	    	var date_type = $('#date_type').val();
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
	    });


	    // departament
	    $(document).on("change", "#dep_id", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('#cash_checker').val();
	    	var dep_id  = $('#dep_id').val();
	    	var date_type = $('#date_type').val();
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
	    });

	    // chekbox
	    $(document).on("change", "#date_type", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('#cash_checker').val();
	    	var dep_id  = $('#dep_id').val();	    	
	    	var date_type = $('#date_type').val();
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
	    	LoadTable(start, end, cash_ch,7,dep_id,date_type);
	    });
	    
	    $(document).on("click", ".download", function () {
            var link = $(this).attr("str");
            link = "http://109.234.117.182:8181/records/" + link;

            var newWin = window.open(link, "JSSite", "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");
            newWin.focus();
        });

	    function openmyact(task_id,custom_prod,sale_id,choose){
		    if(choose == 0){
		    	var buttons = {
			        	"choose_but": {
				            text: "არჩევა",
				            id: "choose_but",
				            click: function () {
				            	openmyact($("#task_id").val(),$("#custom_prod").val(),$("#sale_id").val(),$("#myfirstdep").val())
				            	$(this).dialog("close");				            	
				            }
				        },"cancel": {
				            text: "დახურვა",
				            id: "cancel-dialog",
				            click: function () {
				            	CloseDialog("choose_dep");
				            }
				        }
				};
		    	GetDialog("choose_dep","250","auto",buttons);
		    	$.ajax({
			        url: aJaxURL,
				    data: "act=choose_dep&task_id="+task_id+"&custom_prod="+custom_prod+"&sale_id="+sale_id,
			        success: function(data) {  	        			        	
			        	$("#choose_dep").html(data.page);
				    }
			    });
		    }else{
	    	var buttons = {			       
		        	"print_bt": {
			            text: "ბეჭდვა",
			            id: "print_bt",
			            click: function () {
			            	$(this).dialog("close");
			            }
			        },"cancel": {
			            text: "დახურვა",
			            id: "cancel-dialog",
			            click: function () {
			            	CloseDialog("myact_dialog");
			            }
			        }
			};
	    	GetDialog("myact_dialog","650","auto",buttons);
	    	$.ajax({
		        url: aJaxURL,
			    data: "act=product_list&task_id="+task_id+"&custom_prod="+custom_prod+"&sale_id="+sale_id+"&choose_dep="+choose,
		        success: function(data) {  	        			        	
		        	$("#myact_dialog").html(data.page);
		        	tinymce.init({    
					    selector: "#theacte",      
					    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|"
					});
			    	tinymce.init({    
					    selector: "#theactee",      
					    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,forecolor,backcolor,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontsizeselect,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|"
					});
			    }
		    });
		    }	
	    }
	    $(document).on("click", "#print_bt", function () {
	    	param 			= new Object();

		    param.act		    ="add_rs";
	    	param.counter_rs	= $("#counter_rs").val();
	    	param.theacte		= tinyMCE.get('theacte').getContent();
	    	param.theactee		= tinyMCE.get('theactee').getContent();
	    	
	    	$.ajax({
		        url: aJaxURL,
			    data: param,
		        success: function(data) {  	        			        	
		        	Popup(tinyMCE.get('theacte').getContent(),'#gela',tinyMCE.get('theactee').getContent());
			    }
		    });	
	    });

	    $(document).on("click", "#send_book", function () {
	        var data = $(".check0:checked").map(function () { //Get Checked checkbox array
	            return this.value;
	        }).get();

	        var data_dep = $(".check0:checked").map(function () { //Get Checked checkbox array
	            return $(this).attr('dep');
	        }).get();

	        for (var i = 0; i < data.length; i++) {
	            $.ajax({
	                url: aJaxURL,
	                type: "POST",
	                data: "act=send_book&id=" + data[i] + "&dep=" + data_dep[i],
	                dataType: "json",
	                success: function (data) {
	                    if (data.error != "") {
	                        alert(data.error);
	                    } else {
	                        $("#check-all-in0").attr("checked", false);
                        	var start 	= $("#search_start").val();
            				var end 	= $("#search_end").val();
            				var dep_id  = $('#dep_id').val();
            				var cash_checker = $('#cash_checker').val();
            				var date_type = $('#date_type').val();
                        	LoadTable(start,end,cash_checker,0,dep_id,date_type);	                        	
	                    }
	                }
	            });
	        }
	    });

	    function Popup(data,table,dataa) 
	    {
		   // alert()
		    //console.log(data);
	        var mywindow = window.open('', 'my div', 'height=400,width=800');
	        mywindow.document.write('<html><head><title>my div</title>');
	        mywindow.document.write('</head><body >');	        
	        mywindow.document.write(data);
	        mywindow.document.write($(table).html());
	        mywindow.document.write(dataa);
	        mywindow.document.write('</body></html>');

	        mywindow.document.close(); // necessary for IE >= 10
	        mywindow.focus(); // necessary for IE >= 10

	        mywindow.print();
	        mywindow.close();

	        return true;
	    }

    </script>
    <style type="text/css">

    </style>
</head>

<body>
<div id="button_area" style="margin-top:25px;">
    <div class="left" style="width: 155px;">
		<select style="padding: 2px; margin-left: 5px;" id="date_type" >
		<option value="1">შეკვეთის თარიღი</option>
		<option value="2">გაგზავნის თარიღი</option>
		<option value="3">მიტანის თარიღი</option>
		</select>		
	</div>
	<div class="left" style="width: 175px;">
		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start" class="inpt left"/>
	</div>
	<div class="left" style="">
		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
		<input style="width: 80px; height: 16px; margin-left: 5px; margin-right: 5px;" type="text" name="search_end" id="search_end" class="inpt right" />
	</div>
	
	<div class="left" style="">
		<select id="cash_checker" style="width: 120px">
		<option value="0">ყველა</option>
		<option value="1">ნაღდი</option>
		<option value="2">უნაღდო</option>
		<option value="3">მოუნიშნავი</option>
		</select>	
	</div>
	<div class="right" style="">
		<select id="dep_id" style="margin-left: 5px; width: 200px;">
		<?php
		include '../../includes/classes/core.php';
		$r = mysql_query(" SELECT  `id`,
                            	   `name`
                            FROM   `department`
                            WHERE  `actived` = 1");
		$data = '<option value="0">ყველა</option>';
		while ($rr = mysql_fetch_array($r)){
		  $data .= '<option value="'.$rr[0].'">'.$rr[1].'</option>';
		}
		echo $data;
		?> 
		</select>
	</div>
	<?php
	include '../../includes/classes/core.php';
	if($_SESSION['USERID'] == 3 || $_SESSION['USERID'] == 1 ){
	  echo '<button style="margin-left:5px; margin-right:5px;" id="delete_id" class="right">წაშლა</button>';
	}
	?>
	<button style="margin-left:5px;" id="add_id" class="right">დამატება</button>   
	         		
</div><br>
<div id="tabs_main" style="width: 170%; margin: 0 auto; min-height: 768px; margin-top: 50px;">
		<ul>
		    <li><a href="#tab-7">ყველა</a></li>
		    <li><a href="#tab-0">შეკვეთა მიღებულია</a></li>
		    <li><a href="#tab-1">ჩასარიცხია</a></li>
			<li><a href="#tab-2">შესყიდვა გაკეთებულია</a></li>
			<li><a href="#tab-3">მიღებაჩაბარება დაბეჭდილია</a></li>
			<li><a href="#tab-4">SOLD!</a></li>
			<li><a href="#tab-5">გადავადებული</a></li>
			<li><a href="#tab-6">გაუქმებული</a></li>
		</ul>
    <div id="tab-7" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;margin-top:25px;">  
                <table class="display" id="example7" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
<div id="tab-0" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;">
            <div id="button_area" style="">                  
            		<div class="right" style="">
            		    <button style="margin-left:5px;" id="send_book" class="right">გადაგზავნა ჩასარიცხში</button> 
	            	</div>            		         		
            	</div>
                <table class="display" id="example" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
   
    
    <!-- END TAB 0 -->
    
    <div id="tab-1" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;margin-top:25px;">
                <table class="display" id="example1" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
        <!-- END TAB 1 -->
    
    <div id="tab-2" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;">
                <table class="display" id="example2" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
        <!-- END TAB 2 -->
    
    <div id="tab-3" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;">
                <table class="display" id="example3" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
        <!-- END TAB 3 -->
    
    <div id="tab-4" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;">
                <table class="display" id="example4" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
        <!-- END TAB 4 -->
    
    <div id="tab-5" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;">
                <table class="display" id="example5" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
    <!-- END TAB 5 -->
    
     <!-- TAB 6 -->
    <div id="tab-6" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; margin-top:25px;">
                <table class="display" id="example6" >
                    <thead>
                        <tr id="datatable_header" class="search_header">
                        	<th style="">id</th>
							<th style="width: 50%">მყიდვლი</th>
							<th style="width: 30%">ქალაქი / რაიონი</th>
							<th style="width: 48%">მისამართი</th>						
							<th style="width: 30%">შეკვეთის  თარიღი</th>							
							<th style="width: 30%">გაგზავნის თარიღი</th>
							<th style="width: 30%">მიტანის თარიღი</th>
							<th style="width: 75%">ოპერატორის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 40%">სტატუსი ელვა</th>
							<th style="width: 50%">კოორდინატორი ელვა</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ელვა</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ელვა</th>
							<th style="width: 30%">სტატუსი ქოლცენტრი</th>
							<th style="width: 50%">კოორდინატორი ქოლცენტრი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა ქოლცენტრი</th>							
							<th style="width: 50%">გადახდა/გაუქმების თარიღი ქოლცენტრი</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">მონიტორინგი</th>
							<th style="width: 25%">მიღება ჩაბარება</th>
							<th style="width: 30px">#</th>
                        </tr>
                      </thead>
					  <thead>
                        <tr>
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 80px;" />
                            </th>
                            <th>
								<input type="checkbox" name="check-all" id="check-all-in7"/>
							</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr id="datatable_header" class="search_header">
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px; text-align: right;">ჯამი :<br>სულ :</th>
							<th style="width: 100px; text-align: right;"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>
							<th style="width: 150px"></th>							
							<th style="width: 150px"></th>													
							<th style="width: 150px"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
</div>
<div id='in_page' class="form-dialog"></div>
<div id='choose_dep' class="form-dialog"></div>
<div id='add_product' class="form-dialog"></div>
<div id='myact_dialog' class="form-dialog"></div>
<div id='yesno' class="form-dialog">
    <div id="dialog-form">
        <fieldset>
                    გსურთ თუ არა ცვლილებების შენახვა?
        </fieldset>
    </div>
</div>
<div id='yesnodelete' class="form-dialog">
    <div id="dialog-form">
        <fieldset>
                    გსურთ თუ არა პროდუქტის წაშლა?
        </fieldset>
    </div>
</div>
<div id='prod_div' class="form-dialog">
<table class="display dataTable no-footer" id="example2" >
    <thead>
        <tr id="datatable_header" class="search_header">
        	<th style="">id</th>
			<th style="width: 80%">წიგნები</th>
			<th style="width: 20%">განყოფილება</th>						
			<th style="width: 20%">ფასი</th>							
			<th style="width: 30px">#</th>
        </tr>
      </thead>
	  <thead>
        <tr>
            <th class="colum_hidden">
            	<input type="text" name="search_id" value="ფილტრი" class="search_init"/>
            </th>                            
            <th>
                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
            </th>                            
            <th>
                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
            </th>  
            <th>
                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 80px;" />
            </th>                          
            <th>
				<input type="checkbox" name="check-all" id="check-all-in"/>
			</th>
        </tr>
    </thead>
</table>
</div>
</body>
