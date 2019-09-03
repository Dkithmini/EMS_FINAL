
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

    <title>Admin Login</title>
    
    <body class="bg-light">
    
    <div class="d-flex">
        <div class="sidebar sidebar-dark bg-dark">
            <ul class="list-unstyled">
                <li>
                    <a href="#sm_expand_1" data-toggle="collapse">
                        <i class="fa fa-fw fa-user"></i>Employees
                    </a>
                    <ul id="sm_expand_1" class="list-unstyled collapse">
                        <li><a href="{{url('employees/addemployee')}}">Add Employee</a></li>
                        <li><a href="{{url('employees/viewemployee')}}">View Employee</a></li>
    		            <li><a href="{{url('employees/updateemployee')}}">Update Employee</a></li>
                        <li><a href="#">Delete Employee</a></li>
                    </ul>
                </li>
    	        <li>
                    <a href="#sm_expand_2" data-toggle="collapse">
                       <i class="fa fa-fw fa-calendar-check"></i>Staff
                    </a>
                    <ul id="sm_expand_2" class="list-unstyled collapse">
                        <li><a href="#">Add Staff</a></li>
                        <li><a href="#">View Staff</a></li>
    		            <li><a href="#">Update Staff</a></li>
                        <li><a href="#">Delete Staff</a></li>
                    </ul>
                </li>
    	        <li>
                    <a href="#sm_expand_3" data-toggle="collapse">
                       <i class="fa fa-fw fa-calendar-check"></i>Attendance
                    </a>
                    <ul id="sm_expand_3" class="list-unstyled collapse">
                        <li><a href="{{url('attendance/recordattendance')}}">Record Attendance</a></li>
    		            <li><a href="{{url('attendance/viewattendance')}}">View Attendance</a></li>
                    </ul>
                </li>
    	   
                <li><a href="#"><i class="fa fa-fw fa-chart-bar"></i>Reports</a></li>
            </ul>
        </div>

        <div class="content p-4">
           <!--  <h2 class="mb-4">content</h2> -->
            <div class="card">
                <div class="card-body" >
                     @yield('show_content')						
                </div>
            </div>
        </div>
    </div>
        
    <!-- <script src="{{ asset('js/app.js') }}"></script> -->
    <!-- <script src="{{ asset('js/bootadmin.js') }}"></script> -->
    
    
    <!-- <script src="{{ asset('js/bootstrap.js') }}"></script> -->
    
    <!-- <script src="{{ asset('js/datatables.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/fullcalendar.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/moment.min.js') }}"></script> -->  
@endsection
