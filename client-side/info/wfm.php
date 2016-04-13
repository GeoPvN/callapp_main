<head>
<script type="text/javascript">
var aJaxURL_object    = "server-side/info/wfm.action.php";
var tName             = "table_";
$(document).ready(function () {
	
    GetDateTimes('start_date_holi');
    GetDateTimes('end_date_holi');
    GetButtons("add_holiday","delete_holiday");
    GetButtons("holi_creap","holi_creap_delete");
    GetButtons("holi_creap_break");
    GetButtons("holi_creap_ext");
    LoadTable('holiday',4,'get_holiday',"<'F'lip>");
    
    $.ajax({
        url: aJaxURL_object,
	    data: 'act=get_project',
        success: function(data) {
        	$('#project_id').html(data.proj);
        	$('#project_id').chosen({ search_contains: true });
        	$('#project_id_chosen').css('width','200px');
	    }
    });

    $.ajax({
        url: aJaxURL_object,
	    data: 'act=get_GetHoliday',
        success: function(data) {
        	$('#holiday_id').html(data.holiday);
        	$('#holiday_id').chosen({ search_contains: true });
	    }
    });
});

$(document).on("change", "#project_id", function () {
	$('#work_table td').css('background', '#fff');
	$.ajax({
        url: aJaxURL_object,
        data: 'act=get_wk&project_id='+$('#project_id').val(),
        success: function(data) {
    		if(typeof(data.error) != "undefined"){
    			if(data.error != ""){
    				alert(data.error);
    			}else{
    				for(g=0;g < $(data.work).size();g++){
    					for(i=parseInt(data.work[g].starttime);i < parseInt(data.work[g].endtime);i++){
    						
    						if(i<9){
    							er='000'+i;
    						}else if(i<99){
        						er='00'+i;
        					}else if(i<999){
                				er='0'+i;
        					}else{
            					er=i;
            				}
    						intvar = parseInt($("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").html(),10)
    						if($("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").css('background-color') == 'rgb(0, 128, 0)'){
   		    				   $("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").html(intvar + 1);
      		    			}else{
        						$("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").html(1);
        		    			$("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").css('background','green');
      		    			}
    		    		}
    				}
    				for(o=0;o < $(data.break).size();o++){
    					for(i=parseInt(data.break[o].breakstarttime);i < parseInt(data.break[o].breakendtime);i++){
    						if(i<99){er='00'+i;}else{er=i;}
    						if(i<999){er='0'+i;}else{er=i;}
    						$("td[clock='"+er+"'][wday='"+data.break[o].wday+"']").css('background','yellow');
    						$("td[clock='"+er+"'][wday='"+data.break[o].wday+"']").html('');
    		    		}
    				}
    			}
    		}
        }
    }).done(function() {
    	LoadTable('holiday',4,'get_holiday',"<'F'lip>");
     });
	 
});

$(document).on("click", "#check-all-import-actived", function () {
	$("#table_week  INPUT[type='checkbox']").prop("checked", $("#check-all-import-actived").is(":checked"));
});

$(document).on("click", "#delete_week", function () {

    var data = $("#table_week .check:checked").map(function () { //Get Checked checkbox array
        return this.value;
    }).get();

    for (var i = 0; i < data.length; i++) {
        $.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=delete_week&id=" + data[i],
            dataType: "json",
            success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                    $("#check-all-import-actived").attr("checked", false);
                    GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+$("#wday").val(), 0, "", 1, "desc", '', "<'F'lip>");
                }
            }
        });
    }

});

$(document).on("click", "#check-all-lang", function () {
	$("#table_lang  INPUT[type='checkbox']").prop("checked", $("#check-all-lang").is(":checked"));
});

$(document).on("click", "#delete_lang", function () {

    var data = $("#table_lang .check:checked").map(function () { //Get Checked checkbox array
        return this.value;
    }).get();

    for (var i = 0; i < data.length; i++) {
        $.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=delete_lang&id=" + data[i],
            dataType: "json",
            success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                    $("#check-all-lang").attr("checked", false);
                    week_day_graphic_id = $('#week_day_graphic_id').val();
                    GetDataTable('table_lang', aJaxURL_object, 'get_list_lang', 2, "week_day_graphic_id="+week_day_graphic_id, 0, "", 1, "desc", '', "<'F'lip>");
                    GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+$("#wday").val(), 0, "", 1, "desc", '', "<'F'lip>");
                }
            }
        });
    }

});

$(document).on("click", "#check-all-infosorce", function () {
	$("#table_infosorce  INPUT[type='checkbox']").prop("checked", $("#check-all-infosorce").is(":checked"));
});

$(document).on("click", "#delete_infosorce", function () {

    var data = $("#table_infosorce .check:checked").map(function () { //Get Checked checkbox array
        return this.value;
    }).get();

    for (var i = 0; i < data.length; i++) {
        $.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=delete_infosorce&id=" + data[i],
            dataType: "json",
            success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                    $("#check-all-infosorce").attr("checked", false);
                    week_day_graphic_id = $('#week_day_graphic_id').val();
                    GetDataTable('table_infosorce', aJaxURL_object, 'get_list_infosorce', 2, "week_day_graphic_id="+week_day_graphic_id, 0, "", 1, "desc", '', "<'F'lip>");
                    GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+$("#wday").val(), 0, "", 1, "desc", '', "<'F'lip>");
                }
            }
        });
    }

});

function LoadTable(tbl,col_num,act,change_colum){
    
    client_id	= $("#hidden_client_id").val();
    project_id	= $("#project_id").val();
    wday = $('#weak_id').val()

    GetDataTable(tName+tbl, aJaxURL_object, act, col_num, "client_id="+client_id+"&project_id="+project_id+"&wday="+wday, 0, "", 1, "desc", '', change_colum);

	setTimeout(function(){
		$('.ColVis, .dataTable_buttons').css('display','none');
	}, 90);
}

$(document).on("click", "#holi_creap", function () {
	start = parseInt($("#start_time").val());
	end = parseInt($("#end_time").val());
	ch_id = 0;
	if(start < end){
	    ch_id = 1;
	}else{
		
			  alert('მიუთითეთ სწორი დრო!');
			  ch_id = 0;
		
	}
	if(ch_id == 1){
		if($('#start_time').val() != '' && $('#end_time').val() != '' && $('#ext_number').val() != ''){
		$("td[wday='"+$("#wday").val()+"']").css('background','#FFF');
		$.ajax({
	        url: aJaxURL_object,
		    data: 'act=work_gr&project_id='+$('#project_id').val()+'&start_time='+$("#start_time").val()+'&end_time='+$("#end_time").val()+'&wday='+$("#wday").val() + '&week_day_graphic_id=' + $("#week_day_graphic_id").val() + '&type=' + $("#type").val(),
	        success: function(data) {
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						alert(data.error);
					}else{
						CloseDialog("add-edit-form-weekADD");
						GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+$("#wday").val(), 0, "", 1, "desc", '', "<'F'lip>");
						$.ajax({
					        url: aJaxURL_object,
						    data: 'act=get_wk&project_id='+$('#project_id').val(),
					        success: function(data) {
								if(typeof(data.error) != "undefined"){
									if(data.error != ""){
										alert(data.error);
									}else{
										for(g=0;g < $(data.work).size();g++){
					    					for(i=parseInt(data.work[g].starttime);i < parseInt(data.work[g].endtime);i++){
					    						if(i<9){
					    							er='000'+i;
					    						}else if(i<99){
					        						er='00'+i;
					        					}else if(i<999){
					                				er='0'+i;
					        					}else{
					            					er=i;
					            				}
					        					
					    		    			$("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").css('background','green');
					    		    			$("td[clock='"+er+"'][wday='"+data.work[g].wday+"']").html(data.work[g].ext_number);
					    		    		}
					    				}
					    				for(o=0;o < $(data.break).size();o++){
					    					for(i=parseInt(data.break[o].breakstarttime);i < parseInt(data.break[o].breakendtime);i++){
					    						if(i<99){er='00'+i;}else{er=i;}
					    						if(i<999){er='0'+i;}else{er=i;}
					    						$("td[clock='"+er+"'][wday='"+data.break[o].wday+"']").css('background','yellow');
					    						$("td[clock='"+er+"'][wday='"+data.break[o].wday+"']").html('');
					    		    		}
					    				}
									}
								}
						    }
					    });
					}
				}
		    }
	    });
	}else{
	    alert('შეავსეთ "სამუშაო იწყება","სამუშაო მთავრდება","სადგურის რაოდენობა" !');
	}
	}
});

