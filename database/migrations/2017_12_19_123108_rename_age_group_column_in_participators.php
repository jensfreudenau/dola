<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAgeGroupColumnInParticipators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participators', function(Blueprint $t) {
            $t->renameColumn('discipline', 'discipline_id');
        });
        Schema::table('participators', function(Blueprint $t) {
            $t->renameColumn('age_group', 'ageclass_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participators', function(Blueprint $t) {
            $t->renameColumn('discipline_id', 'discipline');
        });
        Schema::table('participators', function(Blueprint $t) {
            $t->renameColumn('ageclass_id', 'age_group');
        });
    }
}
