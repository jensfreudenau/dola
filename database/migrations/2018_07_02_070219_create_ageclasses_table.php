<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgeclassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ageclasses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->nullable()->default('');
			$table->string('shortname', 191)->nullable()->default('')->index('shortname');
			$table->string('ladv', 191)->nullable()->default('');
			$table->string('dlv', 191)->nullable()->default('');
			$table->string('format', 191)->nullable()->default('');
			$table->string('year_range', 191)->nullable()->default('');
			$table->integer('order')->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('updated_by')->nullable();
			$table->timestamps();
			$table->string('rieping', 191)->nullable()->default('');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ageclasses');
	}

}
