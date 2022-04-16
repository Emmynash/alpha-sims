<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExamsTotalsToStudentAveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_averages', function (Blueprint $table) {
            $table->decimal('examsTotal', 5, 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_averages', function (Blueprint $table) {
            $table->decimal('examsTotal', 5, 1);
        });
    }
}
