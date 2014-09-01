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

        }

        return $users;
    }

    public function saveReview()
    {
        $user = User::find(Input::get('user'));

        $reviewer = Reviewer::find($_SESSION['user_id']);

        $user->removeReviewer();
        $user->saveReviewer($reviewer);

        $topics = Topic::getTopics();

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
