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

    <h1 class="title">Select Profile</h1>

    <br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">


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

                    <th style="text-decoration:underline">Profile</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                <tr>
                    <td><a class="white" href="{{URL::to('/')}}/view-profile/{{$user->id}}"> {{$user->name}}</a></td>
                    <td>{{$user->city}}</td>

                    <td>
                        @foreach($user->groups as $group)
                        {{$group}}
                        @endforeach
                    </td>

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

@stop