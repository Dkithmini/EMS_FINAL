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

//dashboard
Route::get('dashboard/managerdashboard','PageController@getManagerDashboard');
Route::get('/managerdash_allshedules','ScheduleController@ViewAllSchedules');
Route::get('/managerdash_allTasks','ScheduleController@showAllTasks');

//orders

Route::get('orders/addorder','PageController@getAddorder');//load addorderpage
Route::get('orders/vieworder','PageController@getVieworder');//load vieworderpage

Route::get('/getLastId','OrderController@getLastId');//get last order id
Route::get('/getsysdate','OrderController@getSysDate');//get system date
Route::get('/getItemDetails','OrderController@getItemDetails');//get item details
Route::post('/add_order','OrderController@addOrder');//add order
Route::post('/addorderedsizes','OrderController@addItemSizes');//add ordered itemsizes

Route::get('orders/vieworder','OrderController@ViewAllOrders');//display all orders
Route::get('/searchOrderById','OrderController@SearchById');//search order by id
Route::get('/displaydetails','OrderController@displayOrderItems');//display item details
Route::get('/displaysizes','OrderController@displayItemSizes');//display item sizes

//schedules
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
Route::get('/searchschedulebyid','ScheduleController@searchSchedulebyId');//search scheduled tasks details
Route::get('/searchschedulebydate','ScheduleController@searchSchedulebyDate');//search scheduled tasks details
Route::get('/searchsched','ScheduleController@viewSchedule');//view schedules
Route::get('/checkqty','ScheduleController@getItemQty');//get ordered item qty for task allocation
Route::get('/getids','ScheduleController@getComboboxData_Emp');//get emp ids
Route::post('/allocateemp','ScheduleController@allocateEmp');//allocate emp
Route::post('/changetaskstatus','ScheduleController@finishEmpAllocation');//change status of task from pending to allocated
Route::get('/searchtask','ScheduleController@viewAllocatedTask');//get allocated task details
Route::get('/showtaskemp','ScheduleController@showTaskEmployees');//get allocated emp
Route::get('/getitemsizes','ScheduleController@displayTaskSizes');//get item sizes for task
Route::post('/updatetask','ScheduleController@updateTaskCompletion');//update task completion

//employees
Route::get('employees/addemployee','PageController@getAddemployee');//load addemppage
Route::get('employees/viewemployee','PageController@getViewemployee');//load addemppage
Route::get('employees/updateemployee','PageController@getUpdateemployee');//load update-emppage


Route::post('/addemployee','EmployeeController@addEmployee');//add employee
Route::get('/getId','EmployeeController@getId');//get last emp id
Route::get('/viewallemployees','EmployeeController@viewAllEmployees');//view all emp
Route::get('/searchEmpById','EmployeeController@SearchById');//view all emp
Route::post('/updateemployee','EmployeeController@updateEmployees');//update employee


//attendance
Route::get('attendance/recordattendance','PageController@getRecordAttendance');//load record attendance page
Route::get('attendance/viewattendance','PageController@getViewAttendance');//load view attendance page

Route::get('attendance/viewallemp','AttendanceController@viewEmpList');//display all emp list
Route::post('/recordattendance','AttendanceController@recordAttendance');//record attendance
Route::get('/viewunmarked','AttendanceController@viewUnmarkedEmpList');//display unmarked emp list
Route::get('/viewAttendance','AttendanceController@viewAttendance');//display all attendance

