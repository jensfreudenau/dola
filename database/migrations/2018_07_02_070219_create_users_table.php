<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
			$table->string('email', 191);
			$table->string('password', 191);
			$table->integer('role_id')->unsigned()->nullable()->index('41905_59314b1a6c90f');
			$table->string('remember_token', 191)->nullable();
			$table->timestamps();
			$table->string('last_login', 191);
			$table->string('last_logout', 191);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
