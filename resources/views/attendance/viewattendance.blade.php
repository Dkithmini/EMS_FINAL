@extends('AdminHome')

@section('show_content')

<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/attendance.css') }}"> -->
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<div class="panel" >
		<div class="panel-body ">

			<div class="col-md-12">
				<h5>View Attendance</h5>
				<form >
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<!-- <label>Year</label>
					<select>
						<option>2019</option>
						<option>2018</option>
						<option>2017</option>
					</select>
					
					<label>Month</label>
					<select>
						<option>Jan</option>
						<option>Feb</option>
						<option>Mar</option>
					</select> -->
					<label>Date</label><input type="date" name="txtbydate" id="searchbydate">
					<button type="button" id="btnshow">Show</button>
				</form>

			</div>
			<div class="col-md-12">
				<form>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table table-striped table-condensed">
						<thead class>
							<tr>
							<th >Emp Id</th>
							<th >Name</th>
							<th>Attendance</th>
							</tr>
						</thead>
						<tbody id="tbody">
							
											    
						</tbody>
					</table>

					<label>Present Count</label><input type="text" name="txtpresent" id="presentcount">
					<label>Absent Count</label><input type="text" name="txtabsent" id="absentcount">
				</form>
			</div>
			
		</div>
	</div>

	<script type="text/javascript">

		//display attendance details
		$(document).ready(function(){
			$('#btnshow').click(function(){
				var searchdate=$('#searchbydate').val();

				$.ajax({
                type: 'get',
                url: '/viewAttendance',
                data:{'date':searchdate},

	                success: function(att_data) {
	                	// console.log(att_data);
	                	var data=JSON.parse(att_data);
	                	if(!data.length){
	                		// alert('No Record Found for selected date!');	
	                		window.popWindow.dialog("No Attendance Records Found for Selected Date...!","error");

	                		var showdata='';
	                		document.getElementById("tbody").innerHTML=showdata;
	                	}

	                	else{
	                		var showdata='';	
	                		var present_count=0;
	                		var absent_count=0;

							for (var a=0;a<data.length;a++) {
							  	var Id=data[a].Emp_Id;	
							  	var Name=data[a].Emp_Name;
							  	var State=data[a].Status;
							  	
						  		showdata +="<tr>";
						  		showdata +="<td>"+Id+"</td><td>"+Name+"</td><td>"+State+"</td>";
						  		showdata +="</tr>";
						  		document.getElementById("tbody").innerHTML=showdata;

						  		//display present,absent count
						  		if(State==="present"){
						  			present_count+=1;
						  		}
						  		if(State==="absent"){
						  			absent_count+=1;
						  		}

						  		$('#presentcount').val(present_count);
						  		$('#absentcount').val(absent_count);
							}
	                	
	                	}
	                	
                	}
            	});
			})
		})
	</script>
@endsection