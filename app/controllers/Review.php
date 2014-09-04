<?php

class Review extends BaseController
{


    public function showReview()
    {
        $users = $this->getTableData();
        return View::make('review')->with('users',$users);
    }

    public function showReviewUser()
    {
        return View::make('review-user')->with('topics',Topic::getTopics());
    }

    public function getTableData()
    {
        $users = User::getUserDetails();
        foreach ($users as $user) {
            $user->groups = User::getUserGroups($user->id);
            $user->status = User::getStatus($user->id);
            $user->reviewer = User::getReviewedBy($user->id);

        }

        return $users;
    }


    public function saveReview()
    {
        $topics = Topic::getTopics();

        $rules = array();

        foreach($topics as $topic) {
            $questions = $topic->question()->get();
            foreach($questions as $question) {
                $rules['question_' . $question->id] = 'required';
            }
        }

        $validator = Validator::make(Input::all(),$rules);

        if($validator->fails()) {
            return Redirect::to('review-user?user=' . Input::get('user'))->withErrors($validator);
        }

        $user = User::find(Input::get('user'));

        $reviewer = Reviewer::find($_SESSION['user_id']);

        $user->removeReviewer();
        $user->saveReviewer($reviewer);

        $user->removeAnswers();

        foreach($topics as $topic) {
            $questions = $topic->question()->get();
            foreach($questions as $question) {
                $user->saveAnswer(Input::get('question_' . $question->id));
            }
        }

        return Redirect::to('success')->with('message','You have successfully saved review of ' . $user->name);
    }



}
