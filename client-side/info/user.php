<html>
<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/info/user.action.php";		//server side folder url
		var upJaxURL= "server-side/upload/file.action.php";				//server side folder url
		var tName	= "example";											//table name
		var fName	= "add-edit-form";										//form name
		var img_name		= "0.jpg";
		var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";

		$(document).ready(function () {
			LoadTable();

			/* Add Button ID, Delete Button ID */
			GetButtons("add_button", "delete_button");

			SetEvents("add_button", "delete_button", "check-all", tName, fName, aJaxURL);
		});

		function LoadTable(){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 6, "", 0, "", 1, "asc", "", change_colum_main);
			setTimeout(function(){
		    	$('.ColVis, .dataTable_buttons').css('display','none');
		    }, 10);
		}

		function LoadDialog(){
			var id		= $("#pers_id").val();
			if(id != ""){
				$("#lname_fname").attr("disabled", "disabled");
			}
			$("#choose_button").button({
	            icons: {
	                primary: "ui-icon-arrowreturnthick-1-n"
	            }
        	});

			$("#upload_button").button({
	            icons: {
	                primary: "ui-icon-arrowreturnthick-1-n"
	            }
        	});

			var img_url	= $("#upload_img").attr("src");
	    	img_name	= img_url.split("\/")[4]; //Get image name element 4
	    	if(img_name != "0.jpg"){
	    		$("#choose_button").button("disable");
	    	}

			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 450, "auto", "");

			if( $("#position").val() == 13 ){
					$("#passwordTR").removeClass('hidden');
			}
			$( "#accordion" ).accordion({
				active: false,
				collapsible: true,
				heightStyle: "content",
				activate: function(event, ui) {
					$("#is_user").val();
				}
			});
		}

	    // Add - Save
		$(document).on("click", "#save-dialog", function () {
			param = new Object();

            //Action
	    	param.act	= "save_pers";

		    param.id	= $("#pers_id").val();

		    param.n		= $("#name").val();
		    param.t		= $("#tin").val();
		    param.p		= $("#position").val();
		    param.a		= $("#address").val();
		    param.pas	= $("#password").val();
		    param.h_n	= $("#home_number").val();
		    param.m_n	= $("#mobile_number").val();
		    param.comm	= $("#comment").val();

		    param.user	= $("#user").val();
		    param.userp	= $("#user_password").val();
		    param.gp	= $("#group_permission").val();
		    param.ext	= $("#ext").val();
		    param.img 	= img_name;

			if(param.n == ""){
				alert("შეავსეთ სახელი და გვარი!");
			}else if(param.p == 0){
				alert("შეავსეთ თანამდებობა!");
			}else if(param.user && !param.userp){
				alert("შეავსეთ პაროლი")
			}else{
			    $.ajax({
			        url: aJaxURL,
				    data: param,
			        success: function(data) {
						if(typeof(data.error) != "undefined"){
							if(data.error != ""){
								alert(data.error);
							}else{
								LoadTable();
				        		CloseDialog(fName);
							}
						}
				    }
			    });
			}

		});

	    $(document).on("click", "#choose_button", function () {
		    $("#choose_file").click();
		});


	    $(document).on("change", "#choose_file", function () {
	    	var file		= $(this).val();
		    var name		= uniqid();
		    var path		= "../../media/uploads/images/worker/";

		    var ext = file.split('.').pop().toLowerCase();
	        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) { //echeck file type
	        	alert('This is not an allowed file type.');
                this.value = '';
	        }else{
	        	img_name = name + "." + ext;
	        	$("#choose_button").button("disable");
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
    						}else{
    							$("#upload_img").attr("src", "media/uploads/images/worker/" + img_name);
    						}
    					}
    				},
    				error: function (data, status, e)
    				{
    					alert(e);
    				}
    			});
	        }
		});

	    $(document).on("click", "#view_image", function () {
		    var src = $("#upload_img").attr("src");
		    $("#view_img").attr("src", src);
			var buttons = {
				"cancel": {
		            text: "დახურვა",
		            id: "cancel-dialog",
		            click: function () {
		                $(this).dialog("close");
		            }
		        }
		    };
	    	GetDialog("image-form", "auto", "auto", buttons);
		});

	    $(document).on("click", "#upload_img", function () {
		    var src = $("#upload_img").attr("src");
		    $("#view_img").attr("src", src);
			var buttons = {
				"cancel": {
		            text: "დახურვა",
		            id: "cancel-dialog",
		            click: function () {
		                $(this).dialog("close");
		            }
		        }
		    };
	    	GetDialog("image-form", "auto", "auto", buttons);
		});

	    $(document).on("click", "#delete_image", function () {
	    	var img_url	= $("#upload_img").attr("src");
	    	img_name	= img_url.split("\/")[4];	//Get image name element 4
	    	if(img_name != "0.jpg"){
		    	param = new Object();

	            //Action
		    	param.act		= "delete_file";

		    	param.path	 	= "../../media/uploads/images/worker/";
			    param.file_name	= img_name;
			    var id			= $("#pers_id").val();

	            $.ajax({
	                url: upJaxURL,
	                data: param,
	                success: function(data) {
	                    if (typeof(data.error) != "undefined") {
	                        if (data.error != "") {
	                            alert(data.error);
	                        } else {
	                        	$("#choose_button").button("enable");
	                        	$("#upload_img").attr("src", "media/uploads/images/worker/0.jpg");
	                        	if(!empty(id)){
	                        		DeleteImage(id);
		                        }
	                        }
	                    }
	                }
	            });
			}
		});

	    function DeleteImage(prod_id) {
            $.ajax({
                url: aJaxURL,
                data: "act=delete_image&id=" + prod_id,
                success: function(data) {
                    if (typeof(data.error) != "undefined") {
                    	if (data.error != "") {
                            alert(data.error);
                        } else{
                        	img_name = "0.jpg";
                        }
                    }
                }
            });
        }

	    $(document).on("click", "#show_copy_prit_exel", function () {
	        if($(this).attr('myvar') == 0){
	            $('.ColVis,.dataTable_buttons').css('display','block');
	            $(this).css('background','#2681DC');
	            $(this).children('img').attr('src','media/images/icons/select_w.png');
	            $(this).attr('myvar','1');
	        }else{
	        	$('.ColVis,.dataTable_buttons').css('display','none');
	        	$(this).css('background','#FAFAFA');
	            $(this).children('img').attr('src','media/images/icons/select.png');
	            $(this).attr('myvar','0');
	        }
	    });

    </script>
