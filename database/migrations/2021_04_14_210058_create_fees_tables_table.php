<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('system_id');
            $table->integer('schoolid');
            $table->bigInteger('amount_paid');
            $table->integer('term');
            $table->string('session');
            $table->integer('status');
            $table->integer('invoice_id');
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
        Schema::dropIfExists('fees_tables');
    }
}
