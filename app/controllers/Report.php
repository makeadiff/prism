<?php

class Report extends BaseController
{


    public function showReport()
    {
        $vertical_counts = User::getVerticalStatus();
        return View::make('report')->with('vertical_counts',$vertical_counts);
    }



}
