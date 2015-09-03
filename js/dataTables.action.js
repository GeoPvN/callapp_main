/**
* @summary     DataTables Function, jQtransform Plugin Function
* @version     2.3.6
* @contact
*
* @copyright Copyright 2012-2013 Levani Ramazashvili, all rights reserved.
*/


/**
* @summary     GetDataTable
* @version     1.2.8
* @requested   Table Selector Name,
Server Side aJaxURL,
Action,
Colum Number,
Custom Request,
Hidden Colum & Check Box ID,
Menu Array,
Sort Colum ID,
Sort Method
*/
function GetDataTable(tname, aJaxURL, action, count, data, hidden, length, sorting, sortMeth, total, colum_change) {
	
    if (empty(data))
        data = "";
 
    if (empty(tname))
        tname = "example";

    var asInitVals = new Array();

    if (empty(sorting)) {
        sorting = hidden;
    }

    //"asc" or "desc"
    if (empty(sortMeth))
        sortMeth = "asc";

    var oTable = "";

    //Defoult Length
    var dLength = [[10, 30, 50, -1], [10, 30, 50, "ყველა"]];

    if (!empty(length))
        dLength = length;

    var imex = {
		"sSwfPath": "media/swf/copy_csv_xls.swf",
		"aButtons": [ "copy",
		              {
						"sExtends": "xls",
						"sFileName": GetDateTime(1) + ".csv"
		              },
		              "print" ]
	};

    oTable = $("#" + tname).dataTable({
        "bDestroy": true, 																				//Reinicialization table
        "bJQueryUI": true, 																				//Add jQuery ThemeRoller
        "bStateSave": true, 																			//state saving
        "sDom": colum_change,  
		"oTableTools": imex,
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "aaSorting": [[sorting, sortMeth]],
        "iDisplayLength": dLength[0][0],
        "aLengthMenu": dLength,                                                                         //Custom Select Options
        "sAjaxSource": aJaxURL,
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
        	if(!empty(total)){
	        	var iTotal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	            for ( var i = 0 ; i < aaData.length ; i++ )
	            {
	            	for ( var j = 0 ; j < total.length ; j++ )
	                {
		                iTotal[j] += aaData[i][total[j]]*1;
	                }
	            }

	            var iPage = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				for ( var i = iStart ; i < iEnd ; i++ )
				{
					for ( var j = 0 ; j < total.length ; j++ )
	                {
						iPage[j] += aaData[ aiDisplay[i] ][total[j]]*1;
	                }
				}

	            var nCells = nRow.getElementsByTagName('th');
	            for ( var k = 0 ; k < total.length ; k++ )
	            {
	            	nCells[total[k]].innerHTML = (parseInt(iPage[k] * 100) / 100).toFixed(2) + ' <br />' + (parseInt(iTotal[k] * 100) / 100).toFixed(2) + ' ';
	            }
        	}
		},
        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
            oSettings.jqXHR = $.ajax({
                url: sSource,
                data: "act=" + action + "&count=" + count + "&hidden=" + hidden + "&" + data,           //Server Side Requests
                success: function (data) {
                    fnCallback(data);
                    onhovercolor('#2681DC');
                    if (typeof (data.error) != "undefined") {
                        if (data.error != "") {
                            alert(data.error);
                        } else {
                            if ($.isFunction(window.DatatableEnd)) {
                                //execute it
                                DatatableEnd(tname);                                
                            }
                        }
                    }
                }
            });
        },
        "aoColumnDefs": [
              { "sClass": "colum_hidden", "bSortable": false, "bSearchable": false, "aTargets": [hidden]}	//hidden collum
            ],
        "oLanguage": {																						//Localization
            "sProcessing": "იტვირთება...",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "ჩანაწერი ვერ მოიძებნა",
            "sInfo": "_START_-დან _END_-მდე სულ: _TOTAL_",
            "sInfoEmpty": "0-დან 0-მდე სულ: 0",
            "sInfoFiltered": "(გაიფილტრა _MAX_-დან _TOTAL_ ჩანაწერი)",
            "sInfoPostFix": "",
            "sSearch": "ძიება",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "პირველი",
                "sPrevious": "წინა",
                "sNext": "შემდეგი",
                "sLast": "ბოლო"
            }
        }
    });    
    //new $.fn.dataTable.ColReorder(oTable);
    $(".display thead input").keyup(function () {
    	
        /* Filter on the column (the index) of this element */
        oTable.fnFilter(this.value, $(".display thead input").index(this));
    });

    /*
    * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
    * the footer
    */
    $(".display thead input").each(function (i) {
        asInitVals[i] = this.value;
    });

    $(".display thead input").focus(function () {
        if (this.className == "search_init") {
            this.className = "";
            this.value = "";
        }
    });

    $(".display thead input").blur(function (i) {
        if (this.value == "") {
            this.className = "search_init";
            this.value = asInitVals[$(".display thead input").index(this)];
        }
    });

    $(".DTTT_button").hover(
		  function () {
		    $(this).addClass("ui-state-hover");
		  },
		  function () {
		    $(this).removeClass("ui-state-hover");
		  }
    );    
}

