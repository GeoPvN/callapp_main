<html>
<head>
	<script type="text/javascript">
		var aJaxURL	= "server-side/report/out_report.action.php";		//server side folder url
		var tName	= "example";													//table name
		var fName	= "add-edit-form";												//form name
		var change_colum_main = "<'dataTable_buttons'T><'F'Cfipl>";
		    	
		$(document).ready(function () {        	
			LoadTable();	
		});
        
		function LoadTable(){
			
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 2, "", 0, "", 1, "desc", "", change_colum_main);
			setTimeout(function(){
    	    	$('.ColVis, .dataTable_buttons').css('display','none');
  	    	}, 90);
		}
		
		function LoadDialog(){
			var id		= $("#lang_id").val();
			
			/* Dialog Form Selector Name, Buttons Array */
			GetDialog(fName, 600, "auto", "");
		}
		

	    $(document).on("click", "#show_copy_prit_exel", function () {
	        if($(this).attr('myvar') == 0){
	            $('.ColVis,.dataTable_buttons').css('display','block');
	            $(this).css('background','#2681DC');
	            $(this).children('img').attr('src','media/images/icons/select_w.png');
	            $(this).attr('myvar','1');
	        }else{
	        	$('.ColVis,.dataTable_buttons').css('display','none');
	        	$(this).css('background','#E6F2F8');
	            $(this).children('img').attr('src','media/images/icons/select.png');
	            $(this).attr('myvar','0');
	        }
	    });
	   
    </script>
    <style type="text/css">
        #table_right_menu{
            top: 42px;
        }        
        
    </style>
</head>

<body>
<div id="tabs">
<div class="callapp_head">გამავალი რეპორტი<hr class="callapp_head_hr"></div>

<table id="table_right_menu">
<tr>
<td ><img alt="table" src="media/images/icons/table_w.png" height="14" width="14">
</td>
<td><img alt="log" src="media/images/icons/log.png" height="14" width="14">
</td>
<td id="show_copy_prit_exel" myvar="0"><img alt="link" src="media/images/icons/select.png" height="14" width="14">
</td>
</tr>
</table>
    <table class="display" id="example">
        <thead>
            <tr id="datatable_header">
                <th>ID</th>
                <th style="width: 100%;">პროექტი</th>
                <th style="width: 100%;">თარიღი</th>
                <th style="width: 100%;">კომპანია</th>
                <th style="width: 100%;">საქმიანობის სფერო</th>
                <th style="width: 100%;">სტატუსი</th>
                <th style="width: 100%;">ზარის შესახებ</th>
                <th style="width: 100%;">დარეკვის შედეგი</th>
                <th style="width: 100%;">K1. IVR ჩაირთო?</th>
                <th style="width: 100%;">K2. მისალმება  და კითხვა კომპეტენტურ პირზე</th>
                <th style="width: 100%;">K3. კომუნიკაციის არხები</th>
                <th style="width: 100%;">K4. ქოლცენტრი აქვთ?</th>
                <th style="width: 100%;">K5. შეთავაზება და დაინტერესება</th>
                <th style="width: 100%;">K6. მაინც არ გვეუბნება?</th>
                <th style="width: 100%;">K7. იქნებ მეილი გვითხრათ და შეთავაზებას გადმოგიგზავნით</th>
                <th style="width: 100%;">K8. შეხვედრის თარიღი და დრო</th>
                <th style="width: 100%;">K9. განმეორებითი ზარის თარიღი და დრო</th>
                <th style="width: 100%;">K10. იქნებ დამაკავშიროთ:</th>
                <th style="width: 100%;">K11. დასასრული</th>
            </tr>
        </thead>
        <thead>
            <tr class="search_header">
                <th class="colum_hidden">
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
                <th>
                    <input type="text" name="search_category" value="ფილტრი" class="search_init" />
                </th>
            </tr>
        </thead>
    </table>

    
    <!-- jQuery Dialog -->
    <div id="add-edit-form" class="form-dialog" title="სასაუბრო ენა">
    	<!-- aJax -->
	</div>
</body>
</html>

