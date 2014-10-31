@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{{URL::to('/')}}}">MAD 360</a>
@stop

<div class="container-fluid">
    <div class="centered">
        <br>
        <br>
        <h1 class="title">Review</h1>
        <br>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/review/manager" class='btn btn-primary btn-dash '><img class="dash" src="{{{URL::to('/')}}}/img/manager.png"><br>Review your<br>Manager</a>
        </div>


        @if($manager_status == true)
            <div class="col-md-4 col-sm-6 text-center">
                <a href="{{{URL::to('/')}}}/review/managee" class='btn btn-primary btn-dash '><img class="dash" src="{{{URL::to('/')}}}/img/managee.png"><br>Review your<br>Managee</a>
            </div>
        @endif

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/review/peer" class='btn btn-primary btn-dash '><img class="dash" src="{{{URL::to('/')}}}/img/peer.png"><br>Review your<br>Peer</a>
        </div>



    </div>
</div>
@stop
