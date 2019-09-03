<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
 
Route::get('/admin', 'HomeController@adminDashboard')->middleware('admin');
 
Route::get('/supervisor','HomeController@supervisorDashboard')->middleware('supervisor');
 
Route::get('/manager','HomeController@managerDashboard')->middleware('manager');

//DASHBOARD
Route::get('dashboard/managerdashboard','PageController@getManagerDashboard');
Route::get('/dashboardcontent','ScheduleController@dashboardContent');
Route::get('/attendanceSummery','ScheduleController@getAttendanceSummary');
Route::get('/workSummery','ScheduleController@getWorkSummary');
// Route::get('/managerdash_allshedules','ScheduleController@ViewAllSchedulesCount');
// Route::get('/managerdash_pendingTasks','ScheduleController@showAllTasksCount');
// Route::get('/managerdash_completedTasks','ScheduleController@showFinishedTasksCount');

//ORDERS
Route::get('orders/addorder','PageController@getAddorder');//load addorderpage
Route::get('orders/vieworder','PageController@getVieworder');//load vieworderpage

Route::get('/getLastId','OrderController@getLastId');//get last order id
Route::get('/getsysdate','OrderController@getSysDate');//get system date
Route::get('/getLastsched_Date','OrderController@getLastsched_End_date');//get date of last schedule to validate due date of order
Route::get('/getItemDetails','OrderController@getItemDetails');//get item details
Route::post('/add_order','OrderController@addOrder');//add order
Route::post('/addorderedsizes','OrderController@addItemSizes');//add ordered itemsizes

Route::get('orders/vieworder','OrderController@ViewAllOrders');//display all orders
Route::get('/searchOrderById','OrderController@SearchById');//search order by id
Route::get('/displaydetails','OrderController@displayOrderItems');//display item details
Route::get('/displaysizes','OrderController@displayItemSizes');//display item sizes

//SCHEDULES
Route::get('schedules/createschedule','PageController@getAddschedule');//load addschedule page
Route::get('schedules/scheduletask','PageController@getScheduleTask');//load schedule tasks page
Route::get('schedules/viewschedule','PageController@getViewschedule');//load view shed page
Route::get('schedules/viewtask','PageController@getViewTask');//load view task page
Route::get('schedules/updatetask','PageController@getUpdateTask');//load update task page

Route::post('/addschedule','ScheduleController@addSchedule');//add schedule
Route::get('/search','ScheduleController@searchOrder');//search order details
Route::get('/displaydetails','ScheduleController@displayOrderItems');//display ordered items
Route::get('/getLasttaskId','ScheduleController@getLastTaskId');//get last taskid
Route::get('/getLastsheduleId','ScheduleController@getLastShedId');//get last shed id
Route::get('/checkScheduledQty','ScheduleController@checkQty');//check already scheduled qty
Route::post('/addtask','ScheduleController@addTask');//add tasks
// Route::get('/getOrderDuedate','ScheduleController@selectDueDate');
Route::get('/searchschedulebyid','ScheduleController@searchSchedulebyId');//search scheduled tasks details
Route::get('/searchschedulebydate','ScheduleController@searchSchedulebyDate');//search scheduled tasks details
Route::get('/searchsched','ScheduleController@viewSchedule');//view schedules
Route::get('/get_item_code','ScheduleController@getItemCodes');//get ordered item qty for task allocation
Route::get('/getSelected_Item_Total','ScheduleController@getItemTotal');//get unallocated qty of items
Route::get('/getAttendedCount','ScheduleController@getAttendedEmpCount');//get count of total attendance for the day
Route::get('/getids_unallocated','ScheduleController@getUnallocated_Emp');//get ids of unallocated emplpoyees
Route::post('/allocateemp','ScheduleController@allocateEmp');//allocate emp
Route::post('/changetaskstatus','ScheduleController@finishEmpAllocation');//change status of task from pending to allocated
Route::get('/getTasksBydate','ScheduleController@showAlltasksByDate');//search tasks by date
Route::get('/searchtask_byId','ScheduleController@viewAllocatedTask');//get allocated task details
Route::get('/showtaskemp','ScheduleController@showTaskEmployees');//get allocated employee list for task
Route::get('/getitemsizes','ScheduleController@displayTaskSizes');//get item sizes for task
Route::post('/updatetask','ScheduleController@updateTaskCompletion');//update task completion
Route::get('/checkTaskCompletion','ScheduleController@getTaskQtyCompleted');//check comlpleted qty by employees
Route::post('/changeState_completed','ScheduleController@changeTaskState_Completed');//change task state from allocated to completed
Route::get('/checkSchedCompletion','ScheduleController@getSchedsCompleted');// check states of schedule
Route::post('/changeScheduleState','ScheduleController@changeScheduleState_Completed');//change schedule status to completed


//EMPLOYEES
Route::get('employees/addemployee','PageController@getAddemployee');//load addemppage
Route::get('employees/viewemployee','PageController@getViewemployee');//load addemppage
Route::get('employees/updateemployee','PageController@getUpdateemployee');//load update-emppage


Route::post('/addemployee','EmployeeController@addEmployee');//add employee
Route::get('/getId','EmployeeController@getId');//get last emp id
Route::get('/viewallemployees','EmployeeController@viewAllEmployees');//view all emp
Route::get('/searchEmpById','EmployeeController@SearchById');//view all emp
Route::post('/updateemployee','EmployeeController@updateEmployees');//update employee


//ATTENDANCE
Route::get('attendance/recordattendance','PageController@getRecordAttendance');//load record attendance page
Route::get('attendance/viewattendance','PageController@getViewAttendance');//load view attendance page

// Route::get('/viewallemp_forattendance','AttendanceController@viewEmpList_attendance');//display all emp list
Route::get('/viewallemp_forattendance','AttendanceController@viewEmpList_attendance');
Route::post('/recordattendance','AttendanceController@recordAttendance');//record attendance
Route::get('/viewunmarked','AttendanceController@viewUnmarkedEmpList');//display unmarked emp list
Route::get('/viewAttendance','AttendanceController@viewAttendance');//display all attendance

//REPORTS
Route::get('reports/attendanceReports','PageController@getReportsAttendance');//load reports attendance page
Route::get('getAllattendancereport','ReportController@get_AttendanceRecords');//load reports attendance
Route::post('reports/showpdf','ReportController@showPDF');//print to pdf

Route::get('/getAllordersreport','ReportController@getAllOrders');//load reports of orders page
Route::get('reports/ordersReports','PageController@getReportsOrders');//load reports oredrs


Route::get('/getCalendarData','ScheduleController@getcalendar');


