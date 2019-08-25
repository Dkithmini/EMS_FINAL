@extends('AdminHome')

@section('show_content')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/attendance.css') }}"> -->
<div class="panel">
		<div class="panel-body">

			<div class="col-md-12">
				<h5>Record Attendance</h5>
				<form>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<label>Date</label>
					<input type="Date" name="txtdate" id="date_select">
					<br>
					
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
				</form>
				<br>
			</div>
			<button id="btn_add_attendance" style="float: right;">Add Attendance</button>
			<button id="btn_add_refresh" style="float: right;">Refresh</button>
		</div>
	</div>


	<script type="text/javascript">

		//display list of emp
		$(document).ready(function(){
			viewAllEmp();
		})


		function viewAllEmp(){
				$.ajax({
                type: 'get',
                url:  'viewallemp_forattendance',
	                success: function(response) {
	                	// var show=response;
	                	// console.log(response);
	                	var response_data=response.data;
	                    var showdata='';	
	                    var radioid=1;	
						for (var a=0;a<response_data.length;a++) {
						  	var Id=response_data[a].Emp_Id;	
						  	var Name=response_data[a].Emp_Name;
						  	
					  		showdata +="<tr>";
					  		showdata +="<td>"+Id+"</td><td>"+Name+"</td><td><input type='radio' class='att' name="+radioid+" value='present'>Present<input type='radio' class='att' name="+radioid+" value='absent'>Absent<input type='radio' class='att' name="+radioid+" value='Unmarked'  checked='' hidden=''></td>";
					  		showdata +="</tr>";
					  		document.getElementById("tbody").innerHTML=showdata;
					  		radioid+=1;

						}
                	}
            	});
			}

		//add attendance	
		$('#btn_add_attendance').click(function(){
			addAttendance();
		});

		var rec_date;
		function addAttendance(){
			var Table = new Array();
    		rec_date=$('#date_select').val();
    			
			$('#tbody tr').each(function(){
				// var $row = $(this).closest("tr");       
    			$tds = $(this).find("td"); 
	    		var radioValue = $($tds).find("input:checked").val();
				var TableData={ "Empid" : $(this).find('td:eq(0)').text(), "attendance" :radioValue};
				Table.push(TableData);	
			});
				// console.log(Table);
			
			$.ajax({
				url:'/recordattendance',
				type:'post',
				headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				data:{'record':Table,'rec_date':rec_date},
				// dataType:'json',
				success:function(emp){
					// alert('attendance recorded successfully...!');
					window.popWindow.dialog("Attendance Recorded Successfully...!","success");	
				}	  	
			});
		}	

		//refresh - disply list of unmarked emp
		$('#btn_add_refresh').click(function(){
			var search_date=$('#date_select').val();
			refreshAttendance(search_date)

		})

		function refreshAttendance(search_date=''){
			$.ajax({
				url:'/viewunmarked',
				type:'get',
				// headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
				data:{'date':search_date},
				// dataType:'json',
				success:function(data_record){
					// console.log(data_record);
					var result=JSON.parse(data_record);

					if(!result.length){
						// alert('All Employees Marked!');
						window.popWindow.dialog("Attendance Recording Completed for All Employees...!","success");
						 var showdata='';
						 document.getElementById("tbody").innerHTML=showdata;
					}
					else{
						var showdata='';	
	                    var radioid=1;	
						for (var a=0;a<result.length;a++) {
						  	var Id=result[a].Emp_Id;	
						  	var Name=result[a].Emp_Name;
						  	
					  		showdata +="<tr>";
					  		showdata +="<td>"+Id+"</td><td>"+Name+"</td><td><input type='radio' class='att' name="+radioid+" value='present'>Present<input type='radio' class='att' name="+radioid+" value='absent'>Absent<input type='radio' class='att' name="+radioid+" value='Unmarked'  checked='' hidden=''></td>";
					  		showdata +="</tr>";
					  		document.getElementById("tbody").innerHTML=showdata;
					  		radioid+=1;
					  		// console.log(Id);
						}
					}
					 
				}	  	
			});
		}
			
	</script>
@endsection		
