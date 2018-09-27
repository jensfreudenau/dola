<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrganizersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('address_id')->unsigned()->nullable()->index('team_address');
			$table->string('name', 191);
			$table->string('leader', 191)->nullable();
			$table->string('homepage', 191)->nullable();
			$table->timestamps();
			$table->softDeletes()->index('teams_deleted_at_index');
			$table->integer('updated_by')->nullable();
			$table->integer('created_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('organizers');
	}

}
