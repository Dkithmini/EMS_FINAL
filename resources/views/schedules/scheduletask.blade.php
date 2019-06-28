 @extends('SupervisorHome')

    @section('show_content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/mycss/scheduletask.css') }}">
    <div class="panel">
        <div class="panel-body">
            <h5>Task Details</h5>
            <form id="frmsearch">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label>Date</label><input type="date" name="txtscheddate" id="sched_date">
                <button type="button" id="btntaskallocation">Search</button>
                <br><br>
            </form>
            
            <div class="row">
                <div class="col-md-12" style="max-height: 180px;overflow-y: scroll;">
                    <table class=" table table-condensed" >
                        <thead>
                            <tr>
                                <th>Task Id</th>
                                <th>Date</th>
                                <th >Section</th>
                                <th >Time Slot</th>
                                <th >Item Code</th>
                                <th >Quantity</th>
                                <th >Select</th>
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
                    <div class="col-md-6">
                      <h5>Allocate Employees</h5>

                    <form id="frmemp_allocation">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <label>Task Id</label><input type="text" name="txtTaskid" id="tid" readonly=""><br>
                        <label>Section</label><input type="text" name="txtsec" id="section_name" readonly=""><br>
                        <label hidden="">Time</label><input type="text" name="txttime" id="time_slot" readonly="" hidden="">
                        <label>Total Task Qty </label><input type="number" name="txtQty" id="quanty" readonly=""><br>
                        <label>Total allocation</label><input type="number" name="txtNo_employees" id="no_of_emp"><label style="padding-left:0px;">emps.</label><br>
                        <label>Target Qty</label><input type="number" name="txttarget" id="targetQty"><br><br>
                        <label>Item Code</label>
                        <select id="items">
                            <option>--Item--</option>
                        </select>
                        <!-- <input type="text" name="txtItemcode" id="code" readonly="" > --><br>
                        <label>Selected Item Qty</label><input type="number" name="item_qty_selected" id="selected_qty"><br>
                        <label>Employees</label><input type="number" name="emps_count" id="emps_count">
                        <br>
                        <label>Target Qty</label><input type="number" name="txt_target" id="emp_targetQty">
                        <br>
                       <button id="btnallocate_emp" style="float: right;"><i class="fas fa-plus"></i></button><br>
                        <!-- <input type="text" name="txtemplist"  id="displayemp"> -->
                        
                    </form>  
                    </div>

                    <div class="col-md-6">
                        <label style="width: 200px;">Unallocated Employees: </label><input type="text" id="emp_free"><br><br>
                        <label style="width: 200px;">Ordered qty for item : </label><label id="ordered_qty"></label><br><br>  
                         <label>Select Employee</label>

                        <div id="emp_checklist" style="max-height: 150px;overflow: auto;max-width: 260px;">
                            <ul id="selectemp" style="list-style: none;" class="list-group">
                            </ul> 
                        </div>
                        <br>
                        
                    </div>
                   
                </div>
            </div>
        </div>
    </div>



    <div class="panel">
        <div class="panel-body">
            <div class="col-md-8">
                <h5 id="task_section"></h5>
                            
                <table class="table table-condensed" >
                    <thead>
                        <tr>
                            <td>Emp Id</td>
                            <td>Target Qty</td>
                        </tr>
                    </thead>
                    <tbody id="tbody2">
                                    
                    </tbody>
                </table>
                 <div class="btn" id="sec1">
                        <button class="btn btn-basic" type="Reset">Reset</button>
                        <button class="btn btn-info" type="button" id="btnAllocate">Add</button>
                        <button class="btn btn-success" type="button" id="btnfinish" disabled="">Finish</button>
                    </div>
                                
            </div>  
            
        </div>
    </div>

    <script type="text/javascript">
        
        //search schedule
        $('#btntaskallocation').click(function(){
            
            var task_date=$('#sched_date').val();
            viewScheduleTasks(task_date);
            
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
                        // var sid=result[i].Schedule_Id;
                        var task_Id=result[i].Task_Id;
                        var date=result[i].Date;
                        var itemcode=result[i].Item_Code;
                        var section=result[i].Section;
                        var time=result[i].Time_Slot;
                        var qty=result[i].Qty;
                        var task_status=result[i].Status;     

                        showdata +="<tr>";
                        showdata +="<td>"+task_Id+"</td><td>"+date+"</td><td>"+section+"</td><td>"+time+"<td>"+itemcode+"</td><td>"+qty+"</td>";
                        
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

        //get all emp ids
        function getAttendedEmployeeList(task_date=''){
                var task_date=$('#sched_date').val();
                var timeslot=$('#time_slot').val();
                

                $.ajax({
                url:'/getids',
                type:'get',
                data:{'task_date':task_date,'timeslot':timeslot},

                success:function(result){
                    // $('#selectemp').html($('<option>', {
                    //         value: '',
                    //         text: '--emp id--'
                    //     }));
                     
                    // console.log(ids);
                    var result_emp=JSON.parse(result);
                    
                    var count=0;
                    for(i=0;i<result_emp.length;i++){
                        var show=result_emp[i];
                        count=i;
                        var appnd=$('<li class="list-group-item">&emsp;<label for="' + show + '"></label>&emsp;'+'<input class="checkid" type="checkbox" name="' + show + '" id="' + show + '" value="'+show+'"></li>');
                         appnd.find('label').text(show);
                        $('#selectemp').append(appnd);
                        
                    }
                    $('#emp_free').val(count+1);
                                
                    // console.log(result);
                }       
            });
            }

        //display selected empid in the textbox
        // $('#selectemp').change(function(){
        //     var emp =this.value;
        //     // console.log(emp);
        //     $('#displayemp').val(emp);
            
        // })

        $("#btnallocate_emp").click(function(event){
            event.preventDefault();
            var IDs = $(".checkid:checked").map(function(){
            return $(this).val();
            }).toArray();
            console.log(IDs);
            $(".checkid:checked").remove();


        });

        //select task to allocate employees
        $(document).on("click", ".btn-success", function(){

            var $row = $(this).closest("tr"),       // Finds the closest row <tr> 
            $tds = $row.find("td");  
            // console.log($tds);           // Finds all children <td> elements

            var taskid=($($tds[0]).text()); 
            var date=($($tds[1]).text());
            var sec=($($tds[2]).text());
            var time=($($tds[3]).text());
            var item_selected=($($tds[4]).text());
            var qty=($($tds[5]).text());
            
            $('#tid').val(taskid);
            $('#section_name').val(sec);
            $('#time_slot').val(time);
            $('#code').val(item_selected);
            $('#quanty').val(qty);

            getAttendedEmployeeList();
            checkItemRemainder(taskid);

        });

        //calculate target qty for each emp
        $('#no_of_emp').keyup(function(){
            var x=$('#quanty').val();
            var y=$('#no_of_emp').val();
            var target=x/y;
            $('#targetQty').val(target);
        })

        //allocate employee
        $('#btnAllocate').click(function(){
            allocateEmployees();
        })

        function allocateEmployees(){
            $.ajax({
                url:'/allocateemp',
                type:'post',
                data: $('#frmemp_allocation').serialize(),
                
                success:function(data){
                    alert('Employee allocated to the task...!');
                    

                    var result=JSON.parse(data);
                    // console.log(result);

                    var showdata='';
                    
                        var empid=result.Emp_Id;
                        var emp_target=result.Target_Qty;

                        showdata +="<tr>";
                        showdata +="<td>"+empid+"</td><td>"+emp_target+"</td>";
                        showdata +="</tr>";
                        document.getElementById("tbody2").innerHTML+=showdata;
                        
                        $('#btnfinish').attr('disabled',false);
                                
                }       
            });
        }

        //change status of task  after emp allocation
        $('#btnfinish').click(function(){
            var taskid=$('#tid').val();
            $.ajax({
                url:'/changetaskstatus',
                type:'post',
                headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data:{'taskid':taskid},
                
                success:function(response){
                    alert('Employees Allocation Completed..!');
                    
                    $('#frmemp_allocation').trigger("reset");           
                }       
            });
        })

        function checkItemRemainder(taskid=''){
            $.ajax({
                url:'/checkqty',
                method:'get',
                data:{'taskid':taskid},
                success:function(response){
                    var result=response.data;
                    console.log(result);

                    for(i=0;i<result.length;i++){
                        var show=result[i].Item_Code;
                         $('#items').append($('<option>', {
                            value: show,
                            text: show
                        }));
                      
                        
                    } 
                }
            });
        }

        $('#selected_qty').change(function(){
            var selectet_itemqty=$('#selected_qty').val();
            var totQty=$('#quanty').val();
            var empcount=$('#no_of_emp').val();

            if(selectet_itemqty<totQty || selectet_itemqty===totQty){
                var val=Math.round((empcount/totQty)*selectet_itemqty);
                var t=selectet_itemqty/val;
                $('#emps_count').val(val);
                $('#emp_targetQty').val(t);
            }
            else{
                alert('Invalid item qty entered..!Check the value and re-enter.')
            }
        })

    </script>


@endsection