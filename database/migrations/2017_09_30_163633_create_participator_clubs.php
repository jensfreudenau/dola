<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipatorClubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participator_clubs', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('competitions_id')->index();
            $table->string('annunciator');
            $table->string('clubname');
            $table->string('street');
            $table->string('city');
            $table->string('email');
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
        //
    }
}
