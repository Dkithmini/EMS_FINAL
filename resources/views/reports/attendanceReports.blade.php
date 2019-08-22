@extends('ManagerHome')

@section('show_content')

<label >Date</label><input type="date" name="txtSearchDate" id="searchdate">
<button id="btnsearch" class ="bypassme">Search</button>
<button id="btnshowpdf" class ="bypassme"><i class="fas fa-file-pdf fa-2x"></i></button>
<br><br>
<div id="content">
	<h3 style="text-align: left;">SM Garments Pvt Ltd</h3>
	<p style="font-weight: bold;text-align: left;">Rideegama Rd,Hindagolla,Kurunegala</p>
	<p style="font-weight: bold;text-align: left;">Contact : 037-2298929 | E-mail : smgarments@gmail.com</p>	
<hr>
<br>

<h4 style="font-weight: bold;padding-left: 40px;" id="report_Heading">Daily Attendance details Report : </h4><br>
<div>
	<table class="table table-condensed " style="background-color: none;border-style: none">
			<thead>
				<tr>
					<th >Employee Id</th>
					<th >Employee Name</th>
					<th >Attendance</th>

				</tr>
			</thead>
			<tbody id="tbody">
				
			
			</tbody>
	</table>
</div>
</div>
	<script type="text/javascript">
		$('#btnsearch').click(function(){
			searchAttendance();
		});

		function searchAttendance(){
			var date=$('#searchdate').val();
			$.ajax({
			 	url:'/getAllattendancereport',
			 	method:'get',
			 	headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			 	data:{'date':date},
			 	
			 	success:function(response){
			 		var showdata='';
			 		var result=response.data;
			 		// console.log(result);

			 		for(i=0;i<result.length;i++){
						// var sid=result[i].Schedule_Id;
						var emp_id=result[i].Emp_Id;
						var name=result[i].Emp_Name;
						var status=result[i].Status;
						
							  

						showdata +="<tr>";
						showdata +="<td>"+emp_id+"</td><td>"+name+"</td><td>"+status+"</td><td>";
						showdata +="</tr>";
						document.getElementById("tbody").innerHTML=showdata;
						
					}
					$('#report_Heading').append(date);
			 	}
			 });
		}

		$("#btnshowpdf").click(function () {
         	// html2canvas(document.getElementById('content'), 
         	// 	{ onrendered: function(canvas) { 
         	// 		var img =canvas.toDataURL("image/jpeg,1.0"); 

         	// 		var pdf = new jsPDF(); 

         	// 		pdf.addImage(img, 'JPEG',18,15); 
         	// 		// pdf.output('datauri'); 
         	// 		pdf.save('autoprint.pdf'); } })

         	var HTML_Width = $("#content").width();
			 var HTML_Height = $("#content").height();
			 var top_left_margin = 15;
			 var PDF_Width = HTML_Width+(top_left_margin*2);
			 var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
			 var canvas_image_width = HTML_Width;
			 var canvas_image_height = HTML_Height;
			 
			 var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;
			 
			 
			 html2canvas($("#content")[0],{allowTaint:true}).then(function(canvas) {
			 canvas.getContext('2d');
			 
			 // console.log(canvas.height+"  "+canvas.width);
			 
			 
			 var imgData = canvas.toDataURL("image/jpeg", 1.0);
			 var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
			     pdf.addImage(imgData, 'JPEG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
			 
			 
			 for (var i = 1; i <= totalPDFPages; i++) { 
			 pdf.addPage(PDF_Width, PDF_Height);
			 pdf.addImage(imgData, 'JPEG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
			 }
			 
			     pdf.save("AttendanceReport.pdf");
			        });
			 
     	});
	</script>
</body>



@endsection