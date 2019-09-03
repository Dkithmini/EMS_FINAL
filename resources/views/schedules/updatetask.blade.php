@extends('SupervisorHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/updatetask.css') }}">
	
<!-- Seaechb task by id panel -->
	<div class="panel">
		<div class="panel-body">
			<div class="col-md-12">
				<h5>Task Details</h5>
				<div class="row">
					<form>
						<label>Task Id</label><input type="text" name="txtTaskid" id="taskid">
						<button  id="searchtask" type="button">Search</button>
					</form>
				</div>	
			</div>
		</div>
	</div>
<!-- End of search task panel -->

<!-- display task details panel -->
	<div class="panel">
		<div class="panel-body">
			<div class="col-md-12">
				<div class="row">
					
					<div class="col-md-7">
						<table class="table table-hover table-striped table-condensed">
							<thead>
								<tr>
									<td>Emp Id</td>
									<td>Emp Name</td>
									<td>Target Qty</td>
									<td>Completed Qty</td>
									<td>Action</td>
								</tr>
							</thead>
							<tbody id="tbody1" class="tbody">
										
							</tbody>
						</table>
					</div>

					<div class="col-md-5">
						<form id="frmupdatetask">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="text" name="txtTaskid2" id="taskid2" hidden="">
							<label>Employee Id</label><input type="text" name="txteid" id="eid" readonly=""><br>
							<label>Employee Name</label><input type="text" name="txtename" id="e_name" readonly=""><br>
							<label>Target Qty</label><input type="text" name="txttarget_qty" id="tqty" readonly=""><br>
							<label>Completed Qty</label><input type="text" name="txtcompleted_qty" id="cqty" required=""><br><br>
							<button type="reset" class="btn btn-danger" id="btncancel">Cancel</button>
							<button type="button" id="btnsave" disabled="" class="btn btn-info">Save</button>
							
						</form>
					</div>
				</div>	
			</div>
		</div>
	</div>
	<br>
<!-- end of display task panel -->

<!-- Update task panel -->
	<div class="col-md-12" id="summeryForm">
		<label>Task Qty</label><input type="text" name="txtTot_TaskQty" id="tot_TaskQty" readonly="">
		<label>Completed</label><input type="text" name="txtTotCompleted" id="tot_Completed" readonly="">
		<label>Remainder</label><input type="text" name="txtRemainder" id="remainder" readonly="">
		<label>Extra</label><input type="text" name="txtExtra" id="extra" readonly="">
		<button type="button" id="btnrefresh" disabled=""><i class="fas fa-sync-alt"></i></button>
		<button type="button" id="btnupdatestatus" >Update</button>
		<br><br>

		<h5>Task Completion Progress</h5>
		<div class="progress" style="height: 30px;">
			<div class="progress-bar bg-info " role="progressbar" aria-valuemax="100" id="taskprogressbar"><span class="caption"></span></div>
		</div>
	</div>
