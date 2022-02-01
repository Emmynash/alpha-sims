<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatesToAddstudentSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addstudent_secs', function (Blueprint $table) {
            $table->string('states')->nullable();
            $table->string('admissiondate')->nullable();
            $table->string('hometown')->nullable();
            $table->string('lga')->nullable();
            $table->string('admission_no')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addstudent_secs', function (Blueprint $table) {
            $table->string('states')->nullable();
            $table->string('admissiondate')->nullable();
            $table->string('hometown')->nullable();
            $table->string('lga')->nullable();
            $table->string('states')->nullable();
            $table->string('admission_no')->nullable()->change();
        });
    }
}
