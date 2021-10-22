<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatesToAddpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addposts', function (Blueprint $table) {
            $table->bigInteger('promotionaverage')->nullable();
            $table->date('firsttermstarts')->nullable();
            $table->date('firsttermends')->nullable();
            $table->date('secondtermbegins')->nullable();
            $table->date('secondtermends')->nullable();
            $table->date('thirdtermbegins')->nullable();
            $table->date('thirdtermends')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addposts', function (Blueprint $table) {
            $table->bigInteger('promotionaverage')->nullable();
            $table->date('firsttermstarts')->nullable();
            $table->date('firsttermends')->nullable();
            $table->date('secondtermbegins')->nullable();
            $table->date('secondtermends')->nullable();
            $table->date('thirdtermbegins')->nullable();
            $table->date('thirdtermends')->nullable();
        });
    }
}
