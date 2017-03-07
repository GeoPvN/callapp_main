<html>
<head>
<link rel="stylesheet" href="media/css/bootstrap.min.css">
<script src="js/bootstrap.min.js"></script>
<script src="js/highcharts.js"></script>
<script src="js/exporting.js"></script>
<style type="text/css">
.box_main{
	overflow: hidden;
	width: 250px;
	float: left;
    margin-right: 25px;
	margin-bottom: 15px;
}
.box_head{
	width: 100%;
	background: #333333;
	font-family: pvn;
    font-weight: bold;
	color: #FFF;
	padding: 5px;
}
.box_body{
	width: 250px;
	border: 1px solid #E8E8E8;
	background: #FFF;
	height: 160px;
}
#box_content{
	width: 100%;
	margin-top: 17px;
}
.gray_blue{
	background: #EEEEEE;
	color: #2681DC;
}
.box_tab_table{
	width: 100%;
}
.box_tab_table td{
	width: 50%;
	padding: 5px;
	cursor: pointer;
}
.circle
{
	float: left;
    width:30px;
    height:30px;
    border-radius:50%;
    font-size:11px;
    color: #fff;
    line-height: 30px;
    text-align: center;
}
.circle_yellow{
	background: #EFB838;
}
.circle_green{
	background: #50AD4B;
}
.circle_blue{
	background: #2F7ED8;
}
.circle_red{
	background: #AD2C2C;
}
.box_tab_table_content{
	margin-top: 10px;
	width: 100%;
}
.box_tab_table_content td{
	padding: 0 5px 0 5px;
	width: 50%;
}
.box_tab_table_content_text{
	float: left;
	margin-top: 10px;
    margin-left: 5px;
	width: 70px;
}
.bottom_margin_10{
	margin-bottom: 10px;
}
.top_margin_25{
	margin-top: 25px;
}
.now_res{
	text-align: center;
    font-size: 12px;
    font-weight: bold;
	margin-top: 45px;
}
.now_res span {
    font-size: 24px;
    margin-left: -4px;
}
#sl_head{
	width: 165px;
    height: 150px;
    border-radius: 50%;
    border: 5px solid #EEE;
    margin: auto;
    margin-top: 5px;
}
#sl{
	width: 55px;
    margin: auto;
    margin-top: 32px;
    font-size: 30px;
    color: #AD2C2C;
    font-weight: bold;
}
#sls{
    width: 40px;
    margin: auto;
    font-size: 18px;
    color: #222;
    font-weight: bold;
}
.phone_red{
	margin-left: 5px;
	float: left;
	width: 24px;
	height: 24px;
	background: url("media/images/phone_red.png");
}
.phone_yellow{
	margin-left: 5px;
	float: left;
	width: 24px;
	height: 24px;
	background: url("media/images/phone_yellow.png");
}
.phone_progres{
	width: 100%;
}
.phone_progres div{
	height: 24px;
	width: 195px;
    margin-left: 34px;
    border-radius: 4px;
	border: 1px solid #DEDEDE;
	overflow: hidden;
}
.red{
	color: #fff;
	font-size: 16px;
    font-weight: bold;
    text-align: center;
	height: 23px !important;
    margin-left: 0px !important;
	background: #AD2C2C;
}
.yellow{
	color: #fff;
	font-size: 16px;
    font-weight: bold;
    text-align: center;
	height: 23px !important;
    margin-left: 0px !important;
	background: #EFB838
}
.phone_box_hint{
	width: 94%;
	border: 1px solid #9F9F9F;
	height: 25px;
	margin: auto;
	margin-top: 22px;
	border-radius: 6px;

}
.phone_content_box{
	float: left;
	width: 50%;
    height: 100%;
}
.color_box{
    height: 12px;
    width: 16px;
    float: left;
    margin-top: 6px;
    margin-left: 7px;
	border-radius: 3px;
}
.name_box{
	cursor: pointer;
	margin-top: 4px;
    margin-left: 30px;
    font-size: 12px;
}
.content_duration{

}
.total_duration{
	width: 78px;
    margin: auto;
    margin-top: 24px;
    font-size: 30px;
    color: #2F7ED8;
    font-weight: bold;
	margin-bottom: 20px;
}
.min_duration{
	width: 50%;
	float: left;
	font-size: 24px;
    text-align: center;
}
.max_duration{
	width: 50%;
	float: left;
	font-size: 24px;
    text-align: center;
}
.min_icon{
	margin-top: 3px;
	margin-left: 25px;
	float: left;
	width: 24px;
	height: 24px;
	background: url("media/images/min.png");
}
.max_icon{
	margin-top: 3px;
	margin-left: 15px;
	float: left;
	width: 24px;
	height: 24px;
	background: url("media/images/max.png");
}
.min_value{
	float: left;
    margin-left: 5px;
}
.max_value{
	float: left;
    margin-left: 5px;
}
.mini_boxs{
	float: left;
	width: 840px;
}
.table_boxs{
	float: left;
	width: 27%;
}
.table {
  margin: 0 0 40px 0;
  width: 100%;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  display: table;
}
@media screen and (max-width: 580px) {
  .table {
    display: block;
  }
}

