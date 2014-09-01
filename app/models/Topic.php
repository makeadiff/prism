<?php

class Topic extends Eloquent
{
    protected $table = 'prism_topics';

    public function question(){
        return $this->hasMany('Question');
    }

    public static function getTopics()
    {
        return Topic::all();
    }
}