<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterParticipatorDisciplinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participators', function (Blueprint $table) {
            $table->integer('discipline_id')->default(11)->nullable()->change();
        });
        Schema::table('participators', function (Blueprint $table) {
            $table->integer('ageclass_id')->default(11)->nullable()->change();
        });
        Schema::table('participators', function (Blueprint $table) {
            $table->string('discipline_cross')->nullable();
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
