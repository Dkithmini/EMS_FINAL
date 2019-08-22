<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DOMPDF;
use PDF;
Use DB;

class ReportController extends Controller
{
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
}
