@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{URL::to('/')}}">MAD 360</a>
@stop




<div class="container-fluid">
    <div class="centered board">
        <br>
        <br>
        <h1 class="title">Success!</h1>
        <br>
        <div class="row">
            <p class="success">{{Session::get('message')}}</p>
        </div>
        <br>
        <div class="row">
            <a href={{URL::to('/review-type')}} class='btn btn-primary btn-lg transparent'>Back to Review</a>
        </div>
    </div>
</div>
@stop
