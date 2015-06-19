<html>
<head>
<style type="text/css">
.download {

	background:linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#599bb3', endColorstr='#408c99',GradientType=0);
	background-color:#599bb3;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border-radius:8px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:arial;
	font-size:14px;

	text-decoration:none;
	text-shadow:0px 1px 0px #3d768a;
}
#add-edit-form, .idle{'disabled', true};
</style>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
<script type="text/javascript">
var title 	= '0';
var i 		= 0;
var done 	= ['','','','','','',''];
var aJaxURL	= "server-side/report/report_task_user.action.php";		//server side folder url
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
	    i--;
	    drawFirstLevel();
    	if(i==0)$("#back").button({ disabled: true });
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
	                        return '<b>'+ this.point.name +': '+this.point.y+' დავალება :  '+this.percentage.toFixed(2) +' %</b>';

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
	                            	return '<b>'+ this.point.name +': '+this.point.y+' დავალება :  '+this.percentage.toFixed(2) +' %</b>';
	                            }
	                        },
	                        point: {
	                            events: {
	                                click: function() {
		                               $("#back").button({ disabled: false });
		                        		done[i]=this.name;
		                        		if(i==2) i=0;
		                        		else i++;
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
		
		var d_url   ="&start="+start+"&end="+end+"&done="+i+"&user="+user+"&type="+done[0]+"&category="+done[1]+"&sub_category="+done[2];
		var url     = aJaxURL+"?act=get_category"+d_url;

		GetDataTable(tName, aJaxURL, "get_list", 12, d_url, 0, "",'','',[2]);
        $.getJSON(url, function(json) {
	                options.series[0].data 	= 	json.data;
	                options.title['text'] 	=	json.text;
	                chart = new Highcharts.Chart(options);
	                $("#total_quantity").html("იტვირთება....");
	                setTimeout(function(){ $("#total_quantity").html($("#qnt").html().split(">")[1]);}, 500);
		});
		 $("#report tbody").on("click", "tr", function () {
			 if(i==2){
				 d_url1   ="&start="+start+"&end="+end+"&done="+i+"&user="+user+"&type="+done[0]+"&category="+done[1]+"&sub_category="+done[2];
			 		var nTds = $("td", this);
		            var rID = $(nTds[1]).text();
	     		GetDialog("in_form", "100%", "auto");
	     		GetDataTable("report_1", aJaxURL, "get_in_page", 15, d_url1+"&rid="+rID, 0);
	     		SetEvents("", "", "", "report_1", "add-edit-form", "server-side/call/tasks/tasks_tab1.action.php");
	     		$('.ui-dialog-buttonset').hide();

	     		}
	     	});
}
$(document).on("click", ".download", function () {
    var link = ($(this).attr("str")).replace("audio:/var/spool/asterisk/monitor/", "");
//      alert(link)
    link = 'https:/91.233.15.136/records/' + link + '.wav';

    window.open(link, 'chatwindow', "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");

});

function LoadDialog(fname){

	GetDialog(fname, "1154px", "auto");
	$('#add-edit-form, .idle, .idls').attr('disabled', true);
	$('.ui-dialog-buttonset').hide();


};
	</script>
	</head>
	<body>

      <div id="dt_example" class="ex_highlight_row">
       	 <div id="container" style="width:90%">
            <div id="dynamic">
             <div id="button_area" style="margin: 5% 0 0 0">
             <button id="back" style="margin-top:0px">უკან</button>
			</div>
	       <div id="button_area" style="margin: 2% 0 0 0">
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
 <div  id="add-edit-form" class="form-dialog" title="დავალებები">	</div>
  <div id="in_form"  class="form-dialog">
  <br/>
  <br/>
  <br/>
  <table class="display" id="report_1" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
    						<th style="width:19%;">შექმნის თარიღი</th>
    						<th style="width:19%;">დასაწისი</th>
    						<th style="width:19%;">დასასრული</th>
    						<th style="width:19%;">დავალების ტიპი</th>
    						<th style="width:19%;">დეპარტამენტი</th>
    						<th style="width:19%;">პასუხისმგებელი პირი</th>
    						<th style="width:19%;">პრიორიტეტი</th>
    						<th style="width:19%;">სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                    			<input type="text" name="search_id" value="" class="search_init" style="width: 100px"/>
                    		</th>
							<th>
								<input style="width:100px;" type="text" name="search_overhead" value="ფილტრი" class="search_init" />
							</th>
							<th>
								<input style="width:100px;" type="text" name="search_partner" value="ფილტრი" class="search_init" />
							</th>
							
							<th>
								<input style="width:100px;" type="text" name="search_op_date" value="ფილტრი" class="search_init" />
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
							
                        </tr>
                    </thead>
                </table>
               
  </div>
</body>
</html>
