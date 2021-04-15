<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddteachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addteachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schoolid');
            $table->string('classid');
            $table->string('section');
            $table->string('session');
            $table->string('shift');
            $table->string('systemid')->unique();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->string('bloodgroup')->nullable();
            $table->string('dob')->nullable();
            $table->string('courseedit')->nullable();
            $table->string('institutionedit')->nullable();
            $table->string('degreeedit')->nullable();
            $table->string('educationedit')->nullable();
            $table->string('graduationedit')->nullable();
            $table->string('residentialaddress')->nullable();
            $table->string('passport')->nullable();
            $table->string('track')->nullable();
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
        Schema::dropIfExists('addteachers');
    }
}
