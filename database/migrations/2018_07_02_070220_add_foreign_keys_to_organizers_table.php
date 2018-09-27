<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOrganizersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('organizers', function(Blueprint $table)
		{
			$table->foreign('address_id', 'organizers_ibfk_1')->references('id')->on('addresses')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('organizers', function(Blueprint $table)
		{
			$table->dropForeign('organizers_ibfk_1');
		});
	}

}
