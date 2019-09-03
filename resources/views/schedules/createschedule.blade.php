@extends('ManagerHome')

@section('show_content')

<!-- order select result panel-->
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/addschedule.css') }}">
	<div class="panel">
		<div class="panel-body" style="max-height: 200px">
			<div class="col-md-12">
				<div class="row">
				<div class="col-md-6">
					<h5>Order Details</h5>

					<form id="frmsearch_order">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label>Order ID</label>
							<input type="text" name="searchOrderId" id="searchorder" >
							<button type="button" id="search">Serach</button><br>
							<label >Order Date</label>
							<input type="Date" name="txtOrderDate" readonly="" id="orderdate">
							<label>Due Date</label>
							<input type="Date" name="txtDueDate" readonly="" id="duedate"><br>
							<label>Quantity</label><input type="text" name="txttot" id="showTot" readonly=""><br>
						</div>
					</form>	
				</div>

				<div class="col-md-6" style="overflow-y: scroll;max-height: 200px" id="tbldiv">
					<table class="table table-condensed">
						<thead class>
							<tr>
							<th>Item Code</th>
						   	<th>Quantity</th>
							</tr>
						</thead>
						<tbody id="tbody1">	

						</tbody>
					</table>
				</div>
			</div>

			</div>
		</div>	
	</div>
<!-- end select order details panel-->
	
<!-- schedule details panel -->
	<div class="panel">
		<div class="panel-body" style="max-height: 300px;margin-top: 2px">
			<div class="col-md-12" >
				<div class="row">
					<div class="col-md-3">
						<h5>Schedule Details</h5>
						<form id="frmshed">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" name="id2" id="idshed" hidden="">
							<label>Schedule Id</label>
							<input type="text" name="txtSchedId" id="sheduleid" readonly="">
							<label>Start Date</label>
							<input type="Date" name="txtSched_Start" id="shed_start">
							<label>End Date</label>
							<input type="Date" name="txtSched_End" id="shed_end">
							<br>
							<button type="button" id="btnaddshedule" class="btn btn-success" disabled="">Create</button>
						</form>
					</div>

					<div class="col-md-4">
						<div id='calendar' style="width:80%;height: 80%;padding-top: 0px;" ></div>
					</div>

					<div class="col-md-5">
						<form id="frmLastSched">
							<label>Suggested Hrs: </label><br>
							<div id="sugested_summary">
								<label>Cutting</label>
								<input type="number" name="txtduration_Cutting" id="hrs_suggested_Cutting" readonly=""><label style="padding-left: 1px;width: 30px;">hrs.</label>
								<label>Sewing</label>
								<input type="number" name="txtduration_Sewing" id="hrs_suggested_Sewing" readonly=""><label style="padding-left: 1px;width: 30px;">hrs.</label>
								<label>Finishing</label>
								<input type="number" name="txtduration_Finishing" id="hrs_suggested_Finishing" readonly=""><label style="padding-left: 1px;width: 30px;">hrs.</label>
							</div>
							<label>Last Sheduled Date</label>
							<input type="text" name="txtLastDueShed" readonly="" id="LastDueShed"><br>
							<label>Time Slot</label>
							<input type="text" name="txtslot" id="last_slot" readonly="">
							<br>
						</form>
					</div>		
				</div>
			</div>
		</div>
	</div>
<!-- End of schedule details panel -->

