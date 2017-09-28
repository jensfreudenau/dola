<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->integer('team_id')->index();
            $table->integer('addresses_id')->index();
            $table->string('start_date');
            $table->string('submit_date');
            $table->string('award');
            $table->string('classes');
            $table->string('info');
            $table->string('header');
            $table->string('participators_1');
            $table->string('participators_2');
            $table->text('timetable_1');
            $table->text('timetable_2');
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
        Schema::dropIfExists('competitions');
    }
}
