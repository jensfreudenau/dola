<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnnounciatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('announciators', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('competition_id')->unsigned()->nullable()->index('participator_clubs_competitions_id_index');
			$table->string('name', 191)->default('')->index('participator_clubs_annunciator_index');
			$table->string('clubname', 191)->nullable()->default('')->index('participator_clubs_clubname_index');
			$table->string('street', 191)->nullable()->default('');
			$table->string('city', 191)->nullable()->default('');
			$table->string('email', 191);
			$table->string('telephone', 191)->nullable()->default('');
			$table->boolean('resultlist')->nullable();
			$table->date('create_date')->nullable();
			$table->timestamps();
			$table->string('modified_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('announciators');
	}

}
