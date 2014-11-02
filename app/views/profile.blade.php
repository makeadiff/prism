@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{{URL::to('/')}}}">MAD 360</a>
@stop

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12"</div>
        <br>
        <br>
        <h3 class="sub-title centered">{{{$user->name}}}'s Profile</h3>
        <br>

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


        @foreach($types as $type)
            <table data-sort="false" class="table table-bordered footable">
            <thead>
            <tr>
                <th colspan="3">
                    @if($type == 'managee')
                        Your Manager's Review (Reviewed by {{{$data[$type]['count']}}} Manager)
                    @elseif($type == 'manager')
                        Your Managee's Review (Reviewed by {{{$data[$type]['count']}}} Managee)
                    @else
                        Your Peer's Review (Reviewed by {{{$data[$type]['count']}}} Peer)
                    @endif
                </th>
            </tr>

            <tr>
                <th>
                    Question
                </th>
                <th>
                    Score
                </th>
                <th data-hide="all">
                    Comments
                </th>
            </tr>
            </thead>
            @foreach($topics as $topic)

                <?php $questions = $topic->question()->get();?>
                <tbody>

                @foreach($questions as $question)

                    <tr>
                        <td>Q. {{{$question->subject}}} </td>
                        <td>{{{$data[$type][$topic->id][$question->id]['score']}}}</td>
                        <td>
                            @foreach($data[$type][$topic->id][$question->id]['comments'] as $key => $comment)
                            {{{$key+1}}}. {{{$comment}}}<br>
                            @endforeach
                        </td>
                    </tr>




                @endforeach

                </tbody>

            @endforeach
            </table>
        @endforeach

    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#cycle').change(function(){
            @if($source == 'my-profile')
                var str = "{{{URL::to('/')}}}/my-profile/" + $('#cycle').val();
            @else
                var str = "{{{URL::to('/')}}}/view-profile/" + {{{$user->id}}} + "/" + $('#cycle').val();
            @endif
            window.location = str;
        })
    });
</script>


@stop
