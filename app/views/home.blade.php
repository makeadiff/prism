@extends('layouts.master')

@section('body')

<div class="container-fluid">
    <div class="centered">
        <br>
        <br>
        <h1 class="title">MAD 360</h1>
        <br>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/review-type" class='btn btn-primary btn-dash '><img src="{{{URL::to('/')}}}/img/review.png"><br>Review</a>
        </div>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/report-type" class='btn btn-primary btn-dash '><img src="{{{URL::to('/')}}}/img/reports.png"><br>Report</a>
        </div>

        <div class="col-md-4 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/my-profile" class='btn btn-primary btn-dash '><img src="{{{URL::to('/')}}}/img/profile.png"><br>My Profile</a>
        </div>

        @if(Profile::getProfileUsers(User::find($_SESSION['user_id'])) != false)
            <div class="col-md-4 col-sm-6 text-center">
                <a href="{{{URL::to('/')}}}/select-profile" class='btn btn-primary btn-dash '><img src="{{{URL::to('/')}}}/img/hr.png"><br>View Managee<br>Profile</a>
            </div>
        @endif

        <br>


    </div>
</div>
@stop
