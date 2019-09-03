@extends('AdminHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/updateemployee.css') }}">

<!-- update emp panel -->
<div class="panel">
	<div class="panel-body">
		<h5>Update Employee</h5>
		<br>
		<form >
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<label>Search by Emp Id</label><input type="text" name="txtSearchById" id="SearchId"><button type="button" id="SearchEmployeeById">Search</button><br>
			<label>Search by Name</label><input type="text" name="txtSearchByName"><button type="button">Search</button><br>
			<label>Search by NIC</label><input type="text" name="txtSearchBynic"><button type="button">Search</button>
			<br><br>
		</form>
			
		<form  id="frmupdateemployee">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<br>
				
			<div class="col-md-12">
				<label>Employee Id </label>
				<input type="number" name="txtEmpId" required style="width: 120px;" id="empid" readonly=""><br>
				<label>Full Name </label>
				<input type="text" name="txtFullName" required  id="fullname" readonly=""><br>
				<label>NIC No </label>
				<input type="text" name="txtNIC" required pattern="[0-9]{9}[V]|[0-9]{9}[v]" id="nic" readonly="" ><br>
				<label>Date of Birth </label>
				<input type="text" name="txtDOB"  required placeholder="DD/MM/YYYY" id="dob" readonly=""><br>
				<label>Gender </label>
				<input type="text" name="txtgender" readonly="" id="gendr"><br>
				<label>Date Joined</label>
				<input type="text" name="doj" readonly="" id="datejoined" placeholder="DD/MM/YYYY" >
			</div>

			<div class="col-md-12">
				<label>Contact No </label>
				<input type="text" name="txtContactNo"  required pattern="[0-9]{10}" id="contact"><br><br>
				<label>Permanent Address </label>
				<textarea name="txtAddress" cols="50" id="address"></textarea><br><br>
				<label>Salary </label>
				<input type="number" name="txtSalary" id="salary" ><br><br>
					
				<button id="reset" type="reset">Reset</button>
				<button type="button" name="add" id="btnUpdateEmployee">Update</button>
				<button id="view">View</button><br>
			</div>
		</form>
	</div>
</div>	
<!-- end of update emp panel -->

	<script type="text/javascript">
		//search emp by id
		$(document).ready(function() {
    		$("#SearchEmployeeById").click(function() {
    			var searchid=$('#SearchId').val();
    			SearchById(searchid);
    		});
   		 });

		function SearchById(searchid='') {
			 $.ajax({
			 	url:'/searchEmpById',
			 	method:'get',
			 	data:{'search_id':searchid},
			 	success:function(result){
			 		// console.log(result);

			 		var data=JSON.parse(result);

			 		var Id=data[0].Emp_Id;	
					var Name=data[0].Emp_Name;
				  	var NIC=data[0].NIC;
				  	var DOB=data[0].Dob;
				  	var Gender=data[0].Gender;
				  	var contact=data[0].ContactNo;
				  	var address=data[0].Address;
				  	var DOJ=data[0].Doj;
				  	var salary=data[0].Salary;

				  	$('#empid').val(Id);
				  	$('#fullname').val(Name);
				  	$('#nic').val(NIC);
				  	$('#dob').val(DOB);
				  	$('#gendr').val(Gender);
				  	$('#contact').val(contact);
				  	$('#address').val(address);
				  	$('#datejoined').val(DOJ);
				  	$('#salary').val(salary);
			 	}
			 });
		}

		//update employee
		$('#btnUpdateEmployee').click(function(){
			window.popWindow.dialog("Do You Need To Update the Employee Details?","confirm",{onOk:function(){
				updateEmployee();
			}})
		});

		function updateEmployee(){
			$.ajax({
			 	url:'/updateemployee',
			 	method:'post',
			 	data:$('#frmupdateemployee').serialize(),
			 	
			 	success:function(update){
			 		// alert('updated..');
			 		window.popWindow.dialog("Employee Details Updated Successfully..!","success");
			 	}
			});
		}

	</script>
@endsection