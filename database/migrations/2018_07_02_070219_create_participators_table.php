<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participators', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('announciator_id')->index('participators_participator_clubs_id_index');
			$table->string('prename', 191);
			$table->string('lastname', 191);
			$table->string('birthyear', 191);
			$table->integer('ageclass_id')->nullable()->default(11);
			$table->integer('discipline_id')->nullable()->default(11);
			$table->string('best_time', 191)->nullable();
			$table->timestamps();
			$table->string('discipline_cross', 191)->nullable();
			$table->string('clubname', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('participators');
	}

}
