<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EmployeeController extends Controller
{
    public function getId(){

		//$row=array();
		$row=DB::table('employee')->orderBy('Emp_Id', 'DESC')->first();
		$lastId=$row;
		
		echo json_encode($lastId);

	}

	public function addEmployee(Request $addemp){

		if($addemp !=''){
			$emp_Id=$addemp->input('txtEmpId');
			$emp_name=$addemp->input('txtFullName');
			$nic=$addemp->input('txtNIC');
			$dob=$addemp->input('txtDOB');
			$gender=$addemp->input('cmbGender');
			$contact=$addemp->input('txtContactNo');
			$address=$addemp->input('txtAddress');
			$doj=$addemp->input('doj');
			$salary=$addemp->input('txtSalary');

			$data=array('Emp_Id'=>$emp_Id,'Emp_Name'=>$emp_name,'NIC'=>$nic,'Dob'=>$dob,'Gender'=>$gender,'ContactNo'=>$contact,'Address'=>$address,'Doj'=>$doj,'Salary'=>$salary);

			$result=DB::table('employee')->insert($data);
			

			// return Redirect::back();
		}
	}

	public function viewAllEmployees(){
		$data=array();
		$data=DB::table('employee')->get();
		return response($data);
	}


	public function SearchById(Request $search){
    	if($search->ajax()){
    		
    		$id=$search->get('search_id');
    		if($id!=''){
    			// $data=array();
    			$result=DB::table('employee')
    			->where('Emp_Id','like','%'.$id.'%')
    			->get();

    			echo json_encode($result);
    			
    		}
    		
    		else{
    			echo "error in search";
    		}
    	} 
    	
    }

    public function updateEmployees(Request $update){
    	if($update !=''){
			$emp_Id=$update->input('txtEmpId');
			$emp_name=$update->input('txtFullName');
			$nic=$update->input('txtNIC');
			$dob=$update->input('txtDOB');
			$gender=$update->input('cmbGender');
			$contact=$update->input('txtContactNo');
			$address=$update->input('txtAddress');
			$doj=$update->input('doj');
			$salary=$update->input('txtSalary');

			$result=DB::table('employee') 
					->where('Emp_Id', $emp_Id) 
					->limit(1) 
					->update([ 'ContactNo' => $contact, 'Address' => $address, 'Salary' => $salary ]);
			
		}
    }
}
