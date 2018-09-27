<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompetitionDisciplineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('competition_discipline', function(Blueprint $table)
		{
			$table->integer('competition_id')->unsigned()->index('competition_discipline_competition_id_foreign');
			$table->integer('discipline_id')->unsigned()->index('competition_discipline_discipline_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('competition_discipline');
	}

}