function onhovercolor(color){
	var next_color = '';
	$( ".display tbody tr" )
	.mouseenter(function() {		
		if($(this).css('backgroundColor') == 'rgb(249, 249, 249)'){
			next_color = '#F9F9F9';
		}else{
			next_color = '#FFF';
		}		
		$(this).css( 'background', color );
	})
	.mouseleave(function() {
		$(this).css( 'background', next_color );
	});
}

function GetDataTableServer(tname, aJaxURL, action, count, data, hidden, length, sorting, sortMeth, total) {
    if (empty(data))
        data = "";

    if (empty(tname))
        tname = "example";

    var asInitVals = new Array();

    if (empty(sorting)) {
        sorting = hidden;
    }

    //"asc" or "desc"
    if (empty(sortMeth))
        sortMeth = "asc";

    var oTable = "";

    //Defoult Length
    var dLength = [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]];

    if (!empty(length))
        dLength = length;

    var imex = {
		"sSwfPath": "media/swf/copy_csv_xls.swf",
		"aButtons": [ "copy",
		              {
						"sExtends": "xls",
						"sFileName": GetDateTime(1) + ".csv"
		              },
		              "print" ]
	};

    oTable = $("#" + tname).dataTable({
        "bDestroy": true, 																				//Reinicialization table
        "bJQueryUI": true, 																				//Add jQuery ThemeRoller
        //"bStateSave": true, 																			//state saving
        "sDom": "<'dataTable_buttons'T><'H'lfrt><'dataTable_content't><'F'ip>",
		"oTableTools": imex,
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "aaSorting": [[sorting, sortMeth]],
        "iDisplayLength": dLength[0][0],
        "aLengthMenu": dLength,                                                                         //Custom Select Options
        //"sAjaxSource": aJaxURL,
        "bAutoWidth": false,
        "fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
        	if(!empty(total)){
	        	var iTotal = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
	            for ( var i = 0 ; i < aaData.length ; i++ )
	            {
	            	for ( var j = 0 ; j < total.length ; j++ )
	                {
		                iTotal[j] += aaData[i][total[j]]*1;
	                }
	            }

	            var iPage = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				for ( var i = iStart ; i < iEnd ; i++ )
				{
					for ( var j = 0 ; j < total.length ; j++ )
	                {
						iPage[j] += aaData[ aiDisplay[i] ][total[j]]*1;
	                }
				}

	            var nCells = nRow.getElementsByTagName('th');
	            for ( var k = 0 ; k < total.length ; k++ )
	            {
	            	nCells[total[k]].innerHTML = parseInt(iPage[k] * 100) / 100 + ' <br />' + parseInt(iTotal[k] * 100) / 100 + '';
	            }
        	}
		},
        
        "aoColumnDefs": [
              { "sClass": "colum_hidden", "bSortable": false, "bSearchable": false, "aTargets": [hidden]}	//hidden collum
            ],
        "processing": true,
		"serverSide": true,
		"ajax": {
            "url": aJaxURL,
            "data": function ( d ) {d.act = action; d.check = data}
		},
		"stateSave": true,
        "oLanguage": {																						//Localization
            "sProcessing": "იტვირთება...",
            "sLengthMenu": "ნახე _MENU_ ჩანაწერი",
            "sZeroRecords": "ჩანაწერი ვერ მოიძებნა",
            "sInfo": "_START_-დან _END_-მდე სულ: _TOTAL_",
            "sInfoEmpty": "0-დან 0-მდე სულ: 0",
            "sInfoFiltered": "(გაიფილტრა _MAX_-დან _TOTAL_ ჩანაწერი)",
            "sInfoPostFix": "",
            "sSearch": "ძიება",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "პირველი",
                "sPrevious": "წინა",
                "sNext": "შემდეგი",
                "sLast": "ბოლო"
            }
        }
    });

    $("#" + tname + " thead input").keyup(function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter(this.value, $("#" + tname + " thead input").index(this));
    });

    /*
    * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
    * the footer
    */
    $("#" + tname + " thead input").each(function (i) {
        asInitVals[i] = this.value;
    });

    $("#" + tname + " thead input").focus(function () {
        if (this.className == "search_init") {
            this.className = "";
            this.value = "";
        }
    });

    $("#" + tname + " thead input").blur(function (i) {
        if (this.value == "") {
            this.className = "search_init";
            this.value = asInitVals[$("#" + tname + " thead input").index(this)];
        }
    });

    $(".DTTT_button").hover(
		  function () {
		    $(this).addClass("ui-state-hover");
		  },
		  function () {
		    $(this).removeClass("ui-state-hover");
		  }
    );
}

