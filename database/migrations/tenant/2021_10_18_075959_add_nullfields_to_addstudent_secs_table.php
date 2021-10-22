<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullfieldsToAddstudentSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addstudent_secs', function (Blueprint $table) {
            $table->string('gender')->nullable()->change();
            $table->string('studenthouse')->nullable()->change();
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
            //
        });
    }
}
