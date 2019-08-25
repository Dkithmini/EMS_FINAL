<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AttendanceController extends Controller
{
    public function viewEmpList_attendance(){
		$data=array();
		$data=DB::table('employee')->get();
		return response()->json(['data'=>$data]);
	}
	

	public function recordAttendance(Request $rec){
		$attendance_rec=array();
		$attendance_rec=$rec->get('record');
		$att_date=$rec->get('rec_date');

		if($attendance_rec!=''){
			$x=DB::table('attendance')->where('Date','=',$att_date)->exists();
			if($x===true){
				for($i=0;$i<count($attendance_rec);$i++){
					$emp=$attendance_rec[$i]['Empid'];
					$status=$attendance_rec[$i]['attendance'];
				
					$result=DB::table('attendance') 
					->where('Date',$att_date)
					->where('Emp_Id', $emp) 
					->limit(1) 
					->update(['Status' => $status]);
				}
			}

			else{
				for($i=0;$i<count($attendance_rec);$i++){
					$emp=$attendance_rec[$i]['Empid'];
					$status=$attendance_rec[$i]['attendance'];
					
					$data=array('Emp_Id'=>$emp,'Status'=>$status,'Date'=>$att_date);

	        		DB::table('attendance')->insert($data);
				}
			}
			
		}
	}


	public function viewUnmarkedEmpList(Request $req){
		if($req->ajax()){
            $query=$req->get('date');
           	
           	if($query!=''){
           		$att=DB::table('attendance')->where('Date','=',$query)->exists();
           		if($att===true){
           			$data_record=DB::table('employee')
					->join('attendance', 'employee.Emp_Id', '=', 'attendance.Emp_Id')
					->select('employee.Emp_Id','employee.Emp_Name','attendance.*')
					->where('Date','like','%'.$query.'%')
					->where('Status','Unmarked')
					->get();
					echo json_encode($data_record);	
           		}
           		else{
           			$data_record=array();
					$data_record=DB::table('employee')->get();
					echo json_encode($data_record);
           		}
				
           	}
        } 
		
	}

	public function viewAttendance(Request $req){
		if($req->ajax()){
            $att_record=$req->get('date');
           	
           	if($att_record!=''){
           		
				$att_data=DB::table('attendance')
				->join('employee', 'employee.Emp_Id', '=', 'attendance.Emp_Id')
				->select('employee.Emp_Id','employee.Emp_Name','attendance.Status')
				->where('Date','like','%'.$att_record.'%')
				->get();
				echo json_encode($att_data);
           	}
        } 
	}

}

?>