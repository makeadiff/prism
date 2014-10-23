<?php

class Vertical extends Eloquent
{
    protected $table = 'Vertical';
    public $users = array();
    public $total = 0;
    public $done = 0;

    public function group()
    {
        return $this->hasMany('Group','vertical_id');
    }
}