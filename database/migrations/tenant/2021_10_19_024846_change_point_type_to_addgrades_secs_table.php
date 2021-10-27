<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePointTypeToAddgradesSecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addgrades_secs', function (Blueprint $table) {
            $table->text('point')->change();
            $table->text('marksfrom')->change();
            $table->text('marksto')->change();
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
            //
        });
    }
}
