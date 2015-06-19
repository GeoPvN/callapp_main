<head>
	<script type="text/javascript">
		var aJaxURL	    = "server-side/report/out_call_result.action.php";	//server side folder url
		var tName	    = "example";									    //table name
		var scenario_id = 0; 
		$(document).ready(function () {
			GetDate("datetime");
			var datetime 	= $("#datetime").val();
			LoadTable('', '')
		});

		function LoadTable(scenario_id, datetime){
			/* Table ID, aJaxURL, Action, Colum Number, Custom Request, Hidden Colum, Menu Array */
			GetDataTable(tName, aJaxURL, "get_list", 19, "scenario_id=" + scenario_id + "&datetime=" + datetime, 0, "", 1, "desc");
		}


		$(document).on("change", "#scenario", function () {
			var datetime      = $("#datetime").val();
	    	var scenario_id   = $(this).val();    		    	
	       LoadTable(scenario_id, datetime);
	    });
	    
	    $(document).on("change", "#datetime", function () {
	    	var datetime      = $(this).val();
	    	var scenario_id   = $("#scenario").val();	    	
	        LoadTable(scenario_id, datetime);
	    });
	    
    </script>
</head>

<body>
    <div id="dt_example" class="ex_highlight_row">
        <div id="container" style="width: 250%;">        	
            <div id="dynamic">
            	<div id="button_area">
	            	<div class="left" style="width: 280px;">
	            		<label for="search_start" class="left" style="margin: 5px 0 0 9px;">სცენარი</label>
	            		<select style="width: 170px; margin-left:5px;" id="scenario" class="">
	            		<option value="1">კვირის პალიტრის მომხმარებლის კვლევა</option>
	            		</select>
	            	</div>
	            	<div class="right" style="">
	            		<label for="search_end" class="left" style="margin: 5px 0 0 9px;">თარიღი</label>
	            		<input style="height: 13px; width: 100px; margin-left: 5px;" type="text" name="search_end" id="datetime" class="inpt right" />
            		</div>	
            	</div>
                <table class="display" id="example">
                    <thead>
                        <tr id="datatable_header">
                            <th>ID</th>
                            <th style="width: 100%;">თარიღი</th>
                            <th style="width: 100%;">სცენარი</th>
                            <th style="width: 100%;">სცენარის კატეგორია</th>
                            <th style="width: 100%;">სცენარის ქვე-კატეგორია</th>
                            <th style="width: 100%;">მისამართი</th>                            
                            <th style="width: 100%;">სახელი და გვარი</th>
                            <th style="width: 100%;">ტელეფონი 1</th>
                            <th style="width: 100%;">ტელეფონი 2</th>
                            <th style="width: 100%;">შემსრულებელი</th>
                            
                            <th style="width: 100%;">სქესი</th>
                            <th style="width: 100%;">ასაკი</th>
                            <th style="width: 100%;">რა თემატიკის საგაზეთო სტატიები გაინტერესებთ ყველაზე მეტად?</th>
                            <th style="width: 100%;">რომელ რუბრიკას კითხულობთ ყველაზე მეტი ინტერესით?</th>
                            <th style="width: 100%;">რა მოცულობის საგაზეთო სტატიების წაკითხვა გირჩევნიათ?</th>
                            <th style="width: 100%;">აქცევთ თუ არა ყურადღებას რეკლამას გაზეთში?</th>
                            <th style="width: 100%;">მიგიღიათ თუ არა ყიდვის გადაწყვეტილება კვირის პალიტრაში ნანახი რეკლამის საფუძველზე?</th>
                            <th style="width: 100%;">რას ურჩევდით კვირის პალიტრას?</th>
                            <th style="width: 100%;">გთხოვთ დაასახელოთ თქვენი საცხოვრებელი ქალაქი/რეგიონი</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr class="search_header">
                            <th class="colum_hidden">
                            	<input type="text" name="search_id" value="ფილტრი" class="search_init" style=""/>
                            </th>
                            <th>
                            	<input type="text" name="search_number" value="ფილტრი" class="search_init" style="width: 90px;">
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_phone" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                             <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                             <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                             <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                            <th>
                                <input type="text" name="search_date" value="ფილტრი" class="search_init" style="width: 90px;"/>
                            </th>                            
                            <th>
                                <input type="text" name="search_category" value="ფილტრი" class="search_init" style="width: 90px;" />
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="spacer">
            </div>
        </div>
    </div>
</body>
<div id="add-edit-form1" class="form-dialog" title="გამავალი ზარი">
<!-- aJax -->
</div>