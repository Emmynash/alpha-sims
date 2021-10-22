<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionclasstypeToAddsubjectSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addsubject_secs', function (Blueprint $table) {
            $table->integer('sectionclasstype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addsubject_secs', function (Blueprint $table) {
            $table->integer('sectionclasstype');
        });
    }
}
