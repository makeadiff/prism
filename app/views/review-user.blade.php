@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href="{{{URL::to('/')}}}">MAD 360</a>
@stop




<div class="board">
    <h3 class="sub-title">Review for {{{$user_name}}}</h3>
    <br><br>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-12">

            @if($errors->count()>0)

            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>


                <strong>Error</strong> : All questions are required<br>


            </div>
            @endif

            <form id="review-user" method="post" enctype="multipart/form-data" action="{{{action('Review@saveReview')}}}">
                @foreach($topics as $topic)
                    <p class="topic">{{{$topic->subject}}}</p>
                    <?php $questions = $topic->question()->orderBy('order')->get();?>

                    @foreach($questions as $question)
                        <p class="question">Q. {{{$question->subject}}}</p>
                        <?php $answers = $question->answer()->orderBy('level','asc')->get();?>

                        @foreach($answers as $answer)
                            <label class="answer"><input name="question_{{{$question->id}}}"type="radio" id="answer_{{{$answer->id}}}" value="{{{$answer->id}}}">&nbsp;L{{{$answer->level}}}&nbsp;:&nbsp;{{{$answer->subject}}}</label><br>
                        @endforeach
                        <br>
                        <textarea class="form-control" rows="3" name="comment_{{{$question->id}}}" placeholder="Comments on {{{$question->subject}}}"></textarea>
                        <br><br>
                    @endforeach
                    <br><br>
                @endforeach
                <p class="question">Speak to Jithin : </p>
                <p class="sub-text">(This message will be sent directly to Jithin)</p>
                <textarea class="form-control" placeholder="Speak To Jithin" rows="3" name="speak_to_jithin"></textarea>
                <br><br>
                <input type="hidden" name="user" value="{{{$user_id}}}">
                <input type="hidden" name="type" value="{{{$type}}}">
                <a href={{{URL::to('/review-type')}}} class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary"><strong>&nbsp;Save&nbsp;</strong></button>
            </form>

        </div>
    </div>

</div>
@stop