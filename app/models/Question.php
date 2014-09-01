<?php

class Question extends Eloquent
{
    protected $table = 'prism_questions';

    public function topic()
    {
        return $this->belongsTo('Topic');
    }

    public function answer()
    {
        return $this->hasMany('Answer');
    }

    public static function getQuestions()
    {
        return Question::all();
    }
}