function GetNotify(message){
	jNotify(message,
			{
			  autoHide : true,
			  clickOverlay : true,
			  MinWidth : 250,
			  TimeShown : 1000,
			  ShowTimeEffect : 200,
			  HideTimeEffect : 200,
			  LongTrip :20,
			  HorizontalPosition : 'right',
			  VerticalPosition : 'bottom',
			  ShowOverlay : true,
	   		  ColorOverlay : '#000',
			  OpacityOverlay : 0.3,
			  onClosed : function(){
			  },
			  onCompleted : function(){
			  }
			});
}

function Check(timeout,aJaxURL){
	var start = new Date().getTime();
	var time = 0;

	function instance() {
		if(time <= timeout + 100 ){
			    if (time == timeout && $("#chechedStatus").val() == "true" ) {
			    	time += 100;
		        	param 		= new Object();
		        	param.act	= 'check';
				    $.ajax({
				        url: aJaxURL,
					    data: param,
				        success: function(data) {
							if(typeof(data.error) != "undefined")
							{
								if(data.error != "")
								{
									alert(data.error);
								}else
								{
									if( data.message != null ){
											GetNotify(data.message);
											document.getElementById("jNotify").onclick = function(){ time = 0; LoadTable(); };
									}else{
										time = 0;
									}
								}
							}
					    }
				    });
			    }else{
			        time += 100;
			    }
		}else{
			time = 0;
		}
	    window.setTimeout(instance, 100);
	}
	window.setTimeout(instance, 100);
}



/**
* @summary     GetButtons
* @version     1.0.4
* @requested   Add Button Selector Name, Disable Button Selector Name, Export Button Selector Name
*
* http://www.petefreitag.com/cheatsheets/jqueryui-icons/
*/
function GetButtons(add, dis, exp, cancel, clear) {
    if (!empty(add)) {
        $("#" + add).button({
            icons: {
                primary: "ui-icon-plus"
            }
        });
    }
    if (!empty(dis)) {
        $("#" + dis).button({
            icons: {
                primary: "ui-icon-trash"
            }
        });
    }
    if (!empty(exp)) {
        $("#" + exp).button({
            icons: {
                primary: "ui-icon-arrowreturnthick-1-n"
            }
        });
    }
    if (!empty(cancel)) {
        $("#" + cancel).button({
            icons: {
                primary: "ui-icon-cancel"
            }
        });
    }
    if (!empty(clear)) {
        $("#" + clear).button({
            icons: {
                primary: "ui-icon-shuffle"
            },
            text: false
        });
    }
}

