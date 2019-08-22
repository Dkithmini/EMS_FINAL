<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Carbon\Carbon;
class OrderController extends Controller{


	public function getSysDate()
    {
        $date = Carbon::today()->format('m-d-y');
        return response()->json(['data'=>$date]);
    }

	public function getLastId(){

		$row=DB::table('placed_orders')->orderBy('Order_Id', 'DESC')->first();
		$lastId=$row;

		// echo json_encode($lastId);
		return response()->json(['data'=>$lastId]);

	}

	public function getItemDetails(Request $req){
		$code=$req->get('item_code');

		if($code!=''){
			// $var_x=DB::table('items')->where('Item_Code','=',$code)->exists();
			
				$item=DB::table('items')
						->where('Item_Code','like','%'.$code.'%')
						->get();
				return response()->json(['success'=>true,'data'=>$item]);
			
			
		}
	}

	public function addOrder(Request $request){
		// order table
		if($request !=''){
			$orderid=$request->get('id_order');
			$date_order=$request->get('order_date');
			$date_due=$request->get('due_date');
			$cusname=$request->get('cusname');
			
			$orderDetails=array('Order_Id'=>$orderid,'Customer'=>$cusname,'Order_Date'=>$date_order,'Due_Date'=>$date_due);
			$addorder=DB::table('placed_orders')->insert($orderDetails);
			return response()->json(['success'=>true,'message'=>'Order Details Added..!']);
		}
		else{
			return response()->json(['success'=>false,'message'=>'Error.Cannot Add Order..!']);
		}
	}
		
	

	// public function addOrderItems(Request $req2){
	// 	//ordered item table
	// 	$id=$req2->input('txtOrderId');
	// 	$itemcode=$req2->input('txtItemCode');
	// 	$itemname=$req2->input('txtItemName');
	// 	$decsription=$req2->input('txtItemDescription');
	// 	$tot=$req2->input('txtTotQty');
		
	// 	$items=array('Order_Id'=>$id,'Item_Code'=>$itemcode,'Item_Name'=>$itemname,'Description'=>$decsription,'Total_Qty'=>$tot);
	// 	DB::table('ordered_items')->insert($items);
	// 	// echo "Items Added";
		
	// }

	public function addItemSizes(Request $request){

		$sizes_record=array();
		$sizes_record=$request->get('Size_Table');

		$orderid=$request->get('id_order');
		// $date_order=$request->get('order_date');
		// $date_due=$request->get('due_date');
		// $cusname=$request->get('cusname');

		// $orderDetails=array('Order_Id'=>$orderid,'Customer'=>$cusname,'Order_Date'=>$date_order,'Due_Date'=>$date_due);
		// $addorder=DB::table('placed_orders')->insert($orderDetails);
		$temp=DB::table('placed_orders')->where('Order_Id','=',$orderid)->exists();

		//retrieve data in the request array
		if($temp===true){
			if($sizes_record!=''){
				for($i=0;$i<count($sizes_record);$i++){
					$itemId=$sizes_record[$i]['itemId'];
					$xs=$sizes_record[$i]['size_xs'];
					$small=$sizes_record[$i]['size_s'];
					$medium=$sizes_record[$i]['size_m'];
					$large=$sizes_record[$i]['size_l'];
					$XL=$sizes_record[$i]['size_xl'];
					$XXL=$sizes_record[$i]['size_xxl'];
					$totQty=$sizes_record[$i]['totqty'];

					//Add details to ordered_items table
					$orderedItems=array('Order_Id'=>$orderid,'Item_Code'=>$itemId,'Total_Qty'=>$totQty);
					$additem=DB::table('ordered_items')->insert($orderedItems);
					if(!$additem){
						return response()->json(['success'=>false,'message'=>'Error.Failed to Add Order Items..!']);
					}

					// put order item sizes to an array
					$sizearr=array(
						array('size_name'=>'xs','value'=>$xs),
						array('size_name'=>'s','value'=>$small),
						array('size_name'=>'m','value'=>$medium),
						array('size_name'=>'l','value'=>$large),
						array('size_name'=>'xl','value'=>$XL),
						array('size_name'=>'xxl','value'=>$XXL)
					);

					//add item sizes to ordered_sizes table
					foreach($sizearr as $var ){		
						$name=$var['size_name'];
						$qty=$var['value'];
						$itemsizes=array('Order_Id'=>$orderid,'Item_Code'=>$itemId,'Size'=>$name,'Qty'=>$qty);
						$addsizes=DB::table('ordered_sizes')->insert($itemsizes);
						if(!$addsizes){
							return response()->json(['success'=>false,'message'=>'Error.Item Sizes Not Added..!']);
						}
					}
					
				}

				return response()->json(['success'=>true,'message'=>'Order Addition Completed Successsfully..!']);
			}
			else{
				return response()->json(['success'=>false,'message'=>'Error.No Item Details Found to Add..!']);
			}
			
		}

		else{
			return response()->json(['success'=>false,'message'=>'Error.Order not found to Add Details..!']);
		}
			
			
	}

	public function ViewAllOrders(){
		$data=DB::table('placed_orders')->get();
		return view('orders.vieworder',compact('data'));
		
	}

	 public function SearchById(Request $search){
    	if($search->ajax()){
    		// $output="";
    		$id=$search->get('search_id');
    		if($id!=''){
    			// $data=array();
    			$data=DB::table('placed_orders')
    						->where('Order_Id','like','%'.$id.'%')
    						->get();
    			return response()->json(['data'=>$data]);
    			
    // 			foreach ($data as $result) {
				// 	$output.='<tr>'.
				// 	'<td>'.$result->Order_Id.'</td>'.
				// 	'<td>'.$result->Order_Date.'</td>'.
				// 	'<td>'.$result->Due_Date.'</td>'.
				// 	'<td>'.$result->Customer.'</td>'.
				// 	'</tr>';
				// }
				// return Response($output);
    		}
    		
    		// else{
    		// 	echo "error in search";
    		// }
    	} 
    	
    }


    public function displayOrderItems(Request $details){
    	if($details->ajax()){
    		
    		$itemdetails=$details->get('search_id');
    		if($itemdetails!=''){
    			
    			// $itemsdata=DB::table('items')
    			// 			->join('ordered_items','ordered_items.Item_Code', '=','items.Item_Code')
    			// 			->select('ordered_items.Item_Code','items.Item_Name','items.Description','ordered_items.Total_Qty')
    			// 			->where('Order_Id','like','%'.$itemdetails.'%')
    			// 			->get();

    			 $itemsdata=DB::table('ordered_items')
    						->where('Order_Id','like','%'.$itemdetails.'%')
    						->get();
    			
    			return response()->json(['data'=>$itemsdata]);
    			// echo json_encode($itemdata);
    		}
    	}
	}

	public function displayItemSizes(Request $size_details){
		if($size_details->ajax()){
    		$itemsizes=$size_details->get('search_size');
    		if($itemsizes!=''){
    			$sizeqty=DB::table('ordered_sizes')
    			->where('Order_Id','like','%'.$itemsizes.'%')
    			->get();
    			
    			echo json_encode($sizeqty);
    		}
    	}
	}	
}

?>