$(document).on("click", "#holiday_all", function () {
	if ($(this).is(':checked')) {
		$.ajax({
	        url: aJaxURL_object,
		    data: 'act=add_all_holiday&project_id='+$('#project_id').val(),
	        success: function(data) {
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						alert(data.error);
					}else{
						LoadTable('holiday',4,'get_holiday',"<'F'lip>");
					}
				}
		    }
	    });
	}else{
		$.ajax({
	        url: aJaxURL_object,
		    data: 'act=delete_all_holiday&project_id='+$('#project_id').val(),
	        success: function(data) {
				if(typeof(data.error) != "undefined"){
					if(data.error != ""){
						alert(data.error);
					}else{
						LoadTable('holiday',4,'get_holiday',"<'F'lip>");
					}
				}
		    }
	    });
	}
});

$(document).on("click", "#add_holiday", function () {
    if($("#holiday_id").val() != 0){
        $.ajax({
            url: aJaxURL_object,
    	    data: 'act=add_holiday&project_id='+$('#project_id').val()+'&holiday_id='+$("#holiday_id").val(),
            success: function(data) {
    			if(typeof(data.error) != "undefined"){
    				if(data.error != ""){
    					alert(data.error);
    				}else{
    					LoadTable('holiday',4,'get_holiday',"<'F'lip>");
    				}
    			}
    	    }
        });
    }else{
        alert('აირჩიეთ სასურველი დღე!');
    }
});

$(document).on("click", "#check-all-holiday", function () {
	$("#table_holiday tbody INPUT[type='checkbox']").prop("checked", $("#check-all-holiday").is(":checked"));
});

$(document).on("click", "#delete_holiday", function () {
    var data = $("#table_holiday tbody .check:checked").map(function () {
        return this.value;
    }).get();
	

    for (var i = 0; i < data.length; i++) {
        $.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=delete_holiday&id=" + data[i],
            dataType: "json",
            success: function (data) {
                    if (data.error != "") {
                        alert(data.error);
                    } else {
                    	LoadTable('holiday',4,'get_holiday',"<'F'lip>");
                        $("#check-all-holiday").attr("checked", false);
                    }
            }
        });
    }
});

function OpenWeek(id){
	if($('#project_id').val()!=0){
    	var buttons = {
            	"cancel": {
    	            text: "დახურვა",
    	            id: "cancel-dialog",
    	            click: function () {
    	            	$(this).dialog("close");
    	            }
    	        }
    	    };
    	GetDialog("add-edit-form-week", 770, "auto", buttons, 'top top');
    	$.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=get_week&week_id=" + id + '&project_id=' + $('#project_id').val(),
            dataType: "json",
            success: function (data) {
                    if (data.error != "") {
                        alert(data.error);
                    } else {
                    	$('#add-edit-form-week').html(data.week);
                    	GetButtons("add_week","delete_week");
                    	GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+id, 0, "", 1, "desc", '', "<'F'lip>");
                    }
            }
        });
	}else{
	    alert('აირჩიეთ პროექტი!')
	}
}

$(document).on("dblclick", "#table_week tbody tr", function () {
	var buttons = {
			"save": {
	            text: "შენახვა",
	            id: "holi_creap"
	        },
        	"cancel": {
	            text: "დახურვა",
	            id: "cancel-dialog",
	            click: function () {
	            	$(this).dialog("close");
	            }
	        }
	    };
	GetDialog("add-edit-form-weekADD", 500, "auto", buttons, 'top top');
	$.ajax({
        url: aJaxURL_object,
        type: "POST",
        data: "act=get_weekADD&week_id=" + 1 + '&project_id=' + $('#project_id').val() + '&get_weekADD_id='+$($(this).children(0)[0]).html(),
        dataType: "json",
        success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                	$('#add-edit-form-weekADD').html(data.weekADD);
                	$('#end_time,#start_time').timepicker({
    		        	hourMax: 23,
    		    		hourMin: 00,
    		    		minuteMax: 55,
    		    		minuteMin: 00,
    		    		stepMinute: 15,
    		    		minuteGrid: 15,
    		    		hourGrid: 3,
    		        	dateFormat: '',
    		            timeFormat: 'HH:mm'
    		    	});
    		    	$('#addlang,#addinfosorce').button();
                }
        }
    });
});

$(document).on("click", "#add_week", function () {
	var buttons = {
			"save": {
	            text: "შენახვა",
	            id: "holi_creap"
	        },
        	"cancel": {
	            text: "დახურვა",
	            id: "cancel-dialog",
	            click: function () {
	            	$(this).dialog("close");
	            }
	        }
	    };
	GetDialog("add-edit-form-weekADD", 500, "auto", buttons, 'top top');
	$.ajax({
        url: aJaxURL_object,
        type: "POST",
        data: "act=get_weekADD&week_id=" + 1 + '&project_id=' + $('#project_id').val() + '&get_weekADD_id=0',
        dataType: "json",
        success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                	$('#add-edit-form-weekADD').html(data.weekADD);
                	$('#end_time,#start_time').timepicker({
    		        	hourMax: 23,
    		    		hourMin: 00,
    		    		minuteMax: 55,
    		    		minuteMin: 00,
    		    		stepMinute: 15,
    		    		minuteGrid: 15,
    		    		hourGrid: 3,
    		        	dateFormat: '',
    		            timeFormat: 'HH:mm'
    		    	});
    		    	$('#addlang,#addinfosorce').button();
                }
        }
    });
});

$(document).on("click", "#addlang", function () {
	var buttons = {
        	"cancel": {
	            text: "დახურვა",
	            id: "cancel-dialog",
	            click: function () {
	            	$(this).dialog("close");
	            }
	        }
	    };
	GetDialog("add-edit-form-lang", 500, "auto", buttons, 'top top');
	$.ajax({
        url: aJaxURL_object,
        type: "POST",
        data: "act=get_langdialog&week_id=" + 1 + '&project_id=' + $('#project_id').val(),
        dataType: "json",
        success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                	$('#add-edit-form-lang').html(data.lang);
                	$('#spoken_lang_id').chosen({ search_contains: true });
                	client_id	= $("#hidden_client_id").val();
                    project_id	= $("#project_id").val();
                    wday = $('#wday').val();
                    week_day_graphic_id = $('#week_day_graphic_id').val()
                    GetButtons("add_lang","delete_lang");
                	GetDataTable('table_lang', aJaxURL_object, 'get_list_lang', 2, "week_day_graphic_id="+week_day_graphic_id, 0, "", 1, "desc", '', "<'F'lip>");
                }
        }
    });
});

