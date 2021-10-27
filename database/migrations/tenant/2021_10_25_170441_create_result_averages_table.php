<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultAveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_averages', function (Blueprint $table) {
            $table->id();
            $table->integer('regno');
            $table->integer('systemnumber');
            $table->integer('schoolid');
            $table->integer('classid');
            $table->integer('term');
            $table->string('session');
            $table->integer('sumofmarks');
            $table->integer('average');
            $table->integer('position');
            $table->integer('section_id');
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
        Schema::dropIfExists('result_averages');
    }
}
