<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldTypeToAddstudentSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addstudent_secs', function (Blueprint $table) {
            $table->text('insession')->nullable()->change();
            $table->text('gender')->nullable()->change();
            $table->text('studenthouse')->nullable()->change();
            $table->text('studentreligion')->nullable()->change();
            $table->text('bloodgroup')->nullable()->change();
            $table->text('studentclub')->nullable()->change();
            $table->text('studentshift')->nullable()->change();
            $table->text('studentfathername')->nullable()->change();
            $table->text('studentfathernumber')->nullable()->change();
            $table->text('studentmothersname')->nullable()->change();
            $table->text('studentmothersnumber')->nullable()->change();
            $table->text('studentpresenthomeaddress')->nullable()->change();
            $table->text('studentpermanenthomeaddress')->nullable()->change();
            $table->text('dateOfBirth')->nullable()->change();
            $table->text('states')->nullable()->change();
            $table->text('lga')->nullable()->change();
            $table->text('hometown')->nullable()->change();
            $table->text('sessionstatus')->nullable()->change();
            $table->text('admission_no')->nullable()->change();

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
