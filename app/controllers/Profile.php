<?php

class Profile extends BaseController
{


    public function showMyProfile($cycle = null)
    {
        if(empty($cycle))
            $cycle = User::getCurrentCycle();
        else
            $cycle = Cycle::find($cycle);

        $user = User::find($_SESSION['user_id']);

        $data = $this->getScore($user,$cycle);

        $topics = Topic::all();

        $types = array('managee','manager','peer');

        $cycles = Cycle::all();

        return View::make('profile')->with('data',$data)->with('topics',$topics)->with('types',$types)
                    ->with('cycles',$cycles)->with('cycle_id',$cycle->id)->with('user',$user)->with('source','my-profile');
    }

    public function showProfileMaterial($cycle = null)
    {

        if(empty($cycle))
            $cycle = User::getCurrentCycle();
        else
            $cycle = Cycle::find($cycle);

        $user = User::find($_SESSION['user_id']);

        $data = $this->getScore($user,$cycle);

        $topics = Topic::all();

        $types = array('managee','manager','peer');

        $cycles = Cycle::all();

        $tab = $this->checkIfReviewEmpty($user, $cycle,$types); //To check whether to disable the review type tab

        $percentile__strings = $this->getPercentileStrings($user,$cycle,$types,$topics);

        $hi_city_data = $this->getHIAggregateForCity($user);

        $hi_national_data = $this->getHIAggregateForNational();

        $hi_questions = $this->getHIQuestions();

        return View::make('profile-material')->with('data',$data)->with('topics',$topics)->with('types',$types)
            ->with('cycles',$cycles)->with('cycle_id',$cycle->id)->with('user',$user)->with('source','my-profile')
            ->with('tab',$tab)->with('percentile_strings',$percentile__strings)->with('hi_city_data',$hi_city_data)
            ->with('hi_questions',$hi_questions)->with('hi_national_data',$hi_national_data);

    }

    function getHIQuestions() {
        $data = DB::select("SELECT * FROM SS_Question WHERE status = '1'");

        return $data;
    }


