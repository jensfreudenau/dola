<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCompetitionDisciplineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('competition_discipline', function(Blueprint $table)
		{
			$table->foreign('competition_id')->references('id')->on('competitions')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('discipline_id')->references('id')->on('disciplines')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('competition_discipline', function(Blueprint $table)
		{
			$table->dropForeign('competition_discipline_competition_id_foreign');
			$table->dropForeign('competition_discipline_discipline_id_foreign');
		});
	}

}
