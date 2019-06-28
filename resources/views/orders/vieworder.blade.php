@extends('ManagerHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/vieworder.css') }}">
<!--All orders panel-->
	<div class="panel" >
		<h5>All Orders</h5>
		<form id="frmViewAllOrders" action="{{url('orders/vieworder') }}" method="get">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<label>Search by Id</label><input type="text" name="txtSearchById" id="SearchId"><button class="btn-basic" type="button" id="SearchOrderById">Search</button>
			<label>Search by Customer</label><input type="text" name="txtSearchByCus"><button class="btn-basic" type="button">Search</button><br>
			<label>Search by Due-Date</label><input type="text" name="txtSearchByDate"><button class="btn-basic" type="button">Search</button>
			<br><br>
		</form>
		
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12" style="">
					<table class="table table-condensed">
						<thead>
						    <tr>
						    	<th>Order Id</th>
						    	<th >Order Date</th>
						    	<th >Due Date</th>
						    	<th >Customer</th>
						    </tr>
						</thead>
						<tbody id="tbody1">
							@foreach($data as $row)
						    <tr>
						        <td>{{$row->Order_Id}}</td>
								<td>{{$row->Order_Date}}</td>
								<td>{{$row->Due_Date}}</td>
								<td>{{$row->Customer}}</td>
							</tr>
							
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
	<!--End all orders panel-->

	<!--Order details panel-->
	<div class="panel" >
		<h5>Order Details</h5>
		<input type="text" name="txtid" hidden="">
		<div class="panel-body" >
			<div class="row">
				<div class="col-md-12">
					<table class="table table-condensed">
						<thead>
						    <tr>
						    	<th >Item Code</th>
						    	<th >Quantity</th>
						  	</tr>
						</thead>
						<tbody id="tbody2">
						
						</tbody>
					</table>
					<!-- <div class="form-group">
								
								<label>Item Code</label>
								<input type="text" name="txtOrderDate" id="viewordericode" readonly="">
								<label>Item</label>
								<input type="text" name="txtDueDate"  id="viewitem" readonly=""><br>
								<label>Description</label>
								<input type="text" name="txtCusName"  id="viewdescription" readonly="">
								<label>Total Qty</label><input type="text" name="txtno_of_items" style="width: 100px" id="viewtotqty" readonly="">
								
					</div> -->

					<br>
				</div>
			</div>
		</div>
	</div>
	<!--End order details panel-->

	<div class="panel" >
		<h5>Item Sizes</h5>
		<input type="text" name="txtid" hidden="">
		<div class="panel-body" >
			<div class="row">
				<div class="col-md-12">
					<table class="table table-condensed">
						<thead>
						    <tr>
						    	<th >Item Code</th>
						    	<th >Size</th>
						    	<th>Qty</th>
						  	</tr>
						</thead>
						<tbody id="tbody3">
						
						</tbody>
					</table>
					<br>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
    		$("#SearchOrderById").click(function() {
    			var searchid=$('#SearchId').val();
    			SearchById(searchid);
    			DisplayOrderItems(searchid);	
    			DisplayOrderSizes(searchid);
    	});
    });

		function SearchById(searchid='') {
			 $.ajax({
			 	url:'/searchOrderById',
			 	method:'get',
			 	data:{'search_id':searchid},
			 	
			 	success:function(response){
			 		
			 		var result=response.data;
			 		// console.log(result);

			 		if(!result.length){
			 			alert('No Order Found..!');
			 			$('#SearchId').val('');
			 			$('#tbody1').hide();
			 			$('#tbody2').hide();
			 			$('#tbody3').hide();
			 		}
			 		else{
			 			$('#tbody1').show();
			 			$('#tbody2').show();
			 			$('#tbody3').show();
			 			var id_order=result[0].Order_Id;
				 		var cus_name=result[0].Customer;
				 		var o_date=result[0].Order_Date;
				 		var d_date=result[0].Due_Date;
				 		
				 		
				 		var show_order='';
				 			show_order +="<tr>";
							show_order +="</td><td>"+id_order+"</td><td>"+cus_name+"</td><td>"+o_date+"</td><td>"+d_date+"</td></tr>";
						document.getElementById("tbody1").innerHTML=show_order;
				 	}
			 	}
			 		
			 });
		}

		function DisplayOrderItems(searchid='') {
			 $.ajax({
			 	url:'/displaydetails',
			 	method:'get',
			 	data:{'search_id':searchid},
			 	// dataType:'json',
			 	success:function(response){
			 		var show_order_details='';
					var items=response.data;
			 		console.log(response.data);

			 		for(i=0;i<items.length;i++){
				 			var item_code=items[i].Item_Code;
				 			var tot_qty=items[i].Total_Qty;
				 			
				 			
				 				show_order_details +="<tr>";
								show_order_details +="</td><td>"+item_code+"</td><td>"+tot_qty+"</td>";
								show_order_details +="</tr>";

							
						// // 		$('#viewordericode').val(item_code);
						// // 		$('#viewitem').val(item);
						// // 		$('#viewdescription').val(item_description);
						// // 		$('#viewtotqty').val(tot_qty);
								
								document.getElementById("tbody2").innerHTML=show_order_details;
				 			
				 		}
			 		

			 	}
			 });
		}

		function DisplayOrderSizes(searchid=''){
			$.ajax({
			 	url:'/displaysizes',
			 	method:'get',
			 	data:{'search_size':searchid},
			 	// dataType:'json',
			 	success:function(sizeqty){
			 		var show_size='';
			 		// console.log(sizeqty);

			 		var size_details=JSON.parse(sizeqty);
			 		for(i=0;i<size_details.length;i++){
				 			var icode=size_details[i].Item_Code;
				 			var size_name=size_details[i].Size;
				 			var quantity=size_details[i].Qty;
				 			
				 			if(quantity!=0){
				 				show_size +="<tr>";
								show_size +="<td>"+icode+"</td><td>"+size_name+"</td><td>"+quantity+"</td>";
								show_size +="</tr>";
								document.getElementById("tbody3").innerHTML=show_size;
				 			}
				 		}
			 	}
			 });
		}
	</script>

@endsection