<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DOMPDF;
use PDF;
Use DB;

class ReportController extends Controller
{

    //to get attenance report of total daily attendance 
    public function get_AttendanceRecords(Request $req){
    	if($req->ajax()){
            $search_date=$req->get('date');
            if($search_date!=''){
                $attendance_records=DB::table('attendance')
                						->join('employee','employee.Emp_Id','=','attendance.Emp_Id')
                						->where('Date','like','%'.$search_date.'%')
                						->select('employee.Emp_Id','employee.Emp_Name','attendance.Status')
    									->get();
    			return response()->json(['data'=>$attendance_records]);
            }    
        } 
    	
    }

    //to get all order details between a given date range
    // public function get_OrderRecords(){
    //     $search_date_from=$req->get('datefrom'); 
    //     $search_date_to=$req->get('dateto'); 

    //     $records=DB::table('placed_orders')
    //                     ->join('ordered_items','placed_orders.Order_Id','=','ordered_items.Order_Id')
    //                     ->whereBetween('Order_Date',[$search_date_from
    //                         ,$search_date_to])
    //                     ->select('placed_orders.Order_Id','placed_orders.Customer','ordered_items.Item_Code','placed_orders.Item')
    //                     ->get();
        
    //             return response()->json(['data'=>$data]);


    // }

    public function getAllOrders(Request $req){
       
        $search_date_from=$req->get('datefrom'); 
        $search_date_to=$req->get('dateto'); 

        $records=DB::table('placed_orders')
                        ->join('ordered_items','placed_orders.Order_Id','=','ordered_items.Order_Id')
                        ->whereBetween('Order_Date',[$search_date_from
                            ,$search_date_to])
                        ->select('placed_orders.Order_Id','placed_orders.Customer','ordered_items.Item_Code','ordered_items.Total_Qty')
                        ->get();
        
                return response()->json(['data'=>$records]);
        
    }
}