.row {
  display: table-row;
  background: #f6f6f6;
}
.row:nth-of-type(odd) {
  background: #e9e9e9;
}
.row.header {
	font-size: 12px;
    font-weight: 900;
    color: #333;
    background: #FFF;
    font-family: pvn;
}
.row.green {
  background: #27ae60;
}
.row.blue {
  background: #2980b9;
}
@media screen and (max-width: 580px) {
  .row {
    padding: 8px 0;
    display: block;
  }
}
.align_right{
	text-align: right;
}
.cell {
	font-size: 10px;
    padding: 3px;
    display: table-cell;
	vertical-align: middle;
}
@media screen and (max-width: 580px) {
  .cell {
    padding: 2px 2px;
    display: block;
  }
}
#status_id_2,#status_id_3,#status_id_4,#status_id_5,#status_id_6,#status_id_9,#status_id_14,#status_id_15,#status_id_16{
	font-size: 45px;
    font-weight: bold;
    text-align: center;
    padding-top: 45px;
}
</style>
<script type="text/javascript">
$(document).ready(function () {
	get_user();
	get_options();
	get_project();
	incomming_call();
	outgoing_call();
	inner_call();
	answer_unanswer();
	sl();
	live_operators();
	live_calls();
	operator_answer();
	operator_answer_dur();
	hold_avg_time();
	asa();
});

$(document).on("change", "#select_tab", function () {
	if($(this).val()==1){
		$('.showme1').css('display','block');
		$('.showme2').css('display','none');
	}else{
		$('.showme1').css('display','none');
		$('.showme2').css('display','block');
	}
});

$(document).on("click", ".box_tab_table td", function () {
    if($(this).hasClass('gray_blue') == true){
    	$(this).removeClass();
    	$($(this).siblings('td')[0]).addClass('gray_blue');
    }
});

$(document).on("change", "#select_main", function () {
	incomming_call();
	outgoing_call();
	inner_call();
	answer_unanswer();
	sl();
	live_operators();
	live_calls();
	operator_answer();
	operator_answer_dur();
	hold_avg_time();
	asa();
});

function get_project(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=get_project',
        success: function(data) {
        	$("#project_id").html(data.option);
        	$('#project_id,#date_checker').chosen({ search_contains: true, width: "250px" });
        	$('#project_id_chosen,#date_checker_chosen').css('margin-right', '21px');
        	GetDate('start_date');
        	GetDate('end_date');
        	get_status_content();
        }
    });
}

function get_status_content(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=get_status&project_id='+$('#project_id').val()+'&start_date='+$('#start_date').val()+'&end_date='+$('#end_date').val()+'&date_checker='+$('#date_checker').val(),
        success: function(data) {
        	$('#status_id_2').html(data.s2);
        	$('#status_id_3').html(data.s3);
        	$('#status_id_4').html(data.s4);
        	$('#status_id_5').html(data.s5);
        	$('#status_id_6').html(data.s6);
        	$('#status_id_9').html(data.s9);
        	$('#status_id_14').html(data.s14);
        	$('#status_id_15').html(data.s15);
        	$('#status_id_16').html(data.s16);
        }
    });
}

$(document).on("change", "#start_date,#end_date,#project_id,#date_checker", function () {
	get_status_content();
});

function get_options(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=get_options',
        success: function(data) {
        	$("#select_main").html(data.option);
        }
    });
}

function get_user(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=get_user',
        success: function(data) {
        	$("#date_checker").html(data.option);
        }
    });
}

