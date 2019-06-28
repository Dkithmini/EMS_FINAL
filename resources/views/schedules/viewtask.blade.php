@extends('SupervisorHome')

@section('show_content')
   <div class="panel">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-7">
                        <h5>Task Details</h5>
                        <form id="frmtaskdetails">
                            <label>Task Id</label><input type="text" name="txtTaskid" id="taskid">
                            <button id="searchtask" type="button" class="btn-basic">Search</button><br>
                            <label>Date</label><input type="text" name="dtDate" id="Tdate" readonly=""><br>
                            <label>Section</label><input type="text" name="txtSec" id="Tsec" readonly=""><br>
                            <label>Time Slot</label><input type="text" name="txtTime" id="Tslot" readonly=""><br>
                            <!-- <label>No Of Employees</label><input type="number" name=""> -->
                            <label>Item Code</label><input type="text" name="txtItem" id="Icode" readonly=""><br>
                            <label>Qty</label><input type="number" name="txtQuantity" id="Tqty" readonly=""><br>
                            <label>Status</label><input type="text" name="txtStatus" id="Tstatus" readonly=""><br>
                        </form>
                    </div>

                    <div class="col-md-5">
                        <h5>Ordered Quantities</h5>
                        <button type="button" id="btnshowsizes" class="btn-basic" disabled="">Show</button>
                        <div id="task_sizes">
                            
                        </div>
                    </div>

                </div>  
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">
            <div class="col-md-12">
                <h5>Employee Allocation</h5>
                <table class="table  table-condensed">
                    <thead>
                        <tr>
                            <td>Emp Id</td>
                            <td>Emp Name</td>
                            <td>Target Qty</td>
                            <td>Finished Qty</td>
                        </tr>
                    </thead>
                    <tbody id="tbody1">
                                
                    </tbody>
                </table>
                <label>No Of Employees</label><input type="text" name="txtempcount" id="Emp_count" readonly="">
            </div>
        </div>
    </div>


    <script type="text/javascript">
        //search task
        $(document).ready(function(){
            $('#searchtask').click(function(){
                var tid=$('#taskid').val();
                searchTask(tid);
                getTaskEmployees(tid);
            });
        });

        //display search task results
        function searchTask(searchid=''){
            $.ajax({
                url:'/searchtask',
                type:'get',
                data:{'searchid':searchid},
                    // datatype:'json',
                success:function(response){
                    // console.log(data);
                    var result=response.data;
                    // console.log(result);
                    if(!result.length){
                        alert('Task Not Found..!');
                        $('#frmtaskdetails').trigger("reset");
                        $('#Emp_count').val('');
                    }   
                    else{
                        for(i=0;i<result.length;i++){
                            // var sid=result[i].Schedule_Id;
                            var task_Id=result[i].Task_Id;
                            var date=result[i].Date;
                            var itemcode=result[i].Item_Code;
                            var section=result[i].Section;
                            var time=result[i].Time_Slot;
                            var qty=result[i].Qty;
                            var status=result[i].Status;      

                            $('#Tdate').val(date);
                            $('#Tsec').val(section);
                            $('#Tslot').val(time);
                            $('#Icode').val(itemcode);
                            $('#Tqty').val(qty);
                            $('#Tstatus').val(status);
                        }
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
                    // datatype:'json',
                success:function(data){
                    var showdata='';
                    // console.log(data);
                    var result=JSON.parse(data);
                    // // console.log(result);
                    
                    if(!result.length){
                            document.getElementById("tbody1").innerHTML=showdata;
                    }
                    else{
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
                        document.getElementById("tbody1").innerHTML=showdata;
                        $('#Emp_count').val(emp_count);
                        }
                    }

                    
                }       
            });
        }

        $('#btnshowsizes').click(function(){
            var searchid_task_sizes=$('#taskid').val();
            displayTaskSizes(searchid_task_sizes);
        })

        function displayTaskSizes(searchid_task_sizes=''){
            $.ajax({
                url:'/getitemsizes',
                method:'get',
                data:{'searchid_task_sizes':searchid_task_sizes},
                // dataType:'json',
                success:function(itemsizes){
                    var show_size='';
                    // console.log(itemsizes);

                    var size_details=JSON.parse(itemsizes);
                    for(i=0;i<size_details.length;i++){
                            var icode=size_details[i].Item_Code;
                            var size_name=size_details[i].Size;
                            var quantity=size_details[i].Qty;
                            
                            
                                show_size +="<label>"+size_name+"</label><input value="+quantity+"></input><br>";
                                document.getElementById("task_sizes").innerHTML=show_size;
                            
                        }
                }
             });
        }

        
    </script>
 
@endsection