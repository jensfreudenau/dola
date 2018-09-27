<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompetitionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('competitions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organizer_id')->index('competitions_team_id_index');
			$table->string('season', 11)->index('competitions_addresses_id_index');
			$table->string('start_date', 191);
			$table->string('submit_date', 191)->nullable();
			$table->text('award', 65535)->nullable();
			$table->string('classes', 191)->nullable();
			$table->string('info', 191)->nullable();
			$table->string('header', 191);
			$table->text('timetable_1', 65535)->nullable();
			$table->timestamps();
			$table->boolean('register')->nullable();
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->boolean('only_list');
			$table->boolean('ignore_ageclasses')->nullable();
			$table->boolean('ignore_disciplines')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('competitions');
	}

}
