@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href=".">Professionalism</a>
@stop

@section('navbar-links')
<li><a href="./review">Review</a></li>
<li><a href="" class="active">Report</a></li>


@stop


<div class="board">
    <h2 class="sub-title">Report</h2>
    <br><br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">
            <table class="table table-bordered">
                <tr>
                    <th>Vertical</th>
                    <th>Completed</th>
                </tr>
                @foreach($vertical_counts as $vc)
                    <tr>
                        <td>{{{$vc->name}}}</td>
                        <td>{{{$vc->completed}}}/{{{$vc->total}}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@stop