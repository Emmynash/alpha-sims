<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionToAssignmentTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignment_tables', function (Blueprint $table) {
            $table->string('session');
            $table->integer('term');
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assignment_tables', function (Blueprint $table) {
            $table->string('session');
            $table->integer('term');
            $table->string('status')->nullable();
        });
    }
}