function incomming_call(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=incomming_call&qu='+$('#select_main').val(),
        success: function(data) {
        	$("#incomming_call_today").html(data.incomming_call_day_now);
        	$('#incomming_call').highcharts({
    	        chart: {
    	            type: 'line'
    	        },
    	        title: {
    	            text: ''
    	        },
    	        subtitle: {
    	            text: ''
    	        },
    	        xAxis: {
    	        	categories: data.incomming_call_day_date,
    	        	opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
    	        },
    	        yAxis: {
    	            title: {
    	                text: ''
    	            },
    	            opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
    	        },
    	        tooltip: {
                    pointFormat: 'ზარი: <b>{point.y:.0f}</b>'
                },
    	        plotOptions: {
    	            line: {
    	            	color: '#50AD4B',
    	                dataLabels: {
    	                    enabled: false
    	                },
    	                enableMouseTracking: true
    	            }
    	        },
    	        series: data.incomming_call_day,
    	        legend:{
    	        	enabled : false
    	        },
    	        exporting :{
    	        	enabled : false
    	        }
    	    });
        }
    });
}

function outgoing_call(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=outgoing_call&qu='+$('#select_main').val(),
        success: function(data) {
        	$("#outgoing_call_day").html(data.outgoing_call_day_now);
        	$('#outgoing_call').highcharts({
    	        chart: {
    	            type: 'line'
    	        },
    	        title: {
    	            text: ''
    	        },
    	        subtitle: {
    	            text: ''
    	        },
    	        xAxis: {
    	        	categories: data.outgoing_call_day_date,
    	        	opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
    	        },
    	        yAxis: {
    	            title: {
    	                text: ''
    	            },
    	            opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
    	        },
    	        tooltip: {
                    pointFormat: 'ზარი: <b>{point.y:.0f}</b>'
                },
    	        plotOptions: {
    	            line: {
    	            	color: '#EFB838',
    	                dataLabels: {
    	                    enabled: false
    	                },
    	                enableMouseTracking: true
    	            }
    	        },
    	        series: data.outgoing_call_day,
    	        legend:{
    	        	enabled : false
    	        },
    	        exporting :{
    	        	enabled : false
    	        }
    	    });
        }
    });
}

function inner_call(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=inner_call&qu='+$('#select_main').val(),
        success: function(data) {
        	$("#inner_call_day").html(data.inner_call_day_now);
        	$('#inner_call').highcharts({
    	        chart: {
    	            type: 'line'
    	        },
    	        title: {
    	            text: ''
    	        },
    	        subtitle: {
    	            text: ''
    	        },
    	        xAxis: {
    	        	categories: data.inner_call_day_date,
    	        	opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
    	        },
    	        yAxis: {
    	            title: {
    	                text: ''
    	            },
    	            opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
    	        },
    	        tooltip: {
                    pointFormat: 'ზარი: <b>{point.y:.0f}</b>'
                },
    	        plotOptions: {
    	            line: {
    	            	color: '#AD2C2C',
    	                dataLabels: {
    	                    enabled: false
    	                },
    	                enableMouseTracking: true
    	            }
    	        },
    	        series: data.inner_call_day,
    	        legend:{
    	        	enabled : false
    	        },
    	        exporting :{
    	        	enabled : false
    	        }
    	    });
        }
    });
}

function answer_unanswer(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=answer_unanswer&qu='+$('#select_main').val(),
        success: function(data) {
        	$("#answer").html(data.answer_unanswer_today.ans);
        	$("#unanswer").html(data.answer_unanswer_today.unans);
        	$('#answer_unanswer').highcharts({
                chart: {
                    type: 'column'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        style: {
                            fontSize: '11px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
    	                text: ''
    	            },
    	            opposite: false,
    	        	visible: false,
    	        	labels: {
    	        		enabled: false
    	        	}
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'ზარი: <b>{point.y:.0f}</b>'
                },
                series: data.answer_unanswer,
                plotOptions: {
                    column: {
                    	colorByPoint: true,
                      colors: ['#50AD4B', '#AD2C2C'],
                    }
                },
    	        exporting :{
    	        	enabled : false
    	        }
            });
        }
    });
}

function sl(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=sl&qu='+$('#select_main').val(),
        success: function(data) {
        	str = parseInt(data.sl.percent);
            str1 = parseInt(data.sl.sl_procent);
            if(str < str1){
            	$("#sl").css("color","#AD2C2C");
            	$("#sl").html(data.sl.percent+'%');
            	$("#sls").html(data.sl.min+'წმ');
            }else{
            	$("#sl").css("color","#50AD4B");
            	$("#sl").html(data.sl.percent+'%');
            	$("#sls").html(data.sl.min+'წმ');
            }
        }
	});
}