<!--Add task panel-->
	<div class="panel" style="margin-top: 10px;">
		<div class="panel-body">

			<div class="col-md-12">
				<div class="row">
					<div class="col-md-7">
						<h5>Add Task</h5>
						<form id="frmaddtask" style="">
						  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
						  	<div class="form-group">
								<input type="text" name="s_id" id="sid" hidden="">
								<label>Task Id</label><input type="text" name="txtTaskId" id="taskid" readonly="">
								<label>Date</label><input type="Date" name="dateTask" id="datetask"><br>
								<label>Item Code</label>
									<select name="Itemselect" id="itemselect">
												
									</select>
								<label>Section</label>
									<select name="Section" id="section">
										<option >--Select--</option>
										<option value="cuttingSec">Cutting</option>
										<option value="sewingSec">Sewing</option>
										<option value="finishingSec">Finishing</option>
									</select><br>
								<label>Time Slot</label>
									<select name="Timeslot" id="timeslot">
										<option >--Select--</option>
										<option value="morning">8.00-12.00</option>
										<option value="evening">1.00-5.00</option>
										<option value="morning1">8.00-10.00</option>
										<option value="morning2">10.00-12.00</option>
										<option value="evening1">1.00-3.00</option>
										<option value="evening2">3.00-5.00</option>
									</select>
								<label>Quantity</label><input type="text" name="taskQty" id="quantity"><br>
							</div>
											
							<div class="btn-group float-right">
								<button type="button" class="btn btn-danger" id="btnaddtaskcancel">Cancel</button>
					            <button type="button" class="btn btn-info" id="btnaddtask" disabled="">Add Task</button>
					        </div>
						</form>
					</div>
					
					<div class="col-md-5" style="margin-top: 5px;">
						<div id="sec1">
							<label>Item Total</label><input type="text" name="txtItemTotal" id="ItemTotal" readonly=""><br>
							<label>Cutting</label><input type="text" id="Cutting_summery" readonly=""><br>
							<label>Sewing</label><input type="text"  id="Sewing_summery" readonly=""><br>
							<label>Finishing</label><input type="text"  id="Finishing_summery" readonly=""><br>
							<button id="btnrefresh" style="float: right;"><i class="fas fa-sync-alt"></i></button>
						</div>
					</div>
				
				</div>
			</div>
				
			<div class="col-md-12" style="overflow-y: scroll;max-height: 100px">
				<table class="table table-striped table-condensed">
					<thead class>
						<tr>
							<th >Task Id</th>
							<th >Date</th>
						 	<th >Time</th>
							<th >Section</th>
							<!-- <th >Item</th> -->
							<th >Qty</th>
						</tr>
					</thead>
					<tbody id="tbody2">
						<tr>  

						</tr>
										    
					</tbody>
				</table>
			</div>

		</div>
	</div>