/**
* @summary     SetEvents
* @version     1.2.4
* @requested   Add Button Selector Name,
*              Disable Button Selector Name,
*              Check All Selector Name,
*              Table Selector Name,
*              Form Selector Name,
*              Server Side aJaxURL,
*			   Custom Request
*/
function SetEvents(add, dis, check, tname, fname, aJaxURL, c_data) {
    if (empty(c_data))
        c_data = "";
        $("#"+tname+" tbody").off("dblclick");
        $("#" + add).off("click");

    // Add Event
    $("#" + add).on("click", function () {
    	 $.ajax({
            url: aJaxURL,
            type: "POST",
            data: "act=get_add_page&" + c_data,
            dataType: "json",
            success: function (data) {
                if (typeof (data.error) != "undefined") {
                    if (data.error != "") {
                        alert(data.error);
                    } else {
                        $("#" + fname).html(data.page);
                        if ($.isFunction(window.LoadDialog)) {
                            //execute it
                            LoadDialog(fname);
                        }
                    }
                }
            }
        });
    });

    /* Edit Event */
    $("#" + tname + " tbody").on("dblclick", "tr", function () {
        var nTds = $("td", this);
        var empty = $(nTds[0]).attr("class");

        if (empty != "dataTables_empty") {
            var rID = $(nTds[0]).text();
		if(c_data == 1){
			custom = "dep_now="+$(nTds[8]).text();
		}else{
			custom = ''
		}
            $.ajax({
                url: aJaxURL,
                type: "POST",
                data: "act=get_edit_page&id=" + rID + "&" + c_data + "&" + custom,
                dataType: "json",
                success: function (data) {
                    if (typeof (data.error) != "undefined") {
                        if (data.error != "") {
                            alert(data.error);
                        } else {
                            $("#" + fname).html(data.page);
                            if ($.isFunction(window.LoadDialog)) {
                                //execute it
                                LoadDialog(fname);
                                custom ='';
                            }
                        }
                    }
                }
            });
        }
    });

    /* Disable Event */
    $("#" + dis).on("click", function () {
    	
        var data = $(".check:checked").map(function () {
            return this.value;
        }).get();
    	

        for (var i = 0; i < data.length; i++) {
            $.ajax({
                url: aJaxURL,
                type: "POST",
                data: "act=disable&id=" + data[i] + "&" + c_data,
                dataType: "json",
                success: function (data) {
	                    if (data.error != "") {
	                        alert(data.error);
	                    } else {
	                        $("#" + check).attr("checked", false);
	                    }
                }
            });
        }

    });

    /* Check All */
    $("#" + check).on("click", function () {
    	$("#" + tname + " INPUT[type='checkbox']").prop("checked", $("#" + check).is(":checked"));
    });

    $(document).on("dialogbeforeclose", "#" + fname, function( event, ui ) {
    	if($(this).is(":ui-dialog") || $(this).is(":data(dialog)")){
			$(this).dialog("destroy");
		}
	});
}