function live_operators(){
// 	$.ajax({
//         url: "server-side/main.action.php",
//         data: 'act=live_operators',
//         success: function(data) {
	$.ajax({
    	async: false,
    	dataType: "JSON",
        url: 'AsteriskManager/liveStatemini_main.php',
	    data: 'sesvar=hideloggedoff&value=true&stst=1&qu='+$('#select_main').val(),
        success: function(data) {

		
        	$('#operators').highcharts({
        		chart: {
                    type: 'column',
                    height: 166
                },
                colors: ['#50AD4B', '#EFB838', '#AD2C2C'],
                title: {
                    text: ' '
                },
                
                xAxis: {
                    categories: [
                        'ოპერატორები'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    },
                    opposite: false,
                	visible: false,
                	labels: {
                		enabled: false
                	}
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                exporting :{
                	enabled : false
                },
                credits: {
                    enabled: false
                },
                series: [{name: "თავის", data: [data.free]}, {name: "დაკავ", data: [data.use]}, {name: "გამორთ", data: [data.off]}]//data.live_operators
            });
        }
    });
//         }
// 	});
}

function live_calls(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=live_calls&qu='+$('#select_main').val(),
        success: function(data) {
            $('.phone_progres .red').html(data.live_calls.in_talk);
            $('.phone_progres .yellow').html(data.live_calls.in_queue);
            $('.phone_progres .red').css('width',(parseInt(data.live_calls.in_talk)+10)+'%');
            $('.phone_progres .yellow').css('width',(parseInt(data.live_calls.in_queue)+10)+'%');
        }
	});
}

function operator_answer(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=operator_answer&qu='+$('#select_main').val(),
        success: function(data) {
            $('#operator_answer_content').html(data.operator_answer);
        }
	});
}

function operator_answer_dur(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=operator_answer_dur&qu='+$('#select_main').val(),
        success: function(data) {
            $('#operator_answer_dur').html(data.operator_answer_dur);
        }
	});
}

function hold_avg_time(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=hold_avg_time&qu='+$('#select_main').val(),
        success: function(data) {
            $('#duration .total_duration').html(data.hold_avg_time.wait_time_avg);
            $('#duration .min_value').html(data.hold_avg_time.wait_time_min);
            $('#duration .max_value').html(data.hold_avg_time.wait_time_max);
        }
	});
}

