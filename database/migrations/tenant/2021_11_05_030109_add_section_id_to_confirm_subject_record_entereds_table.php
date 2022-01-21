<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionIdToConfirmSubjectRecordEnteredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('confirm_subject_record_entereds', function (Blueprint $table) {
            $table->integer('section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('confirm_subject_record_entereds', function (Blueprint $table) {
            $table->integer('section_id');
        });
    }
}
