<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_records', function (Blueprint $table) {
            $table->id();
            $table->integer('system_id');
            $table->integer('transaction_type');
            $table->integer('term');
            $table->string('session');
            $table->text('purpose');
            $table->bigInteger('amount');
            $table->integer('school_id');
            $table->string('status');
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
        Schema::dropIfExists('transaction_records');
    }
}
