<html>
<head>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
<script type="text/javascript">
var title 	= '0';
var s_i 		= 0;
var done 	= ['','','','','','',''];
var aJaxURL	= "server-side/report/out_call.action.php";		//server side folder url
var tName   = "report";
var start	= $("#search_start").val();
var end		= $("#search_end").val();
$(document).ready(function() {
	$(document).on("change", "#search_start", function () 	{drawFirstLevel();});
	$(document).on("change", "#search_end"  , function () 	{drawFirstLevel();});
	$(document).on("change", "#persons_id"  , function () 	{drawFirstLevel();});
	GetDate("search_start");
	GetDate("search_end");
	drawFirstLevel();
	$("#back").button({ disabled: true });
	$("#back").button({ icons: { primary: "ui-icon-arrowthick-1-w" }});
    $('#back').click(function(){
	    s_i--;
	    drawFirstLevel();
    	if(s_i==0)$("#back").button({ disabled: true });
 });  });

function drawFirstLevel(){
		 var options = {
	                chart: {
	                    renderTo: 'chart_container',
	                    plotBackgroundColor: null,
	                    plotBorderWidth: null,
	                    plotShadow: false
	                },
	                title: {
	                    text: title
	                },
	                tooltip: {
	                    formatter: function() {
	                        return '<b>'+ this.point.name +'-'+this.point.y+' ზარი :  '+this.percentage.toFixed(2) +' %</b>';

	                    }
	                },
	                plotOptions: {
	                	pie: {
	                        allowPointSelect: true,
	                        cursor: 'pointer',
	                        dataLabels: {
	                            enabled: true,
	                            color: '#000000',
	                            connectorColor: '#000000',
	                            formatter: function() {
	                            	return '<b>'+ this.point.name +'-'+this.point.y+' ზარი :  '+this.percentage.toFixed(2) +' %</b>';
	                            }
	                        },
	                        point: {
	                            events: {
	                                click: function() {
	                                	$("#back").button({ disabled: false });
		                        		done[s_i]=this.name;
		                        		if(s_i == 2){
		                        			s_i = 0;
		                        		}else
		                        		{
		                        			s_i++;
		                        		}
		                        		drawFirstLevel();
	                                }
	                            }
	                        }
	                    }
	                },
	                series: [{
	                    type: 'pie',
	                    name: 'კატეგორიები',
	                    data: []
	                }]
	            }
		var start	= $("#search_start").val();
		var end		= $("#search_end").val();
		var user	= $("#persons_id").val();
		
		var d_url   ="&start="+start+"&end="+end+"&done="+s_i+"&user="+user+"&task="+done[0]+"&scenar="+done[1]+"&category="+done[2]+"&sub_category="+done[3];
		var url     = aJaxURL+"?act=get_category"+d_url;
		GetDataTable(tName, aJaxURL, "get_list", 4, d_url, 0, "",'','',[2]);

		$("#report tbody").on("click", "tr", function () {
			 if(s_i==2){
			 var nTds = $("td", this);
		            var rID = $(nTds[1]).text();
		            var d_url   ="&start="+start+"&end="+end+"&done="+s_i+"&user="+user+"&task="+done[0]+"&scenar="+done[1]+"&category="+done[2]+"&sub_category="+done[3];
	    	    GetDataTable("report_1", aJaxURL, "get_in_page", 9, d_url+rID, 0);
	     		GetDialog("in_form", "1100px", "auto");
	     	 }
	     		$("#in_form #save-dialog").hide();
			    SetEvents("", "", "", "report_1", "incoming_dialog", "server-side/call/outgoing/outgoing_tab0.action.php");
			 
	     });
		
        $.getJSON(url, function(json) {
	                options.series[0].data = json.data;
	                options.title['text']=json.text;
	                chart = new Highcharts.Chart(options);
	                $("#total_quantity").html("იტვირთება....")
	                setTimeout(function(){ $("#total_quantity").html($("#qnt").html().split(">")[1]);}, 500);
		});
}
function LoadDialog(fName){

	/* Dialog Form Selector Name, Buttons Array */
	GetDialog(fName, 1150, "auto", "");
	LoadTable5();LoadTable6();
	$('#incoming_dialog input, #incoming_dialog #add-edit-form, #incoming_dialog .idle, #incoming_dialog .idls ').attr('disabled', true);
	$('#incoming_dialog  .save-dialog, #incoming_dialog .calls, #incoming_dialog #read_more, #incoming_dialog .ui-dialog-buttonset, .incoming_dialog-class #save-dialog').hide();
	$("#choose_button").button({
        
    });
    $(".download").button({
        
    });	
    $(".done").button({
        
    });
	$(".next").button({
        
    });
	$(".back").button({
        
    });
	$("#complete").button({
	    
	});
	
};