<!--End of ad task panel  -->
		
	
	<script type="text/javascript">
		// on loading page show order,task and shed ids
		$(document).ready(function(){
			$('#Cutting_summery').val('');
			$('#Sewing_summery').val('');
			$('#Finishing_summery').val('');

			getLastShedId();
			getLastTaskId();
			updateCalendar();
		});
		
		//on click select btn (search order details by id)		
    	$("#search").click(function() {
    		var searchid=$('#searchorder').val();
   			searchForData(searchid);	
   			DisplayOrderItems(searchid);
    			
   		});
    	
		// function to search order details 
		function searchForData(searchid='') {
			$.ajax({
			 	url:'/search',
			 	method:'get',
			 	data:{'searchid':searchid},
		
			 	success:function(response){
			 		// console.log(response.data);
					var result=response.data;	
					var check=response.value;

					if(check===2){		//available unshecheduled order
						$('#frmshed').show();
						$('#frmLastSched').show();
						$('#frmaddtask').show();
						$('#sec1').show();
						$('#tbldiv').show();
						

						for(i=0;i<result.length;i++){
				 			var id=result[i].Order_Id;
				 			var odate=result[i].Order_Date;
				 			var ddate=result[i].Due_Date;

				 			$('#orderdate').val(odate);
				 			$('#duedate').val(ddate);
				 		}	
					}

					if(check===3){		//order not available
						// alert(response.message);
						var message_alert=response.message;
						window.popWindow.dialog(message_alert,"error");

						$('#frmsearch_order').trigger("reset");
						$('#frmshed').hide();
			 			$('#frmLastSched').hide();
			 			$('#frmaddtask').hide();
			 			$('#sec1').hide();
			 			$('#tbldiv').hide();

					}

			 		if(check===1)		//already scheduled order
			 		{
			 			// alert(response.message);
			 			var message_alert=response.message;
						window.popWindow.dialog(message_alert,"error");

			 			$('#frmsearch_order').trigger("reset");
			 			$('#frmshed').hide();
			 			$('#frmLastSched').hide();
			 			$('#frmaddtask').hide();
			 			$('#sec1').hide();
			 			$('#tbldiv').hide();
			 		}

			 		if(check===4)		//response error
			 		{
			 			// alert(response.message);
			 			var message_alert=response.message;
						window.popWindow.dialog(message_alert,"error");

			 			$('#frmsearch_order').trigger("reset");
			 		}	
			 	}
			});
		}

		
		//display order items in add task dropdown and display ordered items in html table
		function DisplayOrderItems(searchid='') {
			$.ajax({
			 	url:'/displaydetails',
			 	method:'get',
			 	data:{'search_id':searchid},

			 	success:function(itemdata){
			 		var tot_Items_Ordered=0;
			 		var showdata='';

					$('#itemselect').html($('<option>', {
    						text: '--select--'
						}));
					// console.log(itemdata);

			 		var order_details=itemdata.data;
			 		var tot_item_qty=0; 

			 		for(i=0;i<order_details.length;i++){	//display order item & qty in html table
						var item_code=order_details[i].Item_Code;
						tot_item_qty=order_details[i].Total_Qty;  

						tot_Items_Ordered= parseInt(tot_Items_Ordered+tot_item_qty);
						// console.log(tot_Items_Ordered);

						showdata +="<tr>";
						showdata +="<td>"+item_code+"</td><td>"+tot_item_qty+"</td>";
						showdata +="</tr>";
						document.getElementById("tbody1").innerHTML=showdata;

						// select ordered item codes for select tag drop down in "add task"
						$('#itemselect').append($('<option>', {
    						value: item_code,
    						text: item_code
						}));
						
					}

					$('#showTot').val(tot_Items_Ordered);	//display total qty of order

					//calculate the production hours for sections
					// Ratio of emps: C:S:F = 4:18:8
					// Ratio of items/hr: C:S:F = 50:3:5

					var avg_cutting= (50*4);
					var avg_sewing= (3*18);
					var avg_finishing= (5*8);

					var C_hrs=(tot_Items_Ordered/avg_cutting);
					var S_hrs=(tot_Items_Ordered/avg_sewing);
					var F_hrs=(tot_Items_Ordered/avg_finishing);

					var t1=(C_hrs%2);
					var t2=(S_hrs%2);
					var t3=(F_hrs%2);
					var x1;
					var x1;
					var x1;

					//roundoff cutting hrs
					if(t1>0.75){
					 	x1=C_hrs+(2-(C_hrs%2));
					}else{
				 		x1=C_hrs-(C_hrs%2);
				 	}

					//roundoff sewing hrs
					if(t2>0.75){
				 		x2=S_hrs+(2-(S_hrs%2));
				 	}else{
				 		x2=S_hrs-(S_hrs%2);
				 	}
					 	
					//roundoff finishing hrs
					if(t3>0.75){
				 		x3=F_hrs+(2-(F_hrs%2));
				 	}else{
				 		x3=F_hrs-(F_hrs%2);
				 	}
					 	
					$('#hrs_suggested_Cutting').val(x1);
					$('#hrs_suggested_Sewing').val(x2);
					$('#hrs_suggested_Finishing').val(x3);
				}
			});
		}		


		//get shed id automatically
		function getLastShedId(){
        	$.ajax({
        		url:'/getLastsheduleId',
			 	method:'get',
			 	success:function(lastshed){
			 		var result=lastshed.data;
			 		var nextId;
			 		var shed_start_date;

					if(!result){
			 			nextId=1;
			 		}
			 		else{
			 			nextId=result.Schedule_Id;
			 			nextId=nextId+1;
			 		}
			 		// console.log(nextId);
			 		$('#sheduleid').val(nextId);
			 	}
        	});
        }

	    //check the validity of sched start & end dates
		$('#shed_start').change(function(){
		 	var date_order=$('#orderdate').val();
		 	var date_due=$('#duedate').val();
		 	var date_start=$('#shed_start').val();
		 	
		 	if(date_start<date_order || date_start>date_due){	
		 		alert('Invalid Start date..!');
		 		$('#shed_start').val('');
		 	}
		 	else{
		 		console.log('valid date');
		 	}
		 	
		 });

		 //check the validity of sched start & end dates
		$('#shed_end').change(function(){
		 	var date_due=$('#duedate').val();
		 	var date_end=$('#shed_end').val();
			var date_start=$('#shed_start').val();

		 	if(date_end>date_due || date_end<date_start){
		 		alert('Invalid End date..!');
		 		$('#shed_end').val('');
		 	}
		 	else{
		 		$('#btnaddshedule').prop('disabled',false);
		 	}
		});

		 
		//add schedule to database
		$('#btnaddshedule').click(function(){

			var temp=$('#searchorder').val();
			$('#idshed').val(temp);
			
			$.ajax({
				method:'post',
				url:'/addschedule',				 	
				data: $('#frmshed').serialize(),
				 
				success:function(data){
				 	// alert('schedule added..');
				 	window.popWindow.dialog("Schedule Added Successfully..!","success");

				 	$('#btnaddshedule').prop('disabled',true);
				 	$('#btnaddtask').prop('disabled',false);
				 	$('#shed_start').prop('readonly',true);
				 	$('#shed_end').prop('readonly',true);
				}
			});
		});

		//get task id automatically
		function getLastTaskId(){
        	$.ajax({
        		url:'/getLasttaskId',
			 	method:'get',
			 	success:function(lastId){

			 		var result=lastId.data;
			 		var nextId;
			 		if(!result){
			 			nextId=1;
			 		}
			 		else{
			 			var sec=result.Time_Slot;
			 			var last_date=result.Date;
			 			nextId=result.Task_Id;
			 			nextId=nextId+1;
			 		}

			 		$('#taskid').val(nextId);
			 		$('#last_slot').val(sec);
			 		$('#LastDueShed').val(last_date);	//display last shed date
			 		$('#shed_start').val(last_date);
			 	}
        	});
        }
		
		//check selected task date with schedule dates
		$('#datetask').change(function(){
		 	var date_end=$('#shed_end').val();
		 	var date_start=$('#shed_start').val();
		 	var date_task=$('#datetask').val();

		 	if(date_task<date_start || date_task>date_end){			 		
		 		alert('Invalid Task date..!');
		 		$('#btnaddtask').prop('disabled',true);
			}	
			else{
				$('#btnaddtask').prop('disabled',false);
			}
		});

		$('#itemselect').change(function(){
		 	getItemTotal()
		});

		//suggest task qty when section,slot selected
		$("#section").change(function(){
		 	$('#timeslot').change(function(){
		 		setTaskQty();
		 	});
		});

		//setting target qtys for different sections
		function setTaskQty(){
		 	var slot_selected=$('#timeslot').val();
		 	var sec_selected=$('#section').val();
		 	var qty_task=0;
		 	var qty_tot=$('#showTot').val();

		 	if(slot_selected==='morning' || slot_selected==='evening'){	//if 4h slots selected
		 		if(sec_selected==='cuttingSec'){
		 			var cutting_hrs=$('#hrs_suggested_Cutting').val();
		 			qty_task=Math.round((qty_tot/cutting_hrs)*4);
		 			$('#quantity').val(qty_task);
		 		}
		 		if(sec_selected==='sewingSec'){
		 			var sewing_hrs=$('#hrs_suggested_Sewing').val();
		 			qty_task=Math.round((qty_tot/sewing_hrs)*4);
		 			$('#quantity').val(qty_task);
		 		}
		 		if(sec_selected==='finishingSec'){
		 			var finishing_hrs=$('#hrs_suggested_Finishing').val();
		 			qty_task=Math.round((qty_tot/finishing_hrs)*4);
		 			$('#quantity').val(qty_task);
		 		}
		 	}

		 	else{
		 		if(sec_selected==='cuttingSec'){	//if 2h slots selected
		 			var cutting_hrs=$('#hrs_suggested_Cutting').val();
		 			qty_task=Math.round((qty_tot/cutting_hrs)*2);
		 			$('#quantity').val(qty_task);
		 		}
		 		if(sec_selected==='sewingSec'){
		 			var sewing_hrs=$('#hrs_suggested_Sewing').val();
		 			qty_task=Math.round((qty_tot/sewing_hrs)*2);
		 			$('#quantity').val(qty_task);
		 		}
		 		if(sec_selected==='finishingSec'){
		 			var finishing_hrs=$('#hrs_suggested_Finishing').val(); 
		 			qty_task=Math.round((qty_tot/finishing_hrs)*2);
		 			$('#quantity').val(qty_task);
		 		}
		 	}
		}

		//add tasks to database
		$('#btnaddtask').click(function(){
			var temp2=$('#sheduleid').val();

			$('#sid').val(temp2);
		 		$.ajax({
				url:'/addtask',
				headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				method:'post',
				data: $('#frmaddtask').serialize(),

				success:function(response){
				 	// alert('task added successfully...');
				 	window.popWindow.dialog("Task Added Successfully","success");
				 	var result=response.data;
				 	// console.log(result);
				 	$("#taskid").val(result);

				 	//display tasks in html table
				 	var id=$("#taskid").val();
					var date=$("#datetask").val();
					var section=$("#section").val();
					var timeslot=$("#timeslot").val();
					var itemcode=$("#itemselect").val();
					var qty=$("#quantity").val();

					var markup = "<tr><td>"+ id +"</td><td>" + date + "</td><td>" + section +"</td><td>"+ timeslot + "</td><td>"+ qty +"</td></tr>";
		           		$('#tbody2').append(markup);

				}
			});
		});

		$('#btnaddtaskcancel').click(function(){
			$('#frmaddtask').find('input, select').not("#taskid").val('');
		});

		//show remaining qtys of each section to be scheduled
		$('#btnrefresh').click(function(){
			var searchShed=$('#sheduleid').val();
			checkSummery(searchShed);
		});

		//check summery of task qty for sections
		function checkSummery(searchShed=''){
			var selected_itemCode=$('#itemselect').val();
							
				$.ajax({
					url:'/checkScheduledQty',
					method:'get',
					data:{'searchShed':searchShed,'selected_itemCode':selected_itemCode},

					success:function(response){
						var total_quantity=$('#ItemTotal').val();
						var result=response.data;
						// console.log(result);

						var C_total=0;
					 	var S_total=0;
					 	var F_total=0;

						for(i=0;i<result.length;i++){
						 	var val_1=result[i].Section;
						 	var val_2=parseInt(result[i].Qty);

						 	if(val_1==='cuttingSec'){	//calc remainder qty for cutting section
						 		C_total=C_total+val_2;
						 	}
						 	if(val_1==='sewingSec'){	//calc remainder qty for sewing section
								S_total=S_total+val_2;
					 		}
					 		if(val_1==='finishingSec'){	//calc remainder qty for finishing section
					 			F_total=F_total+val_2;
					 		}
					 	}

						$('#Cutting_summery').val(total_quantity-C_total);
						$('#Sewing_summery').val(total_quantity-S_total);
					 	$('#Finishing_summery').val(total_quantity-F_total);
					}
				});
			}

			//get total item qty of order
			function getItemTotal(){
				var ItemId=$('#itemselect').val();
				var ScheduleId=$('#idshed').val();

		 		$.ajax({
				url:'/getSelected_Item_Total',
				method:'get',
				data: {'ItemId':ItemId,'ScheduleId':ScheduleId},

				success:function(response){
				 	var qty_item=response.data;

				 	for(i=0;i<qty_item.length;i++){
				 		qty_selected_item=qty_item[0].Total_Qty;
				 	}

				 	$('#ItemTotal').val(qty_selected_item);

					}
				});
			}
		

		function updateCalendar(){
			$.ajax({
				url:'/getCalendarData',
				method:'get',
				data: {},

				success:function(response){
				 	var tasks=response.data;
					var start_date;
					var title;
					var end_date;
					var events=new Array();
					
					for(i=0;i<tasks.length;i++){
						start_date=tasks[i].Date;
						title=tasks[i].Section;
						end_date=tasks[i].End_Date;
						// console.log(title);

						// event = new Object();       
					 //    event.title = title; // this should be string
					 //    event.start = start_date; // this should be date object
					 //    event.end = end_date; // this should be date object
					 //    event.color = "blue";
					 //    // event.allDay = false;
					 //    // this.label1.setCaption(start_date);
					 //    //EventArray.push(EventEntry);
					 //    // console.log(events['title']);
					 //    events.push(event);
						
						$('#calendar').fullCalendar({
            			// put your options and callbacks here
          	
				            events : [
				                {
				                    title: title,
				        			start: start_date,
				        			end: end_date,
				      				color: 'tomato'
				                },
				            ]
			        	});
					}

					// $('#calendar').fullCalendar('addEventSource',events);
				}
			
			});	
		}
	</script>

@endsection