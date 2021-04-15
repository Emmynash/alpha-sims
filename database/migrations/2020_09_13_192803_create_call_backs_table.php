<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_backs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('date');
            $table->String('fullname');
            $table->String('phonenumber');
            $table->String('emailadd');
            $table->String('message');
            $table->String('status');
            $table->String('willcallback');
            $table->String('address');
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
        Schema::dropIfExists('call_backs');
    }
}
