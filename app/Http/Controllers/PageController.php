<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function getLogin(){
		return view('login');
	}
	public function getManagerHome(){
		return view('ManagerHome');
	}
	public function getSupervisorHome(){
		return view('SupervisorHome');
	}
	public function getAdminHome(){
		return view('AdminHome');
	}

	//dashboard
	public function getManagerDashboard(){
		return view('dashboard/dashboardMain');
	}



	//orders
	public function getAddorder(){
		return view('orders/addorder');
	}
		
	public function getVieworder(){
		return view('orders/vieworder');
	}



	// schedules
	public function getAddschedule(){
		return view('schedules/createschedule');
	}
	public function getScheduleTask(){
		return view('schedules/scheduletask');
	}
	public function getViewschedule(){
		return view('schedules/viewschedule');
	}
	public function getViewTask(){
		return view('schedules/viewtask');
	}
	public function getUpdateTask(){
		return view('schedules/updatetask');
	}


	//employees
	public function getAddemployee(){
		return view('employees/addemployee');
	}

	public function getViewemployee(){
		return view('employees/viewemployee');
	}

	public function getUpdateemployee(){
		return view('employees/updateemployee');
	}


	//attendance
	public function getRecordAttendance(){
		return view('attendance/recordattendance');
	}

	public function getViewAttendance(){
		return view('attendance/viewattendance');
	}


	//reports
	public function getReports(){
		return view('reports/attendanceReports');
	}	
}
