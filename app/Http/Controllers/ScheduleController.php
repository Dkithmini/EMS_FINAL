<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    //search order details for add schedule
    public function searchOrder(Request $req){
        if($req->ajax()){
            $query=$req->get('searchid');

            if($query!=''){
                
                $check_oreder=DB::table('placed_orders')->where('Order_Id','=',$query)->exists();

                if($check_oreder===true){
                    $check_sched=DB::table('schedules')->where('Order_Id','=',$query)->exists();

                    if($check_sched==true){
                        return response()->json(['value'=>1,'message'=>'Order Already Scheduled..!']);
                    }
                    else   
                    {
                        $data=DB::table('placed_orders')
                            ->where('Order_Id','like','%'.$query.'%')
                            ->get();
                        return response()->json(['value'=>2,'message'=>'Order Unscheduled!','data'=>$data]);
                            // echo json_encode($data);
                    }
                }
               
                else
                {
                    return response()->json(['value'=>3,'message'=>'Order Not Available..!']);
                }
                    
            } else{
                return response()->json(['value'=>4,'message'=>'Ajax Error..!']);
            }  
        } 
        
    }

   
    //display ordered item details for add schedule
    public function displayOrderItems(Request $details){
        if($details->ajax()){
            $output2="";
            $itemdetails=$details->get('search_id');

            if($itemdetails!=''){
                $itemdata=DB::table('ordered_items')
                ->where('Order_Id','like','%'.$itemdetails.'%')
                ->get();
                return response()->json(['data'=>$itemdata]);
                // echo json_encode($itemdata);
            }  
        }
    }

    //last shed id
    public function getLastShedId(){
        $row=DB::table('schedules')->orderBy('Schedule_Id', 'DESC')->first();
        $lastshed=$row;
        
        return response()->json(['data'=>$lastshed]);
        // echo json_encode($lastshed);

    }

     //add schedule
    public function addSchedule(Request $request){
        $orderid=$request->input('id2');
        $id=$request->input('txtSchedId');
        $start_date=$request->input('txtSched_Start');
        $end_date=$request->input('txtSched_End');
            
        $data=array('Schedule_Id'=>$id,'Order_Id'=>$orderid,'Start_Date'=>$start_date,'End_Date'=>$end_date,'Status'=>'created');

        DB::table('schedules')->insert($data);
        // echo "successfully added to shedule";
            
        
    }

    //last task id
     public function getLastTaskId(){
        $row=DB::table('daily_tasks')->orderBy('Task_Id', 'DESC')->first();
        $lastId=$row;
        return response()->json(['data'=>$lastId]);
        // echo json_encode($lastId);

    }

    public function checkQty(Request $req){
        $temp=$req->get('searchShed');
        $code_selected=$req->get('selected_itemCode');

        $row=DB::table('daily_tasks')
                ->where('Schedule_Id','like','%'.$temp.'%')
                ->where('Item_Code','like','%'.$code_selected.'%')
                ->get();
       
        return response()->json(['data'=>$row]);
        // echo json_encode($lastId);

    }

    // get items codes for selected order to be scheduled
    public function getItemCodes(Request $taskid){
        if($taskid->ajax()){
            $req=$taskid->get('taskid');
            if($req!=''){
                $data=DB::table('schedules')
                        ->join('daily_tasks','schedules.Schedule_Id','=','daily_tasks.Schedule_Id')
                        ->where('Task_Id','like','%'.$req.'%')
                        ->join('ordered_items','schedules.Order_Id','=','ordered_items.Order_Id')
                        ->select('ordered_items.Item_Code')
                        ->get();
                
                    return response()->json(['data'=>$data]);    
                
             }
        }

    }

    // get total qty for items of selected order to be scheduled
    public function getItemTotal(Request $request){
        if($request->ajax()){
            $req_sched=$request->get('ScheduleId');
            $req_itemCode=$request->get('ItemId');
            
            $data=DB::table('schedules')
                    ->join('ordered_items','schedules.Order_Id','=','ordered_items.Order_Id')
                    ->where('Schedule_Id','like','%'.$req_sched.'%')
                    ->select('ordered_items.Total_Qty')
                    ->where('Item_Code','like','%'.$req_itemCode.'%')
                    ->get();
                
                    return response()->json(['data'=>$data]);    
                
             
        }
    }

     //add tasks for schedule
    public function addTask(Request $req2){
        $shed_Id=$req2->input('s_id');
        $task_id=$req2->input('txtTaskId');
        $date=$req2->input('dateTask');
        $item_code=$req2->input('Itemselect');
        $section=$req2->input('Section');
        $time=$req2->input('Timeslot');
        $qty=$req2->input('taskQty');
        $status="pending";

        $data=array('Schedule_Id'=>$shed_Id,'Task_Id'=>$task_id,'Date'=>$date,'Time_Slot'=>$time,'Section'=>$section,'Item_Code'=>$item_code,'Qty'=>$qty,'Status'=>$status);

        DB::table('daily_tasks')->insert($data);

        $data=$task_id+1;
        return response()->json(['data'=>$data]);
        // echo "successfully added to shedule";
    }


    //view schedule details
    public function viewSchedule(Request $req){
        if($req->ajax()){
            $shed=$req->get('searchid');
            if($shed!=''){
                $data=DB::table('schedules')
                ->where('Schedule_Id','like','%'.$shed.'%')
                ->get();
               return response()->json(['data'=>$data]);
                // echo json_encode($data);
            }    
        } 
    }

     public function dashboardContent(){
        $shed_data=DB::table('schedules')->where('Status','=','created')->count();
        $allTasks=DB::table('daily_tasks')->where('Status','=','pending')->count();
        $completedTasks=DB::table('daily_tasks')->where('Status','=','Completed')->count();
        
       $responseArr=array($shed_data,$allTasks,$completedTasks);
       return response()->json(['data'=>$responseArr]); 
       
    }

    public function getAttendanceSummary(){
        $date_today=Carbon::today();    //get system date

        $allEmpCount=DB::table('employee')->count();
        $presentCount=DB::table('attendance')->where('Date','like','%'.$date_today.'%')->where('Status','=','present')->count();
        $absentCount=($allEmpCount-$presentCount);

        $return_Arr=array($allEmpCount,$presentCount,$absentCount);
        return response()->json(['data'=>$return_Arr]);
    }

    public function getWorkSummary(){
        $date_today=Carbon::today();        //get system date

        $alltaskCount=DB::table('daily_tasks')->where('Date','like','%'.$date_today.'%')->count();
        $allocatedtaskCount=DB::table('daily_tasks')->where('Date','like','%'.$date_today.'%')->where('Status','=','allocated')->count();
        $completedtaskCount=DB::table('daily_tasks')->where('Date','like','%'.$date_today.'%')->where('Status','=','Completed')->count();
        $dueOrders=DB::table('placed_orders')->where('Due_Date','like','%'.$date_today.'%')->count();

        $return_Arr=array($allocatedtaskCount,$allocatedtaskCount,$completedtaskCount,$dueOrders);
        return response()->json(['data'=>$return_Arr]);
    }
   

    //search scheduled tasks details by id(view sched)
    public function searchSchedulebyId(Request $shed){
        if($shed->ajax()){
            $tasks=$shed->get('searchid');
            if($tasks!=''){
                $data=DB::table('daily_tasks')
                        ->where('Schedule_Id','like','%'.$tasks.'%')
                        ->get();
                  return response()->json(['data'=>$data]);  
                // echo json_encode($data);
             }
        }

    }

    //search scheduled tasks details by date(task allocation)
    public function searchSchedulebyDate(Request $shed2){
        if($shed2->ajax()){
            $tasks=$shed2->get('task_date');
            if($tasks!=''){
                $data=DB::table('daily_tasks')
                        ->where('Date','like','%'.$tasks.'%')
                        ->get();
                    
                echo json_encode($data);
             }
        }

    }

    //get all employee ids unallocated
    public function getUnallocated_Emp(Request $select_emp){
         if($select_emp->ajax()){
            $check_date=$select_emp->get('task_date');
            $check_time=$select_emp->get('timeslot');
            $state='allocated';
            $x;

            if($check_time==='morning' || $check_time==='morning1'){
                $check_emp=DB::table('daily_tasks')
                            ->where('Date','like','%'.$check_date.'%')
                            ->where('Time_Slot','=','morning1')
                            ->orwhere('Time_Slot','=','morning')
                            ->where('Status','like','%'.$state.'%')
                            ->join('employee_allocation','employee_allocation.Task_Id','=','daily_tasks.Task_Id')
                            ->pluck('employee_allocation.Emp_Id');
                    $x=json_decode($check_emp,true);
            }        

            else if($check_time==='evening' || $check_time==='evening1'){
                 $check_emp=DB::table('daily_tasks')
                            ->where('Date','like','%'.$check_date.'%')
                            ->where('Time_Slot','=','evening1')
                            ->orwhere('Time_Slot','=','evening')
                            ->where('Status','like','%'.$state.'%')
                            ->join('employee_allocation','employee_allocation.Task_Id','=','daily_tasks.Task_Id')
                            ->pluck('employee_allocation.Emp_Id');
                    $x=json_decode($check_emp,true);
            }

            else{
                 $check_emp=DB::table('daily_tasks')
                            ->where('Date','like','%'.$check_date.'%')
                            ->where('Time_Slot','like','%'.$check_time.'%')
                            ->where('Status','like','%'.$state.'%')
                            ->join('employee_allocation','employee_allocation.Task_Id','=','daily_tasks.Task_Id')
                            ->pluck('employee_allocation.Emp_Id');
                    $x=json_decode($check_emp,true);
            }

             $attended_employees=DB::table('attendance')
                        ->where('Date','like','%'.$check_date.'%')
                        ->where('Status','present')
                        ->pluck('Emp_Id');
                     $y=json_decode($attended_employees,true);   

                $result=array_values(array_diff($y,$x));

                echo json_encode($result);
                
        }
    }

    //emp allocation
    public function allocateEmp(Request $allocate){

            $task_id=$allocate->get('taskid_toAllocate');
            $emp_id=$allocate->get('empid_toAllocate');
            $task_item=$allocate->get('task_Item');

            $targetqty=$allocate->get('emp_TargetQty');

            $data=array('Emp_Id'=>$emp_id,'Task_Id'=>$task_id,'Item_Code'=>$task_item,'Target_Qty'=>$targetqty);

            DB::table('employee_allocation')->insert($data);

            $update_status=DB::table('daily_tasks') 
                    ->where('Task_Id', $task_id) 
                    ->limit(1) 
                    ->update(['Status' => "allocated"]);
           // echo json_encode($data);
            return response()->json(['message'=>'Emplloyee Allocated for the Task','data'=>$data]);
    }

    //get count of all attended employees for the date
    public function getAttendedEmpCount(Request $request){
       if($request->ajax()){
            $req_date=$request->get('');
            $state_present='present';
            
            $data=DB::table('attendance')
                    ->where('Date','like','%'.$req_date.'%')
                    ->where('Status','like','%'.$state_present.'%')
                    ->pluck('attendance.Emp_Id');
                
            return response()->json(['data'=>$data]);                
        } 
    }


    //search task 
    function viewAllocatedTask(Request $task){
        if($task->ajax()){
            $req=$task->get('searchid');
            if($req!=''){
                $data=DB::table('daily_tasks')
                        ->where('Task_Id','like','%'.$req.'%')
                        ->get();
                
                return response()->json(['data'=>$data]);
                    // echo json_encode($data);
            }

            else{
                return response()->json(['message'=>'Ajax Error']);
            }  
                
        }
    }
    

    //show allocated employees for tasks
    public function showTaskEmployees(Request $emps){
        if($emps->ajax()){
            $req=$emps->get('searchid');
            if($req!=''){
                $data=DB::table('employee_allocation')
                        ->join('employee','employee_allocation.Emp_Id','=','employee.Emp_Id')
                        ->select('employee_allocation.Emp_Id','employee.Emp_Name','employee_allocation.Target_Qty','employee_allocation.Completed_Qty')
                        ->where('Task_Id','like','%'.$req.'%')
                        ->get();
                    
                echo json_encode($data);
             }
        }
    }

    // public function finishEmpAllocation(Request $finished){
    //     $req=$finished->get('taskid');
    //     $update_status=DB::table('daily_tasks') 
    //                 ->where('Task_Id', $req) 
    //                 ->limit(1) 
    //                 ->update(['Status' => "allocated"]);
        
        
    // }

    public function displayTaskSizes(Request $req2){
        if($req2->ajax()){
            $Search_Id=$req2->get('searchid_task_sizes');
            if($Search_Id!=''){
                $itemsizes=DB::table('schedules')
                        ->join('daily_tasks','schedules.Schedule_Id','=','daily_tasks.Schedule_Id')
                        ->join('ordered_sizes','schedules.Order_Id','=','ordered_sizes.Order_Id')
                        ->select('ordered_sizes.Item_Code','ordered_sizes.Size','ordered_sizes.Qty')
                        ->where('Task_Id','like','%'.$Search_Id.'%')
                        ->get();
                    
                echo json_encode($itemsizes);
             }
        }
    }

    //update task completion by employees
    public function updateTaskCompletion(Request $update_Task){
        if($update_Task !=''){
            $emp_Id=$update_Task->input('txteid');
            $t_id=$update_Task->input('txtTaskid2');
            $Completed_Qty_Update=$update_Task->input('txtcompleted_qty');
            

            $updated_task=DB::table('employee_allocation') 
                    ->where('Task_Id', $t_id) 
                    ->where('Emp_Id',$emp_Id)
                    ->limit(1) 
                    ->update([ 'Completed_Qty' => $Completed_Qty_Update ]);
            
        }
    
        
    }

    public function getTaskQtyCompleted(Request $request){
         if($request->ajax()){
            $Taskid=$request->get('taskId');

            if($Taskid!=''){
               $data=DB::table('daily_tasks')
                        ->join('employee_allocation','daily_tasks.Task_Id','=','employee_allocation.Task_Id')
                        ->select('daily_tasks.Qty','employee_allocation.Completed_Qty')
                        ->where('employee_allocation.Task_Id','like','%'.$Taskid.'%')
                        ->get();
                       
                    
                return response()->json(['data'=>$data]);
             }
        }
    }

    public function showAlltasksByDate(Request $request){
        if($request->ajax()){
            $date_to_Search=$request->get('dateToSearch');
           
            if($date_to_Search!=''){
                $data=DB::table('daily_tasks')
                            ->where('Date','like','%'.$date_to_Search.'%')
                            ->get();

                return response()->json(['data'=>$data]);    
            }
        }
    }

    public function changeTaskState_Completed(Request $request){
        if($request->ajax()){
            $taskCompleted=$request->get('task_to_Update');
            $state_ofTask='Completed';

            if($taskCompleted!=''){
                $updated_state=DB::table('daily_tasks') 
                    ->where('Task_Id', $taskCompleted) 
                    ->limit(1) 
                    ->update([ 'Status' => $state_ofTask]);

                return response()->json(['message'=>'Updated Successfully']);    
            }
        }
    }

    
    public function getSchedsCompleted(Request $request){
        if($request->ajax()){
            $sched_ById=$request->get('schedId');
            $state_ofShed='completed';

            if($sched_ById!=''){
                $shed_state_summery=DB::table('daily_tasks') 
                    ->where('Schedule_Id', $sched_ById) 
                    ->pluck('daily_tasks.Status');
                return response()->json(['data'=>$shed_state_summery]);    
            }
        }
    }

    public function changeScheduleState_Completed(Request $request){
        if($request->ajax()){
            $scheduleCompleted=$request->get('schedule_to_Update');
            $schedule_state='completed';

            if($scheduleCompleted!=''){
                $updated_state=DB::table('schedules') 
                    ->where('Schedule_Id', $scheduleCompleted) 
                    ->limit(1) 
                    ->update([ 'Status' => $schedule_state]);

                return response()->json(['message'=>'Updated Successfully']);    
            }
        }
    }
}
