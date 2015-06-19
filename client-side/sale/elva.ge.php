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

</style>

	<script type="text/javascript">
		var aJaxURL	= "server-side/sale/elva.ge.action.php";	//server side folder url
		var seoyURL	= "server-side/seoy/seoy.action.php";							//server side folder url
		var tName	= "example";
		var tbName	= "tabs";											//table name

		$(document).ready(function () {
			GetTabs(tbName);
			GetTabs("tabs_main");
			GetDate("search_start");
			GetDate("search_end");
				
			GetDate("search_start1");
			GetDate("search_end1");
			
			GetDate("search_start2");
			GetDate("search_end2");
			
			GetDate("search_start3");
			GetDate("search_end3");

			GetDate("search_start4");
			GetDate("search_end4");

			GetDate("search_start5");
			GetDate("search_end5");
			
			GetDate("search_start6");
			GetDate("search_end6");

			GetDate("search_start7");
			GetDate("search_end7");
			
			var start 	= $("#search_start").val();
			var end 	= $("#search_end").val();
			var dep_id  = $('#dep_id').val();
			if ($('#date_type').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
			GetButtons("add_id","delete_id");
			GetButtons("add_id1","delete_id1");
			GetButtons("add_id2","delete_id2");
			GetButtons("add_id3","delete_id3");
			GetButtons("add_id4","delete_id4");
			GetButtons("add_id5","delete_id5");
			GetButtons("add_id6","delete_id6");
			GetButtons("add_id7","delete_id7");
			LoadTable(start,end,'undefined',0,dep_id,date_type);			
			SetEvents('','delete_id','check-all-in',tName,'in_page',aJaxURL,1);	
			$("#send_book").button();
		});

		$(document).on("tabsactivate", "#tabs_main", function() {
        	var tab = GetSelectedTab('tabs_main');
        	if (tab == 0) {
        		var start 	= $("#search_start").val();
				var end 	= $("#search_end").val();
				var dep_id  = $('#dep_id').val();
				if ($('#date_type').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
        		LoadTable(start,end,'undefined',0,dep_id,date_type);
        	}if(tab == 1){
        		var start 	= $("#search_start1").val();
				var end 	= $("#search_end1").val();
				var dep_id  = $('#dep_id1').val();
				if ($('#date_type1').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
        		LoadTable(start,end,'undefined',1,dep_id,date_type);
        		SetEvents('','delete_id1','check-all-in1',"example1",'in_page',aJaxURL,1);	
            }if(tab == 2){
            	var start 	= $("#search_start2").val();
				var end 	= $("#search_end2").val();
				var dep_id  = $('#dep_id2').val();
				if ($('#date_type2').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
            	LoadTable(start,end,'undefined',2,dep_id,date_type);
            	SetEvents('','delete_id2','check-all-in2',"example2",'in_page',aJaxURL,1);
            }if(tab == 3){
            	var start 	= $("#search_start3").val();
				var end 	= $("#search_end3").val();
				var dep_id  = $('#dep_id3').val();
				if ($('#date_type3').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
            	LoadTable(start,end,'undefined',3,dep_id,date_type);
            	SetEvents('','delete_id3','check-all-in3',"example3",'in_page',aJaxURL,1);
            }if(tab == 4){
            	var start 	= $("#search_start4").val();
				var end 	= $("#search_end4").val();
				var dep_id  = $('#dep_id4').val();
				if ($('#date_type4').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
            	LoadTable(start,end,'undefined',4,dep_id,date_type);
            	SetEvents('','delete_id4','check-all-in4',"example4",'in_page',aJaxURL,1);
            }if(tab == 5){
            	var start 	= $("#search_start5").val();
				var end 	= $("#search_end5").val();
				var dep_id  = $('#dep_id5').val();
				if ($('#date_type5').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
            	LoadTable(start,end,'undefined',5,dep_id,date_type);
            	SetEvents('','delete_id5','check-all-in5',"example5",'in_page',aJaxURL,1);
            }if(tab == 6){
            	var start 	= $("#search_start6").val();
				var end 	= $("#search_end6").val();
				var dep_id  = $('#dep_id6').val();
				if ($('#date_type6').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
            	LoadTable(start,end,'undefined',6,dep_id,date_type);
            	SetEvents('','delete_id6','check-all-in6',"example6",'in_page',aJaxURL,1);
            }if(tab == 7){
            	var start 	= $("#search_start7").val();
				var end 	= $("#search_end7").val();
				var dep_id  = $('#dep_id7').val();
				if ($('#date_type7').is(':checked')) {
		    		date_type = 1;
		    	}else{
		    		date_type = 0;
		    	}
            	LoadTable(start,end,'undefined',7,dep_id,date_type);
            	SetEvents('','delete_id7','check-all-in7',"example7",'in_page',aJaxURL,1);
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
        		GetDataTableReload("sub2", aJaxURL, "get_my_prod_gif", 10, "id="+$('#id').val(), 0, dLength, 0, "desc",total);
        		SetEvents_prod("add_prod_but_gif", "delete_prod_but_gif", "check-all", "sub1", "add_product_gif", aJaxURL, "elva_id="+$("#id").val());
        		var str = $("#my_prod_sum").html();  
        		var gela = str.split("<br>");
        		$("#sum_price").val(gela[1]); 
            }else if(tab == 2){
        		var str = $("#my_prod_sum").html();
        		var gela = str.split("<br>");
        		$("#sum_price").val(gela[1]);
            }
         });
		$(document).on("keydown", "#production_name", function(event) {
        	if (event.keyCode == $.ui.keyCode.ENTER) {
        		GetProductionInfo(this.value);
            	event.preventDefault();
        	}
    	});
		$(document).on("click", ".combobox", function(event) {
            var i = $(this).text();
            $("#" + i).autocomplete("search", "");
        });

		function GetProductionInfo(name) {
            $.ajax({
                url: aJaxURL,
                data: "act=get_product_info&name=" + name,
                success: function(data) {
                    if(data.error == ''){
                        $("#hidden_prod_id").val(data.id+"^"+$("#prod_count").val());
                        $("#hidden_prod_id_or").val(data.id);
                        alert('პროდუქტი აჩეულია!');
                    }else{
                        alert('პროდუქტი ვერ მოიძებნა!');
                    }
                     
                }
            });
        }
		$(document).on("change", "#prod_count", function(event) {
			$("#hidden_prod_id").val($("#hidden_prod_id_or").val()+"^"+$(this).val());
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
								param.elva_id = $("#id").val();
								param.prod_id = $("#hidden_prod_id").val();
								param.change  = $("#change").val();
								
								$.ajax({
					  	            url: aJaxURL,
					  	            type: "POST",
					  	            data: param,
					  	            dataType: "json", 
					  	            success: function (data) {
					  	            	var total=[7];
					  	            	var dLength = [[-1,-1], [500,500]];
					  	        		GetDataTableReload("sub1", aJaxURL, "get_my_prod", 10, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 0, "desc",total);
										$('#add_product').dialog("close");
										var str = $("#my_prod_sum").html();
						        		var gela = str.split("<br>");
						        		$("#sum_price").val(gela[1]);
					  	            }
								});
				 				
				            
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
				GetDialog("add_product","400","auto", buttons);
				SeoY("production_name", seoyURL, "production_name", "", 0);
				$("#prod_count").keydown(function(event) {
				    return false;
				});
			}else{
			var total=[7];
    		var dLength = [[-1,-1], [500,500]];
    		GetDataTableReload("sub1", aJaxURL, "get_my_prod", 10, "id="+$('#id').val() + "&my_dep=" + $("#my_dep").val(), 0, dLength, 0, "desc",total);
    		SetEvents_prod("add_prod_but", "delete_prod_but", "check-all", "sub1", "add_product", aJaxURL, "elva_id="+$("#id").val());
			GetDialog("in_page","1150","auto");
			$('#city_id, #cooradinator, #prod_cat, #status, #status_p, #main_status, #main_status1, #period').chosen({ search_contains: true });
			GetDate1("oder_date");
			GetDate1("date");
			GetDate1("send_date");
			GetDate1("send_client_date");			
			$(".download").button({
	            
		    });
			 $("#save-dialog").on("click",function(){
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
						if ($('#date_type').is(':checked')) {
				    		date_type = 1;
				    	}else{
				    		date_type = 0;
				    	}
				    	//
						var start1 	= $("#search_start1").val();
						var end1 	= $("#search_end1").val();
						var dep_id1  = $('#dep_id1').val();
						if ($('#date_type1').is(':checked')) {
				    		date_type1 = 1;
				    	}else{
				    		date_type1 = 0;
				    	}
				    	//
						var start2 	= $("#search_start2").val();
						var end2 	= $("#search_end2").val();
						var dep_id2  = $('#dep_id2').val();
						if ($('#date_type2').is(':checked')) {
				    		date_type2 = 1;
				    	}else{
				    		date_type2 = 0;
				    	}
						//
						var start3 	= $("#search_start3").val();
						var end3 	= $("#search_end3").val();
						var dep_id3  = $('#dep_id3').val();
						if ($('#date_type3').is(':checked')) {
				    		date_type3 = 1;
				    	}else{
				    		date_type3 = 0;
				    	}
						//
						var start4 	= $("#search_start4").val();
						var end4 	= $("#search_end4").val();
						var dep_id4  = $('#dep_id4').val();
						if ($('#date_type4').is(':checked')) {
				    		date_type4 = 1;
				    	}else{
				    		date_type4 = 0;
				    	}
						//
						var start5 	= $("#search_start5").val();
						var end5 	= $("#search_end5").val();
						var dep_id5  = $('#dep_id5').val();
						if ($('#date_type5').is(':checked')) {
				    		date_type5 = 1;
				    	}else{
				    		date_type5 = 0;
				    	}
				    	//
						var start6 	= $("#search_start6").val();
						var end6 	= $("#search_end6").val();
						var dep_id6  = $('#dep_id6').val();
						if ($('#date_type6').is(':checked')) {
				    		date_type5 = 1;
				    	}else{
				    		date_type5 = 0;
				    	}
				    	//
						var start7 	= $("#search_start7").val();
						var end7 	= $("#search_end7").val();
						var dep_id7  = $('#dep_id7').val();
						if ($('#date_type7').is(':checked')) {
				    		date_type5 = 1;
				    	}else{
				    		date_type5 = 0;
				    	}
						if ($('.cash_checker').is(':checked')) {
							var cash_ch = $('.cash_checker:checked').val();
				    	}else{
				    		var cash_ch = 'undefined';
				    	}
						if ($('.cash_checker1').is(':checked')) {
							var cash_ch1 = $('.cash_checker1:checked').val();
				    	}else{
				    		var cash_ch1 = 'undefined';
				    	}
						if ($('.cash_checker2').is(':checked')) {
							var cash_ch2 = $('.cash_checker2:checked').val();
				    	}else{
				    		var cash_ch2 = 'undefined';
				    	}
						if ($('.cash_checker3').is(':checked')) {
							var cash_ch3 = $('.cash_checker3:checked').val();
				    	}else{
				    		var cash_ch3 = 'undefined';
				    	}
						if ($('.cash_checker4').is(':checked')) {
							var cash_ch4 = $('.cash_checker4:checked').val();
				    	}else{
				    		var cash_ch4 = 'undefined';
				    	}
						if ($('.cash_checker5').is(':checked')) {
							var cash_ch5 = $('.cash_checker5:checked').val();
				    	}else{
				    		var cash_ch5 = 'undefined';
				    	}
						if ($('.cash_checker6').is(':checked')) {
							var cash_ch6 = $('.cash_checker6:checked').val();
				    	}else{
				    		var cash_ch6 = 'undefined';
				    	}
						if ($('.cash_checker7').is(':checked')) {
							var cash_ch7 = $('.cash_checker7:checked').val();
				    	}else{
				    		var cash_ch7 = 'undefined';
				    	}
						
						LoadTable(start, end,cash_ch,0,dep_id,date_type);
						LoadTable(start1, end1,cash_ch1,1,dep_id1,date_type1);
						LoadTable(start2, end2,cash_ch2,2,dep_id2,date_type2);
						LoadTable(start3, end3,cash_ch3,3,dep_id3,date_type3);
						LoadTable(start4, end4,cash_ch4,4,dep_id4,date_type4);
						LoadTable(start5, end5,cash_ch5,5,dep_id5,date_type5);
						LoadTable(start6, end6,cash_ch6,6,dep_id6,date_type6);
						LoadTable(start7, end7,cash_ch7,7,dep_id7,date_type7);
	  	            }
				});
 				$('#'+fname).dialog("close");
				}else{
				    alert('ქოლ-ცენტრის დარეკვის თარიღი არ არის შევსებული!!!');
				}
  				});
			}
			} ;
		function LoadTable(start, end, cash_ch,tmp,dep_id,date_type){
			var total=[10];
			if(tmp != 0){
			    real_name = tName+tmp;
			}else{
				real_name = tName;
			}
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTableReload(real_name, aJaxURL, "get_list", 19, "start=" + start + "&end=" + end + "&cash_ch=" + cash_ch + "&tab_num=" + tmp + "&dep_id=" + dep_id + "&date_type=" + date_type, 0, "", 0, "desc", total);
		}
		
		$(document).on("click", "#delete_prod_but", function () {

		});
			
		$(document).on("change", "#search_start", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('.cash_checker:checked').val();
	    	var dep_id  = $('#dep_id').val();
	    	if ($('#date_type').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    });
		$(document).on("change", "#search_start1", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end1").val();
	    	var cash_ch = $('.cash_checker1:checked').val();
	    	var dep_id  = $('#dep_id1').val();
	    	if ($('#date_type1').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,1,dep_id);
	    });
		$(document).on("change", "#search_start2", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end2").val();
	    	var cash_ch = $('.cash_checker2:checked').val();
	    	var dep_id  = $('#dep_id2').val();
	    	if ($('#date_type2').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,2,dep_id);
	    });
		$(document).on("change", "#search_start3", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end3").val();
	    	var cash_ch = $('.cash_checker3:checked').val();
	    	var dep_id  = $('#dep_id3').val();
	    	if ($('#date_type3').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,3,dep_id);
	    });
		$(document).on("change", "#search_start4", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end4").val();
	    	var cash_ch = $('.cash_checker4:checked').val();
	    	var dep_id  = $('#dep_id4').val();
	    	if ($('#date_type4').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,4,dep_id);
	    });
		$(document).on("change", "#search_start5", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end5").val();
	    	var cash_ch = $('.cash_checker5:checked').val();
	    	var dep_id  = $('#dep_id5').val();
	    	if ($('#date_type5').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,5,dep_id);
	    });
		$(document).on("change", "#search_start6", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end6").val();
	    	var cash_ch = $('.cash_checker6:checked').val();
	    	var dep_id  = $('#dep_id6').val();
	    	if ($('#date_type6').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,6,dep_id);
	    });
		$(document).on("change", "#search_start7", function () {
	    	var start	= $(this).val();
	    	var end		= $("#search_end7").val();
	    	var cash_ch = $('.cash_checker7:checked').val();
	    	var dep_id  = $('#dep_id7').val();
	    	if ($('#date_type7').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,7,dep_id);
	    });

		 // end_date
	    $(document).on("change", "#search_end", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker:checked').val();
	    	var dep_id  = $('#dep_id').val();
	    	if ($('#date_type').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    });
	    $(document).on("change", "#search_end1", function () {
	    	var start	= $("#search_start1").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker1:checked').val();
	    	var dep_id  = $('#dep_id1').val();
	    	if ($('#date_type1').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,1,dep_id);
	    });
	    $(document).on("change", "#search_end2", function () {
	    	var start	= $("#search_start2").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker2:checked').val();
	    	var dep_id  = $('#dep_id2').val();
	    	if ($('#date_type2').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,2,dep_id);
	    });
	    $(document).on("change", "#search_end3", function () {
	    	var start	= $("#search_start3").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker3:checked').val();
	    	var dep_id  = $('#dep_id3').val();
	    	if ($('#date_type3').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,3,dep_id);
	    });
	    $(document).on("change", "#search_end4", function () {
	    	var start	= $("#search_start4").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker4:checked').val();
	    	var dep_id  = $('#dep_id4').val();
	    	if ($('#date_type4').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,4,dep_id);
	    });
	    $(document).on("change", "#search_end5", function () {
	    	var start	= $("#search_start5").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker5:checked').val();
	    	var dep_id  = $('#dep_id5').val();
	    	if ($('#date_type5').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,5,dep_id);
	    });
	    $(document).on("change", "#search_end6", function () {
	    	var start	= $("#search_start6").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker6:checked').val();
	    	var dep_id  = $('#dep_id6').val();
	    	if ($('#date_type6').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,6,dep_id);
	    });
	    $(document).on("change", "#search_end7", function () {
	    	var start	= $("#search_start7").val();
	    	var end		= $(this).val();
	    	var cash_ch = $('.cash_checker7:checked').val();
	    	var dep_id  = $('#dep_id7').val();
	    	if ($('#date_type7').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,7,dep_id);
	    });

	    // cash
	    $(document).on("change", ".cash_checker", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('.cash_checker:checked').val();
	    	var dep_id  = $('#dep_id').val();
	    	if ($('#date_type').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    });
	    $(document).on("change", ".cash_checker1", function () {
	    	var start	= $("#search_start1").val();
	    	var end		= $("#search_end1").val();
	    	var cash_ch = $('.cash_checker1:checked').val();
	    	var dep_id  = $('#dep_id1').val();
	    	if ($('#date_type1').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,1,dep_id);
	    });
	    $(document).on("change", ".cash_checker2", function () {
	    	var start	= $("#search_start2").val();
	    	var end		= $("#search_end2").val();
	    	var cash_ch = $('.cash_checker2:checked').val();
	    	var dep_id  = $('#dep_id2').val();
	    	if ($('#date_type2').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,2,dep_id);
	    });
	    $(document).on("change", ".cash_checker3", function () {
	    	var start	= $("#search_start3").val();
	    	var end		= $("#search_end3").val();
	    	var cash_ch = $('.cash_checker3:checked').val();
	    	var dep_id  = $('#dep_id3').val();
	    	if ($('#date_type3').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,3,dep_id);
	    });
	    $(document).on("change", ".cash_checker4", function () {
	    	var start	= $("#search_star4t").val();
	    	var end		= $("#search_end4").val();
	    	var cash_ch = $('.cash_checker4:checked').val();
	    	var dep_id  = $('#dep_id4').val();
	    	if ($('#date_type4').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,4,dep_id);
	    });
	    $(document).on("change", ".cash_checker5", function () {
	    	var start	= $("#search_start5").val();
	    	var end		= $("#search_end5").val();
	    	var cash_ch = $('.cash_checker5:checked').val();
	    	var dep_id  = $('#dep_id5').val();
	    	if ($('#date_type5').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,5,dep_id);
	    });
	    $(document).on("change", ".cash_checker6", function () {
	    	var start	= $("#search_start6").val();
	    	var end		= $("#search_end6").val();
	    	var cash_ch = $('.cash_checker6:checked').val();
	    	var dep_id  = $('#dep_id6').val();
	    	if ($('#date_type6').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,6,dep_id);
	    });
	    $(document).on("change", ".cash_checker7", function () {
	    	var start	= $("#search_start7").val();
	    	var end		= $("#search_end7").val();
	    	var cash_ch = $('.cash_checker7:checked').val();
	    	var dep_id  = $('#dep_id7').val();
	    	if ($('#date_type7').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,7,dep_id);
	    });

	    // departament
	    $(document).on("change", "#dep_id", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('.cash_checker:checked').val();
	    	var dep_id  = $('#dep_id').val();
	    	if ($('#date_type').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    });
	    $(document).on("change", "#dep_id1", function () {
	    	var start	= $("#search_start1").val();
	    	var end		= $("#search_end1").val();
	    	var cash_ch = $('.cash_checker1:checked').val();
	    	var dep_id  = $('#dep_id1').val();
	    	if ($('#date_type1').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,1,dep_id);
	    });
	    $(document).on("change", "#dep_id2", function () {
	    	var start	= $("#search_start2").val();
	    	var end		= $("#search_end2").val();
	    	var cash_ch = $('.cash_checker2:checked').val();
	    	var dep_id  = $('#dep_id2').val();
	    	if ($('#date_type2').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,2,dep_id);
	    });
	    $(document).on("change", "#dep_id3", function () {
	    	var start	= $("#search_start3").val();
	    	var end		= $("#search_end3").val();
	    	var cash_ch = $('.cash_checker3:checked').val();
	    	var dep_id  = $('#dep_id3').val();
	    	if ($('#date_type3').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,3,dep_id);
	    });
	    $(document).on("change", "#dep_id4", function () {
	    	var start	= $("#search_start4").val();
	    	var end		= $("#search_end4").val();
	    	var cash_ch = $('.cash_checker4:checked').val();
	    	var dep_id  = $('#dep_id4').val();
	    	if ($('#date_type4').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,4,dep_id);
	    });
	    $(document).on("change", "#dep_id5", function () {
	    	var start	= $("#search_start5").val();
	    	var end		= $("#search_end5").val();
	    	var cash_ch = $('.cash_checker5:checked').val();
	    	var dep_id  = $('#dep_id5').val();
	    	if ($('#date_type5').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,5,dep_id);
	    });
	    $(document).on("change", "#dep_id6", function () {
	    	var start	= $("#search_start6").val();
	    	var end		= $("#search_end6").val();
	    	var cash_ch = $('.cash_checker6:checked').val();
	    	var dep_id  = $('#dep_id6').val();
	    	if ($('#date_type6').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,6,dep_id);
	    });
	    $(document).on("change", "#dep_id7", function () {
	    	var start	= $("#search_start7").val();
	    	var end		= $("#search_end7").val();
	    	var cash_ch = $('.cash_checker7:checked').val();
	    	var dep_id  = $('#dep_id7').val();
	    	if ($('#date_type7').is(':checked')) {
	    		date_type = 1;
	    	}else{
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,7,dep_id);
	    });

	    // chekbox
	    $(document).on("click", "#date_type", function () {
	    	var start	= $("#search_start").val();
	    	var end		= $("#search_end").val();
	    	var cash_ch = $('.cash_checker:checked').val();
	    	var dep_id  = $('#dep_id').val();	    	
	    	if ($('#date_type').is(':checked')) {
	    		$("#date_type_label").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,0,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type1", function () {
	    	var start	= $("#search_start1").val();
	    	var end		= $("#search_end1").val();
	    	var cash_ch = $('.cash_checker1:checked').val();
	    	var dep_id  = $('#dep_id1').val();	    	
	    	if ($('#date_type1').is(':checked')) {
	    		$("#date_type_label1").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label1").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,1,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type2", function () {
	    	var start	= $("#search_start2").val();
	    	var end		= $("#search_end2").val();
	    	var cash_ch = $('.cash_checker2:checked').val();
	    	var dep_id  = $('#dep_id2').val();	    	
	    	if ($('#date_type2').is(':checked')) {
	    		$("#date_type_label2").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label2").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,2,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type3", function () {
	    	var start	= $("#search_start3").val();
	    	var end		= $("#search_end3").val();
	    	var cash_ch = $('.cash_checker3:checked').val();
	    	var dep_id  = $('#dep_id3').val();	    	
	    	if ($('#date_type3').is(':checked')) {
	    		$("#date_type_label3").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label3").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,3,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type4", function () {
	    	var start	= $("#search_start4").val();
	    	var end		= $("#search_end4").val();
	    	var cash_ch = $('.cash_checker4:checked').val();
	    	var dep_id  = $('#dep_id4').val();	    	
	    	if ($('#date_type4').is(':checked')) {
	    		$("#date_type_label4").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label4").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,4,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type5", function () {
	    	var start	= $("#search_start5").val();
	    	var end		= $("#search_end5").val();
	    	var cash_ch = $('.cash_checker5:checked').val();
	    	var dep_id  = $('#dep_id5').val();	    	
	    	if ($('#date_type5').is(':checked')) {
	    		$("#date_type_label5").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label5").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,5,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type6", function () {
	    	var start	= $("#search_start6").val();
	    	var end		= $("#search_end6").val();
	    	var cash_ch = $('.cash_checker6:checked').val();
	    	var dep_id  = $('#dep_id6').val();	    	
	    	if ($('#date_type6').is(':checked')) {
	    		$("#date_type_label6").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label6").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
	    	LoadTable(start, end, cash_ch,6,dep_id,date_type);
	    });
	    $(document).on("click", "#date_type7", function () {
	    	var start	= $("#search_start7").val();
	    	var end		= $("#search_end7").val();
	    	var cash_ch = $('.cash_checker7:checked').val();
	    	var dep_id  = $('#dep_id7').val();	    	
	    	if ($('#date_type7').is(':checked')) {
	    		$("#date_type_label7").html('გაგზავნის თარიღი');
	    		date_type = 1;
	    	}else{
	    		$("#date_type_label7").html('შეკვეთის თარიღი');
	    		date_type = 0;
	    	}
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
	    $(document).on("click", "#add_id,#add_id1,#add_id2,#add_id3,#add_id4,#add_id5,#add_id6,#add_id7", function () {
		    alert('ძველ გაყიდვებში დამატების ფუნქცია გათიშულია');
	    });
	    $(document).on("click", "#send_book", function () {
	        var data = $(".check:checked").map(function () { //Get Checked checkbox array
	            return this.value;
	        }).get();

	        var data_dep = $(".check:checked").map(function () { //Get Checked checkbox array
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
	                        $("#check-all-in").attr("checked", false);
                        	var start 	= $("#search_start").val();
            				var end 	= $("#search_end").val();
            				var dep_id  = $('#dep_id').val();
                        	LoadTable(start,end,'undefined',0,dep_id);	                        	
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
<div id="tabs_main" style="width: 130%; margin: 0 auto; min-height: 768px; margin-top: 25px;">
		<ul>
		    <li><a href="#tab-0">შეკვეთა მიღებულია</a></li>
		    <li><a href="#tab-1">ჩასარიცხია</a></li>
			<li><a href="#tab-2">შესყიდვა გაკეთებულია</a></li>
			<li><a href="#tab-3">მიღებაჩაბარება დაბეჭდილია</a></li>
			<li><a href="#tab-4">SOLD!</a></li>
			<li><a href="#tab-5">გადავადებული</a></li>
			<li><a href="#tab-6">გაუქმებული</a></li>
			<li><a href="#tab-7">ყველა</a></li>
		</ul>
<div id="tab-0" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type" id="date_type_label" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type" id="date_type" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker right" />
            		</div>
            		<div class="right" style="">
            		    <button style="margin-left:5px;" id="send_book" class="right">გაგზავნა</button> 
	            		<label for="dep_id" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
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
            		  echo '<button style="margin-left:5px;" id="delete_id" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id" class="right">დამატება</button>   
            		         		
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
								<input type="checkbox" name="check-all" id="check-all-in"/>
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
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type1" id="date_type_label1" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type1" id="date_type1" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start1" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start1" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end1" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end1" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker1 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker1 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id1" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id1" style="margin-left: 5px;width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id1" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id1" class="right">დამატება</button>         		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
								<input type="checkbox" name="check-all" id="check-all-in1"/>
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
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type2" id="date_type_label2" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type2" id="date_type2" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start2" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start2" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end2" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end2" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker2 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker2 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id2" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id2" style="margin-left: 5px; width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id2" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id2" class="right">დამატება</button>   		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
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
								<input type="checkbox" name="check-all" id="check-all-in2"/>
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
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type3" id="date_type_label3" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type3" id="date_type3" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start3" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start3" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end3" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end3" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker3 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker3 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id3" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id3" style="margin-left: 5px; width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id3" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id3" class="right">დამატება</button>        		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
								<input type="checkbox" name="check-all" id="check-all-in3"/>
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
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type4" id="date_type_label4" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type4" id="date_type4" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start4" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start4" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end4" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end4" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker4 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker4 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id4" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id4" style="margin-left: 5px; width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id4" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id4" class="right">დამატება</button>  		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 80px;" />
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
								<input type="checkbox" name="check-all" id="check-all-in4"/>
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
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type5" id="date_type_label5" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type5" id="date_type5" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start5" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start5" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end5" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end5" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker5 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker5 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id5" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id5" style="margin-left: 5px; width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id5" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id5" class="right">დამატება</button>          		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
								<input type="checkbox" name="check-all" id="check-all-in5"/>
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
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type6" id="date_type_label6" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type" id="date_type6" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start6" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start6" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end6" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end6" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker6 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker6 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id6" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id6" style="margin-left: 5px; width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id6" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id6" class="right">დამატება</button>   
            		         		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
								<input type="checkbox" name="check-all" id="check-all-in"/>
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
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
    </div>
    
     <!-- TAB 6 -->
    <div id="tab-7" >
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 100%; margin-top: 10px;"  >
            <div id="dynamic" style="width: 100%; ">
            <div id="button_area" style="">
                    <div class="left" style="width: 155px;">
	            		<label for="date_type7" id="date_type_label7" class="left" style="margin: 5px 0 0 9px;">შეკვეთის თარიღი</label>
	            		<input style="height: 15px; margin-left: 7px;" type="checkbox" name="date_type" id="date_type6" class=""/>
	            	</div>
	            	<div class="left" style="width: 175px;">
	            		<label for="search_start7" class="left" style="margin: 5px 0 0 9px;">დასაწყისი</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_start" id="search_start7" class="inpt left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label for="search_end7" class="left" style="margin: 5px 0 0 9px;">დასასრული</label>
	            		<input style="width: 80px; height: 16px; margin-left: 5px;" type="text" name="search_end" id="search_end7" class="inpt right" />
            		</div>
            		
            		<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">ნაღდი</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="1" class="cash_checker7 left"/>
	            	</div>
	            	<div class="left" style="">
	            		<label class="left" style="margin: 5px 0 0 9px;">უნაღდო</label>
	            		<input style="margin-left: 5px;" type="radio" name="cash_checker" value="2" class="cash_checker7 right" />
            		</div>
            		<div class="right" style="">
	            		<label for="dep_id7" class="left" style="margin: 5px 0 0 9px;">დეპარტამენტი</label>
	            		<select id="dep_id7" style="margin-left: 5px; width: 200px;">
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
            		  echo '<button style="margin-left:5px;" id="delete_id7" class="right">წაშლა</button>';
            		}
            		?>
            		<button style="margin-left:5px;" id="add_id7" class="right">დამატება</button>   
            		         		
            	</div>
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
							<th style="width: 75%">ქოლცენტრის კომენტარი</th>
							<th style="width: 30%">დეპარტამენტი</th>
							<th style="width: 30%">პროდუქტის სახეობა</th>
							<th style="width: 22%">თანხა</th>	
							<th style="width: 40%">ოპერატორი</th>
							<th style="width: 30%">სტატუსი</th>
							<th style="width: 50%">კოორდინატორი</th>
							<th style="width: 50%">კოოდინატორის შენიშვნა</th>
							<th style="width: 50%">გაუქმების მიზეზი</th>
							<th style="width: 50%">ნინო (ელვა)</th>
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
								<input type="checkbox" name="check-all" id="check-all-in"/>
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
