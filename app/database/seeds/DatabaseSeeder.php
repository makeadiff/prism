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
        $question->subject = 'Reliability';
        $question->order = 1;
        $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Major Delays (without reason), typically hard to reach out to, will not highlight confusions and wait for clarity';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Minor Delays (with excuses), not seeking clarification actively, \'lax\' in work';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'On time and as expected - does whatever it takes to get the job done on time and as expected, needs minimal followups';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'On time and delightful - will proactively seek clarifications and keep giving updates on tasks';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Always reliable - has built a consistent reputation for being reliable and ahead of time, very rarely seeking extensions of deadline and giving quality work';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();


        $question = new Question;
        $question->subject = 'Level of Involvement';
        $question->order = 2;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Below 80% of perceived potential without clear reasons why';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Below 80% of potential + irregular \'peaks\' due to regular and chronic reasons (health, family etc - not addressed)';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Giving 100% \'as expected\' from peers, leaders and the role';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Occasionally exceeding mandate and creating \'Wow\' in the quality of work and level of bringing oneself into it';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Consistently exceeds own standards of excellence (which are higher than organisational) and sees work as an expression of himself / herself';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();

        $question = new Question;
        $question->subject = 'Honoring the word';
        $question->order = 3;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Very vague promises, often not kept and breakdowns not acknowledged';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Gives word but consistently fails to keep it - only \'knowing\' integrity, not \'being\'';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Fairly consistent keeping of word and handling breakdowns if it is not kept';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Has a history of honouring the word, built credibility and effectively handles breakdowns';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Creates a positive influence on integrity of others and the organization';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();

        $topic = new Topic;
        $topic->subject = 'Team Work';
        $topic->order = 2;
        $topic->save();

        $question = new Question;
        $question->subject = 'Proactive Communication';
        $question->order = 1;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Waits for communication to reach, doesn\'t clarify or seek clarifications, acts on incomplete information';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Tends to do \'last minute\' communication of needs and requirements, expects to be communicated to rather than seek information out';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Adequate level of information seeking and timely updating of needs, requirements and views to the team and the organization';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Actively anticipates upcoming needs and communicates well in advance, initiates conversations that matter';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Acts as a source of information to others and encourages others to improve their communication, is in the \'know\' of what is happening @ MAD overall';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();


        $question = new Question;
        $question->subject = 'Humility';
        $question->order = 2;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Communicates superiority complex (in actions and words) that negatively affects the team, tends to be reactive and defensive when this is pointed out';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Occasional one-upmanship, abrasive humour, unwillingness to accept mistakes, draws excessive pride from position';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Grounded, aware of own\'s strengths but humble about limitations, makes others feel at ease about their shortcomings';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Develops deep connections because of being non-judgemental, seen as a very approachable leader that puts others at ease';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = ' Exemplifies a spirit of servant leadership, making others see their own strengths, occasionally self-depricating humour, holds ego very lightly';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();

         $question = new Question;
        $question->subject = 'Level Headedness';
        $question->order = 3;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Huge temper losses and tantrums that affect the entire team (irrespective of who is at fault)';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Tends to snap and get angry when things are not going right and under pressure';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Maintains composure in face of difficult situations and ensures smooth working continues';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Able to handle difficult situations with ease, handles tantrums of others tactfully';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Brings peace and resolves conflicts in the team, creates ripple-effects of joyful co-working';
        $answer->level = 5;
        $answer->question()->associate($question);
        $answer->save();

         $question = new Question;
        $question->subject = 'Personal Professional Balance';
        $question->order = 4;
            $question->topic()->associate($topic);
        $question->save();

        $answer = new Answer;
        $answer->subject = 'Work tends to be completely biased by personal preferences, seen in groupism, back-biting, preferential treatment etc';
        $answer->level = 1;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Tends to be moderately biased towards own preferences, brings some degree of \'personal\' (dysfunctional) behaviours into work';
        $answer->level = 2;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Maintains a healthy professionalism that allows for work to flow without hinderance from personal preferences, can easily prioritise what \'needs\' to be done';
        $answer->level = 3;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Able to hold the professional working along-with personal preferences, leveraging personal relationships when it benefits but putting them at the back when needed';
        $answer->level = 4;
        $answer->question()->associate($question);
        $answer->save();

        $answer = new Answer;
        $answer->subject = 'Able to foster strong relationships and equations with all members of the core team, and leverages them to further work effectiveness';
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

