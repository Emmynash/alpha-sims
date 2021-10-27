<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_secs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schoolid');
            $table->string('eventtitle');
            $table->string('eventdetails');
            $table->string('eventstart');
            $table->string('eventend');
            $table->string('status');
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
        Schema::dropIfExists('events_secs');
    }
}
