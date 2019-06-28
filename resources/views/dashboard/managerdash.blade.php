@extends('ManagerHome')

@section('show_content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/dashboard.css') }}">
	<div class="panel" >
		<form >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<h5> Sheduled Order Summery</h5>
			<label id="idfrom"> From</label><input type="date" name="txtFrom" >
			<label id="idto">To</label><input type="date" name="txtTo" >

			<div class="panel-body" style="max-height: 150px;overflow-y: scroll">
				<div class="row-md-12" >
					<table class="table table-condensed">
					    <thead >
					      <tr>
					        <th >Schedule Id</th>
					        <th>Order Id</th>
					        <th >Start date</th>
					        <th >End date</th>
					        <!-- <th >Task Id</th> -->
					        <!-- <th >Date</th> -->
					        <!-- <th >Time Slot</th>
					        <th >Section</th>
					        <th >Item Code</th>
					        <th >Qty</th> -->
					      </tr>
					    </thead>
					    <tbody id="tbody1">
					    	
					    </tbody>
					   
					  </table>
				</div>		
			</div>
		</form>
	</div>
		
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

	<div role="tabpanel" class="tab-pane active container-fluid" >
            <div class="row">
                <div class="col-md-6">
                	<div class="panel panel-default">
	                	<div class="panel-body">
	                   		<h5> Attendance Summery</h5>	                   		

	                   		<form id="frmAttendanceSummery">
	                   			<div class="form-group" id="fgAttendanceSummery">
	                   				<input type="text" placeholder="Search" name="search" id="search1">
  									<button type="submit">Search</button><br><br>
        							<label>Total Employees</label>
        							<input type="text" name="txtTotEmp"><br>
        							<label>Total Attended</label>
        							<input type="text" name="txtTotEmpAtt"><br>
        							<label>Total Employees Absent</label>
        							<input type="text" name="txtTotEmpAb"><br>
        							<label>Total Approved leaves</label>
        							<input type="text" name="txtTotLeaves"><br>
	                   			</div>
	                   		</form>

	                	</div>
            		</div>
            	</div>
                
            	<div class="col-md-6">
            		<div class="panel panel-default ">
                		<div class="panel-body">
                    		<h5>Daily Work Summery</h5>

                    		<form id="frmWorkSummery">
	                   			<div class="form-group" id="fgWorkSummery">
	                   				<input type="text" placeholder="Search" name="search" id="search1">
  									<button type="submit">Search</button><br><br>
        							<label>Total Tasks Allocated</label>
        							<input type="text" name="txtTotTasks"><br>
        							<label>Total Tasks Completed</label>
        							<input type="text" name="txtTotTasksCompleted"><br>
        							<label>Due Orders</label>
        							<input type="text" name="txtDueOrders"><br>
        							<label>Completed Orders</label>
        							<input type="text" name="txtCompletedOrders"><br>
	                   			</div>
	                   		</form>
                		</div>
     				</div>
   				</div>
   			</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			 showAllSchedules();
			 showAllTasks();
		});

		function showAllSchedules(){
			$.ajax({
			 	url:'/managerdash_allshedules',
			 	method:'get',
			 	// dataType:'json',
			 	success:function(display){
			 		// console.log(data);
			 		$('#tbody1').html(display);

			 	}
			 });
		}

		function showAllTasks(){
			$.ajax({
			 	url:'/managerdash_allTasks',
			 	method:'get',
			 	// dataType:'json',
			 	success:function(response){
			 		console.log(response.data);
			 		var showdata='';
			 		var result=response.data;

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
						
						
						document.getElementById("tbody2").innerHTML=showdata;
						
					}
			 	}
			 });
		}
	</script>

@endsection