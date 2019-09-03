@extends('ManagerHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/addorder.css') }}">

<!--Enter order details panel-->
	<div class="panel">
		<div class="panel-body">
			<div class="col-md-12" style="margin-top: 5px;margin-bottom: 5px;" id="sec1">
				<h5>Enter Order Details</h5>
				<div class="row">
					<form id="frmorder" method="post" action="/addorder">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">	
						<div class="form-group">
							<label>Order ID</label>
							<input type="number" name="txtOrderId" id="orderid" readonly="" >
							<label>Order Date</label>
							<input type="date" name="txtOrderDate" required="" id="orderdate" >
							<label>Due Date</label>
							<input type="Date" name="txtDueDate" required="" id="duedate">
							<label>Customer </label>
							<input type="text" name="txtCusName" id="cusname" required="">
							<br>
						</div>
					</form>
				</div>	
			</div>

			<div class="col-md-12" style="margin-bottom: 5px; ">
				<h5> Order Items</h5>
				<form id="frmitemdetails">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group">
						<input type="text" name="txtOrderId2" id="id" hidden="">
						<label>Item Code</label>
						<input type="text" name="txtItemCode" id="itemcode" required="">
						<label>Item Name</label>
						<input type="text" name="txtItemName" id="itemname" readonly="">
						<input type="textarea" name="txtItemDescription" placeholder="description" style="width: 350px;height: 40px;padding-left: 10px" id="itemdes" readonly="">				
						<br>

						<div class="orderitems">
							<h5>Item Sizes</h5>
															
							<label>XS</label><input type="text" name="txtXS"  id="xs" class="size" value="0">
							<label>S</label><input type="text" name="txtS"  id="smll"  class="size" value="0">
							<label>M</label><input type="text" name="txtM"  id="medm"  class="size" value="0">
							<label>L</label><input type="text" name="txtL"  id="lrg"  class="size" value="0">
							<label>XL</label><input type="text" name="txtXL"  id="xlg"  class="size" value="0">
							<label>XXL</label><input type="text" name="txtXXL"  id="xxlg"  class="size" value="0"><br>
							<label>Total Quantity</label><input type="text" name="txtTotQty" class="total" id="tot"><label style="width: 40px;">Pcs</label>
						</div>
						<br>
						
						<div class="btn-group float-right">
							<button class="btn btn-danger" type="button" id="btnreset">Reset</button>
							<button class="btn btn-success" type="button"  id="btnAddItem" disabled="">Add Item</button>
						</div>							
					</div>
				</form>	
			</div>		
		</div>
	</div>
<!--End order details panel-->


<!--Display Order details table panel-->
	<div class="panel" style=" margin-bottom: 5px;border-style: none" id="sec2">
		<div class="panel-body" style="max-height: 200px; overflow-y: scroll" >
			<div class="col-md-12" >
			  	<div class="table-responsive">
					<table class="table table-striped">
						<thead style="table-layout: fixed;">
							<tr>
							    <th >Item Code</th>
							    <th >Item Name</th>
							    <th >XS</th>
							    <th >S</th>
							    <th >M</th>
							    <th >L</th>
							    <th >XL</th>
							    <th >XXL</th>
							    <th >Total Qty</th>
							    <th >Remove</th>
							</tr>
						</thead>
						<tbody id="tbody">
							<!-- table content -->
						</tbody>
					</table>
			  	</div>
			</div>
		</div>
		<br>
	</div>
