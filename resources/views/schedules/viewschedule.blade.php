@extends('ManagerHome')

@section('show_content')
<div class="panel">
		<div class="panel-body">

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
			<div class="col-md-12">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
						<th >task Id</th>
						<th >Date</th>
						<th >Section</th>
					   	<th >Time</th>
						<th >Item</th>
						<th >Qty</th>
						<th >Status</th>
						<th >Select</th>
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


	<script type="text/javascript">
		$('#btnviewshedule').click(function(){
			
			var searchid=$('#sheduleid').val();
			viewSchedule(searchid);
			viewScheduleTasks(searchid);
		});
		

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
					console.log(result);
					
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
							showdata +="<td><button type='button' id='btntableallocate' class='btn btn-success btn-sm'>Allocate</td>";
						}
						else
							showdata +="<td><button type='button' id='btntableallocate' class='btn btn-success btn-sm' disabled=''>Allocate</td>";
						showdata +="</tr>";
						document.getElementById("tbody1").innerHTML=showdata;
						
					}

				}	  	
			});
		}

		function viewSchedule(searchid=''){
			$.ajax({
			 	url:'/searchsched',
			 	method:'get',
			 	data:{'searchid':searchid},
			 	//dataType:'json',
			 	success:function(response){
			 		// console.log(data);
			 		var result=response.data;

			 		if(!result.length){
				 		alert('Schedule not Available..!');
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

	</script>
@endsection