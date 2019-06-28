<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function managerDashboard()
    {
        return view('ManagerHome');
    }

     public function adminDashboard()
    {
        return view('AdminHome');
    }

     public function supervisorDashboard()
    {
        return view('SupervisorHome');
    }
}
