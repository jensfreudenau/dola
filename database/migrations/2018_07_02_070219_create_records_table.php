<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('records', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('header', 191);
			$table->string('mnemonic', 191);
			$table->text('records_table', 65535);
			$table->timestamps();
			$table->integer('created_by');
			$table->integer('updated_by');
			$table->string('sex', 191);
			$table->integer('sort');
			$table->string('type', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('records');
	}

}
