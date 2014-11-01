<?php

class Review extends BaseController
{


    public function showReview($type)
    {
        $users = $this->getTableData($type);
        return View::make('review')->with('users',$users)->with('type',$type);
    }

    public function showReviewType()
    {

        return View::make('review-type')->with('manager_status',User::checkIfManager());
    }

    public function showReviewUser($type,$user_id)
    {
        $user_name = User::find($user_id)->name;
        return View::make('review-user')->with('topics',Topic::getTopics())->with('type',$type)->with('user_id',$user_id)->with('user_name',$user_name);
    }

    public function getTableData($type)
    {
        $cycle = User::getCurrentCycle();

        $users = User::getUserDetails();
        foreach ($users as $user) {
            $user->groups = User::getUserGroups($user->id);
            $user->status = User::getStatus($user->id,$type,$cycle);
            $user->reviewers = User::getReviewedBy($user->id,$type,$cycle);

        }

        return $users;
    }


    public function saveReview()
    {
        $topics = Topic::getTopics();

        $cycle = User::getCurrentCycle();

        $rules = array();

        foreach($topics as $topic) {
            $questions = $topic->question()->get();
            foreach($questions as $question) {
                $rules['question_' . $question->id] = 'required';
            }
        }

        $validator = Validator::make(Input::all(),$rules);

        if($validator->fails()) {
            return Redirect::to('review-user/' . Input::get('type') . '/' . Input::get('user'))->withErrors($validator);
        }

        $user = User::find(Input::get('user'));
        $type = Input::get('type');

        $reviewer_id = $_SESSION['user_id'];


        //Remove existing answers of the same type by the same reviewer
        DB::statement('DELETE FROM prism_answer_user
                    WHERE prism_answer_user.user_id = ? AND prism_answer_user.reviewer_id = ? AND prism_answer_user.type = ?
                    AND DATE(created_at) >= ? AND DATE(created_at) <= ?',
                    array($user->id,$reviewer_id,$type,$cycle->start_date,$cycle->end_date));



        foreach($topics as $topic) {
            $questions = $topic->question()->get();
            foreach($questions as $question) {
                $answer = Answer::find(Input::get('question_' . $question->id));
                $comment = Input::get('comment_' . $question->id);
                $user->answer()->attach($answer,array('reviewer_id' => $reviewer_id, 'type' => $type, 'comment' => $comment));

            }
        }

        $stj_sub = Input::get('speak_to_jithin');
        if(!empty($stj_sub)) {
            $stj = new SpeakToJithin;
            $stj->subject = $stj_sub;
            $stj->user_id = $reviewer_id;
            $stj->save();
        }


        return Redirect::to('success')->with('message','You have successfully saved review of ' . $user->name);
    }



}
