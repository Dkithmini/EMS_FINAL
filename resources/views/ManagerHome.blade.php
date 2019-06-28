
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

    <title>Admin Login</title>
</head>
<body class="bg-light">

<!-- <nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars"></i></a>
    <a class="navbar-brand" href="#">EMS</a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown">
                <a href="#" id="dd_user" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> John Doe</a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd_user">
                    <a href="#" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav> -->

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
	        <li>
                <a href="#sm_expand_3" data-toggle="collapse">
                   <i class="fa fa-fw fa-user fa"></i>Employees
                </a>
                <ul id="sm_expand_3" class="list-unstyled collapse">
		            <li><a href="#">View Employee</a></li>
                </ul>
            </li>
	        <li>
                <a href="#sm_expand_4" data-toggle="collapse">
                   <i class="fa fa-fw fa-calendar-check"></i>Attendance
                </a>
                <ul id="sm_expand_4" class="list-unstyled collapse">
		            <li><a href="#">View Attendance</a></li>
                </ul>
            </li>	
	        <li>
                <a href="#sm_expand_5" data-toggle="collapse">
                   <i class="fa fa-fw fa-file-medical-alt"></i>Leaves
                </a>
                <ul id="sm_expand_5" class="list-unstyled collapse">
		            <li><a href="#">View Leaves</a></li>
	                <li><a href="#">Manage Leaves</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-fw fa-chart-bar"></i>Reports</a></li>
        </ul>
    </div>

    <div class="content p-4">
        <!-- <h2 class="mb-4">Content</h2> -->

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