    function getHIAggregateForCity($user) {
        $survey_event_id = DB::select("SELECT id FROM SS_Survey_Event ORDER BY added_on DESC LIMIT 0,1")[0]->id; // Default Survey event.
        $city_id	= $user->city()->first()->id;
        $data 		= array();
        $total_responders = 0;

        $raw_data = DB::select("SELECT DISTINCT UA.user_id as user_id, UA.question_id as question_id, UA.answer as answer FROM SS_UserAnswer UA
			INNER JOIN User U ON U.id=UA.user_id
			WHERE U.status='1' AND U.user_type='volunteer' AND U.city_id = ? AND UA.survey_event_id= ?",array($city_id,$survey_event_id));

        $answers = array();

        $total_responders = DB::select("SELECT COUNT(DISTINCT UA.user_id) AS count FROM SS_UserAnswer UA
			INNER JOIN User U ON U.id=UA.user_id
			WHERE U.status='1' AND U.user_type='volunteer' AND U.city_id= ? AND UA.survey_event_id= ?",array($city_id,$survey_event_id))[0]->count;

        // Lifted from controllers/parameter.php:ss_calulate()
        foreach ($raw_data as $ans) {
            // If not defined, define the defaults
            if(!isset($answers[$ans->question_id])) $answers[$ans->question_id] = array(0=>0, 1=>0, 3=>0, 5=>0);

            $answers[$ans->question_id][$ans->answer]++;
        }

        foreach ($answers as $question_id => $values) {
            // Find level by aggregating the total and averaging.
            // If there are 5 answers - 1 x Level 1, 2 x Level 3 and 2 x Level 5, we aggregate it - (1 x 1) + (2 x 3) + (2 x 5) = 17
            //	Then we divide by total count : 17/5 = 3.4. Rounds to 3. Thats the level.
            $aggregate = 0;
            $total_answer_count = 0;
            $data[$question_id] = array();

            $total_answer_count = $values[1] + $values[3] + $values[5];

            foreach(array(1,3,5) as $answer_value) {
                $aggregate += $answer_value * $values[$answer_value];


                $data[$question_id]['level'][$answer_value] = $values[$answer_value];
                if($total_answer_count)
                    $data[$question_id]['level_percentage'][$answer_value] = round((($values[$answer_value] / $total_answer_count) * 100), 2);
                else $data[$question_id]['level_percentage'][$answer_value] = 0;
            }
            if($total_answer_count) $level = round($aggregate / $total_answer_count, 1);
            else $level = 0;

            $data[$question_id]['aggregate_level'] = $level;
            $data[$question_id]['total_answer_count'] = $total_responders;
        }


        return $data;
    }


    function getHIAggregateForNational() {
        $survey_event_id = DB::select("SELECT id FROM SS_Survey_Event ORDER BY added_on DESC LIMIT 0,1")[0]->id; // Default Survey event.
        $data 		= array();
        $total_responders = 0;

        $raw_data = DB::select("SELECT DISTINCT UA.user_id as user_id, UA.question_id as question_id, UA.answer as answer FROM SS_UserAnswer UA
			INNER JOIN User U ON U.id=UA.user_id
			WHERE U.status='1' AND U.user_type='volunteer' AND UA.survey_event_id= ?",array($survey_event_id));

        $answers = array();

        $total_responders = DB::select("SELECT COUNT(DISTINCT UA.user_id) AS count FROM SS_UserAnswer UA
			INNER JOIN User U ON U.id=UA.user_id
			WHERE U.status='1' AND U.user_type='volunteer' AND UA.survey_event_id= ?",array($survey_event_id))[0]->count;

        // Lifted from controllers/parameter.php:ss_calulate()
        foreach ($raw_data as $ans) {
            // If not defined, define the defaults
            if(!isset($answers[$ans->question_id])) $answers[$ans->question_id] = array(0=>0, 1=>0, 3=>0, 5=>0);

            $answers[$ans->question_id][$ans->answer]++;
        }

        foreach ($answers as $question_id => $values) {
            // Find level by aggregating the total and averaging.
            // If there are 5 answers - 1 x Level 1, 2 x Level 3 and 2 x Level 5, we aggregate it - (1 x 1) + (2 x 3) + (2 x 5) = 17
            //	Then we divide by total count : 17/5 = 3.4. Rounds to 3. Thats the level.
            $aggregate = 0;
            $total_answer_count = 0;
            $data[$question_id] = array();

            $total_answer_count = $values[1] + $values[3] + $values[5];

            foreach(array(1,3,5) as $answer_value) {
                $aggregate += $answer_value * $values[$answer_value];


                $data[$question_id]['level'][$answer_value] = $values[$answer_value];
                if($total_answer_count)
                    $data[$question_id]['level_percentage'][$answer_value] = round((($values[$answer_value] / $total_answer_count) * 100), 2);
                else $data[$question_id]['level_percentage'][$answer_value] = 0;
            }
            if($total_answer_count) $level = round($aggregate / $total_answer_count, 1);
            else $level = 0;

            $data[$question_id]['aggregate_level'] = $level;
            $data[$question_id]['total_answer_count'] = $total_responders;
        }


        return $data;
    }

    function getPercentileStrings($user,$cycle,$types,$topics) {

        foreach($types as $type) {
            foreach($topics as $topic) {

                $percentile = $topic->getPercentile($user,$type,$cycle);

                if($percentile >= 90) {
                    $percentile_string = "top 10%";
                }elseif($percentile < 90 && $percentile >= 75) {
                    $percentile_string = "top 25%";
                }elseif($percentile <75 && $percentile >= 50) {
                    $percentile_string = "top 50%";
                }elseif($percentile < 50) {
                    $percentile_string = "bottom 50%";
                }else{
                    $percentile_string = "N/A";
                }

                $percentile_strings[$type][$topic->id] = $percentile_string;
            }
        }

        return $percentile_strings;


    }



    function checkIfReviewEmpty($user,$cycle,$types) {
        foreach($types as $type) {
            if(empty($user->answer()->where('question_id',1)->wherePivot('created_at','>=',$cycle->start_date)
                ->wherePivot('created_at','<=',$cycle->end_date)->where('type',$type)->avg('level'))) {
                $tab[$type]['disabled'] = 'disabled';
                $tab[$type]['active'] = '';
            }
            else {
                $tab[$type]['disabled'] = '';
                $tab[$type]['active'] = 'active';
            }

        }

        return $tab;
    }

    public function showViewProfile($encrypted_user_id, $cycle = null) {

        if(empty($cycle))
            $cycle = User::getCurrentCycle();
        else
            $cycle = Cycle::find($cycle);

        try {
            $user_id = Crypt::decrypt($encrypted_user_id);
        }catch(Exception $e){
            return Redirect::to('error')->with('message',"Invalid profile id");
        }

        $user = User::find($user_id);

        $data = $this->getScore($user,$cycle);

        $topics = Topic::all();

        $types = array('managee','manager','peer');

        $cycles = Cycle::all();

        $tab = $this->checkIfReviewEmpty($user, $cycle,$types); //To check whether to disable the review type tab

        $percentile__strings = $this->getPercentileStrings($user,$cycle,$types,$topics);

        $hi_city_data = $this->getHIAggregateForCity($user);

        $hi_national_data = $this->getHIAggregateForNational();

        $hi_questions = $this->getHIQuestions();

        return View::make('profile-material')->with('data',$data)->with('topics',$topics)->with('types',$types)
            ->with('cycles',$cycles)->with('cycle_id',$cycle->id)->with('user',$user)->with('source','my-profile')
            ->with('tab',$tab)->with('percentile_strings',$percentile__strings)->with('hi_city_data',$hi_city_data)
            ->with('hi_questions',$hi_questions)->with('hi_national_data',$hi_national_data);



    }

    public function showSelectProfile()
    {

        $user = User::find($_SESSION['user_id']);

        $users = $this->getProfileUsers($user);

        if($users == false)
            return Redirect::to('error')->with('message',"You don't have permission to access this page.");

        foreach ($users as $user) {
            $user->groups = User::getUserGroups($user->id);
        }

        return View::make('select-profile')->with('users',$users);
    }



    public static function getProfileUsers($user) {

        $exec = false;
        $bro = false;
        $strat = false;

        $groups = $user->group()->get();

        foreach($groups as $group) {
            if($group->name == 'Executive Team')
                $exec = true;
            elseif($group->type == 'national')
                $bro = true;
            elseif($group->type == 'strat')
                $strat = true;
        }

        if($exec == true) {
            $users = DB::select('SELECT User.id as id, User.name as name,City.name as city,Region.name as region FROM User
                                INNER JOIN City
                                ON User.city_id = City.id
                                INNER JOIN Region
                                ON City.region_id = Region.id
                                INNER JOIN UserGroup
                                ON UserGroup.user_id = User.id
                                INNER JOIN `Group`
                                ON `Group`.id = UserGroup.group_id
                                INNER JOIN Vertical
                                ON Vertical.id = `Group`.vertical_id
                                WHERE User.status = 1 AND User.user_type = ?
                                AND (Group.type = ? OR Group.type = ? OR Group.type = ?)
                                ',array('volunteer','national','fellow','strat'));

        }
        elseif($bro == true) {
            $users = DB::select('SELECT User.id as id, User.name as name,City.name as city,Region.name as region FROM User
                                INNER JOIN City
                                ON User.city_id = City.id
                                INNER JOIN Region
                                ON City.region_id = Region.id
                                INNER JOIN UserGroup
                                ON UserGroup.user_id = User.id
                                INNER JOIN `Group`
                                ON `Group`.id = UserGroup.group_id
                                INNER JOIN Vertical
                                ON Vertical.id = `Group`.vertical_id
                                WHERE User.status = 1 AND User.user_type = ?
                                AND (Group.type = ? OR Group.type = ?)
                                ',array('volunteer','fellow','strat'));

        }

        elseif($strat == true) {
            $users = DB::select('SELECT User.id as id, User.name as name,City.name as city,Region.name as region FROM User
                                INNER JOIN City
                                ON User.city_id = City.id
                                INNER JOIN Region
                                ON City.region_id = Region.id
                                INNER JOIN UserGroup
                                ON UserGroup.user_id = User.id
                                INNER JOIN `Group`
                                ON `Group`.id = UserGroup.group_id
                                INNER JOIN Vertical
                                ON Vertical.id = `Group`.vertical_id
                                WHERE User.status = 1 AND User.user_type = ?
                                AND (Group.type = ?)
                                ',array('volunteer','fellow'));

        }

        else {

            return false;

        }

        //Hack to get rid of duplicate entries

        $count = count($users);

        for($outer = 0; $outer < $count; $outer++) {
            for($inner = 0; $inner < $count; $inner ++ ) {

                if(isset($users[$outer]) && isset($users[$inner])) {
                    if($outer != $inner && $users[$outer]->id == $users[$inner]->id) {
                        unset($users[$inner]);
                    }
                }


            }
        }


        return $users;


    }

    function getScore($user,$cycle)
    {
        $topics = Topic::all();
        $types = array('manager','managee','peer');


        foreach($types as $key => $type) {




            $data[$type]['count'] = $user->answer()->wherePivot('created_at','>=',$cycle->start_date)
                ->wherePivot('created_at','<=',$cycle->end_date)->where('type',$type)->count() / 7;



            foreach($topics as $topic) {
                $score[$topic->id] = array();
                $questions = $topic->question()->get();

                $data[$type][$topic->id]['score'] = round($topic->getUserScore($user->id,$type,$cycle),1);

                $data[$type][$topic->id]['average'] = round($topic->getAverageScore($type,$user->getUserType(),$cycle),1);

                foreach($questions as $question) {

                    $data[$type][$topic->id][$question->id]['score'] = round($user->answer()->where('question_id',$question->id)->wherePivot('created_at','>=',$cycle->start_date)
                        ->wherePivot('created_at','<=',$cycle->end_date)->where('type',$type)->avg('level'),1);

                    $data[$type][$topic->id][$question->id]['average'] = round($question->getAverageScore($type,$user->getUserType(),$cycle),1);

                    $answers = $user->answer()->where('question_id',$question->id)->wherePivot('created_at','>=',$cycle->start_date)
                        ->wherePivot('created_at','<=',$cycle->end_date)->where('type',$type)->wherePivot('comment','<>','')->get();

                    $data[$type][$topic->id][$question->id]['comments'] = array();

                    foreach($answers as $answer) {
                        $data[$type][$topic->id][$question->id]['comments'][] = $answer->pivot->comment;
                    }
            }
            }
        }

    return $data;

    }


}


?>