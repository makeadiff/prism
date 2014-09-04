<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        Topic::truncate();
        Question::truncate();
        Answer::truncate();
        DB::table('prism_answer_user')->delete();
        DB::table('prism_reviewer_user')->delete();


        $topic = new Topic;
        $topic->subject = 'Integrity';
        $topic->order = 1;
        $topic->save();

        $question = new Question;
        $question->subject = 'Reply to mails';
        $question->order = 1;
        $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Very Bad';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Bad';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'OK';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Good';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Very Good';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();


        $question = new Question;
        $question->subject = 'Reply to Calls';
        $question->order = 2;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Very Bad';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Bad';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'OK';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Good';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Very Good';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();

        $topic = new Topic;
        $topic->subject = 'Team Work';
        $topic->order = 2;
        $topic->save();

        $question = new Question;
        $question->subject = 'Feedback';
        $question->order = 1;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Very Bad';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Bad';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'OK';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Good';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Very Good';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();


        $question = new Question;
        $question->subject = 'Collaboration';
        $question->order = 2;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Very Bad';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Bad';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'OK';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Good';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Very Good';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();

/*        $user = User::find(1);
        $answer = Answer::find(1);
        $user->answer()->attach($answer);

        $reviewer = Reviewer::find(2);
        $reviewer->user()->attach($user);

        $user = User::find(3);
        $answer = Answer::find(2);
        $user->answer()->attach($answer);

        $reviewer = Reviewer::find(4);
        $reviewer->user()->attach($user);

        $user = User::find(5);
        $answer = Answer::find(3);
        $user->answer()->attach($answer);

        $reviewer = Reviewer::find(6);
        $reviewer->user()->attach($user);*/



	}

}

