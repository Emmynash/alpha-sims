<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeAddgradesSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addgrades_secs', function (Blueprint $table) {
            $table->string('marksfrom', 64)->change();
            $table->string('marksto', 64)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addgrades_secs', function (Blueprint $table) {
            $table->string('marksfrom', 64)->change();
            $table->string('marksto', 64)->change();
        });
    }
}
