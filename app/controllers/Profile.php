<?php

class Profile extends BaseController
{
    public function showMyProfile($cycle = 2)
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

    public function showViewProfile($user_id, $cycle = 2) {

        if(empty($cycle))
            $cycle = User::getCurrentCycle();
        else
            $cycle = Cycle::find($cycle);

        $user = User::find($user_id);

        $data = $this->getScore($user,$cycle);

        $topics = Topic::all();

        $types = array('managee','manager','peer');

        $cycles = Cycle::all();

        return View::make('profile')->with('data',$data)->with('topics',$topics)->with('types',$types)
                    ->with('cycles',$cycles)->with('cycle_id',$cycle->id)->with('user',$user)->with('source','view-profile');



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



                foreach($questions as $question) {


                    $data[$type][$topic->id][$question->id]['score'] = $user->answer()->where('question_id',$question->id)->wherePivot('created_at','>=',$cycle->start_date)
                        ->wherePivot('created_at','<=',$cycle->end_date)->where('type',$type)->avg('level');



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