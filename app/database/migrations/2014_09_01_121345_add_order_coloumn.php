<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderColoumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('prism_topics', function($table)
            {
                $table->integer('order')->unsigned;
            });
        Schema::table('prism_questions', function($table)
            {
                $table->integer('order')->unsigned;
            });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('prism_topics', function($table)
            {
                $table->dropColumn('order');
            });
        Schema::table('prism_questions', function($table)
            {
                $table->dropColumn('order');
            });
	}

}
