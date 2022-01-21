<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddsubjectSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addsubject_secs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schoolid');
            $table->string('classid')->nullable();
            $table->string('subjectname');
            $table->integer('sectionclasstype');
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
        Schema::dropIfExists('addsubject_secs');
    }
}