$(document).on("click", "#add_lang", function () {
	if($('#spoken_lang_id').val() != 0){
    	$.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=add_lang&week_id=" + $('#wday').val() + '&project_id=' + $('#project_id').val() + '&spoken_lang_id=' + $('#spoken_lang_id').val() + '&week_day_graphic_id=' + $('#week_day_graphic_id').val(),
            dataType: "json",
            success: function (data) {
            	week_day_graphic_id = $('#week_day_graphic_id').val()
            	GetDataTable('table_lang', aJaxURL_object, 'get_list_lang', 2, "week_day_graphic_id="+week_day_graphic_id, 0, "", 1, "desc", '', "<'F'lip>");
            	GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+$('#wday').val(), 0, "", 1, "desc", '', "<'F'lip>");
            }
        });
	}else{
	    alert('მიუთითეთ სასაუბრო ენა!');
	}
});

$(document).on("click", "#add_infosorce", function () {
	if($('#information_source_id').val() != 0){
    	$.ajax({
            url: aJaxURL_object,
            type: "POST",
            data: "act=add_infosorce&week_id=" + $('#wday').val() + '&project_id=' + $('#project_id').val() + '&information_source_id=' + $('#information_source_id').val() + '&week_day_graphic_id=' + $('#week_day_graphic_id').val(),
            dataType: "json",
            success: function (data) {
            	week_day_graphic_id = $('#week_day_graphic_id').val()
            	GetDataTable('table_infosorce', aJaxURL_object, 'get_list_infosorce', 2, "week_day_graphic_id="+week_day_graphic_id, 0, "", 1, "desc", '', "<'F'lip>");
            	GetDataTable('table_week', aJaxURL_object, 'table_week', 6, "client_id="+client_id+"&project_id="+project_id+"&wday="+$('#wday').val(), 0, "", 1, "desc", '', "<'F'lip>");  
            }
        });
	}else{
	    alert('მიუთითეთ ინფორმაციის წყარო!');
	}
});

$(document).on("click", "#addinfosorce", function () {
	var buttons = {
        	"cancel": {
	            text: "დახურვა",
	            id: "cancel-dialog",
	            click: function () {
	            	$(this).dialog("close");
	            }
	        }
	    };
	GetDialog("add-edit-form-infosorce", 500, "auto", buttons, 'top top');
	$.ajax({
        url: aJaxURL_object,
        type: "POST",
        data: "act=get_infosorce&week_id=" + 1 + '&project_id=' + $('#project_id').val(),
        dataType: "json",
        success: function (data) {
                if (data.error != "") {
                    alert(data.error);
                } else {
                	$('#add-edit-form-infosorce').html(data.infosorce);
                	$('#information_source_id').chosen({ search_contains: true });
                	client_id	= $("#hidden_client_id").val();
                    project_id	= $("#project_id").val();
                    wday = $('#wday').val();
                    GetButtons("add_infosorce","delete_infosorce");
                	GetDataTable('table_infosorce', aJaxURL_object, 'get_list_infosorce', 2, "week_day_graphic_id="+$('#week_day_graphic_id').val(), 0, "", 1, "desc", '', "<'F'lip>");
                }
        }
    });
});
</script>
<style type="text/css">

#table_right_menu{
    top: 28px;
}
.ColVis, .dataTable_buttons{
	z-index: 100;
} 
#table_holiday_length,
#table_week_length,
#table_lang_length,
#table_infosorce_length{
	position: inherit;
    width: 0px;
	float: left;
}
#table_holiday_length label select,
#table_week_length label select,
#table_lang_length label select,
#table_infosorce_length label select{
	width: 60px;
    font-size: 10px;
    padding: 0;
    height: 18px;
}
#table_holiday_info{
	width: 32%;
}
#table_holiday_paginate{
	margin-left: 0px;
}
#work_table tr{
	height: 19px;
}
.left_border_bold{
    border-left: 2px solid black !important;
}
.right_border_bold{
    border-right: 2px solid !important;
}
</style>
</head>

