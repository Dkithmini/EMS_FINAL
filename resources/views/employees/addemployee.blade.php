@extends('AdminHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/addemployee.css') }}">

<!-- Add Employee panel -->
<div class="panel">
	<div class="panel-body">
			
		<form  id="frmaddemployee">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<h5>Add Employee</h5>
			<br>
				
			<div class="col-md-12">
				<label>Employee Id </label>
				<input type="number" name="txtEmpId" required style="width: 150px;" id="empid" readonly=""><br>
				<label>Full Name </label>
				<input type="text" name="txtFullName" required  id="fullname" ><br>
				<label>NIC No </label>
				<input type="text" name="txtNIC" required pattern="[0-9]{9}[V]|[0-9]{9}[v]" id="nic" ><br>
				<label>Date of Birth </label>
				<input type="date" name="txtDOB"  required placeholder="DD/MM/YYYY" id="dob"><br>
				<label>Gender </label>
				<select name="cmbGender"required id="gender">
					<option value="Select">--Select--</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
				</select><br>
				<label>Contact No </label>
				<input type="text" name="txtContactNo"  required pattern="[0-9]{10}" id="contact"><br><br>
				<label>Permanent Address </label>
				<textarea name="txtAddress" cols="50" id="address"></textarea><br>
			</div>

			<div class="col-md-12">
				<label>Date Joined</label>
				<input type="date" name="doj"><br>
				<label>Salary </label>
				<input type="number" name="txtSalary" id="salary"><br><br>
				<button id="reset" type="reset" class="btn-md">Reset</button>
				<button name="add" id="btnAddEmployee" class="btn-md">Add</button>
			</div>
		</form>
	</div>
</div>
<!-- End of add employee panel -->
	
	<script type="text/javascript">

		$(document).ready(function(){
        	$.ajax({
        		url:'/getId',
			 	type:'get',
			 	success:function(lastId){
			 		var result = JSON.parse(lastId);
			 			//console.log(result.Order_Id);
			 		var nextId = result.Emp_Id;
			 		nextId += 1;
			 			// console.log(nextId);
			 		$('#empid').val(nextId);
			 	}
        	});
        });

		//add new employee
		$('#btnAddEmployee').click(function(){
			$.ajax({
				url:'/addemployee',
				type:'post',
				data:$('#frmaddemployee').serialize(),
				succes:function(show){
					alert("Employee was addeded");
				
				}	
			});
		});
	</script>
@endsection