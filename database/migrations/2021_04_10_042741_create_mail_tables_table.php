<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('classid')->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('type');
            $table->integer('schoolid');
            $table->integer('mailbody');
            $table->string('seenstatus');
            $table->integer('senderid');
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
        Schema::dropIfExists('mail_tables');
    }
}
