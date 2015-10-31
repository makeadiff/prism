@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{URL::to('/')}}">MAD 360</a>
@stop




<div class="board centered">
    <h1 class="title">Managee Review Report</h1>
    <p class="sub-text">(This report shows the list of managees whose review has not been completed by their managers)</p>
    <br>


    </select>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">

            <div class="col-md-offset-4 col-md-4">
            <select class="form-control" id="cycle">
                @foreach($cycles as $cycle)

                    <option value="{{$cycle->id}}"
                        @if($cycle_id == $cycle->id)
                            selected="selected"
                        @endif
                        >{{$cycle->name}}</option>

                @endforeach
            </select>
            </div>
            <br><br><br>

            <table class="table table-bordered">
                <tr>
                    <th>Vertical</th>
                    <th>Completed</th>
                </tr>
                <?php $total  = 0; $done = 0 ?>
                    @foreach($verticals as $vertical)
                        <tr>
                            <td><a class = "white" href="#collapse_{{$vertical->id}}" data-toggle="collapse"><span class="glyphicon glyphicon-plus"></span>&nbsp;{{$vertical->name}}</a>
                            <div id="collapse_{{$vertical->id}}" class="panel-collapse collapse out">
                                @foreach($vertical->users as $user)
                                    <strong>{{$user->name}}'s</strong> ({{$user->city()->first()->name}}) review has not been done by their manager<br>
                                @endforeach
                            </div></td>
                            <td>{{$vertical->done}}/{{$vertical->total}}</td>
                        </tr>
                    <?php $total+=$vertical->total; $done+=$vertical->done?>
                    @endforeach
                <tr>
                    <td>
                        Total
                    </td>
                    <td>
                        {{$done}}/{{$total}}
                    </td>

                </tr>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#cycle').change(function(){
            var str = "{{URL::to('/')}}/report/managee/" + $('#cycle').val();
            window.location = str;
        })
    });
</script>

@stop