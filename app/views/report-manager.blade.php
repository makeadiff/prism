@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{{URL::to('/')}}}">MAD 360</a>
@stop




<div class="board centered">
    <h1 class="title">Manager Review Report</h1>
    <br>


    </select>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">

            <div class="col-md-offset-4 col-md-4">
            <select class="form-control" id="cycle">
                @foreach($cycles as $cycle)

                    <option value="{{{$cycle->id}}}"
                        @if($cycle_id == $cycle->id)
                            selected="selected"
                        @endif
                        >{{{$cycle->name}}}</option>

                @endforeach
            </select>
            </div>
            <br><br><br>

            <table class="table table-bordered">
                <tr>
                    <th>Vertical</th>
                    <th>Completed</th>
                </tr>
                    @foreach($verticals as $vertical)
                        <tr>
                            <td><a class = "white" href="#collapse_{{{$vertical->id}}}" data-toggle="collapse">{{{$vertical->name}}}</a>
                            <div id="collapse_{{{$vertical->id}}}" class="panel-collapse collapse out">
                                @foreach($vertical->users as $user)
                                    <strong>{{{$user->name}}} </strong>({{{$user->city()->first()->name}}}) has not done manager review<br>
                                @endforeach
                            </div></td>
                            <td>{{{$vertical->done}}}/{{{$vertical->total}}}</td>
                        </tr>
                    @endforeach

            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#cycle').change(function(){
            var str = "{{{URL::to('/')}}}/report/manager/" + $('#cycle').val();
            window.location = str;
        })
    });
</script>

@stop