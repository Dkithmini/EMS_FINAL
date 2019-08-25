@extends('SupervisorHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/scheduletask.css') }}">
    <div class="panel">
        <div class="panel-body">
            <h5>Task Details</h5>
            <form id="frmsearch">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label>Date</label><input type="date" name="txtscheddate" id="sched_date">
                <button type="button" id="btntaskallocation_search">Search</button>
                <br><br>
            </form>
            
            <div class="row">
                <div class="col-md-12" style="max-height: 180px;overflow-y: scroll;">
                    <table class=" table table-condensed" >
                        <thead>
                            <tr>
                                <th>Schedule Id</th>
                                <th>Task Id</th>
                                <th>Date</th>
                                <th>Section</th>
                                <th>Time Slot</th>
                                <th>Item Code</th>
                                <th>Quantity</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            <div class="row">
                
                <div class="col-md-12">
                    <h5>Allocate Employees</h5>

                    <form id="frmemp_allocation">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label>Task Id</label><input type="text" name="txtTaskid" id="tid" readonly="">
                        <input type="text" name="txtSid" id="shed" hidden="">
                        <label>Section</label><input type="text" name="txtsec" id="section_name" readonly="">
                        <label>Time Slot</label><input type="text" name="txttime" id="time_slot" readonly="" >
                        <label>Item Code</label><input type="text" name="txtitem" id="code" readonly="" >
                        <label>Task Qty </label><input type="number" name="txtQty" id="quanty" readonly="">
                        <label>Suggested Allocation</label><input type="text" name="txtNo_employees" id="no_of_emp" readonly="">
                        <label>Employees</label><input type="number" name="emps_count" id="emps_count">
                        <label>Target Qty</label><input type="number" name="txt_target" id="emp_targetQty">
                        <br><br>     
                    </form>  
                </div>

                <div class="col-md-12">
                    
                    <div class="row">
                        <div class="col-md-4" style="max-height: 180px;overflow-y: scroll;">
                          
                            <table class="table table-striped table-md" id="tblemps">
                                <thead>
                                    <tr>
                                        <th>Emp Id</th>
                                        <th>Action Needed</th>
                                    </tr>
                                </thead>
                                <tbody id="empList">
                                    
                                </tbody>
                            </table>
                        </div> 
                        <div class="col-md-4" style="max-height: 180px;">
                           <table class="table table-striped" >
                                <thead>
                                    <tr>
                                        <td>Emp Id</td>
                                        <td>Target Qty</td>
                                    </tr>
                                </thead>
                                <tbody id="tbody2">
                                            
                                </tbody>
                            </table> 
                                
                        </div>
                        <div class="col-md-4" style="max-height: 180px;">
                            <label style="width: 200px;text-align: left;">Total Attended</label><input type="text" id="emp_attended" style="width: 80px;" readonly=""><br>
                            <label style="width: 200px;text-align: left;">Unallocated Employees</label><input type="text" id="emp_free" style="width: 80px;" readonly="">
                            <label style="width: 200px;text-align: left;">Count</label><input type="text" name="txtCountAllocated_SelectedTask" style="width: 80px;" id="allocatedCount" readonly="">
                            <br><br> 
            
                            <!-- <button class="btn btn-info" type="button" id="btnAllocate">Add</button> -->
                            <button class="btn btn-info" type="button" id="btnfinish" disabled="">Finish</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        
        //search schedule
        $('#btntaskallocation_search').click(function(){
            var task_date=$('#sched_date').val();
            viewScheduleTasks(task_date);
            getAllAttendedCount(task_date);
            
        });
        
        //display schedule
        function viewScheduleTasks(task_date=''){
            $.ajax({
                url:'/searchschedulebydate',
                type:'get',
                data:{'task_date':task_date},
                    
                success:function(data){
                    var showdata='';
                    // console.log(data);
                    var result=JSON.parse(data);
                    // console.log(result);
                              
                    for(i=0;i<result.length;i++){
                        var sid=result[i].Schedule_Id;
                        var task_Id=result[i].Task_Id;
                        var date=result[i].Date;
                        var itemcode=result[i].Item_Code;
                        var section=result[i].Section;
                        var time=result[i].Time_Slot;
                        var qty=result[i].Qty;
                        var task_status=result[i].Status;     

                        showdata +="<tr>";
                        showdata +="<td>"+sid+"</td><td>"+task_Id+"</td><td>"+date+"</td><td>"+section+"</td><td>"+time+"<td>"+itemcode+"</td><td>"+qty+"</td>";
                        
                        if(task_status==="pending"){
                            showdata +="<td><button type='button' id='btntableselect' class='btn btn-success btn-sm'>select</td>";
                        }
                        else
                            showdata +="<td><button type='button' id='btntableselect' class='btn btn-success btn-sm' disabled=''>select</td>";
                        showdata +="</tr>";
                        document.getElementById("tbody1").innerHTML=showdata;
                    }

                }       
            });
        }

        //get count of all employees present
        function getAllAttendedCount(task_date=''){
                
                 $.ajax({
                    url:'/getAttendedCount',
                    method:'get',
                    data:{'date_toSearch':task_date},

                    success:function(response){
                        var result=response.data;
                        console.log(result.length);
                        // $('#emp_attended').val(result.length);
                    }
                });
            }


        //select task to allocate employees
        $(document).on("click", ".btn-success", function(){

            var $row = $(this).closest("tr"),       // Finds the closest row <tr> 
            $tds = $row.find("td");  
            // console.log($tds);           // Finds all children <td> elements
            var shed_id=($($tds[0]).text());
            var taskid=($($tds[1]).text()); 
            var date=($($tds[2]).text());
            var sec=($($tds[3]).text());
            var time=($($tds[4]).text());
            var item_selected=($($tds[5]).text());
            var qty=($($tds[6]).text());
            
            $('#tid').val(taskid);
            $('#shed').val(shed_id);
            $('#section_name').val(sec);
            $('#time_slot').val(time);
            $('#code').val(item_selected);
            $('#quanty').val(qty);
            $('#no_of_emp').val('');
            $('#emps_count').val('');
            $('#emp_targetQty').val('');


            getUnallocatedEmployeeList();
            show_Suggested_Emps();
            // getItemCodes(taskid);

        });
    
        //get all ids of unallocated emps 
        function getUnallocatedEmployeeList(task_date=''){
            var task_date=$('#sched_date').val();
            var timeslot=$('#time_slot').val();
                

            $.ajax({
                url:'/getids_unallocated',
                type:'get',
                data:{'task_date':task_date,'timeslot':timeslot},

                success:function(result){
                    var result_emp=JSON.parse(result);
                    var appnd='';
                    var count=0;

                    for(i=0;i<result_emp.length;i++){
                        var show_id=result_emp[i];
                        count=i;
                        // appnd=$('<li class="list-group-item">&emsp;<label for="' + show + '"></label>&emsp;'+'<input class="checkid" type="checkbox" name="' + show + '" id="' + show + '" value="'+show+'"></li>');
                        //  appnd.find('label').text(show);
                        // $('#selectemp').append(appnd);
                        
                        appnd +="<tr>";
                        appnd +="<td>"+show_id+"</td><td><button class='selectEmployee'><i class='far fa-plus-square'></i></button><button><i class='fas fa-trash-alt'></i></button></td>";
                        appnd +="</tr>";
                        document.getElementById("empList").innerHTML=appnd;

                    }
                    $('#emp_free').val(count+1);
                                
                    console.log(result);
                }       
            });
        }

        //calculate suggested employee count for the task
        function show_Suggested_Emps(){
            var section_Task=$('#section_name').val();
            var target_Qty=$('#quanty').val();
            var emps_Available=$('#emp_attended').val();
            var time_Slot_selected=$('#time_slot').val();
            var suggested_Emp_Count=0;

            if(time_Slot_selected==='morning' || time_Slot_selected==='evening'){
                if(section_Task==='cuttingSec'){
                suggested_Emp_Count=Math.round((target_Qty/50)/4);
                }

                if(section_Task==='sewingSec'){
                    suggested_Emp_Count=Math.round((target_Qty/3)/4);
                }

                if(section_Task==='finishingSec'){
                    suggested_Emp_Count=Math.round((target_Qty/5)/4);
                } 
            }
            else{
                if(section_Task==='cuttingSec'){
                suggested_Emp_Count=Math.round((target_Qty/50)/2);
                }

                if(section_Task==='sewingSec'){
                    suggested_Emp_Count=Math.round((target_Qty/3)/2);
                }

                if(section_Task==='finishingSec'){
                    suggested_Emp_Count=Math.round((target_Qty/5)/2);
                } 
            }

            $('#no_of_emp').val(suggested_Emp_Count+'  emps.' );   //display suggested employee count
        }

        //remove newly allocated emps from checkbox list
        // $("#btnallocate_emp").click(function(event){
        //     event.preventDefault();
        //     var IDs = $(".checkid:checked").map(function(){
        //     return $(this).val();
        //     }).toArray();
        //     console.log(IDs);
        //     $(".checkid:checked").remove();


        // });

        
        
        //allocate selected employee for task
       $(document).on("click", ".selectEmployee", function(){
           var $row = $(this).closest("tr"),       // Finds the closest row <tr> 
            $tds = $row.find("td"); 
            var empid_toAllocate=($($tds[0]).text());  //get the value of id column
            var taskid_toAllocate=$('#tid').val();
            var task_Item=$('#code').val();
            var emp_TargetQty=$('#emp_targetQty').val();
            $(this).closest("tr").remove();

           
            $.ajax({
                url:'/allocateemp',
                headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                type:'post',
                data: {'empid_toAllocate':empid_toAllocate,'taskid_toAllocate':taskid_toAllocate,'task_Item':task_Item,'emp_TargetQty':emp_TargetQty},
                
                success:function(response){
                    // alert(response.message);
                    
                    var result=response.data;
                    // console.log(result);

                    var showdata='';


                    var empid=result.Emp_Id;
                    var emp_target=result.Target_Qty;

                    showdata +="<tr>";
                    showdata +="<td>"+empid+"</td><td>"+emp_target+"</td>";
                    showdata +="</tr>";
                    document.getElementById("tbody2").innerHTML+=showdata;

                     
                    $('#btnfinish').attr('disabled',false);
                    var allocated_Count=$('#tbody2').find('tr').length;
                    $('#allocatedCount').val(allocated_Count);
                               
                }       
            });
       });


        //change status of task  after emp allocation completed
        $('#btnfinish').click(function(){
            // var taskid=$('#tid').val();
            // $.ajax({
            //     url:'/changetaskstatus',
            //     type:'post',
            //     headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            //     data:{'taskid':taskid},
                
            //     success:function(response){
            //         alert('Employees Allocation Completed..!');
                    
            //         $('#frmemp_allocation').trigger("reset"); 
            //         $("#empList").empty();
            //         $("#tbody2").empty();
            //         $('#allocatedCount').val('');
            //     }       
            // });

            $('#frmemp_allocation').trigger("reset"); 
            $("#empList").empty();
            $("#tbody2").empty();
            $('#allocatedCount').val('');
        })

        // function getItemCodes(taskid=''){
        //     $.ajax({
        //         url:'/get_item_code',
        //         method:'get',
        //         data:{'taskid':taskid},
        //         success:function(response){
        //             var result=response.data;
        //             console.log(result);

        //             $('#items').html($('<option>', {
        //                     value: '',
        //                     text: '--Item--'
        //                 }));

        //             for(i=0;i<result.length;i++){
        //                 var show=result[i].Item_Code;
        //                  $('#items').append($('<option>', {
        //                     value: show,
        //                     text: show
        //                 }));
                      
                        
        //             } 
        //         }
        //     });
        // }

        // $('#items').change(function(){
        //     showQtyItem_Ordered();
        // });

        $('#emps_count').change(function(){
            var No_of_selected_emp=$('#emps_count').val();
            var totQty=$('#quanty').val();

            if(No_of_selected_emp===''){
                $('#emp_targetQty').val('');
            }

            else {
                var amount=Math.round(totQty/No_of_selected_emp);
                $('#emp_targetQty').val(amount);
            }
           
 
        });


        // function showQtyItem_Ordered(){
        //      var sched_Id=$('#shed').val();
        //      var section_chosen=$('#section_name').val();
        //      var item_chosen=$('#items').val();
        //      var reduce_qty=$('#selected_qty').val();

        //      $.ajax({
        //         url:'/check_remainder_itemQty',
        //         method:'get',
        //         data:{'section_chosen':section_chosen,'item_chosen':item_chosen,'sched_Id':sched_Id},

        //         success:function(response){
        //             var result=response.data;
        //             console.log(result);
        //         }
        //     });

        // }

            
    </script>


@endsection