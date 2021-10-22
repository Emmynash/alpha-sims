<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddmotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addmotos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('user_id');
            $table->string('regno');
            $table->string('session');
            $table->string('term');
            $table->string('neatness');
            $table->string('punctuality');
            $table->string('reliability');
            $table->string('politeness');
            $table->string('honesty');
            $table->string('selfcontrol');
            $table->string('cooperation');
            $table->string('attentivity');
            $table->string('initiative');
            $table->string('organizationalability');
            $table->string('perseverance');
            $table->string('flexibity');
            $table->string('handwriting');
            $table->string('gamessport');
            $table->string('creativity');
            $table->string('handlingoftools');
            $table->string('dexterity');
            $table->string('notecopying');
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
        Schema::dropIfExists('addmotos');
    }
}
