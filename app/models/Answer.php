<?php

class Answer extends Eloquent
{
    protected $table = 'prism_answers';

    public function question()
    {
        return $this->belongsTo('Question');
    }

    public function user()
    {
        return $this->belongsToMany('User','prism_answer_user')->withPivot('reviewer_id','type','comment')->withTimestamps();
    }

    public static function getAnswers()
    {
        return Answer::all();
    }
}