<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMotoSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moto_secs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('user_id');
            $table->string('regno');
            $table->string('session');
            $table->string('term');
            $table->string('punctuality');
            $table->string('attendance');
            $table->string('attentivity');
            $table->string('assignment');
            $table->string('neatness');
            $table->string('honesty');
            $table->string('selfcontrol');
            $table->string('gamessport');
            $table->string('handlingoftools');
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
        Schema::dropIfExists('moto_secs');
    }
}
