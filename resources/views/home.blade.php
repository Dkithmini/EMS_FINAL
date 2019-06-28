@extends('layouts.app')

@section('content')
<div class="container">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
    <div class="row justify-content-center">
        <div class="col-md-8">
           <!--  <div class="card card-default"  id="message">
                <div class="card-header">WELCOME TO EMPLOYEE MANAGEMENT SYSTEM..!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div> -->

            <div class="jumbotron">
                <p id="message">WELCOME TO EMPLOYEE MANAGEMENT SYSTEM</p>
            </div>

        </div>
    </div>
</div>
<style type="text/css">
    #message{
        font-size: 280%;
        font-weight:bolder;
        color: white;

    }

    .jumbotron{
       margin-top: 50px;
       /*background: rgba(200, 54, 54, 0.5);*/
       background: #413F3F;
    }
</style>
@endsection