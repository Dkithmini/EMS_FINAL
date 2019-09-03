@extends('ManagerHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/dashboard.css') }}">

<div class="card-deck">

	<div class="card">
	  	<div class="row">
	  		<div class="col-sm-4">
	  			<i class="fas fa-shopping-cart fa-3x" style="color:#3B9F57;"></i>
	  		</div>
	  		<div class="col-sm-8">
	  			 <div class="card-body-right" style="color:#3B9F57">
			      	<p class="card-title">COMPLETED ORDERS</p>
			      	<p id="valAllOrders"></p>
			    </div>
	  		</div>
	  	</div>
	</div>

	<div class="card">
	  	<div class="row">
	  		<div class="col-sm-4">
	  			<i class="fas fa-calendar-alt fa-3x" style="color:#75538A;"></i>
	  		</div>
	  		<div class="col-sm-8">
	  			<div class="card-body-right" style="color:#75538A;">
			      	<p class="card-title">SCHEDULED </p>
			      	<p id="valSchedules"></p>
			    </div>
	  		</div>
	  	</div>
	</div>

	<div class="card">
	  	<div class="row">
	  		<div class="col-sm-4">
	  			<i class="fas fa-clock fa-3x" style="color:#928752;"></i>
	  		</div>
	  		<div class="col-sm-8">
	  			<div class="card-body-right" style="color:#928752;">
			      	<p class="card-title">PENDING TASKS</p>
			      	<p id="valPendingTasks"></p>
			    </div>
	  		</div>
	  	</div>
	</div>

	<div class="card" >
	  	<div class="row">
	  		<div class="col-sm-4">
	  			 <i class="fas fa-tasks fa-3x" style="color:#415C84;"></i>
	  		</div>
	  		<div class="col-sm-8">
	  			<div class="card-body-right" style="color:#415C84;">
	      			<p class="card-title">FINISHED TASKS</p>
	      			<p id="valCompletedTasks"></p>
	    		</div>
	  		</div>
	  	</div>
	  </div>
</div>
<br><br>

<!-- Tasks summery panel -->
<div class="panel" >
	<h5> Order Task Summery</h5>
	<div class="panel-body" style="max-height: 150px;overflow-y: scroll">
		<div class="row-md-12">
			<table class="table table-condensed">
			    <thead>
			      	<tr>
					    <th scope="col">Task Id</th>
					    <th scope="col">Date</th>
					    <th scope="col">Time Slot</th>
					    <th scope="col">Section</th>
					    <th scope="col">Item Code</th>
					    <th scope="col">Qty</th>
					    <th scope="col">Status</th>
				    </tr>
				</thead>
				<tbody id="tbody2">
				      
				</tbody>
			</table>
		</div>		
	</div>
</div>
<br><br>
<!-- end of task summary panel -->

<!-- attendance summary section -->
<div class="card-deck">
	<div class="card" id="attsummery">
		<div class="row">
			<div class="col-sm-8">
				<p class="card-title" style="margin-top: 20px">ATTENDANCE SUMMARY</p>
			</div>
			<div class="col-sm-4">
				<i class="fas fa-users fa-3x" style="margin-top: 2px;color:#972222"></i>
			</div>
		</div>
		<div class="card-body">

		<form id="frmAttSummery">
            <div class="form-group" id="fgWorkSummery">
	            <label>Date</label>
	            <input type="text" name="txtToday" id="todayDateAttendance" readonly="">
  				<!-- <button type="submit">Search</button><br><br> -->
        		<label>Total Employees</label>
        		<input type="text" name="txtTotEmp" readonly="" id="TotEmpCount"><br>
        		<label>Total Attended</label>
        		<input type="text" name="txtTotEmpAtt" readonly="" id="totPresentEmpCount"><br>
        		<label>Total Absent</label>
        		<input type="text" name="txtTotEmpAb" readonly="" id="totAbsentEmpCount"><br>
        		<label>Approved leaves</label>
        		<input type="text" name="txtTotLeaves" readonly=""><br>
	        </div>
	    </form>
	</div>
<!--end of attendance summary  -->

<!--Work summary section -->			
	</div>
	<div class="card" id="worksummery">
		<div class="row">
			<div class="col-sm-8">
				<p class="card-title" style="margin-top: 20px">WORK SUMMARY</p>
			</div>
			<div class="col-sm-4">
				<i class="fas fa-briefcase fa-3x" style="margin-top: 2px;color:#972222"></i>
			</div>
		</div>

		<div class="card-body">
			<form id="frmWorkSummery">
	            <div class="form-group" id="fgWorkSummery" >
	                <label>Date</label>
	                <input type="text" name="txtToday" id="todayDateWork" >
  					<label>Total Tasks</label>
  					<input type="text" name="txtTotTasks" readonly="" id="totTaskCount"><br>
        			<label>Allocated Tasks</label>
        			<input type="text" name="txtTotAllocatedTasks" readonly="" id="totAllocatedTaskCount"><br>
        			<label>Completed Tasks</label>
        			<input type="text" name="txtTotTasksCompleted" readonly="" id="totCompletedTaskCount"><br>
        			<label>Due Orders</label>
        			<input type="text" name="txtDueOrders" readonly="" id="totDueOrders"><br>
	              </div>
	        </form>
		</div>
	</div>
</div>
<!--end of attendance summary  -->

<script type="text/javascript">
		$(document).ready(function(){
			getDashboardWidgets();
			getTodayDate(); 
			displayAttendanceSummary();
			displayWorkSummary();
		});

		//display dashboard widget details
		function getDashboardWidgets(){
			$.ajax({
			 	url:'/dashboardcontent',
			 	method:'get',
			 
			 	success:function(response){
			 		var result=response.data;
			 		$('#valSchedules').text(result[0]);
			 		$('#valPendingTasks').text(result[1]);
			 		$('#valCompletedTasks').text(result[2]);	
			 	}
			 });	
		}

		//get system date 
		function getTodayDate(){
			var today = new Date();
			var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
			$('#todayDateAttendance').val(date);
			$('#todayDateWork').val(date);
		}

		//display attendance summary
		function displayAttendanceSummary(){
			$.ajax({
			 	url:'/attendanceSummery',
			 	method:'get',
			 
			 	success:function(response){
			 		var result=response.data;
			 		$('#TotEmpCount').val(result[0]);
			 		$('#totPresentEmpCount').val(result[1]);
			 		$('#totAbsentEmpCount').val(result[2]);
			 		
			 	}
			 });	
		}

		//display wirk summary
		function displayWorkSummary(){
			$.ajax({
			 	url:'/workSummery',
			 	method:'get',
			 
			 	success:function(response){
			 		var result=response.data;
			 		$('#totTaskCount').val(result[0]);
			 		$('#totAllocatedTaskCount').val(result[1]);
			 		$('#totCompletedTaskCount').val(result[2]);
			 		$('#totDueOrders').val(result[3]);	
			 	}
			 });	
		}

		
	</script>
				
@endsection	