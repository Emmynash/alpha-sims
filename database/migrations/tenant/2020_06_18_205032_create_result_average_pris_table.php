<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultAveragePrisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_average_pris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('regno');
            $table->string('systemnumber');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('term');
            $table->string('session');
            $table->string('sumofmarks');
            $table->string('average');
            $table->string('position');
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
        Schema::dropIfExists('result_average_pris');
    }
}
