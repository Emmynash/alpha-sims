<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestModelAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_model_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amountrequesting');
            $table->text('reasonforrequest');
            $table->integer('schoolid');
            $table->boolean('seeenstatus');
            $table->string('status');
            $table->string('dateaccepted');
            $table->integer('sender');
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
        Schema::dropIfExists('request_model_accounts');
    }
}
