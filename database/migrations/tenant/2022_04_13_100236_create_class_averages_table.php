<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassAveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_averages', function (Blueprint $table) {
            $table->id();
            $table->integer('classid');
            $table->integer('term');
            $table->string('session');
            $table->decimal('average', 5, 1);
            $table->integer('sectionId');
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
        Schema::dropIfExists('class_averages');
    }
}