<body>
<div id="tabs" style="width: 100%">
<div class="callapp_head">WFM<hr class="callapp_head_hr"></div>

    
<div class="callapp_filter_show">    
<fieldset id="holiday">

	    <style>
	    #work_table{
	    
	    width: 100%;
	    margin-top:15px;
	    }
	    #work_table td,#work_table th{
	    border: 1px solid;
        font-size: 11px;
        font-weight: normal;
        text-align: center;
	    }
	    .im_border{
	    border:1px solid;
	    }
        #work_table td input{
        display:none;
        }
	    </style>
               
                <span style="margin-right: 10px;width: 250px;">აირჩიე პროექტი</span><select id="project_id"></select>
	            <table class="dialog-form-table" id="work_table">
                    <tr>
                        <th style="border-top: 2px solid black;" class="left_border_bold"></th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">00:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">01:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">02:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">03:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">04:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">05:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">06:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">07:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">08:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">09:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">10:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">11:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">12:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">13:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">14:00</th>
	                    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">15:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">16:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">17:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">18:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">19:00</th>
	                    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">20:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">21:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">22:00</th>
                	    <th style="border-top: 2px solid black;" class="left_border_bold right_border_bold" colspan="4">23:00</th>
                    </tr>
                    <tr>
                        <th style="width: ;" class="left_border_bold"></th>
                	    <th style="width: ;" class="left_border_bold">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
	                    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
	                    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
	                    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                	    <th style="width: ;">00</th>
                	    <th style="width: ;">15</th>
                	    <th style="width: ;">30</th>
                	    <th style="width: ;" class="right_border_bold">45</th>
                    </tr>
    	            <tr id="wday1">
                        <td onclick="OpenWeek(1)" class="left_border_bold" style="cursor: pointer;">ორშ</td>
                	    <td style="" clock="0000"  check_clock="" wday="1" class="left_border_bold"></td>
                	    <td style="" clock="0015"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0030"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0045"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0100"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0115"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0130"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0145"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0200"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0215"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0230"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0245"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0300"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0315"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0330"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0345"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0400"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0415"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0430"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0445"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0500"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0515"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0530"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0545"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0600"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0615"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0630"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0645"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0700"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0715"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0730"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0745"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0800"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0815"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0830"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0845"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="0900"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0915"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0930"  check_clock="" wday="1" ></td>
                	    <td style="" clock="0945"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1000"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1015"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1030"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1045"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1100"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1115"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1130"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1145"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1200"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1215"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1230"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1245"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1300"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1315"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1330"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1345"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1400"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1415"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1430"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1445"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1500"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1515"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1530"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1545"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1600"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1615"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1630"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1645"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1700"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1715"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1730"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1745"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1800"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1815"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1830"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1845"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="1900"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1915"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1930"  check_clock="" wday="1" ></td>
                	    <td style="" clock="1945"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="2000"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2015"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2030"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2045"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="2100"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2115"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2130"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2145"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="2200"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2215"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2230"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2245"  check_clock="" wday="1" class="right_border_bold"></td>
                	    <td style="" clock="2300"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2315"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2330"  check_clock="" wday="1" ></td>
                	    <td style="" clock="2345"  check_clock="" wday="1" class="right_border_bold"></td>
                    </tr>
	                <tr id="wday2">
                        <td onclick="OpenWeek(2)" class="left_border_bold" style="cursor: pointer;">სამ</td>
                	    <td style="" clock="0000"  check_clock="" wday="2" class="left_border_bold"></td>
                        <td style="" clock="0015"  check_clock="" wday="2" ></td>
                        <td style="" clock="0030"  check_clock="" wday="2" ></td>
                        <td style="" clock="0045"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0100"  check_clock="" wday="2" ></td>
                        <td style="" clock="0115"  check_clock="" wday="2" ></td>
                        <td style="" clock="0130"  check_clock="" wday="2" ></td>
                        <td style="" clock="0145"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0200"  check_clock="" wday="2" ></td>
                        <td style="" clock="0215"  check_clock="" wday="2" ></td>
                        <td style="" clock="0230"  check_clock="" wday="2" ></td>
                        <td style="" clock="0245"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0300"  check_clock="" wday="2" ></td>
                        <td style="" clock="0315"  check_clock="" wday="2" ></td>
                        <td style="" clock="0330"  check_clock="" wday="2" ></td>
                        <td style="" clock="0345"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0400"  check_clock="" wday="2" ></td>
                        <td style="" clock="0415"  check_clock="" wday="2" ></td>
                        <td style="" clock="0430"  check_clock="" wday="2" ></td>
                        <td style="" clock="0445"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0500"  check_clock="" wday="2" ></td>
                        <td style="" clock="0515"  check_clock="" wday="2" ></td>
                        <td style="" clock="0530"  check_clock="" wday="2" ></td>
                        <td style="" clock="0545"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0600"  check_clock="" wday="2" ></td>
                        <td style="" clock="0615"  check_clock="" wday="2" ></td>
                        <td style="" clock="0630"  check_clock="" wday="2" ></td>
                        <td style="" clock="0645"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0700"  check_clock="" wday="2" ></td>
                        <td style="" clock="0715"  check_clock="" wday="2" ></td>
                        <td style="" clock="0730"  check_clock="" wday="2" ></td>
                        <td style="" clock="0745"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0800"  check_clock="" wday="2" ></td>
                        <td style="" clock="0815"  check_clock="" wday="2" ></td>
                        <td style="" clock="0830"  check_clock="" wday="2" ></td>
                        <td style="" clock="0845"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="0900"  check_clock="" wday="2" ></td>
                        <td style="" clock="0915"  check_clock="" wday="2" ></td>
                        <td style="" clock="0930"  check_clock="" wday="2" ></td>
                        <td style="" clock="0945"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1000"  check_clock="" wday="2" ></td>
                        <td style="" clock="1015"  check_clock="" wday="2" ></td>
                        <td style="" clock="1030"  check_clock="" wday="2" ></td>
                        <td style="" clock="1045"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1100"  check_clock="" wday="2" ></td>
                        <td style="" clock="1115"  check_clock="" wday="2" ></td>
                        <td style="" clock="1130"  check_clock="" wday="2" ></td>
                        <td style="" clock="1145"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1200"  check_clock="" wday="2" ></td>
                        <td style="" clock="1215"  check_clock="" wday="2" ></td>
                        <td style="" clock="1230"  check_clock="" wday="2" ></td>
                        <td style="" clock="1245"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1300"  check_clock="" wday="2" ></td>
                        <td style="" clock="1315"  check_clock="" wday="2" ></td>
                        <td style="" clock="1330"  check_clock="" wday="2" ></td>
                        <td style="" clock="1345"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1400"  check_clock="" wday="2" ></td>
                        <td style="" clock="1415"  check_clock="" wday="2" ></td>
                        <td style="" clock="1430"  check_clock="" wday="2" ></td>
                        <td style="" clock="1445"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1500"  check_clock="" wday="2" ></td>
                        <td style="" clock="1515"  check_clock="" wday="2" ></td>
                        <td style="" clock="1530"  check_clock="" wday="2" ></td>
                        <td style="" clock="1545"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1600"  check_clock="" wday="2" ></td>
                        <td style="" clock="1615"  check_clock="" wday="2" ></td>
                        <td style="" clock="1630"  check_clock="" wday="2" ></td>
                        <td style="" clock="1645"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1700"  check_clock="" wday="2" ></td>
                        <td style="" clock="1715"  check_clock="" wday="2" ></td>
                        <td style="" clock="1730"  check_clock="" wday="2" ></td>
                        <td style="" clock="1745"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1800"  check_clock="" wday="2" ></td>
                        <td style="" clock="1815"  check_clock="" wday="2" ></td>
                        <td style="" clock="1830"  check_clock="" wday="2" ></td>
                        <td style="" clock="1845"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="1900"  check_clock="" wday="2" ></td>
                        <td style="" clock="1915"  check_clock="" wday="2" ></td>
                        <td style="" clock="1930"  check_clock="" wday="2" ></td>
                        <td style="" clock="1945"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="2000"  check_clock="" wday="2" ></td>
                        <td style="" clock="2015"  check_clock="" wday="2" ></td>
                        <td style="" clock="2030"  check_clock="" wday="2" ></td>
                        <td style="" clock="2045"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="2100"  check_clock="" wday="2" ></td>
                        <td style="" clock="2115"  check_clock="" wday="2" ></td>
                        <td style="" clock="2130"  check_clock="" wday="2" ></td>
                        <td style="" clock="2145"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="2200"  check_clock="" wday="2" ></td>
                        <td style="" clock="2215"  check_clock="" wday="2" ></td>
                        <td style="" clock="2230"  check_clock="" wday="2" ></td>
                        <td style="" clock="2245"  check_clock="" wday="2" class="right_border_bold"></td>
                        <td style="" clock="2300"  check_clock="" wday="2" ></td>
                        <td style="" clock="2315"  check_clock="" wday="2" ></td>
                        <td style="" clock="2330"  check_clock="" wday="2" ></td>
                        <td style="" clock="2345"  check_clock="" wday="2" class="right_border_bold"></td>
                    </tr>
	                <tr id="wday3">
                        <td onclick="OpenWeek(3)" class="left_border_bold" style="cursor: pointer;">ოთხ</td>
                	    <td style="" clock="0000"  check_clock="" wday="3" class="left_border_bold"></td>
                        <td style="" clock="0015"  check_clock="" wday="3" ></td>
                        <td style="" clock="0030"  check_clock="" wday="3" ></td>
                        <td style="" clock="0045"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0100"  check_clock="" wday="3" ></td>
                        <td style="" clock="0115"  check_clock="" wday="3" ></td>
                        <td style="" clock="0130"  check_clock="" wday="3" ></td>
                        <td style="" clock="0145"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0200"  check_clock="" wday="3" ></td>
                        <td style="" clock="0215"  check_clock="" wday="3" ></td>
                        <td style="" clock="0230"  check_clock="" wday="3" ></td>
                        <td style="" clock="0245"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0300"  check_clock="" wday="3" ></td>
                        <td style="" clock="0315"  check_clock="" wday="3" ></td>
                        <td style="" clock="0330"  check_clock="" wday="3" ></td>
                        <td style="" clock="0345"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0400"  check_clock="" wday="3" ></td>
                        <td style="" clock="0415"  check_clock="" wday="3" ></td>
                        <td style="" clock="0430"  check_clock="" wday="3" ></td>
                        <td style="" clock="0445"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0500"  check_clock="" wday="3" ></td>
                        <td style="" clock="0515"  check_clock="" wday="3" ></td>
                        <td style="" clock="0530"  check_clock="" wday="3" ></td>
                        <td style="" clock="0545"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0600"  check_clock="" wday="3" ></td>
                        <td style="" clock="0615"  check_clock="" wday="3" ></td>
                        <td style="" clock="0630"  check_clock="" wday="3" ></td>
                        <td style="" clock="0645"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0700"  check_clock="" wday="3" ></td>
                        <td style="" clock="0715"  check_clock="" wday="3" ></td>
                        <td style="" clock="0730"  check_clock="" wday="3" ></td>
                        <td style="" clock="0745"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0800"  check_clock="" wday="3" ></td>
                        <td style="" clock="0815"  check_clock="" wday="3" ></td>
                        <td style="" clock="0830"  check_clock="" wday="3" ></td>
                        <td style="" clock="0845"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="0900"  check_clock="" wday="3" ></td>
                        <td style="" clock="0915"  check_clock="" wday="3" ></td>
                        <td style="" clock="0930"  check_clock="" wday="3" ></td>
                        <td style="" clock="0945"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1000"  check_clock="" wday="3" ></td>
                        <td style="" clock="1015"  check_clock="" wday="3" ></td>
                        <td style="" clock="1030"  check_clock="" wday="3" ></td>
                        <td style="" clock="1045"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1100"  check_clock="" wday="3" ></td>
                        <td style="" clock="1115"  check_clock="" wday="3" ></td>
                        <td style="" clock="1130"  check_clock="" wday="3" ></td>
                        <td style="" clock="1145"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1200"  check_clock="" wday="3" ></td>
                        <td style="" clock="1215"  check_clock="" wday="3" ></td>
                        <td style="" clock="1230"  check_clock="" wday="3" ></td>
                        <td style="" clock="1245"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1300"  check_clock="" wday="3" ></td>
                        <td style="" clock="1315"  check_clock="" wday="3" ></td>
                        <td style="" clock="1330"  check_clock="" wday="3" ></td>
                        <td style="" clock="1345"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1400"  check_clock="" wday="3" ></td>
                        <td style="" clock="1415"  check_clock="" wday="3" ></td>
                        <td style="" clock="1430"  check_clock="" wday="3" ></td>
                        <td style="" clock="1445"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1500"  check_clock="" wday="3" ></td>
                        <td style="" clock="1515"  check_clock="" wday="3" ></td>
                        <td style="" clock="1530"  check_clock="" wday="3" ></td>
                        <td style="" clock="1545"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1600"  check_clock="" wday="3" ></td>
                        <td style="" clock="1615"  check_clock="" wday="3" ></td>
                        <td style="" clock="1630"  check_clock="" wday="3" ></td>
                        <td style="" clock="1645"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1700"  check_clock="" wday="3" ></td>
                        <td style="" clock="1715"  check_clock="" wday="3" ></td>
                        <td style="" clock="1730"  check_clock="" wday="3" ></td>
                        <td style="" clock="1745"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1800"  check_clock="" wday="3" ></td>
                        <td style="" clock="1815"  check_clock="" wday="3" ></td>
                        <td style="" clock="1830"  check_clock="" wday="3" ></td>
                        <td style="" clock="1845"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="1900"  check_clock="" wday="3" ></td>
                        <td style="" clock="1915"  check_clock="" wday="3" ></td>
                        <td style="" clock="1930"  check_clock="" wday="3" ></td>
                        <td style="" clock="1945"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="2000"  check_clock="" wday="3" ></td>
                        <td style="" clock="2015"  check_clock="" wday="3" ></td>
                        <td style="" clock="2030"  check_clock="" wday="3" ></td>
                        <td style="" clock="2045"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="2100"  check_clock="" wday="3" ></td>
                        <td style="" clock="2115"  check_clock="" wday="3" ></td>
                        <td style="" clock="2130"  check_clock="" wday="3" ></td>
                        <td style="" clock="2145"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="2200"  check_clock="" wday="3" ></td>
                        <td style="" clock="2215"  check_clock="" wday="3" ></td>
                        <td style="" clock="2230"  check_clock="" wday="3" ></td>
                        <td style="" clock="2245"  check_clock="" wday="3" class="right_border_bold"></td>
                        <td style="" clock="2300"  check_clock="" wday="3" ></td>
                        <td style="" clock="2315"  check_clock="" wday="3" ></td>
                        <td style="" clock="2330"  check_clock="" wday="3" ></td>
                        <td style="" clock="2345"  check_clock="" wday="3" class="right_border_bold"></td>
                    </tr>
	                <tr id="wday4">
                        <td onclick="OpenWeek(4)" class="left_border_bold" style="cursor: pointer;">ხუთ</td>
                	    <td style="" clock="0000"  check_clock="" wday="4" class="left_border_bold"></td>
                        <td style="" clock="0015"  check_clock="" wday="4" ></td>
                        <td style="" clock="0030"  check_clock="" wday="4" ></td>
                        <td style="" clock="0045"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0100"  check_clock="" wday="4" ></td>
                        <td style="" clock="0115"  check_clock="" wday="4" ></td>
                        <td style="" clock="0130"  check_clock="" wday="4" ></td>
                        <td style="" clock="0145"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0200"  check_clock="" wday="4" ></td>
                        <td style="" clock="0215"  check_clock="" wday="4" ></td>
                        <td style="" clock="0230"  check_clock="" wday="4" ></td>
                        <td style="" clock="0245"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0300"  check_clock="" wday="4" ></td>
                        <td style="" clock="0315"  check_clock="" wday="4" ></td>
                        <td style="" clock="0330"  check_clock="" wday="4" ></td>
                        <td style="" clock="0345"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0400"  check_clock="" wday="4" ></td>
                        <td style="" clock="0415"  check_clock="" wday="4" ></td>
                        <td style="" clock="0430"  check_clock="" wday="4" ></td>
                        <td style="" clock="0445"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0500"  check_clock="" wday="4" ></td>
                        <td style="" clock="0515"  check_clock="" wday="4" ></td>
                        <td style="" clock="0530"  check_clock="" wday="4" ></td>
                        <td style="" clock="0545"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0600"  check_clock="" wday="4" ></td>
                        <td style="" clock="0615"  check_clock="" wday="4" ></td>
                        <td style="" clock="0630"  check_clock="" wday="4" ></td>
                        <td style="" clock="0645"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0700"  check_clock="" wday="4" ></td>
                        <td style="" clock="0715"  check_clock="" wday="4" ></td>
                        <td style="" clock="0730"  check_clock="" wday="4" ></td>
                        <td style="" clock="0745"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0800"  check_clock="" wday="4" ></td>
                        <td style="" clock="0815"  check_clock="" wday="4" ></td>
                        <td style="" clock="0830"  check_clock="" wday="4" ></td>
                        <td style="" clock="0845"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="0900"  check_clock="" wday="4" ></td>
                        <td style="" clock="0915"  check_clock="" wday="4" ></td>
                        <td style="" clock="0930"  check_clock="" wday="4" ></td>
                        <td style="" clock="0945"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1000"  check_clock="" wday="4" ></td>
                        <td style="" clock="1015"  check_clock="" wday="4" ></td>
                        <td style="" clock="1030"  check_clock="" wday="4" ></td>
                        <td style="" clock="1045"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1100"  check_clock="" wday="4" ></td>
                        <td style="" clock="1115"  check_clock="" wday="4" ></td>
                        <td style="" clock="1130"  check_clock="" wday="4" ></td>
                        <td style="" clock="1145"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1200"  check_clock="" wday="4" ></td>
                        <td style="" clock="1215"  check_clock="" wday="4" ></td>
                        <td style="" clock="1230"  check_clock="" wday="4" ></td>
                        <td style="" clock="1245"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1300"  check_clock="" wday="4" ></td>
                        <td style="" clock="1315"  check_clock="" wday="4" ></td>
                        <td style="" clock="1330"  check_clock="" wday="4" ></td>
                        <td style="" clock="1345"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1400"  check_clock="" wday="4" ></td>
                        <td style="" clock="1415"  check_clock="" wday="4" ></td>
                        <td style="" clock="1430"  check_clock="" wday="4" ></td>
                        <td style="" clock="1445"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1500"  check_clock="" wday="4" ></td>
                        <td style="" clock="1515"  check_clock="" wday="4" ></td>
                        <td style="" clock="1530"  check_clock="" wday="4" ></td>
                        <td style="" clock="1545"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1600"  check_clock="" wday="4" ></td>
                        <td style="" clock="1615"  check_clock="" wday="4" ></td>
                        <td style="" clock="1630"  check_clock="" wday="4" ></td>
                        <td style="" clock="1645"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1700"  check_clock="" wday="4" ></td>
                        <td style="" clock="1715"  check_clock="" wday="4" ></td>
                        <td style="" clock="1730"  check_clock="" wday="4" ></td>
                        <td style="" clock="1745"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1800"  check_clock="" wday="4" ></td>
                        <td style="" clock="1815"  check_clock="" wday="4" ></td>
                        <td style="" clock="1830"  check_clock="" wday="4" ></td>
                        <td style="" clock="1845"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="1900"  check_clock="" wday="4" ></td>
                        <td style="" clock="1915"  check_clock="" wday="4" ></td>
                        <td style="" clock="1930"  check_clock="" wday="4" ></td>
                        <td style="" clock="1945"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="2000"  check_clock="" wday="4" ></td>
                        <td style="" clock="2015"  check_clock="" wday="4" ></td>
                        <td style="" clock="2030"  check_clock="" wday="4" ></td>
                        <td style="" clock="2045"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="2100"  check_clock="" wday="4" ></td>
                        <td style="" clock="2115"  check_clock="" wday="4" ></td>
                        <td style="" clock="2130"  check_clock="" wday="4" ></td>
                        <td style="" clock="2145"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="2200"  check_clock="" wday="4" ></td>
                        <td style="" clock="2215"  check_clock="" wday="4" ></td>
                        <td style="" clock="2230"  check_clock="" wday="4" ></td>
                        <td style="" clock="2245"  check_clock="" wday="4" class="right_border_bold"></td>
                        <td style="" clock="2300"  check_clock="" wday="4" ></td>
                        <td style="" clock="2315"  check_clock="" wday="4" ></td>
                        <td style="" clock="2330"  check_clock="" wday="4" ></td>
                        <td style="" clock="2345"  check_clock="" wday="4" class="right_border_bold"></td>
                    </tr>
	                <tr id="wday5">
                        <td onclick="OpenWeek(5)" class="left_border_bold" style="cursor: pointer;">პარ</td>
                	    <td style="" clock="0000"  check_clock="" wday="5" class="left_border_bold"></td>
                        <td style="" clock="0015"  check_clock="" wday="5" ></td>
                        <td style="" clock="0030"  check_clock="" wday="5" ></td>
                        <td style="" clock="0045"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0100"  check_clock="" wday="5" ></td>
                        <td style="" clock="0115"  check_clock="" wday="5" ></td>
                        <td style="" clock="0130"  check_clock="" wday="5" ></td>
                        <td style="" clock="0145"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0200"  check_clock="" wday="5" ></td>
                        <td style="" clock="0215"  check_clock="" wday="5" ></td>
                        <td style="" clock="0230"  check_clock="" wday="5" ></td>
                        <td style="" clock="0245"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0300"  check_clock="" wday="5" ></td>
                        <td style="" clock="0315"  check_clock="" wday="5" ></td>
                        <td style="" clock="0330"  check_clock="" wday="5" ></td>
                        <td style="" clock="0345"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0400"  check_clock="" wday="5" ></td>
                        <td style="" clock="0415"  check_clock="" wday="5" ></td>
                        <td style="" clock="0430"  check_clock="" wday="5" ></td>
                        <td style="" clock="0445"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0500"  check_clock="" wday="5" ></td>
                        <td style="" clock="0515"  check_clock="" wday="5" ></td>
                        <td style="" clock="0530"  check_clock="" wday="5" ></td>
                        <td style="" clock="0545"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0600"  check_clock="" wday="5" ></td>
                        <td style="" clock="0615"  check_clock="" wday="5" ></td>
                        <td style="" clock="0630"  check_clock="" wday="5" ></td>
                        <td style="" clock="0645"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0700"  check_clock="" wday="5" ></td>
                        <td style="" clock="0715"  check_clock="" wday="5" ></td>
                        <td style="" clock="0730"  check_clock="" wday="5" ></td>
                        <td style="" clock="0745"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0800"  check_clock="" wday="5" ></td>
                        <td style="" clock="0815"  check_clock="" wday="5" ></td>
                        <td style="" clock="0830"  check_clock="" wday="5" ></td>
                        <td style="" clock="0845"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="0900"  check_clock="" wday="5" ></td>
                        <td style="" clock="0915"  check_clock="" wday="5" ></td>
                        <td style="" clock="0930"  check_clock="" wday="5" ></td>
                        <td style="" clock="0945"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1000"  check_clock="" wday="5" ></td>
                        <td style="" clock="1015"  check_clock="" wday="5" ></td>
                        <td style="" clock="1030"  check_clock="" wday="5" ></td>
                        <td style="" clock="1045"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1100"  check_clock="" wday="5" ></td>
                        <td style="" clock="1115"  check_clock="" wday="5" ></td>
                        <td style="" clock="1130"  check_clock="" wday="5" ></td>
                        <td style="" clock="1145"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1200"  check_clock="" wday="5" ></td>
                        <td style="" clock="1215"  check_clock="" wday="5" ></td>
                        <td style="" clock="1230"  check_clock="" wday="5" ></td>
                        <td style="" clock="1245"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1300"  check_clock="" wday="5" ></td>
                        <td style="" clock="1315"  check_clock="" wday="5" ></td>
                        <td style="" clock="1330"  check_clock="" wday="5" ></td>
                        <td style="" clock="1345"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1400"  check_clock="" wday="5" ></td>
                        <td style="" clock="1415"  check_clock="" wday="5" ></td>
                        <td style="" clock="1430"  check_clock="" wday="5" ></td>
                        <td style="" clock="1445"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1500"  check_clock="" wday="5" ></td>
                        <td style="" clock="1515"  check_clock="" wday="5" ></td>
                        <td style="" clock="1530"  check_clock="" wday="5" ></td>
                        <td style="" clock="1545"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1600"  check_clock="" wday="5" ></td>
                        <td style="" clock="1615"  check_clock="" wday="5" ></td>
                        <td style="" clock="1630"  check_clock="" wday="5" ></td>
                        <td style="" clock="1645"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1700"  check_clock="" wday="5" ></td>
                        <td style="" clock="1715"  check_clock="" wday="5" ></td>
                        <td style="" clock="1730"  check_clock="" wday="5" ></td>
                        <td style="" clock="1745"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1800"  check_clock="" wday="5" ></td>
                        <td style="" clock="1815"  check_clock="" wday="5" ></td>
                        <td style="" clock="1830"  check_clock="" wday="5" ></td>
                        <td style="" clock="1845"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="1900"  check_clock="" wday="5" ></td>
                        <td style="" clock="1915"  check_clock="" wday="5" ></td>
                        <td style="" clock="1930"  check_clock="" wday="5" ></td>
                        <td style="" clock="1945"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="2000"  check_clock="" wday="5" ></td>
                        <td style="" clock="2015"  check_clock="" wday="5" ></td>
                        <td style="" clock="2030"  check_clock="" wday="5" ></td>
                        <td style="" clock="2045"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="2100"  check_clock="" wday="5" ></td>
                        <td style="" clock="2115"  check_clock="" wday="5" ></td>
                        <td style="" clock="2130"  check_clock="" wday="5" ></td>
                        <td style="" clock="2145"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="2200"  check_clock="" wday="5" ></td>
                        <td style="" clock="2215"  check_clock="" wday="5" ></td>
                        <td style="" clock="2230"  check_clock="" wday="5" ></td>
                        <td style="" clock="2245"  check_clock="" wday="5" class="right_border_bold"></td>
                        <td style="" clock="2300"  check_clock="" wday="5" ></td>
                        <td style="" clock="2315"  check_clock="" wday="5" ></td>
                        <td style="" clock="2330"  check_clock="" wday="5" ></td>
                        <td style="" clock="2345"  check_clock="" wday="5" class="right_border_bold"></td>
                    </tr>
	                <tr id="wday6">
                        <td onclick="OpenWeek(6)" class="left_border_bold" style="cursor: pointer;">შაბ</td>
                	    <td style="" clock="0000"  check_clock="" wday="6" class="left_border_bold"></td>
                        <td style="" clock="0015"  check_clock="" wday="6" ></td>
                        <td style="" clock="0030"  check_clock="" wday="6" ></td>
                        <td style="" clock="0045"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0100"  check_clock="" wday="6" ></td>
                        <td style="" clock="0115"  check_clock="" wday="6" ></td>
                        <td style="" clock="0130"  check_clock="" wday="6" ></td>
                        <td style="" clock="0145"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0200"  check_clock="" wday="6" ></td>
                        <td style="" clock="0215"  check_clock="" wday="6" ></td>
                        <td style="" clock="0230"  check_clock="" wday="6" ></td>
                        <td style="" clock="0245"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0300"  check_clock="" wday="6" ></td>
                        <td style="" clock="0315"  check_clock="" wday="6" ></td>
                        <td style="" clock="0330"  check_clock="" wday="6" ></td>
                        <td style="" clock="0345"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0400"  check_clock="" wday="6" ></td>
                        <td style="" clock="0415"  check_clock="" wday="6" ></td>
                        <td style="" clock="0430"  check_clock="" wday="6" ></td>
                        <td style="" clock="0445"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0500"  check_clock="" wday="6" ></td>
                        <td style="" clock="0515"  check_clock="" wday="6" ></td>
                        <td style="" clock="0530"  check_clock="" wday="6" ></td>
                        <td style="" clock="0545"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0600"  check_clock="" wday="6" ></td>
                        <td style="" clock="0615"  check_clock="" wday="6" ></td>
                        <td style="" clock="0630"  check_clock="" wday="6" ></td>
                        <td style="" clock="0645"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0700"  check_clock="" wday="6" ></td>
                        <td style="" clock="0715"  check_clock="" wday="6" ></td>
                        <td style="" clock="0730"  check_clock="" wday="6" ></td>
                        <td style="" clock="0745"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0800"  check_clock="" wday="6" ></td>
                        <td style="" clock="0815"  check_clock="" wday="6" ></td>
                        <td style="" clock="0830"  check_clock="" wday="6" ></td>
                        <td style="" clock="0845"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="0900"  check_clock="" wday="6" ></td>
                        <td style="" clock="0915"  check_clock="" wday="6" ></td>
                        <td style="" clock="0930"  check_clock="" wday="6" ></td>
                        <td style="" clock="0945"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1000"  check_clock="" wday="6" ></td>
                        <td style="" clock="1015"  check_clock="" wday="6" ></td>
                        <td style="" clock="1030"  check_clock="" wday="6" ></td>
                        <td style="" clock="1045"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1100"  check_clock="" wday="6" ></td>
                        <td style="" clock="1115"  check_clock="" wday="6" ></td>
                        <td style="" clock="1130"  check_clock="" wday="6" ></td>
                        <td style="" clock="1145"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1200"  check_clock="" wday="6" ></td>
                        <td style="" clock="1215"  check_clock="" wday="6" ></td>
                        <td style="" clock="1230"  check_clock="" wday="6" ></td>
                        <td style="" clock="1245"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1300"  check_clock="" wday="6" ></td>
                        <td style="" clock="1315"  check_clock="" wday="6" ></td>
                        <td style="" clock="1330"  check_clock="" wday="6" ></td>
                        <td style="" clock="1345"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1400"  check_clock="" wday="6" ></td>
                        <td style="" clock="1415"  check_clock="" wday="6" ></td>
                        <td style="" clock="1430"  check_clock="" wday="6" ></td>
                        <td style="" clock="1445"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1500"  check_clock="" wday="6" ></td>
                        <td style="" clock="1515"  check_clock="" wday="6" ></td>
                        <td style="" clock="1530"  check_clock="" wday="6" ></td>
                        <td style="" clock="1545"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1600"  check_clock="" wday="6" ></td>
                        <td style="" clock="1615"  check_clock="" wday="6" ></td>
                        <td style="" clock="1630"  check_clock="" wday="6" ></td>
                        <td style="" clock="1645"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1700"  check_clock="" wday="6" ></td>
                        <td style="" clock="1715"  check_clock="" wday="6" ></td>
                        <td style="" clock="1730"  check_clock="" wday="6" ></td>
                        <td style="" clock="1745"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1800"  check_clock="" wday="6" ></td>
                        <td style="" clock="1815"  check_clock="" wday="6" ></td>
                        <td style="" clock="1830"  check_clock="" wday="6" ></td>
                        <td style="" clock="1845"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="1900"  check_clock="" wday="6" ></td>
                        <td style="" clock="1915"  check_clock="" wday="6" ></td>
                        <td style="" clock="1930"  check_clock="" wday="6" ></td>
                        <td style="" clock="1945"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="2000"  check_clock="" wday="6" ></td>
                        <td style="" clock="2015"  check_clock="" wday="6" ></td>
                        <td style="" clock="2030"  check_clock="" wday="6" ></td>
                        <td style="" clock="2045"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="2100"  check_clock="" wday="6" ></td>
                        <td style="" clock="2115"  check_clock="" wday="6" ></td>
                        <td style="" clock="2130"  check_clock="" wday="6" ></td>
                        <td style="" clock="2145"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="2200"  check_clock="" wday="6" ></td>
                        <td style="" clock="2215"  check_clock="" wday="6" ></td>
                        <td style="" clock="2230"  check_clock="" wday="6" ></td>
                        <td style="" clock="2245"  check_clock="" wday="6" class="right_border_bold"></td>
                        <td style="" clock="2300"  check_clock="" wday="6" ></td>
                        <td style="" clock="2315"  check_clock="" wday="6" ></td>
                        <td style="" clock="2330"  check_clock="" wday="6" ></td>
                        <td style="" clock="2345"  check_clock="" wday="6" class="right_border_bold"></td>
                    </tr>
	                <tr id="wday7" style="border-bottom: 2px solid black;">
                        <td onclick="OpenWeek(7)" class="left_border_bold" style="cursor: pointer;">კვი</td>
                	    <td style="" clock="0000"  check_clock="" wday="7" class="left_border_bold"></td>
                        <td style="" clock="0015"  check_clock="" wday="7" ></td>
                        <td style="" clock="0030"  check_clock="" wday="7" ></td>
                        <td style="" clock="0045"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0100"  check_clock="" wday="7" ></td>
                        <td style="" clock="0115"  check_clock="" wday="7" ></td>
                        <td style="" clock="0130"  check_clock="" wday="7" ></td>
                        <td style="" clock="0145"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0200"  check_clock="" wday="7" ></td>
                        <td style="" clock="0215"  check_clock="" wday="7" ></td>
                        <td style="" clock="0230"  check_clock="" wday="7" ></td>
                        <td style="" clock="0245"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0300"  check_clock="" wday="7" ></td>
                        <td style="" clock="0315"  check_clock="" wday="7" ></td>
                        <td style="" clock="0330"  check_clock="" wday="7" ></td>
                        <td style="" clock="0345"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0400"  check_clock="" wday="7" ></td>
                        <td style="" clock="0415"  check_clock="" wday="7" ></td>
                        <td style="" clock="0430"  check_clock="" wday="7" ></td>
                        <td style="" clock="0445"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0500"  check_clock="" wday="7" ></td>
                        <td style="" clock="0515"  check_clock="" wday="7" ></td>
                        <td style="" clock="0530"  check_clock="" wday="7" ></td>
                        <td style="" clock="0545"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0600"  check_clock="" wday="7" ></td>
                        <td style="" clock="0615"  check_clock="" wday="7" ></td>
                        <td style="" clock="0630"  check_clock="" wday="7" ></td>
                        <td style="" clock="0645"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0700"  check_clock="" wday="7" ></td>
                        <td style="" clock="0715"  check_clock="" wday="7" ></td>
                        <td style="" clock="0730"  check_clock="" wday="7" ></td>
                        <td style="" clock="0745"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0800"  check_clock="" wday="7" ></td>
                        <td style="" clock="0815"  check_clock="" wday="7" ></td>
                        <td style="" clock="0830"  check_clock="" wday="7" ></td>
                        <td style="" clock="0845"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="0900"  check_clock="" wday="7" ></td>
                        <td style="" clock="0915"  check_clock="" wday="7" ></td>
                        <td style="" clock="0930"  check_clock="" wday="7" ></td>
                        <td style="" clock="0945"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1000"  check_clock="" wday="7" ></td>
                        <td style="" clock="1015"  check_clock="" wday="7" ></td>
                        <td style="" clock="1030"  check_clock="" wday="7" ></td>
                        <td style="" clock="1045"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1100"  check_clock="" wday="7" ></td>
                        <td style="" clock="1115"  check_clock="" wday="7" ></td>
                        <td style="" clock="1130"  check_clock="" wday="7" ></td>
                        <td style="" clock="1145"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1200"  check_clock="" wday="7" ></td>
                        <td style="" clock="1215"  check_clock="" wday="7" ></td>
                        <td style="" clock="1230"  check_clock="" wday="7" ></td>
                        <td style="" clock="1245"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1300"  check_clock="" wday="7" ></td>
                        <td style="" clock="1315"  check_clock="" wday="7" ></td>
                        <td style="" clock="1330"  check_clock="" wday="7" ></td>
                        <td style="" clock="1345"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1400"  check_clock="" wday="7" ></td>
                        <td style="" clock="1415"  check_clock="" wday="7" ></td>
                        <td style="" clock="1430"  check_clock="" wday="7" ></td>
                        <td style="" clock="1445"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1500"  check_clock="" wday="7" ></td>
                        <td style="" clock="1515"  check_clock="" wday="7" ></td>
                        <td style="" clock="1530"  check_clock="" wday="7" ></td>
                        <td style="" clock="1545"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1600"  check_clock="" wday="7" ></td>
                        <td style="" clock="1615"  check_clock="" wday="7" ></td>
                        <td style="" clock="1630"  check_clock="" wday="7" ></td>
                        <td style="" clock="1645"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1700"  check_clock="" wday="7" ></td>
                        <td style="" clock="1715"  check_clock="" wday="7" ></td>
                        <td style="" clock="1730"  check_clock="" wday="7" ></td>
                        <td style="" clock="1745"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1800"  check_clock="" wday="7" ></td>
                        <td style="" clock="1815"  check_clock="" wday="7" ></td>
                        <td style="" clock="1830"  check_clock="" wday="7" ></td>
                        <td style="" clock="1845"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="1900"  check_clock="" wday="7" ></td>
                        <td style="" clock="1915"  check_clock="" wday="7" ></td>
                        <td style="" clock="1930"  check_clock="" wday="7" ></td>
                        <td style="" clock="1945"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="2000"  check_clock="" wday="7" ></td>
                        <td style="" clock="2015"  check_clock="" wday="7" ></td>
                        <td style="" clock="2030"  check_clock="" wday="7" ></td>
                        <td style="" clock="2045"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="2100"  check_clock="" wday="7" ></td>
                        <td style="" clock="2115"  check_clock="" wday="7" ></td>
                        <td style="" clock="2130"  check_clock="" wday="7" ></td>
                        <td style="" clock="2145"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="2200"  check_clock="" wday="7" ></td>
                        <td style="" clock="2215"  check_clock="" wday="7" ></td>
                        <td style="" clock="2230"  check_clock="" wday="7" ></td>
                        <td style="" clock="2245"  check_clock="" wday="7" class="right_border_bold"></td>
                        <td style="" clock="2300"  check_clock="" wday="7" ></td>
                        <td style="" clock="2315"  check_clock="" wday="7" ></td>
                        <td style="" clock="2330"  check_clock="" wday="7" ></td>
                        <td style="" clock="2345"  check_clock="" wday="7" class="right_border_bold"></td>
                    </tr>
	            </table>
	            <table class="dialog-form-table">
                    <tr>
                       <td style="width: 210px;"><label for="queue_scenar">საანგარიშო პერიოდი</label></td>    
	                   <td></td>
                    </tr>
    	            <tr>
                       <td><input style="width: 150px; float: left;" id="start_date_holi" type="text"><span style="margin-top: 5px;float: left;">-დან</span></td>
	                   <td><input style="width: 150px; float: left;" id="end_date_holi" type="text"><span style="margin-top: 5px;float: left;">-მდე</span></td>
                    </tr>
	            </table>
	            <table class="dialog-form-table">
                    <tr>
	                   <td><input id="holiday_all" type="checkbox"></td>
                       <td style="width: ;"><label for="holiday_id">დღესასწაულები</label></td>
                	   <td style="width: ;"><select id="holiday_id" style="width:253px;">'.GetHoliday().'</select></td>
	                   <td style="width: ;"><button id="add_holiday">დამატება</button></td>
                	   <td style="width: ;"><button id="delete_holiday">წაშლა</button></td>
                    </tr>
	            </table>
                <table class="display" id="table_holiday" >
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 29%;">თარიღი</th>
                            <th style="width: 40%;;">სახელი</th>
                            <th style="width: 29%;">კატეგორია</th>
							<th style="width: 30px;" class="check">&nbsp;</th>
						</tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                        	   <input type="text" name="search_id" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" />
                            </th>
							<th>
				            	<div class="callapp_checkbox">
				                    <input type="checkbox" id="check-all-holiday" name="check-all" />
				                    <label style="margin-top: 3px;" for="check-all-holiday"></label>
				                </div>
				            </th>
						</tr>
                    </thead>
                </table>
</div>


<!-- jQuery Dialog -->
<div  id="add-edit-form" class="form-dialog" title="შემომავალი ზარი">
</div>
	<div  id="add-edit-form-hour" class="form-dialog" title="წუთი">
	</div>
	<div  id="add-edit-form-weekADD" class="form-dialog" title="დამატება">
	</div>
	<div  id="add-edit-form-week" class="form-dialog" title="სამუშაო გრაფიკი">
	</div>
	<div  id="add-edit-form-lang" class="form-dialog" title="სასაუბრო ენა">
	</div>
	<div  id="add-edit-form-infosorce" class="form-dialog" title="ინფორმაციის წყარო">
	</div>
</body>