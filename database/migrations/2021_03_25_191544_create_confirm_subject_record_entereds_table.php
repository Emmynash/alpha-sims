<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmSubjectRecordEnteredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_subject_record_entereds', function (Blueprint $table) {
            $table->id();
            $table->string('session');
            $table->integer('term');
            $table->integer('subject_id');
            $table->integer('schoolid');
            $table->integer('user_id');
            $table->integer('classid');
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
        Schema::dropIfExists('confirm_subject_record_entereds');
    }
}
