@extends('layouts.master')

@section('body')

<div class="container-fluid">
    <div class="centered">
        <br>
        <br>
        <h1 class="title">MAD 360</h1>
        <br>

        <div class="col-md-6 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/review-type" class='btn btn-primary btn-dash '><img src="{{{URL::to('/')}}}/img/review.png"><br>Review</a>
        </div>

        <div class="col-md-6 col-sm-6 text-center">
            <a href="{{{URL::to('/')}}}/report-type" class='btn btn-primary btn-dash '><img src="{{{URL::to('/')}}}/img/reports.png"><br>Report</a>
        </div>

        <br>


    </div>
</div>
@stop
