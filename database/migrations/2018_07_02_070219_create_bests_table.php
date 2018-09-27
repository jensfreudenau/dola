<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bests', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('year');
			$table->string('sex', 191);
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
			$table->string('filename', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bests');
	}

}
