<?php

class User extends Eloquent
{
    protected $table = 'User';

    public function answer()
    {
        return $this->belongsToMany('Answer','prism_answer_user')->withTimestamps();
    }

    public function reviewer()
    {
        return $this->belongsToMany('Reviewer','prism_reviewer_user')->withTimestamps();
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
                                AND (Group.type = ? OR Group.type = ?)
                                ',array('volunteer','national','fellow'));

        return $users;
    }

    public static function getUserGroups($user_id)
    {
        $groups = DB::select('SELECT `Group`.id,`Group`.name FROM `Group`
                    INNER JOIN `UserGroup` ON `Group`.id=`UserGroup`.group_id
                    WHERE `UserGroup`.user_id=?',array($user_id));

        $all_groups = array();
        foreach($groups as $group) {
            $all_groups[$group->id] = $group->name;
        }

        return $all_groups;
    }

    public static function getStatus($user_id)
    {
        $count = DB::select('SELECT COUNT(*) as count FROM prism_reviewer_user WHERE user_id = ?',array($user_id));

        if($count[0]->count == 0)
            return 'Pending';
        else
            return 'Done';
    }


    public static function getVerticalStatus()
    {
        $vertical_total = DB::select('SELECT Vertical.id as id, Vertical.name as name, COUNT(User.id) as total FROM User
                                        INNER JOIN UserGroup
                                        ON UserGroup.user_id = User.id
                                        INNER JOIN `Group`
                                        ON `Group`.id = UserGroup.group_id
                                        INNER JOIN Vertical
                                        ON Vertical.id = `Group`.vertical_id
                                        WHERE User.status = ? AND User.user_type = ?
                                        AND (Group.type = ? OR Group.type = ?)
                                        GROUP BY Vertical.id',array(1,'volunteer','national','fellow'));

        $vertical_completed = DB::select('SELECT Vertical.id as id, COUNT(User.id) as completed FROM User
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
                                        GROUP BY Vertical.id',array(1,'volunteer','national','fellow'));

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
    }

    public function saveAnswer($answer_id)
    {
        $answer = Answer::find($answer_id);
        $this->answer()->attach($answer);
    }

    public function removeAnswers()
    {
        $this->answer()->detach();
    }

    public function saveReviewer($reviewer)
    {

        $this->reviewer()->attach($reviewer);
    }

    public function RemoveReviewer()
    {
        $this->reviewer()->detach();
    }

}
