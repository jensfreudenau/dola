<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdditionalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('additionals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('competition_id');
			$table->string('key', 191);
			$table->text('value');
			$table->string('mnemonic', 191);
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('additionals');
	}

}