function asa(){
	$.ajax({
        url: "server-side/main.action.php",
        data: 'act=asa&qu='+$('#select_main').val(),
        success: function(data) {
            $('#asa .total_duration').html(data.asa.wait_time_avg);
            $('#asa .min_value').html(data.asa.wait_time_min);
            $('#asa .max_value').html(data.asa.wait_time_max);
        }
	});
}
function go_sl(){
	window.location="http://212.72.155.176:9898/index.php?pg=7";
}
</script>
</head>
<body onselectstart='return false;'>
<div id="tabs" style="width: 98%;margin-bottom: 60px;height: 710px;">
<div class="callapp_head"><select id="select_main" style="margin-right: 10px;"></select><select id="select_tab"><option value="1">მთავარი</option><option value="2">გამავალი</option></select><hr class="callapp_head_hr"></div>
    <div id="box_content" class="showme1">
        <div class="mini_boxs">
        <div class="box_main">
            <div class="box_head">ოპერატორები LIVE</div>
            <div class="box_body">
                <div>
                     <div id="operators" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;"></div>
                </div>
            </div>
        </div>
        
        <div class="box_main">
            <div class="box_head">შემომავალი ზარები</div>
            <div class="box_body">
                <div>
                    <table class="box_tab_table_content">
                        <tr>
                            <td>
                                <div id="incomming_call" style="width: 180px; height: 145px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div class="now_res"><span id="incomming_call_today">0</span><br> დღეს</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="box_main">
            <div class="box_head">ნაპასუხები / უპასუხო</div>
            <div class="box_body">
                <div>
                    <table class="box_tab_table_content">
                        <tr>
                            <td>
                                <div id="answer_unanswer" style="width: 160px; height: 146px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div class="now_res" style="margin-top: 20px;"><span id="answer">0</span><br> ნაპასუხები</div>
                                <div class="now_res" style="margin-top: 13px;"><span id="unanswer">0</span><br> უპასუხო</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="box_main ">
            <div class="box_head">ზარები LIVE</div>
            <div class="box_body">
                <div>
                    <table class="box_tab_table_content" style="margin-top: 35px;">
                        <tr>
                            <td style="padding-bottom: 20px;">
                                <div class="phone_red"></div>
                                <div class="phone_progres"><div> <div class="red">0</div> </div></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="phone_yellow"></div>
                                <div class="phone_progres"><div> <div class="yellow">0</div> </div></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="phone_box_hint"><div class="phone_content_box"> <div class="color_box circle_red"></div><div class="name_box">საუბრობს</div> </div><div class="phone_content_box"> <div class="color_box circle_yellow"></div><div class="name_box">რიგშია</div> </div></div>
                            </td>
                        </tr>
                    </table>
                    
                </div>
            </div>
        </div>
        
        <div class="box_main ">
            <div class="box_head">გამავალი ზარები</div>
            <div class="box_body">
                <div>
                    <table class="box_tab_table_content">
                        <tr>
                            <td>
                                <div id="outgoing_call" style="width: 180px; height: 145px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div class="now_res"><span id="outgoing_call_day">0</span><br> დღეს</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="box_main ">
            <div class="box_head">ASA</div>
            <div class="box_body">
                <div id="asa">
                    <div class="content_duration"><div class="total_duration">00:00</div><div class="min_duration"><div class="min_icon"></div><div class="min_value">00:00</div></div><div class="max_duration"><div class="max_icon"></div><div class="max_value">00:00</div></div> </div>
                </div>
            </div>
        </div>
        

        <div class="box_main " onclick="go_sl()">
            <div class="box_head">SL</div>
            <div class="box_body">
                <div>
                    <div id="sl_head">
                        <div id="sl">0%</div>
                        <div id="sls">0წმ</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box_main ">
            <div class="box_head">შიდა ზარები</div>
            <div class="box_body">
                <div>
                    <table class="box_tab_table_content">
                        <tr>
                            <td>
                                <div id="inner_call" style="width: 180px; height: 145px; margin: 0 auto"></div>
                            </td>
                            <td>
                                <div class="now_res"><span id="inner_call_day">0</span><br> დღეს</div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="box_main ">
            <div class="box_head">ლოდინის საშ ხან-ბა გათიშვამდე</div>
            <div class="box_body">
                <div id="duration">
                    <div class="content_duration"><div class="total_duration">00:00</div><div class="min_duration"><div class="min_icon"></div><div class="min_value">00:00</div></div><div class="max_duration"><div class="max_icon"></div><div class="max_value">00:00</div></div> </div>
                </div>
            </div>
        </div>
        
        </div>
        
        <div class="table_boxs">
             <div class="table" id="operator_answer_content"></div>
             <div class="table" id="operator_answer_dur"></div>
        </div>
    
    </div>
    
    <div id="box_content" class="showme2" style="display: none;">
    <div style="margin-bottom: 15px;">
    <select id="project_id" style="width: 150px;margin-right: 15px;"></select>
    <select id="date_checker" style="width: 150px;"></select>
    <input type="text" id="start_date">-დან
    <input type="text" id="end_date">-მდე
    </div>
        <div class="box_main">
            <div class="box_head">პირველადი</div>
            <div class="box_body">
                <div>
                     <div id="status_id_2" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">მიმდინარე</div>
            <div class="box_body">
                <div>
                     <div id="status_id_3" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">არ დაინტერესდა</div>
            <div class="box_body">
                <div>
                     <div id="status_id_4" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">პროგრესი</div>
            <div class="box_body">
                <div>
                     <div id="status_id_5" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">კლიენტები</div>
            <div class="box_body">
                <div>
                     <div id="status_id_6" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">გაუქმებული</div>
            <div class="box_body">
                <div>
                     <div id="status_id_9" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">გადასარეკია უკან</div>
            <div class="box_body">
                <div>
                     <div id="status_id_14" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">დანიშნულია შეხვედრა</div>
            <div class="box_body">
                <div>
                     <div id="status_id_15" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>
        <div class="box_main">
            <div class="box_head">მდივნის ბარიერი</div>
            <div class="box_body">
                <div>
                     <div id="status_id_16" style="min-width: 250px; max-width: 250px; height: 150px;margin: 0 auto;">0</div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
