@extends('layouts.master')

@section('body')
@section('navbar-header')
<a class="navbar-brand" href=".">MAD 360</a>
@stop

@section('navbar-links')
<li><a href="./review">Review</a></li>
<li><a href="./report">Report</a></li>

@stop


<div class="board">
    <h2 class="sub-title">Review</h2>
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
                    @endforeach
                    <br><br>
                @endforeach
                <input type="hidden" name="user" value="{{{Input::get('user')}}}">
                <a href={{{URL::to('/review')}}} class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-primary"><strong>&nbsp;Save&nbsp;</strong></button>
            </form>

        </div>
    </div>

</div>
@stop