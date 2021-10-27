<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePrincipalsignatureToNullableInAddposts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addposts', function (Blueprint $table) {
            $table->string('schoolLogo')->nullable()->change();
            $table->string('schoolprincipalsignature')->nullable()->change();
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
            $table->string('schoolLogo')->nullable()->change();
            $table->string('schoolprincipalsignature')->nullable()->change();
        });
    }
}