</head>

<body>
<div id="tabs" style="width: 90%">
<div class="callapp_head">თანამშრომლები<hr class="callapp_head_hr"></div>
    
    <div style="margin-top: 15px;">
        <button id="add_button">დამატება</button>
        <button id="delete_button">წაშლა</button>
    </div>
    
<div class="callapp_filter_show">
<table id="table_right_menu">
<tr>
<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;background:#2681DC;"><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td style="cursor: pointer;padding: 4px;border-right: 1px solid #E6E6E6;"><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td style="cursor: pointer;padding: 4px;" id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>
<table class="display" id="example">
    <thead>
        <tr id="datatable_header">
            <th>ID</th>
            <th style="width: 100%">ვინაობა</th>
            <th style="width: 50%">ექსთენშენი</th>
            <th class="min">პირადი ნომერი</th>
            <th class="min">თანამდებობა</th>
            <th class="aver">მისამართი</th>
            <th class="check">#</th>
        </tr>
    </thead>
    <thead>
        <tr class="search_header">
            <th class="colum_hidden">
            	<input type="text" name="search_id" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_name" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_tin" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_tin" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_position" value="ფილტრი" class="search_init" />
            </th>
            <th>
                <input type="text" name="search_address" value="ფილტრი" class="search_init" />
            </th>
            <th>
            	<input type="checkbox" name="check-all" id="check-all">
            </th>
        </tr>
    </thead>
</table>
</div>

    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="თანამშრომლები">
    	<!-- aJax -->
	</div>
    <!-- jQuery Dialog -->
    <div id="image-form" class="form-dialog" title="თანამშრომლის სურათი">
    	<img id="view_img" src="media/uploads/images/worker/0.jpg">
	</div>
	 <!-- jQuery Dialog -->
    <div id="add-group-form" class="form-dialog" title="ჯგუფი">
	</div>
</body>
</html>