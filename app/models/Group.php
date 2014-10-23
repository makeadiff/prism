<?php

class Group extends Eloquent
{
    protected $table = 'Group';


    public function user()
    {
        return $this->belongsToMany('User','UserGroup','group_id','user_id');
    }

    public function vertical()
    {
        return $this->belongsTo('Vertical');
    }


}
