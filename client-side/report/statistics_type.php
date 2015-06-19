<html>
<head>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
<script type="text/javascript">
var title 	='0';
var s_i		= 0;
var done  	= ['','','','','','',''];
var aJaxURL	= "server-side/report/statistics_type.action.php";		//server side folder url
var tName   = "report";
var start	= $("#search_start").val();
var end		= $("#search_end").val();
var d_url 	= "";
$(document).ready(function() {

	$(document).on("change", "#search_start", function () 	{drawFirstLevel();});
	$(document).on("change", "#search_end"  , function () 	{drawFirstLevel();});
	$(document).on("change", "#inc_type"  , function () 	{drawFirstLevel();});
	GetDate("search_start");
	GetDate("search_end");
	drawFirstLevel();
	$("#back").button({ disabled: true });
	$("#back").button({ icons: { primary: "ui-icon-arrowthick-1-w" }});
    $('#back').click(function(){
    	s_i--;
    	drawFirstLevel();
    	if(s_i==0)$("#back").button({ disabled: true });
	});
	});


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
										if(s_i==4) s_i=0;
		                        		else s_i++;
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
	            };


		var start	= $("#search_start").val();
		var end		= $("#search_end").val();
		var inc_type		= $("#inc_type").val();
		d_url   ="&start="+start+"&end="+end+"&done="+s_i+"&status_type="+done[0]+"&type="+done[1]+"&departament="+done[2]+"&category="+done[3]+"&sub_category="+done[4]+"&inc_type="+inc_type;
		var url     = aJaxURL+"?act=get_category"+d_url;
		GetDataTable(tName, aJaxURL, "get_list", 4, d_url, 0, "",'','',[2]);

		$("#report tbody").on("click", "tr", function () {
			 if(s_i==4){
			 var nTds = $("td", this);
		            var rID = $(nTds[1]).text();
		            d_url   ="&start="+start+"&end="+end+"&done="+s_i+"&inc_type="+inc_type+"&departament="+done[2]+"&type="+done[1]+"&category="+done[3]+"&sub_category=";
	    	    GetDataTable("report_1", aJaxURL, "get_in_page", 4, d_url+rID, 0);
	     		GetDialog("in_form", "1100px", "auto");}
	     		$("#in_form #save-dialog").hide();
			    SetEvents("", "", "", "report_1", "incoming_dialog", "server-side/call/incomming.action.php");
			 
	     	});
        $.getJSON(url, function(json) {options.series[0].data = json.data;
	           		options.series[0].data = json.data;
	                options.title['text']=json.text;
	                chart = new Highcharts.Chart(options);
	                $("#total_quantity").html("იტვირთება....");
	                setTimeout(function(){ $("#total_quantity").html($("#qnt").html().split(">")[1]);
	                }, 500);
	    });

}
function LoadDialog(fName){

	/* Dialog Form Selector Name, Buttons Array */
	GetDialog(fName, 1200, "auto", "");
	$('#incoming_dialog input, #incoming_dialog #add-edit-form, #incoming_dialog .idle, #incoming_dialog .idls ').attr('disabled', true);
	$('#incoming_dialog  .save-dialog, #incoming_dialog .calls, #incoming_dialog #read_more, #incoming_dialog .ui-dialog-buttonset, .incoming_dialog-class #save-dialog').hide();
	$("#choose_button").button({
        
    });
    $(".download").button({
        
    });	
	
};

$(document).on("click", ".download", function () {
    var link = $(this).attr("str");
    link = "http://109.234.117.182:8181/records/" + link + ".wav";

    var newWin = window.open(link, "JSSite", "width=420,height=230,resizable=yes,scrollbars=yes,status=yes");
    newWin.focus();
});
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
		          <select style="width: 186px;" id="inc_type" class="inpt right">
						<option value="0" selected="selected">ყველა</option>
                        <option value="1">შემომავალი ზარი</option>
                        <option value="2">გამოტოვებული ზარები</option>
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
                            <th style="display: none" >ID</th>
                            <th style="width: 140px;">თარიღი</th>
                            <th style="width: 130px;">განყოფილებები</th>
                            <th style="width: 100%;">ქვე-კატეგორია</th>
                            <th style="width: 120px;">ტელეფონი</th>
                            <th style="width: 80%;">ზარის სტატუსი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th style="display: none" >
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init">
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
                        </tr>
                    </thead>
                </table>
  </div>
  <div id="incoming_dialog"  class="form-dialog">
  </div>
</body>
</html>
