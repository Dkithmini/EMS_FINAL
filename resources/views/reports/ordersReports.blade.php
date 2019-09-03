@extends('ManagerHome')
@section('show_content')

<label >From</label><input type="date" name="txtSearchFromDate" id="searchdate_from">
<label >To</label><input type="date" name="txtSearchToDate" id="searchdate_to">
<button id="btnsearchorders" class ="bypassme">Search</button>
<button id="btnshowpdf" class ="bypassme"><i class="fas fa-file-pdf fa-2x"></i></button>
<br><br>
<div id="content">
	<h3 style="text-align: left;">SM Garments Pvt Ltd</h3>
	<p style="font-weight: bold;text-align: left;">Rideegama Rd,Hindagolla,Kurunegala</p>
	<p style="font-weight: bold;text-align: left;">Contact : 037-2298929 | E-mail : smgarments@gmail.com</p>	
<hr>
<br>

<h4 style="font-weight: bold;padding-left: 40px;" id="report_Heading"></h4><br>
<div>
	<table class="table table-condensed " style="background-color: none;border-style: none">
			<thead>
				<tr>
					<th >Order Id</th>
					<th >Customer</th>
					<th >Ordered Item</th>
					<th >Quantity</th>
				</tr>
			</thead>
			<tbody id="tbody">
				
			
			</tbody>
	</table>
</div>
</div>
	<script type="text/javascript">
		$('#btnsearchorders').click(function(){
			searchOrder_byDaterange();
		});

		// search orders between a date range
		// function searchOrders(){
		// 	var datefrom=$('#searchdate_from').val();
		// 	var dateto=$('#searchdate_to').val();
			
		// 	$.ajax({
		// 	 	url:'/getAllattendancereport',
		// 	 	method:'get',
		// 	 	// headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
		// 	 	// data:{'datefrom':datefrom,'dateto':dateto},
			 	
		// 	 	success:function(response){
		// 	 		console.log(response);
		// 	 	// 	var showdata='';
		// 	 	// 	var result=response.data;
		// 	 	// 	console.log(response);

		// 	 	// 	for(i=0;i<result.length;i++){
		// 			// 	// var sid=result[i].Schedule_Id;
		// 			// 	var orderid=result[i].Order_Id;
		// 			// 	var customer=result[i].Customer;
		// 			// 	var itemcode=result[i].Item_Code;
		// 			// 	var item=result[i].Item;
							  

		// 			// 	showdata +="<tr>";
		// 			// 	showdata +="<td>"+orderid+"</td><td>"+customer+"</td><td>"+itemcode+"</td><td>"+item+"</td>";
		// 			// 	showdata +="</tr>";
		// 			// 	document.getElementById("tbody").innerHTML=showdata;
						
		// 			// }
		// 			// var string='datefrom'+" - "+'dateto';
		// 			// $('#report_Heading').append(string);
		// 	 	}
		// 	 });
		// }

		function searchOrder_byDaterange(){
			var datefrom=$('#searchdate_from').val();
			var dateto=$('#searchdate_to').val();

			$.ajax({
        		url:'/getAllordersreport',
			 	method:'get',
			 	data:{'datefrom':datefrom,'dateto':dateto},

			 	success:function(response){
			 		// console.log(response);
			 		var result=response.data;
			 		var showdata='';

			 		for(i=0;i<result.length;i++){
						// var sid=result[i].Schedule_Id;
						var orderid=result[i].Order_Id;
						var customer=result[i].Customer;
						var itemcode=result[i].Item_Code;
						var item_qty=result[i].Total_Qty;
							  

						showdata +="<tr>";
						showdata +="<td>"+orderid+"</td><td>"+customer+"</td><td>"+itemcode+"</td><td>"+item_qty+"</td>";
						showdata +="</tr>";
						document.getElementById("tbody").innerHTML=showdata;
						
					}
					var string=datefrom+" to "+dateto;
					$('#report_Heading').text("Order Summery Report : "+string);
			 	
			 	}
        	});
		}

		$("#btnshowpdf").click(function () {
         	
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