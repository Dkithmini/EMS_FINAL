@extends('SupervisorHome')

@section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/viewtask.css') }}">
   
<!--  Task details panel -->
   <div class="panel">
        <div class="panel-body" >
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Task Details</h5>
                        <form id="frmtaskdetails">
                            <label>Task Id</label><input type="text" name="txtTaskid" id="taskid">
                            <button id="searchtaskbyid" type="button" class="btn-basic">Search</button><br>
                            <label>Date</label><input type="text" name="dtDate" id="Tdate" readonly=""><br>
                            <label>Section</label><input type="text" name="txtSec" id="Tsec" readonly=""><br>
                            <label>Time Slot</label><input type="text" name="txtTime" id="Tslot" readonly=""><br>
                            <label>Item Code</label><input type="text" name="txtItem" id="Icode" readonly=""><br>
                            <label>Qty</label><input type="number" name="txtQuantity" id="Tqty" readonly=""><br>
                            <label>Status</label><input type="text" name="txtStatus" id="Tstatus" readonly=""><br>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <h5>Task Summery</h5>
                        <label>Date</label><input type="date" name="txtSearchTaskByDate" id="SearchTaskByDate">
                        <button type="button" id="btnsearchTaskSummery">Search</button>
                        <br><br>

                            <table class="table table-striped table-responsive" style="max-height: 150px;">
                            <thead>
                                <tr>
                                    <td>Schedule Id</td>
                                    <td>Task Id</td>
                                    <td>Section</td>
                                    <td>Time Slot</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody id="tbody1">
                                        
                            </tbody>
                        </table>
                       
                        
                    </div>
                </div>  
            </div>
        </div>
    </div>
<!-- End of task details panel -->

<!-- Allocated emp summary table panel -->
    <div class="panel">
        <div class="panel-body">
            <div class="col-md-12">
                <h5>Employee Allocation</h5>
                <br>
                <div id="tbldiv">
                <table class="table  table-condensed">
                    <thead>
                        <tr>
                            <td>Emp Id</td>
                            <td>Emp Name</td>
                            <td>Target Qty</td>
                            <td>Finished Qty</td>
                        </tr>
                    </thead>
                    <tbody id="tbody2">
                                
                    </tbody>
                </table>
                </div>
                
                <label>No Of Employees</label><input type="text" name="txtempcount" id="Emp_count" readonly="">
            </div>
        </div>
    </div>
<!-- End of Allocated emp summary table panel -->

    <script type="text/javascript">
        //search task
        $(document).ready(function(){
            $('#searchtaskbyid').click(function(){
                var tid=$('#taskid').val();
                searchTask(tid);
                getTaskEmployees(tid);
            });
        });

        //display search task results
        function searchTask(searchid=''){
            $.ajax({
                url:'/searchtask_byId',
                type:'get',
                data:{'searchid':searchid},
                    // datatype:'json',
                success:function(response){
                    // console.log(data);
                    var result=response.data;
                    // console.log(result);
                    if(!result.length){
                        // alert('Task Not Found..!');
                        window.popWindow.dialog("Selected Task Not Found..!","error");
                        
                        $('#frmtaskdetails').trigger("reset");
                        $('#Emp_count').val('');
                    }   
                    else{

                        var task_Id=result[0].Task_Id;
                        var date=result[0].Date;
                        var itemcode=result[0].Item_Code;
                        var section=result[0].Section;
                        var time=result[0].Time_Slot;
                        var qty=result[0].Qty;
                        var status=result[0].Status;      

                        $('#Tdate').val(date);
                        $('#Tsec').val(section);
                        $('#Tslot').val(time);
                        $('#Icode').val(itemcode);
                        $('#Tqty').val(qty);
                        $('#Tstatus').val(status);

                    }       
                    
                }       
            });
        }

        //get emp list
        function getTaskEmployees(searchid=''){
            $.ajax({
                url:'/showtaskemp',
                type:'get',
                data:{'searchid':searchid},
                
                success:function(data){
                    var showdata='';
                    // console.log(data);
                    var result=JSON.parse(data);
                    // // console.log(result);
                    
                    if(!result.length){
                            document.getElementById("tbody1").innerHTML=showdata;
                            $('#tbldiv').hide();
                            $('#Emp_count').val('');
                    }
                    else{
                        $('#tbldiv').show();
                        for(i=0;i<result.length;i++){
                        // var sid=result[i].Schedule_Id;
                        var emp_Id=result[i].Emp_Id;
                        var empname=result[i].Emp_Name;
                        var targetqty=result[i].Target_Qty;  
                        var finishedqty=result[i].Completed_Qty;
                        var emp_count=(i+1); 

                        showdata +="<tr>";
                        showdata +="<td>"+emp_Id+"</td><td>"+empname+"</td><td>"+targetqty+"</td><td>"+finishedqty+"</td>";
                        showdata +="</tr>";
                        document.getElementById("tbody2").innerHTML=showdata;
                        $('#Emp_count').val(emp_count);
                        }
                    }

                    
                }       
            });
        }

        $('#btnsearchTaskSummery').click(function(){
            var dateToSearch=$('#SearchTaskByDate').val();
            searchTaskSummery(dateToSearch);
        });

        // search task summary
        function searchTaskSummery(dateToSearch=''){
            
            $.ajax({
                url:'/getTasksBydate',
                headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                method:'get',
                data:{'dateToSearch':dateToSearch},
                    
                success:function(response){
                    // console.log(response.data);
                    var showtasks='';
                    
                    var result=response.data;
                    // console.log(result);
                              
                    for(i=0;i<result.length;i++){
                        var sid=result[i].Schedule_Id;
                        var task_Id=result[i].Task_Id;
                        var sec=result[i].Section;
                        var tslot=result[i].Time_Slot;
                        var task_status=result[i].Status;     

                        showtasks +="<tr>";
                        showtasks +="<td>"+sid+"</td><td>"+task_Id+"</td><td>"+sec+"</td><td>"+tslot+"</td><td>"+task_status+"</td>";
                        showtasks +="</tr>";
                        document.getElementById("tbody1").innerHTML=showtasks;
                    }
                        
                }
            });
        }
        
    </script>
 
@endsection