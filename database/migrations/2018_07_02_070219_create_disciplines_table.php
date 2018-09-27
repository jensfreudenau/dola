<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDisciplinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('disciplines', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('shortname', 191);
			$table->string('ladv', 191);
			$table->string('dlv', 191);
			$table->string('format', 191);
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
			$table->string('rieping', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('disciplines');
	}

}
