<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveReivewerId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('UPDATE prism_answer_user au
		                JOIN prism_reviewer_user ru
		                ON au.user_id = ru.user_id
		                SET au.reviewer_id = ru.reviewer_id');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
