<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EMS</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/bootadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/bootadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css2/fullcalendar.min.css') }}">

</head>
<body>
    <style type="text/css">
    body {
        width: 100%;
        height: 100%;
        color: #1E7479;
         background: url("/images/homescreen.jpg");
         /*height: 200px;*/
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-blend-mode: lighten;
    }

    .navbar-dark{
        font-size: medium;
        height: 50px;
    }
    </style>
    <div id="app">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">  
        
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <!-- <div class="container"> -->
               
                <!-- <a class="navbar-brand" href="{{url('/')}}"><i class="fas fa-home"></i></a> -->
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} 
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                 <a class="sidebar-toggle mr-3" href="#"><i class="fa fa-bars fa-1x "></i></a>
            <!-- </div> -->
        </nav>
            
        <main class="py-4">
            @yield('content')
        </main>
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
</body>
</html>
