<?php

class User extends Eloquent
{
    protected $table = 'User';

    public function answer()
    {
        return $this->belongsToMany('Answer','prism_answer_user')->withPivot('reviewer_id','type','comment')->withTimestamps();
    }

    public function city()
    {
        return $this->belongsTo('City');
    }

    public function group()
    {
        return $this->belongsToMany('Group','UserGroup','user_id','group_id');
    }


    public static function getCity($user_id)
    {
        $city = DB::select('SELECT city_id FROM User WHERE id = ?',array($user_id));

        return $city[0]->city_id;
    }

    public static function checkIfCTL($user_id)
    {
        $group = DB::select('SELECT Group.name as group_name FROM User
                                INNER JOIN UserGroup
                                ON UserGroup.user_id = User.id
                                INNER JOIN `Group`
                                ON `Group`.id = UserGroup.group_id
                                WHERE User.id = ?',array($user_id));

        if($group[0]->group_name == 'City Team Lead')
        {
            return true;
        }else{
            return false;
        }
    }

    public static function getCityUsers($city_id)
    {
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
                                AND City.id = ?
                                ',array('volunteer','national','fellow','strat',$city_id));

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


    public static function getUserDetails()
    {
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

    public static function getUserGroups($user_id)
    {
        $groups = DB::select('SELECT `Group`.id,`Group`.name FROM `Group`
                    INNER JOIN `UserGroup` ON `Group`.id=`UserGroup`.group_id
                    WHERE `UserGroup`.user_id=?
                    AND (Group.type = ? OR Group.type = ? OR Group.type = ?)',array($user_id,'national','fellow','strat'));

        $all_groups = array();
        foreach($groups as $group) {
            $all_groups[$group->id] = $group->name;
        }

        return $all_groups;
    }

    public static function checkIfManager()
    {
        $user = User::find($_SESSION['user_id']);

        $groups = $user->group()->get();

        foreach($groups as $group) {
            //if($group->type == 'national' || $group->type == 'strat' || $group->name == 'City Team Lead' || $group->name == 'Fundraising Head')
            if($group->type == 'national' || $group->type == 'strat')
                return true;
        }

        return false;
    }

    public static function checkIfBro()
    {
        $user = User::find($_SESSION['user_id']);

        $groups = $user->group()->get();

        foreach($groups as $group) {
            //if($group->type == 'national' || $group->type == 'strat' || $group->name == 'City Team Lead' || $group->name == 'Fundraising Head')
            if($group->type == 'national')
                return true;
        }

        return false;
    }



    public static function getCurrentCycle()
    {
        $today = new DateTime("today");
        $today = date_format($today,'Y-m-d');

        $cycles = Cycle::all();

        $current_cycle = Cycle::first();

        foreach($cycles as $cycle) {
            if($today >= $cycle->start_date && $today <= $cycle->end_date) {
                $current_cycle = $cycle;
                break;
            }

        }

        return $current_cycle;
    }

    public static function getStatus($user_id,$type, $cycle)
    {



        $count = DB::select('SELECT COUNT(*) as count FROM prism_answer_user WHERE user_id = ?
                                AND created_at >= ? AND created_at <= ? AND type = ?',array($user_id,$cycle->start_date,$cycle->end_date,$type));

        if($count[0]->count == 0)
            return 'No';
        else
            return 'Yes';
    }

    public static function getReviewedBy($user_id,$type, $cycle)
    {
        $user = User::find($user_id);



        $reviewer_ids = array();

        $answers = $user->answer()->wherePivot('created_at','<=',$cycle->end_date)->wherePivot('created_at','>=',$cycle->start_date)->wherePivot('type',$type)->get();

        foreach($answers as $answer) {
            array_push($reviewer_ids,$answer->pivot->reviewer_id);
        }

        $reviewer_ids = array_unique($reviewer_ids);

        $reviewer_names = array();

        foreach($reviewer_ids as $id) {
            $reviewer = User::find($id);
            if(!empty($reviewer))
                array_push($reviewer_names,$reviewer->name);
        }

        return $reviewer_names;

    }


    /*public static function getVerticalStatus()
    {
        $total_fellows_strats = DB::select('SELECT Vertical.id as id, Vertical.name as name, COUNT(User.id) as total FROM User
                                        INNER JOIN UserGroup
                                        ON UserGroup.user_id = User.id
                                        INNER JOIN `Group`
                                        ON `Group`.id = UserGroup.group_id
                                        INNER JOIN Vertical
                                        ON Vertical.id = `Group`.vertical_id
                                        WHERE User.status = ? AND User.user_type = ?
                                        AND (Group.type = ? OR Group.type = ?)
                                        GROUP BY Vertical.id',array(1,'volunteer','fellow','strat'));

        $completed_manager = DB::select('SELECT Vertical.id as id, COUNT(User.id) as completed FROM User
                                        INNER JOIN UserGroup
                                        ON UserGroup.user_id = User.id
                                        INNER JOIN `Group`
                                        ON `Group`.id = UserGroup.group_id
                                        INNER JOIN Vertical
                                        ON Vertical.id = `Group`.vertical_id
                                        INNER JOIN prism_reviewer_user
                                        ON prism_reviewer_user.user_id = User.id
                                        WHERE User.status = ? AND User.user_type = ?
                                        AND (Group.type = ? OR Group.type = ?)
                                        AND Group.name <> ? AND Group.name <> ?
                                        GROUP BY Vertical.id',array(1,'volunteer','national','fellow','All Access','Executive Team'));

        foreach($vertical_total as $vt) {
            $vt->completed = 0;
            foreach($vertical_completed as $vc) {
                if($vt->id == $vc->id) {
                    $vt->completed = $vc->completed;
                    break;
                }
            }
        }

        return $vertical_total;
    }*/

    public static function getScore($user_id, $topic_id)
    {
        $score = DB::select('SELECT AVG(prism_answers.level) AS score FROM prism_answers
                                INNER JOIN prism_answer_user
                                ON prism_answer_user.answer_id = prism_answers.id
                                INNER JOIN prism_questions
                                ON prism_answers.question_id = prism_questions.id
                                WHERE prism_answer_user.user_id = ? AND prism_questions.topic_id = ?',
                                array($user_id,$topic_id));

        if(!empty($score[0]->score))
          return $score[0]->score;
        else
          return 0;



    }

    public static function getAnswers($user_id)
    {
        $cycle = User::getCurrentCycle();
        $data = DB::select('SELECT prism_questions.subject as question, prism_answers.level as level, prism_answers.subject as answer
                            FROM prism_answers
                            INNER JOIN prism_answer_user
                            ON prism_answer_user.answer_id = prism_answers.id
                            INNER JOIN prism_questions
                            ON prism_answers.question_id = prism_questions.id
                            WHERE prism_answer_user.user_id = ?
                            AND prism_answer_user.created_at >= ? AND prism_answer_user.created_at <= ?
                            GROUP BY prism_questions.id',array($user_id,$cycle->start_date,$cycle->end_date));
        return $data;
    }

    public static function getVerticalScore()
    {
        $users = DB::select('SELECT User.id as id, User.name as name,City.name as city,City.id as city_id,
                                Region.name as region, Region.id as region_id,
                                Vertical.name as vertical, Vertical.id as vertical_id FROM User
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
                                AND Group.name <> ? AND Group.name <> ?
                                ',array('volunteer','national','fellow','All Access','Executive Team'));

        $verticals = DB::select('SELECT id, name FROM Vertical');
        $cities = DB::select('SELECT id, name FROM City');
        $regions = DB::select('SELECT id, name FROM Region');
        $topics = Topic::getTopics();

        $vertical_score = array();

        foreach($users as $user) {
            foreach($verticals as $vertical) {
                foreach($cities as $city) {
                    foreach($topics as $topic) {
                        if($user->vertical_id == $vertical->id && $user->city_id == $city->id) {
                            $score = User::getScore($user->id,$topic->id);

                            if(!isset($vertical_score[$vertical->id][$city->id][$topic->id]['count']))
                                $vertical_score[$vertical->id][$city->id][$topic->id]['count'] = 0;

                            if($score != 0)
                                $vertical_score[$vertical->id][$city->id][$topic->id]['count']++;

                            if(!isset($vertical_score[$vertical->id][$city->id][$topic->id]['total']))
                                $vertical_score[$vertical->id][$city->id][$topic->id]['total'] = 0;

                            $vertical_score[$vertical->id][$city->id][$topic->id]['total'] += $score;

                            if(!isset($vertical_score[$vertical->id][$city->id][$topic->id]['score']))
                                $vertical_score[$vertical->id][$city->id][$topic->id]['score'] = 0;
                            if($score != 0)
                                $vertical_score[$vertical->id][$city->id][$topic->id]['score'] = $vertical_score[$vertical->id][$city->id][$topic->id]['total'] / $vertical_score[$vertical->id][$city->id][$topic->id]['count'];
                        }
                    }
                }
            }
        }

        return $vertical_score;


    }





}
