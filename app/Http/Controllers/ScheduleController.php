<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
            
        $data=array('Schedule_Id'=>$id,'Order_Id'=>$orderid,'Start_Date'=>$start_date,'End_Date'=>$end_date);

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

    //view all schedules
    public function ViewAllSchedules(){
        $display="";
        $shed_data=DB::table('schedules')->get();
        foreach ($shed_data as $result) {
            $display.='<tr>'.
                    '<td>'.$result->Schedule_Id.'</td>'.
                    '<td>'.$result->Order_Id.'</td>'.
                    '<td>'.$result->Start_Date.'</td>'.
                    '<td>'.$result->End_Date.'</td>'.
                    '</tr>';
                }
        return Response($display);        
       
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
    public function getComboboxData_Emp(Request $select_emp){
         if($select_emp->ajax()){
            $check_date=$select_emp->get('task_date');
            $check_time=$select_emp->get('timeslot');
            $state='allocated';

                 $check_emp=DB::table('employee_allocation')
                            ->join('daily_tasks','employee_allocation.Task_Id','=','daily_tasks.Task_Id')
                            
                            ->where('Date','like','%'.$check_date.'%')
                            ->where('Time_Slot','like','%'.$check_time.'%')
                            ->where('Status','like','%'.$state.'%')
                            ->pluck('employee_allocation.Emp_Id');
                    $x=json_decode($check_emp,true);


                $attended_employees=DB::table('attendance')
                        ->where('Date','like','%'.$check_date.'%')
                        ->where('Status','present')
                        ->pluck('Emp_Id');
                     $y=json_decode($attended_employees,true);   

                $result=array_diff($y, $x);

                // $array_ids = array_map(function ($array) {return $array['Emp_Id'];}, $data);
                // $result = DB::table('employee')
                //         ->whereIn('Emp_Id',$array_ids)
                //         ->select('Emp_Name')
                //         ->get();  
                echo json_encode($result);
             
        }
    }

    //emp allocation
    public function allocateEmp(Request $allocate){

            $task_id=$allocate->input('txtTaskid');
            $emp_id=$allocate->input('txtemplist');
            $targetqty=$allocate->input('txttarget');

            $data=array('Emp_Id'=>$emp_id,'Task_Id'=>$task_id,'Target_Qty'=>$targetqty);

            DB::table('employee_allocation')->insert($data);
           echo json_encode($data);
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

    public function finishEmpAllocation(Request $finished){
        $req=$finished->get('taskid');
         $update_status=DB::table('daily_tasks') 
                    ->where('Task_Id', $req) 
                    ->limit(1) 
                    ->update(['Status' => "allocated"]);
        
        
    }

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

    public function showAllTasks(){
        $allTasks=DB::table('daily_tasks')
                    ->where('Status','=','allocated')
                    ->get();
        return response()->json(['data'=>$allTasks]);
    }   

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
}