<!--End of order detail table panel-->

	<div class="col-md-12">
		<div class="btn-group float-right">
			<button class="btn btn-danger " type="button" >Cancel</button>
			<button class="btn btn-info" type="button" id="btnAddOrder" disabled="">Add Order</button>
		</div>	
	</div>

	<script type="text/javascript">
		//get order id and order date on loading the page
		$(document).ready(function(){
        	displayOrderId();
        	getSystemDate();
        });

		//calculate order id to be displayed
		function displayOrderId(){
		 	$.ajax({
        		url:'/getLastId',
			 	method:'get',
			 	success:function(lastId){
			 		// console.log(lastId);
					var result=lastId.data;
			 		
					if(!result){
			 			var nextId=1;
			 		}
			 		else{
			 			var nextId=result.Order_Id;
			 			var nextId=nextId+1;
			 		}
			 		// console.log(nextId);
			 		$('#orderid').val(nextId);
			 	}
        	});
		 }

		 //get system date as order date
		function getSystemDate(){
    		var today = new Date();
			var day = ("0" + today.getDate()).slice(-2);
    		var month = ("0" + (today.getMonth() + 1)).slice(-2);

    		var date = today.getFullYear()+"-"+(month)+"-"+(day) ;
		 	$('#orderdate').val(date);
		}

		//validate due date
		$('#duedate').change(function(){
			validateDuedate();
		});

		function validateDuedate(){
			$.ajax({
        		url:'/getLastsched_Date',
			 	method:'get',
			 	success:function(response){
			 		// console.log(response.data);
			 		var lastSched_end=response.data;
			 		var orderdate_tocheck=$('#orderdate').val();
			 		var date_tocheck=$('#duedate').val();

			 		if( date_tocheck < orderdate_tocheck){
						alert('wrong due data..!');
						$('#duedate').val('');
					}
					else{
						if( date_tocheck < lastSched_end){
							alert('wrong due data..!');
							$('#duedate').val('');
						}
					}
			 	}
        	});
		} 

		// show item details for selected item code
		$('#itemcode').change(function(){
			var item_code=$('#itemcode').val();

			if(item_code === ''){
				$('#itemname').val('');
			 	$('#itemdes').val('');
			}
			else{
				get_Item_Details(item_code);
			}
		 	
		 })

		function get_Item_Details(item_code=''){
		 		$.ajax({
        		url:'/getItemDetails',
			 	method:'get',
			 	data:{'item_code':item_code},

			 	success:function(response){
			 		var check=response.success;
			 		var show=response.data;

			 		if(!show.length){
			 			alert('Item Not Found..!');	
			 			$('#itemcode').val('');
			 			$('#itemname').val('');
			 			$('#itemdes').val('');
			 		}
			 		else{
			 			var item_name=show[0].Item_Name;
			 			var item_des=show[0].Description;
			 			$('#itemname').val(item_name);
			 			$('#itemdes').val(item_des);
			 		}
			 	}
        	});
		}


		$('.size').change(function(){
		 	$('#btnAddItem').prop('disabled',false);
		});

		//calc total item qty
		$(document).on("change", ".size", function() {
   		 	var sum = 0;
   		 	$(".size").each(function(){
       	 		sum += +$(this).val();
   			 });
   		 	$(".total").val(sum);
		});
		
		//reset item details form
		$('#btnreset').click(function(){
			resetForm();
		})
		 
		function resetForm(){
		 	$('#frmitemdetails').trigger("reset");
		 }


		$('#btnAddItem').click(function(data){
			var x=$('#itemcode').val();
			if(x!=''){
				var icode=$("#itemcode").val();
				var iname=$("#itemname").val();
				var exsmall=$("#xs").val();
				var small=$("#smll").val();
				var med=$("#medm").val();
				var large=$("#lrg").val();
				var xlarge=$("#xlg").val();
				var xxl=$("#xxlg").val();
				var tot=$("#tot").val();

				//display ordered items and sizes
				var markup = "<tr><td>"+ icode+"</td><td>" + iname + "</td><td>" + exsmall +"</td><td>"+ small + "</td><td>"+ med +"</td><td>"+ large +"</td><td>"+ xlarge+"</td><td>"+ xxl +"</td><td>"+tot+"</td><td><button type='button' id='btntableselect' class='remove'><i class='fas fa-trash-alt'></i></td></tr>";
            	$('#tbody').append(markup);
            	$('#btnAddOrder').prop('disabled',false);
            	resetForm();
            	$('#btnAddItem').prop('disabled',true);
			}
			else{
				alert('Select item to add..!');
				$('#btnAddItem').prop('disabled',true);
				resetForm();
			}	    	
		});
		
		//remove a item from item table
		$(document).on("click",'.remove',function(){
			$(this).closest('tr').remove(); 
		});

		$('#btnAddOrder').click(function(){
			addOrder();
			addSizes();

		});

		//Add order details 
		function addOrder(){
			var id_order=$('#orderid').val();
			var order_date=$('#orderdate').val();
			var due_date=$('#duedate').val();
			var cusname=$('#cusname').val();
			
			if(order_date!='' && due_date!='' && due_date!='' &&cusname!=''){
				$.ajax({
		            type: 'post',
		            url: '/add_order',
		            headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    data: {'id_order':id_order,'order_date':order_date,'due_date':due_date,'cusname':cusname},

		            success: function(response) {
						// alert(response.message);
						window.popWindow.dialog("Order Added Successfully..!","success");
						location.reload();
		            }
		        });
		    }
		}
		
		//Add order sizes
		function addSizes(){
			var id_order=$('#orderid').val();
			var order_date=$('#orderdate').val();
			var due_date=$('#duedate').val();
			var cusname=$('#cusname').val();

			if(order_date!='' && due_date!='' && due_date!='' &&cusname!=''){
				$('#tbody').find('tr').each(function (i, el) {
			        var Size_Table = new Array();
			        var Size_TableData={ "itemId" : $(this).find('td:eq(0)').text(),
			            				"itemName" : $(this).find('td:eq(1)').text(),
			            				"size_xs" : $(this).find('td:eq(2)').text(),
			            				"size_s" : $(this).find('td:eq(3)').text(),
			            				"size_m" : $(this).find('td:eq(4)').text(),
			            				"size_l" : $(this).find('td:eq(5)').text(),
			            				"size_xl" : $(this).find('td:eq(6)').text(),
			            				"size_xxl" : $(this).find('td:eq(7)').text(),
			            				"totqty" : $(this).find('td:eq(8)').text()
			            			};
			        Size_Table.push(Size_TableData);
			        // console.log(Size_Table);

			        $.ajax({
			            type: 'post',
			            url: '/addorderedsizes',
			            headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
	                    data: {'Size_Table':Size_Table,'id_order':id_order},

			            success: function(response) {
							// alert(response.message);
							window.popWindow.dialog(response.message,"info");
			            }
			        });
		    	});
			}
			else{
				// alert('	Incomplete Order details..!');
				window.popWindow.dialog("Incomplete Order Details..!","error");
			}	
		}

	</script>

@endsection
