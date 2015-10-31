<?php

class Topic extends Eloquent
{
    protected $table = 'prism_topics';

    public function question(){
        return $this->hasMany('Question');
    }

    public static function getTopics()
    {
        return Topic::all();
    }

    public function getUserScore($user_id,$review_type,$cycle)
    {
        $data = DB::select('SELECT AVG(prism_answers.level) AS score FROM prism_answers
                                INNER JOIN prism_answer_user
                                ON prism_answer_user.answer_id = prism_answers.id
                                INNER JOIN prism_questions
                                ON prism_answers.question_id = prism_questions.id
                                WHERE prism_answer_user.user_id = ? AND prism_questions.topic_id = ?
                                AND prism_answer_user.type = ? AND prism_answer_user.created_at >= ?
                                AND prism_answer_user.created_at <= ?',
                                array($user_id,$this->id,$review_type,$cycle->start_date,$cycle->end_date));

        if(!empty($data[0]->score))
            return $data[0]->score;
        else
            return 0;

    }

    public function getAverageScore($review_type, $user_type, $cycle)
    {

        $data = DB::select("SELECT AVG(prism_answers.level) as average FROM prism_answer_user
                            INNER JOIN prism_answers
                            ON prism_answers.id = prism_answer_user.answer_id
                            INNER JOIN prism_questions
                            ON prism_answers.question_id = prism_questions.id
                            INNER JOIN prism_topics
                            ON prism_questions.topic_id = prism_topics.id
                            INNER JOIN User
                            ON User.id = prism_answer_user.user_id
                            INNER JOIN UserGroup
                            ON UserGroup.user_id = User.id
                            INNER JOIN `Group`
                            ON `Group`.id = UserGroup.group_id
                            WHERE prism_answer_user.type = ? AND `Group`.type = ?
                            AND prism_answer_user.created_at >= ? AND prism_answer_user.created_at <= ?
                            AND UserGroup.year = ? AND prism_topics.id = ?
                            ",array($review_type,$user_type,$cycle->start_date,$cycle->end_date,date("Y"),$this->id));

        return $data[0]->average;

    }
}