<?php

class Question extends Eloquent
{
    protected $table = 'prism_questions';

    public function topic()
    {
        return $this->belongsTo('Topic');
    }

    public function answer()
    {
        return $this->hasMany('Answer');
    }

    public static function getQuestions()
    {
        return Question::all();
    }

    public function getAverageScore($review_type, $user_type, $cycle)
    {

        $data = DB::select("SELECT AVG(prism_answers.level) as average FROM prism_answer_user
                            INNER JOIN prism_answers
                            ON prism_answers.id = prism_answer_user.answer_id
                            INNER JOIN prism_questions
                            ON prism_answers.question_id = prism_questions.id
                            INNER JOIN User
                            ON User.id = prism_answer_user.user_id
                            INNER JOIN UserGroup
                            ON UserGroup.user_id = User.id
                            INNER JOIN `Group`
                            ON `Group`.id = UserGroup.group_id
                            WHERE prism_answer_user.type = ? AND `Group`.type = ?
                            AND prism_answer_user.created_at >= ? AND prism_answer_user.created_at <= ?
                            AND UserGroup.year = ? AND prism_questions.id = ?
                            ",array($review_type,$user_type,$cycle->start_date,$cycle->end_date,date("Y"),$this->id));

        if(!empty($data[0]->average))
            return $data[0]->average;
        else
            return 0;

    }
}