function LoadTable5(){		
	var scenar_name =	$("#shabloni").val();
	GetButtons("add_button_product","delete_button_product");
	/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
	GetDataTable("sub1", "server-side/call/outgoing/suboutgoing/outgoing_tab1.action.php", "get_list&scenar_name="+scenar_name, 5, "", 0, "", 1, "asc", "");
	
}
function LoadTable6(){		
	var scenar_name =	$("#shabloni").val();	
	GetButtons("add_button_gift","delete_button_gift");
	/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
	GetDataTable("sub2", "server-side/call/outgoing/suboutgoing/outgoing_tab2.action.php", "get_list&scenar_name="+scenar_name, 5, "", 0, "", 1, "asc", "");
	
}

$(document).on("click", ".download", function () {
    var link = $(this).attr("str");
    link = "http://109.234.117.182:8181/records/" + link;

    var newWin = window.open(link, "JSSite", "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");
    newWin.focus();
});

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
       	 <div id="container" style="width:90%">
            <div id="dynamic">
             <div id="button_area" style="margin: 3% 0 0 0">
             <button id="back" style="margin-top:0px">უკან</button>
			</div>
	       <div id="button_area" style="margin: 3% 0 0 0">
	         <div class="left" style="width: 175px;">
	           <input type="text" name="search_start" id="search_start" class="inpt right"/>
	             </div>
	            	<label for="search_start" class="left" style="margin:5px 0 0 3px">-დან</label>
	             <div class="left" style="width: 185px;">
		            <input type="text" name="search_end" id="search_end" class="inpt right" />
	             </div>
	            	<label for="search_end" class="left" style="margin:5px 0 0 3px">–მდე</label>
	            	
	            	<div class="left" style="width: 195px;">
	         		<label for="search_end" class="left" style="margin:-18px 0 0 28px">პასუხისმგებელი პირი</label>
		          <select style="width: 186px;" id="persons_id" class="inpt right"><?php 
		          
		       
							   $rResult = mysql_query("	SELECT users.`id`, persons.`name`
														FROM `persons`
														JOIN	`users` ON persons.id = users.person_id
														WHERE persons.actived=1 AND users.group_id in(3,15)");

								echo'<option value="0" selected="selected">ყველა</option>';
								
							    while ( $aRow = mysql_fetch_array( $rResult ) )
							    {
							    	echo '<option value="'.$aRow[0].'">'.$aRow[1].'</option>';
							    }?>
				</select>
	             </div>
	             
	           <label class="left" style="margin:5px 0 0 40px">ზარების  ჯამური რაოდენობა: </label> <label id="total_quantity" class="left" style="margin:5px 0 0 2px; font-weight: bold;">5</label>
	       <br /><br /><br />
	            </div>
			<div id="chart_container" style="width: 100%; height: 480px; margin-top:-30px;"></div>
			<input type="text" id="hidden_name" value="" style="display: none;" />
			<br><br><br><br><br><br><br><br><br><br>

			 <table class="display" id="report">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width:100%">დასახელება</th>
                            <th class="min">რაოდენობა</th>
                            <th class="min">პროცენტი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init">
                            </th>
                            <th>
                            	<input type="text" name="search_object" value="ფილტრი" class="search_init">
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th id="qnt">&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
                 <div class="spacer">
            	</div>
		</div>
	</div>
  </div>
    <div id="in_form"  class="form-dialog">
  <br/>
  <br/>
  <br/>
  <table class="display" id="report_1" >
                    <thead>
								<tr id="datatable_header">
		                            <th>ID</th>
									<th style="width:19%;">დარეკვის თარიღი</th>
									<th style="width:19%;">დავალების ტიპი</th>
									<th style="width:19%;">სცენარი</th>
									<th style="width:19%;">დასახელება</th>
									<th style="width:19%;">პასუხისმგებელი პირი</th>
									<th style="width:19%;">პრიორიტეტი</th>
									<th style="width:19%;">შენიშვნა</th>
									<th style="width:30%;">ზარის დაზუსტება</th>
								</tr>
							</thead>
							<thead>
								<tr class="search_header">
									<th class="colum_hidden">
                            			<input type="text" name="search_id" value="" class="search_init" style="width: 10px"/>
                            		</th>
									<th>
										<input style="width:85px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:85px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_op_date" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									<th>
										<input style="width:100px;" type="text" name="search_sum_cost" value="ფილტრი" class="search_init" />
									</th>
									
								</tr>
							</thead>
                    
                </table>
  </div>
   <div id="incoming_dialog"  class="form-dialog">
  </div>
</body>
</html>
