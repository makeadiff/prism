<?php

class Reviewer extends Eloquent
{
    protected $table = 'User';

    public function user()
    {
        return $this->belongsToMany('user','prism_reviewer_user')->withTimestamps();
    }



}

?>
