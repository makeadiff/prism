<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prism_answer_user', function(Blueprint $table)
		{
			$table->string('comment',1000);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prism_answer_user', function(Blueprint $table)
		{
			$table->dropColumn('comment');
		});
	}

}
