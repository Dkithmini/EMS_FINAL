@extends('AdminHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/viewemployee.css') }}">

<!-- Search Employee panel -->
<div class="panel">
	<h5>View Employee</h5>
	<div class="panel-body">
		<div class="col-md-12">
			<form >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<label>Search by Emp Id</label><input type="text" name="txtSearchById" id="SearchId"><button type="button" id="SearchEmployeeById">Search</button>
				<label>Search by Name</label><input type="text" name="txtSearchByName"><button type="button">Search</button><br>
				<label>Search by NIC</label><input type="text" name="txtSearchBynic"><button type="button">Search</button>
				<br><br>
			</form>
		</div>
	
	</div>
</div>
<!-- End of search employee panel -->

<!-- Employee details table -->
<div style="overflow: scroll;max-height: 400px;">
	<table class="table table-striped" >
		<div>
			<thead>
				<tr>
					<th >Emp Id</th>
					<th >Emp Name</th>
					<th >NIC</th>
					<th >DOB</th>
					<th >Gender</th>
					<th >Contact</th>
					<th >Address</th>
					<th >DOJ</th>
					<th >Salary</th>		        
				</tr>
			</thead>
		</div>
	
			<tbody id="tbody">
				<!-- table content -->
			</tbody>
	</table>
</div>
<!--End of emp details table  -->

<script type="text/javascript">
	//view all employees
	$(document).ready(function(){
		viewAll();
	})


	function viewAll(){
		$.ajax({
            type: 'get',
            url: '/viewallemployees',
            success: function(data) {
	            // console.log(response);
	            var showdata='';		
				for (var a=0;a<data.length;a++) {
					var Id=data[a].Emp_Id;	
					var Name=data[a].Emp_Name;
					var NIC=data[a].NIC;
					var DOB=data[a].Dob;
					var Gender=data[a].Gender;
					var contact=data[a].ContactNo;
					var address=data[a].Address;
					var DOJ=data[a].Doj;
					var salary=data[a].Salary;

					showdata +="<tr>";
					showdata +="<td>"+Id+"</td><td>"+Name+"</td><td>"+NIC+"</td><td>"+DOB+"</td><td>"+Gender+"</td><td>"+contact+"</td><td>"+address+"</td><td>"+DOJ+"</td><td>"+salary+"</td>";
					showdata +="</tr>";
					document.getElementById("tbody").innerHTML=showdata;

				}
            }
        });
	}
		
	//search by id
	$(document).ready(function() {
   		$("#SearchEmployeeById").click(function() {
    		var searchid=$('#SearchId').val();
    		if(searchid!=''){
    			SearchById(searchid);
   			}
    		else{
    			viewAll();
    		}
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
	   			var showdata='';		
						
				var Id=data[0].Emp_Id;	
				var Name=data[0].Emp_Name;
				var NIC=data[0].NIC;
				var DOB=data[0].Dob;
				var Gender=data[0].Gender;
				var contact=data[0].ContactNo;
				var address=data[0].Address;
				var DOJ=data[0].Doj;
				var salary=data[0].Salary;

				showdata +="<tr>";
				showdata +="<td>"+Id+"</td><td>"+Name+"</td><td>"+NIC+"</td><td>"+DOB+"</td><td>"+Gender+"</td><td>"+contact+"</td><td>"+address+"</td><td>"+DOJ+"</td><td>"+salary+"</td>";
				showdata +="</tr>";
				document.getElementById("tbody").innerHTML=showdata;
			}		
		});
	}
</script>
@endsection