/**
* @summary     GetDialog
* @version     1.0.7
* @requested   Dialog Form Selector Name, Buttons Array
*/
function GetDialog(fname, width, height, buttons, position) {
    var defoult = {
        "save": {
            text: "შენახვა",
            id: "save-dialog",
            click: function () {
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
    var ok_defoult = "save-dialog";

    if (!empty(buttons)) {
        defoult = buttons;
    }

    $("#" + fname).dialog({
    	position: position,
        resizable: false,
        width: width,
        height: height,
        modal: true,
        stack: false,
        dialogClass: fname + "-class",
        buttons: defoult
    });
}

/**
* @summary     CloseDialog
* @version     1.0.1
* @requested   Dialog Form Selector Name
*/
function CloseDialog(form){
	$("#" + form).dialog("close");
	$("#" + form).html("");
}

/**
* @summary     GetTabs
* @version     1.0.2
* @requested   Tabs Selector Name
*/
function GetTabs(tbname) {
    var tabs = $("#" + tbname).tabs({
        collapsible: false
    });
}

/**
* @summary     GetSelectedTab
* @version     1.0.2
* @requested   Tabs Selector Name
*/
function GetSelectedTab(tbname) {
    var tabs = $("#" + tbname).tabs();
    var selected = tabs.tabs("option", "active"); // => 0

    return selected;
}

/**
* @summary     GetDate
* @version     1.0.1
* @requested   Input Selector Name
*/
function GetDate(iname) {
    $("#" + iname).datepicker({
        numberOfMonths: 1
    });

    var date = $("#" + iname).val();

    $("#" + iname).datepicker("option", $.datepicker.regional["ka"]);
    $("#" + iname).datepicker("option", "dateFormat", "yy-mm-dd");
    $("#" + iname).datepicker( "setDate", date );
}

function GetDate1(iname) {
    $("#" + iname).datepicker({
    	dateFormat: "yy-mm-dd"
    });

    var date = $("#" + iname).val();
}

function GetDate2(iname) {
    $("." + iname).datepicker({
    	dateFormat: "yy-mm-dd"
    });

    var date = $("." + iname).val();
}


/**
* @summary     GetDateTime
* @version     1.0.1
* @requested   Input Selector Name
*/
function GetDateTimes(iname) {
    $("#" + iname).datetimepicker({
    	dateFormat: "yy-mm-dd"
    });
}

function GetDateTimes1(iname) {
    $("." + iname).datetimepicker({
    	dateFormat: "yy-mm-dd"
    });
}
/**
* @summary     SeoY
* @version     1.0.1
* @requested   Input Selector Name,
*              Server Side seoyURL,
*              Action,
*              Custom Request,
*              MinLength
*/
function SeoY(iname, seoyURL, act, cdata, length) {
    var dlength = 1;

    //Register Button
    $(".combobox").button({
        icons: {
            primary: "ui-icon-triangle-1-s"
        }
    });

    if (!empty(length)) {
        length = dlength;
    }

    $.ajax({
        url: seoyURL,
        type: "POST",
        data: "act=" + act + "&" + cdata,
        dataType: "json",
        success: function (data) {
            $("#" + iname).autocomplete({
                source: data,
                minLength: length,
                autoFocus: true
            });
            $("#" + iname).autocomplete("widget").attr("id", iname + "-widget");
        }
    });
}

/*get calls dialog*/
function GetDialogCalls(fname, width, height, buttons) {
    var defoult = {
        "save": {
            text: "შენახვა",
            id: "save-dialog",
            click: function () {
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
    var ok_defoult = "save-dialog";

    if (!empty(buttons)) {
        defoult = buttons;
    }

    $("#" + fname).dialog({
    	position: "right top",
        resizable: false,
        width: width,
        height: height,
        modal: false,
        stack: false,
        dialogClass: fname + "-class",
        buttons: defoult
    });
}

/**
* @summary     AjaxSetup
* @version     1.0.4
*/
function AjaxSetup() {
    $.ajaxSetup({
        type: "POST",
        dataType: "json",
        beforeSend: function(){
            $("#loading").dialog({
                resizable: false,
                width: 160,
                height: 160,
                modal: true,
                stack: false,
                dialogClass: "loading-dialog",
                open: function(event,ui){
                    $(".ui-widget-overlay").addClass("loading-overlay");
                }
            });
        },
        complete: function(){
        	var $focused = "";
        	$("#loading").dialog({
	      		beforeClose: function( event, ui ) {
	      			$focused = $(":focus");
	      		}
        	});
        	$("#loading").dialog("close");
        	$("#loading").dialog("destroy");
        	$(".ui-widget-overlay").removeClass("loading-overlay");
        	$($focused).focus();
        },
	    error: function (jqXHR, exception) {
	        if (jqXHR.status === 0) {
	        	location.reload(true);
	        } else if (jqXHR.status == 404) {
	            window.location = "index.php";
	        } else if (jqXHR.status == 500) {
	        	location.reload(true);
	        } else if (exception === "parsererror") {
	        	alert('d');
	        	//location.reload(true);
	        } else if (exception === "timeout") {
	        	location.reload(true);
	        } else if (exception === "abort") {
	        	location.reload(true);
	        } else {
	        	location.reload(true);
	        }
	    }
    });
}

/**
* @summary     GetDateTime
* @version     1.0.1
*/
function GetDateTime(format) {
	var currentdate = new Date();
	var datetime;

	var d		= currentdate.getDate();
	var m		= currentdate.getMonth() + 1;
	var yy		= currentdate.getYear();

	var day		= (d < 10) ? '0' + d : d;
	var month	= (m < 10) ? '0' + m : m;
	var year	= (yy < 1000) ? yy + 1900 : yy;

	var h		= currentdate.getHours();
	var mm		= currentdate.getMinutes();
	var s		= currentdate.getSeconds();

	var hours	= (h < 10) ? '0' + h : h;
	var minutes = (mm < 10) ? '0' + mm : mm;
	var seconds = (s < 10) ? '0' + s : s;

	switch (format) {
		case 0:
			datetime = year + "-" + month  + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
			break;
		case 1:
			datetime = year + "-" + month  + "-" + day + "-" + hours + "-" + minutes + "-" + seconds;
			break;
		case 2:
			datetime = year + "-" + month  + "-" + day;
			break;
		default:
			datetime = "Null";
	}

    return datetime;
}

function ToPrice(price) {
	return parseFloat(price).toFixed(2);
}

/**
* @summary     GetAjaxData
* @version     1.0.1
* @requested   Object Array
*/
function GetAjaxData(data) {
    param = "";
    for (var key in data) {
        var value = data[key];
        if (typeof (value) != "undefined") {
            param += key + "=" + value + "&"
        }
    }

    return param;
}

function GetRootDIR(){
	var url = window.location.href;
	var path = url.substring(url.lastIndexOf('/')+1);
	var root = url.substring(0, url.length - path.length);

	return root;
}


