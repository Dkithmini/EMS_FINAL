@extends('ManagerHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/viewschedule.css') }}">

<!-- search schedule panel -->
	<div class="panel">
		<div class="panel-body" >
			<div class="col-md-12">
				<h5>Schedule Details</h5>
				<form id="frmshed">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="text" name="id2" id="idshed" hidden="">
					<label>Schedule Id</label>
					<input type="text" name="txtSchedId" id="sheduleid">
					<button type="button" id="btnviewshedule" class="btn-basic">View</button><br>
					<label>Order Id</label>
					<input type="text" name="txtSched_Days" id="o_id" readonly="">
					<label>Start Date</label>
					<input type="Date" name="txtSched_Start" id="shed_start" readonly="">
					<label>End Date</label>
					<input type="Date" name="txtSched_End" id="shed_end" readonly="">
					
					<br><br>
					
				</form>
			</div>
			<div class="col-md-12" style="max-height: 200px;overflow-y: scroll;">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
						<th >Task Id</th>
						<th >Date</th>
						<th >Section</th>
					   	<th >Time Slot</th>
						<th >Item Code</th>
						<th >Qty</th>
						<th >Status</th>
						<th ></th>
						</tr>
					</thead>
					<tbody id="tbody1">
						<tr>  

						</tr>
										    
					</tbody>
				</table>
				<br>
			</div>
		</div>
	</div>
<!-- End of serch panel -->

<!-- shedule summary panel -->
	<div class="panel">
		<div class="panel-body">
			<div>
				<label>Scheduled Tasks</label><input type="text" name="txtTotal_scheduled" id="totalScheduled" readonly="">
				<label>Processing Tasks</label><input type="text" name="txtAllocated" id="totalallocated" readonly="">
				<label>Pending Tasks</label><input type="text" name="txtPending" id="totalpending" readonly="">
				<label>Completed Tasks</label><input type="text" name="txtCompleted" id="totalcompleted" readonly=""><br>
				<button type="button" id="btnRefresh" disabled="" class="btn btn-success">Refresh</button>
				<button type="button" id="btnupdatestatus" class="btn btn-info">Update</button><br>
			</div>
			<br>
			<h5>Schedule Progress</h5>
			<div class="progress" style="height: 30px;" >
				<div class="progress-bar bg-info" role="progressbar" aria-valuemax="100" id="scheduleprogressbar"><span class="caption"></span>
				</div>
			</div>
		</div>
	</div>
<!-- End of schedule summary -->

	<script type="text/javascript">

		$('#btnviewshedule').click(function(){
			
			var searchid=$('#sheduleid').val();
			viewSchedule(searchid);
			viewScheduleTasks(searchid);

			$('#btnRefresh').prop('disabled',false);
			$('#btnRefresh').trigger('click');
		});
		
		//dispaly schedule tasks for schedules when search by sched id
		function viewScheduleTasks(searchid=''){
			$.ajax({
				url:'/searchschedulebyid',
				type:'get',
				data:{'searchid':searchid},
					// datatype:'json',
				success:function(response){
					var showdata='';
					// console.log(data);
					var result=response.data;
					// console.log(result);
					
					for(i=0;i<result.length;i++){
						// var sid=result[i].Schedule_Id;
						var task_Id=result[i].Task_Id;
						var date=result[i].Date;
						var itemcode=result[i].Item_Code;
						var section=result[i].Section;
						var time=result[i].Time_Slot;
						var qty=result[i].Qty;
						var status=result[i].Status;	  

						showdata +="<tr>";
						showdata +="<td>"+task_Id+"</td><td>"+date+"</td><td>"+section+"</td><td>"+time+"<td>"+itemcode+"</td><td>"+qty+"</td><td>"+status+"</td>";
						if(status==="pending"){
							showdata +="<td><i class='fas fa-times'></i></td>";
						}
						else if(status==="Completed"){
							showdata +="<td><i class='fas fa-check'></i></td>";
						}
						else
							showdata +="<td><i class='fas fa-times'></i></td>";
						showdata +="</tr>";
						document.getElementById("tbody1").innerHTML=showdata;
						
					}
				}	  	
			});
		}

		//display schedule details
		function viewSchedule(searchid=''){
			$.ajax({
			 	url:'/searchsched',
			 	method:'get',
			 	data:{'searchid':searchid},
			 	
			 	success:function(response){
			 		// console.log(data);
			 		var result=response.data;

			 		if(!result.length){
				 		// alert('Schedule not Available..!');
				 		window.popWindow.dialog("Schedule Not Available for Selected Id..!","error");
				 		$('#frmshed').trigger("reset");
				 		
			 		}
			 		else
			 		{
			 			$('#tbody').show();
			 			for(i=0;i<result.length;i++){
				 			var oid=result[i].Order_Id;
				 			var sdate=result[i].Start_Date;
				 			var edate=result[i].End_Date;
				 			
				 			$('#o_id').val(oid);
				 			$('#shed_start').val(sdate);
				 			$('#shed_end').val(edate);
				 		}
			 			
			 		}
			 		
			 	}
			 })
		}

		$('#btnRefresh').click(function(){
			var checkBySchedId=$('#sheduleid').val();
			checkSheduleCompletionState(checkBySchedId);
		});

		//check state of schedule completion
		function checkSheduleCompletionState(checkBySchedId=''){
			$.ajax({
				url:'/checkSchedCompletion',
			 	method:'get',
			 	data:{'schedId':checkBySchedId},
			 	
			 	success:function(response){
			 		// console.log(response);
			 		var result=response.data;
			 		var count_completed=0;
			 		var count_total=0;
			 		var count_allocated=0;
			 		var count_pending=0;

			 		for(i=0;i<result.length;i++){
			 			var temp=result[i];
			 			count_total=(i+1);

			 			if(temp==='Completed'){
			 				count_completed=parseInt(count_completed+1);
			 			}
			 			if(temp==='allocated'){
			 				count_allocated=parseInt(count_allocated+1);
			 			}
			 			if(temp==='pending'){
			 				count_pending=parseInt(count_pending+1);
			 			}
			 		}
			 		
			 		$('#totalScheduled').val(count_total);
			 		$('#totalallocated').val(count_allocated);
			 		$('#totalcompleted').val(count_completed);
			 		$('#totalpending').val(count_pending);

			 		var ratio_completed=Math.round((count_completed/count_total)*100);
			 		$('#scheduleprogressbar').width(ratio_completed+'%').attr('aria-valuenow', ratio_completed+'%');
			 		$("#scheduleprogressbar").children('span.caption').html(ratio_completed + '%');
			 	}
			})
		}


		//update schedule status from 'created to completed' on completion of all tasks
		$('#btnupdatestatus').click(function(){
			var schedule_to_Update=$('#sheduleid').val();
			var total_Tasks=$('#totalScheduled').val();
			var completed_Tasks=$('#totalcompleted').val();

			if(total_Tasks===completed_Tasks){
				$.ajax({
				 	url:'/changeScheduleState',
				 	headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				 	method:'post',
				 	data:{'schedule_to_Update':schedule_to_Update},
				 	
				 	success:function(response){
				 		alert(response.message);
				 		
				 	}
			 	});
			}
		});
	</script>
@endsection