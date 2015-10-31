@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{URL::to('/')}}">MAD 360</a>
@stop

<div class="container-fluid">
    <div class="centered">
        <br>
        <br>
        <h1 class="title">Reports</h1>
        <br>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{URL::to('/')}}/report/manager" class='btn btn-primary btn-dash '><img class="dash" src="{{URL::to('/')}}/img/manager.png"><br>Manager<br>Review Report</a>
        </div>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{URL::to('/')}}/report/managee" class='btn btn-primary btn-dash '><img class="dash" src="{{URL::to('/')}}/img/managee.png"><br>Managee<br>Review Report</a>
        </div>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{URL::to('/')}}/report/user" class='btn btn-primary btn-dash '><img class="dash" src="{{URL::to('/')}}/img/peer.png"><br>User Report</a>
        </div>



    </div>
</div>
@stop
