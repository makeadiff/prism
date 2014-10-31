<?php

class Report extends BaseController
{


    public function showManagerReport($cycle_id = 2)
    {
        $cycles = Cycle::all();

        return View::make('report-manager')->with('verticals',$this->getManagerReviewStatus($cycle_id))->with('cycles',$cycles)
                        ->with('cycle_id',$cycle_id);
    }

    public function showManageeReport($cycle_id = 2)
    {
        $cycles = Cycle::all();

        return View::make('report-managee')->with('verticals',$this->getManageeReviewStatus($cycle_id))->with('cycles',$cycles)
            ->with('cycle_id',$cycle_id);
    }

    public function showUserReport($cycle_id = 2)
    {
        $cycle = Cycle::find($cycle_id);
        $users = User::getUserDetails();
        foreach ($users as $user) {
            $user->groups = User::getUserGroups($user->id);
            $user->managee_review_status = User::getStatus($user->id,'manager',$cycle);
            $user->manager_review_status = User::getStatus($user->id,'managee',$cycle);
            $user->peer_review_status = User::getStatus($user->id,'peer',$cycle);
            $user->peers = User::getReviewedBy($user->id,'peer',$cycle);
            $user->managees = User::getReviewedBy($user->id,'manager',$cycle);
            $user->managers = User::getReviewedBy($user->id,'managee',$cycle);

        }

        return View::make('report-user')->with('users',$users)->with('cycle_id',$cycle_id)->with('cycles',Cycle::all());


    }

    public function showReportType()
    {

        return View::make('report-type');
    }

    public function getManagerReviewStatus($cycle_id)
    {
        $verticals = Vertical::all();

        $cycle = Cycle::find($cycle_id);


        foreach($verticals as $vertical)
        {


            $groups = $vertical->group()->where('group_type','=','normal')->where(function($query){
                $query->where('type','=','strat')->orWhere('type','=','fellow')->orWhere('type','=','national');
                })->get();

            foreach($groups as $group) {
                $users = $group->user()->where('status','=',1)->where('user_type','=','volunteer')->get();

                foreach($users as $user) {


                $review = DB::select('SELECT id FROM prism_answer_user WHERE reviewer_id = ? AND type = ?
                                        AND DATE(created_at) >= ? AND DATE(created_at) <= ?',
                                array($user->id,'manager',$cycle->start_date,$cycle->end_date));

                $vertical->total++;

                if(empty($review)) {

                    $vertical->users[] = $user;


                }else{
                    $vertical->done++;
                }



                }
            }
        }

        return $verticals;
    }

    public function getManageeReviewStatus($cycle_id)
    {
        $verticals = Vertical::all();

        $cycle = Cycle::find($cycle_id);


        foreach($verticals as $vertical)
        {


            $groups = $vertical->group()->where('group_type','=','normal')->where(function($query){
                    $query->where('type','=','strat')->orWhere('type','=','fellow')->orWhere('type','=','national');
                })->get();

            foreach($groups as $group) {
                $users = $group->user()->where('status','=',1)->where('user_type','=','volunteer')->get();

                foreach($users as $user) {


                    $review = DB::select('SELECT id FROM prism_answer_user WHERE user_id = ? AND type = ?
                                        AND DATE(created_at) >= ? AND DATE(created_at) <= ?',
                        array($user->id,'managee',$cycle->start_date,$cycle->end_date));

                    $vertical->total++;

                    if(empty($review)) {

                        $vertical->users[] = $user;


                    }else{
                        $vertical->done++;
                    }



                }
            }
        }

        return $verticals;
    }



}
