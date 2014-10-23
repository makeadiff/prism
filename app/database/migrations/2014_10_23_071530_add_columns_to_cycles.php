<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCycles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('prism_cycles', function(Blueprint $table)
		{
			$table->string('name',100);
            $table->date('start_date');
            $table->date('end_date');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('prism_cycles', function(Blueprint $table)
		{
			$table->dropColumn('name');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');

		});
	}

}
