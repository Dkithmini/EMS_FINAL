
    @extends('layouts.app')

    @section('content')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/bootadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootadmin.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/popWindow.css') }}">
    <script src="{{ asset('js/popWindow.js') }}"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
     <script src="{{ asset('js/html2canvas.min.js') }}"></script>

    
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
    <title>Admin Login</title>
    
    <body class="bg-light">
        <div class="d-flex">
            <div class="sidebar sidebar-dark bg-dark">
                <ul class="list-unstyled">
                    <li class="active"><a href="{{url('dashboard/managerdashboard')}}"><i class="fa fa-fw fa-tachometer-alt fa-1x"></i>Dashboard</a></li>
                    <li>
                        <a href="#sm_expand_1" data-toggle="collapse">
                            <i class="fa fa-fw fa-cart-plus"></i>Orders
                        </a>
                        <ul id="sm_expand_1" class="list-unstyled collapse">
                            <li><a href="{{url('orders/addorder')}}">Add Order</a></li>
                            <li><a href="{{url('orders/vieworder')}}">View Order</a></li>
        		            <li><a href="#">Update Order</a></li>
                            <li><a href="#">Delete Order</a></li>
                        </ul>
                    </li>
        	    <li>
                        <a href="#sm_expand_2" data-toggle="collapse">
                           <i class="fa fa-fw fa-clock"></i></i>Schedules
                        </a>
                        <ul id="sm_expand_2" class="list-unstyled collapse">
                            <li><a href="{{url('schedules/createschedule')}}">Create Schedule</a></li>
        		            <li><a href="{{url('schedules/viewschedule')}}">View Schedule</a></li>        
                       </ul>
                    </li>
        	        <!-- <li>
                        <a href="#sm_expand_3" data-toggle="collapse">
                           <i class="fa fa-fw fa-user fa"></i>Employees
                        </a>
                        <ul id="sm_expand_3" class="list-unstyled collapse">
        		            <li><a href="#">View Employee</a></li>
                        </ul>
                    </li> -->
        	        <!-- <li>
                        <a href="#sm_expand_4" data-toggle="collapse">
                           <i class="fa fa-fw fa-calendar-check"></i>Attendance
                        </a>
                        <ul id="sm_expand_4" class="list-unstyled collapse">
        		            <li><a href="#">View Attendance</a></li>
                        </ul>
                    </li>	 -->
        	        <li>
                        <a href="#sm_expand_5" data-toggle="collapse">
                           <i class="fa fa-fw fa-file-medical-alt"></i>Leaves
                        </a>
                        <ul id="sm_expand_5" class="list-unstyled collapse">
        		            <li><a href="#">View Leaves</a></li>
        	                <li><a href="#">Manage Leaves</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#sm_expand_6" data-toggle="collapse">
                           <i class="fa fa-fw fa-chart-bar"></i>Reports
                        </a>
                        <ul id="sm_expand_6" class="list-unstyled collapse">
                            <li><a href="{{url('reports/attendanceReports')}}">Attendance report</a></li>
                            <li><a href="{{url('reports/ordersReports')}}">Orders report</a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="{{url('reports/attendanceReports')}}"><i class="fa fa-fw fa-chart-bar"></i>Reports</a>
                    </li> -->
                </ul>
            </div>

            <div class="content p-4">

                <div class="card mb-4">
                    <div class="card-body">
                          @yield('show_content')    								
                    </div>
                </div>
            </div>
        </div>


    
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootadmin.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootadmin.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootstrap.js') }}"></script> -->
    <!-- <script src="{{ asset('js/jquery.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/datatables.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/fullcalendar.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/moment.min.js') }}"></script> -->

@endsection
