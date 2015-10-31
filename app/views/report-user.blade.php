@extends('layouts.master')

@section('head')

<script type="text/javascript">

    $(function () {

        $('.clear-filter').click(function (e) {
            e.preventDefault();
            $('table').trigger('footable_clear_filter');
        });






    });

</script>
@stop

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{URL::to('/')}}/">MAD 360</a>
@stop



<div class="board centered">
    <br>

        <h1 class="title">User Report</h1>

    <br>
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

            <form class="form-inline text-center">
                <label for="filter">Filter :&nbsp;</label>
                <input type="text" id="filter" data-filter=#filter class="form-control input-sm">
                <a href="#clear" class="clear-filter" title="clear filter" id="filter-clear">[clear]</a>
            </form>

            <br>
            <table data-page-size="25" data-filter="#filter" class="footable table table-bordered table-responsive toggle-medium" data-filter-timeout="500" data-filter-text-only="true" data-filter-minimum="3">
                <thead>
                <tr>
                    <th style="text-decoration:underline">Name</th>
                    <th data-sort-initial="true" style="text-decoration:underline">City</th>
                    <th data-hide="phone" style="text-decoration:underline">Region</th>
                    <th data-hide="phone" style="text-decoration:underline">Profile</th>
                    <th style="text-decoration:underline">Reviewed by Manager</th>
                    <th style="text-decoration:underline">Reviewed by Managee</th>
                    <th style="text-decoration:underline">Reviewed by Peer</th>
                    <th data-hide="all" style="text-decoration:underline" data-filter-ignore="true">Reviewed by Managers</th>
                    <th data-hide="all" style="text-decoration:underline" data-filter-ignore="true">Reviewed by Managees</th>
                    <th data-hide="all" style="text-decoration:underline" data-filter-ignore="true">Reviewed by Peers</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->city}}</td>
                        <td>{{$user->region}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>
                            @foreach($user->groups as $group)
                                {{$group}}
                            @endforeach
                        </td>
                        <td>{{$user->manager_review_status}}</td>
                        <td>{{$user->managee_review_status}}</td>
                        <td>{{$user->peer_review_status}}</td>
                        <td>
                            @foreach($user->managers as $key => $manager)
                                @if($key!=0)
                                    ,
                                @endif
                                {{$manager}}
                            @endforeach
                        </td>
                        <td>
                            @foreach($user->managees as $key => $managee)
                            @if($key!=0)
                            ,
                            @endif
                            {{$managee}}
                            @endforeach
                        </td>
                        <td>
                            @foreach($user->peers as $key => $peer)
                            @if($key!=0)
                            ,
                            @endif
                            {{$peer}}
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            <div class="text-center">
                            <ul class="pagination pagination-centered hide-if-no-paging"></ul>
                            </div>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#cycle').change(function(){
            var str = "{{URL::to('/')}}/report/user/" + $('#cycle').val();
            window.location = str;
        })
    });
</script>





@stop