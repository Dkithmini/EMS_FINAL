@extends('SupervisorHome')

@section('show_content')
<div class="panel">
		<div class="panel-body">
			<div class="col-md-12">
				<h5>Task Details</h5>
				<div class="row">
					<form>
						<label>Task Id</label><input type="text" name="txtTaskid" id="taskid">
						<button  id="searchtask" type="button">Search</button>
						
						<!-- <label>Qty</label><input type="number" name="txtQuantity" id="Tqty"> -->
					</form>
				</div>	
			</div>
		</div>
	</div>

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
							<label>Employee Id</label><input type="text" name="txteid" id="eid"><br>
							<label>Employee Name</label><input type="text" name="txtename" id="e_name"><br>
							<label>Target Qty</label><input type="text" name="txttarget_qty" id="tqty"><br>
							<label>Completed Qty</label><input type="text" name="txtcompleted_qty" id="cqty"><br><br>
							<button type="button" id="btnsave" disabled="" class="btn btn-info">Save</button>
							<button class="btn btn-danger" id="btncancel">Cancel</button>
						</form>
					</div>
				</div>	
			</div>
		</div>
	</div>

	<script type="text/javascript">

		$('#searchtask').click(function(){
			var searchid=$('#taskid').val();
			$('#taskid2').val(searchid);
			get_TaskEmployees(searchid);
		});

		//get emp list with targets
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
					
					if(!result.length){
						alert('Task Pending....!');
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
						if(targetqty===completed){
							showdata +="<td><button type='button' id='btntableupdate' class='btn btn-info btn-sm' disabled=''>Completed</td>";
						}
						if(targetqty!==completed){
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
			$('#btnsave').prop('disabled',true);
			
		});

		$('#cqty').change(function(){
			var qty_completed=$('#cqty').val();
			var qty_target=$('#tqty').val();

			if(qty_completed!=''){
				if(qty_completed===qty_target || qty_completed<qty_target ){
					$('#btnsave').prop('disabled',false);
				}
				
				else{
					alert('Invalid Qty for Completed Qty..!');
					$('#cqty').val('');
					$('#btnsave').prop('disabled',true);
				}
			}
			else{
				alert('Enter Completed Qty..!');
			}
		});

		function updateTask(){
			$.ajax({
			 	url:'/updatetask',
			 	method:'post',
			 	data:$('#frmupdatetask').serialize(),
			 	
			 	success:function(updated_task){
			 		alert('updated successfully...');
			 		$('#frmupdatetask').trigger("reset");
			 	}
			 });
		}


	</script>
@endsection