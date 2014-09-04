<?php

class Score extends BaseController
{


    public function showScore()
    {
        $verticals = DB::select('SELECT id, name FROM Vertical');
        $cities = DB::select('SELECT id, name, region_id FROM City');
        $regions = DB::select('SELECT id, name FROM Region');
        $topics = Topic::getTopics();
        $vertical_score = User::getVerticalScore();
        return View::make('score')->with('vertical_score',$vertical_score)->with('verticals',$verticals)->with('cities',$cities)->with('regions',$regions)
                                    ->with('topics',$topics);
    }



}
