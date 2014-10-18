<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReivewerTypeColunm extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prism_answer_user', function(Blueprint $table)
		{
			$table->integer('reviewer_id')->unsigned();
            $table->enum('type',['manager','managee','peer']);
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
			$table->dropColumn('reviewer_id');
            $table->dropColumn('type');
		});
	}

}