<!-- End of update task panel -->
	

	<script type="text/javascript">

		//search task by task id
		$('#searchtask').click(function(){
			var searchid=$('#taskid').val();
			$('#taskid2').val(searchid);
			get_TaskEmployees(searchid);

			$('#btnrefresh').prop('disabled',false);
			$('#btnrefresh').trigger('click');
		});

		//display allocated emps and targets
		function get_TaskEmployees(searchid=''){
			$.ajax({
				url:'/showtaskemp',
				type:'get',
				data:{'searchid':searchid},
				
				success:function(data){
					var showdata='';
					// console.log(data);
					var result=JSON.parse(data);
					// console.log(result);
					
					if(!result.length){				//if task not available/allocated
						// alert('Task Pending....!');
						window.popWindow.dialog("No Allocated Task Available For Given Id..!","error");
						$('#taskid').val('');
					}
					else{
						for(i=0;i<result.length;i++){
						// var sid=result[i].Schedule_Id;
						var emp_Id=result[i].Emp_Id;
						var empname=result[i].Emp_Name;
						var targetqty=result[i].Target_Qty;	 
						var completed=result[i].Completed_Qty; 

						showdata +="<tr>";
						showdata +="<td>"+emp_Id+"</td><td>"+empname+"</td><td>"+targetqty+"</td><td>"+completed+"</td>";
						if(targetqty===completed || targetqty<completed){
							showdata +="<td><i class='fas fa-check'></i></td>";
						}
						else{
							showdata +="<td><button type='button' id='btntableupdate' class='btn btn-success btn-sm' >update</td>";
						}
						showdata +="</tr>";
						document.getElementById("tbody1").innerHTML=showdata;
					}
					}
					
				}	  	
			});
		}

		//update completed qty by each emp
		$(document).on("click", ".btn-success", function(){
    		var $row = $(this).closest("tr");      // Finds the closest row <tr> 
    		$tds = $row.find("td");           // Finds all children <td> elements

    		var empid=($($tds[0]).text()); 
    		var ename=($($tds[1]).text());
    		var target=($($tds[2]).text());
    		var finished=($($tds[3]).text());
    		
    		$('#eid').val(empid);
    		$('#e_name').val(ename);
    		$('#tqty').val(target);
    		$('#cqty').val(finished);

		});

		
		$('#btnsave').click(function(){
			updateTask();
			$('#btnrefresh').trigger('click');

		});

		//validate update task form
		$('#cqty').change(function(){
			var qty_completed=parseInt($('#cqty').val());
			var qty_target=parseInt($('#tqty').val());

			if(qty_completed!=''){
				if(qty_completed<qty_target ){
					// alert('Invalid Qty for Completed Qty..!');
					window.popWindow.dialog("Invalid Quantity..!(Please Enter Value either Equal or Grater than Target Quanity)","error");

					$('#cqty').val('');
					$('#btnsave').prop('disabled',true);
					
				}
				
				else{
					$('#btnsave').prop('disabled',false);
				}
			}
			else{
				// alert('Enter Completed Qty..!');
				window.popWindow.dialog("Please Enter Value of Completed Quantity..!","error");
			}
		});

		//update task completion
		function updateTask(){
			$.ajax({
			 	url:'/updatetask',
			 	method:'post',
			 	data:$('#frmupdatetask').serialize(),
			 	
			 	success:function(updated_task){
			 		// alert('updated successfully...');
			 		window.popWindow.dialog("Task Competion Saved Successfully..!","success");

			 		$('#frmupdatetask').trigger("reset");
			 		$('#btnsave').prop('disabled',true);
			 	}
			 });
		}


		$('#btnrefresh').click(function(){
			var id=$('#taskid').val();
			checkCompletion_Task(id);
		});

		//check completed task qty summery
		function checkCompletion_Task($taskId=''){
			var checkByTaskId=$('#taskid').val();
			$.ajax({
			 	url:'/checkTaskCompletion',
			 	method:'get',
			 	data: {'taskId':checkByTaskId},
			 	
			 	success:function(response){
			 		// console.log(response);

			 		var result=response.data;
			 		var total=result[0].Qty;
			 		var completed=0;

			 		for(i=0;i<result.length;i++){
			 			var qty_Completed=result[i].Completed_Qty;
			 			completed=parseInt(completed+qty_Completed);
			 		}

			 		$('#tot_TaskQty').val(total);
			 		$('#tot_Completed').val(completed);

			 		var ratio_completed=Math.round((completed/total)*100);
			 		$('#taskprogressbar').width(ratio_completed+'%').attr('aria-valuenow', ratio_completed+'%');
			 		$("#taskprogressbar").children('span.caption').html(ratio_completed + '%');
			 		
			 		var remainderQty=parseInt(total-completed);

			 		if(remainderQty<0){		//if excess qty produced
			 			var extraQty=(remainderQty*(-1));
			 			$('#remainder').val(0);
			 			$('#extra').val(extraQty);
			 		}
			 		else{
			 			$('#remainder').val(remainderQty);
			 			$('#extra').val(0);
			 		}
			 		
			 	}
			 });
		}

		//update task status from allocated to completed on task completion
		$('#btnupdatestatus').click(function(){
			var remainder_Taskqty=parseInt($('#remainder').val());
			var task_to_Update=$('#taskid').val();

			if(remainder_Taskqty===0){
				$.ajax({
				 	url:'/changeState_completed',
				 	headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				 	method:'post',
				 	data:{'task_to_Update':task_to_Update},
				 	
				 	success:function(response){
				 		// alert(response.message);
				 		var alert_message=response.message;
				 		window.popWindow.dialog(alert_message,"info");
				 	}
			 	});
			}
		});
 


	</script>
@endsection