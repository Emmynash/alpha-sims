<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addposts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schooltype');
            $table->String('schoolname');
            $table->String('schoolemail');
            $table->String('mobilenumber');
            $table->String('schoolLogo');
            $table->String('schoolwebsite');
            $table->String('dateestablished');
            $table->String('schooladdress');
            $table->String('schoolsession')->nullable();
            $table->String('schoolprincipalsignature');
            $table->string('status');
            $table->string('shoolinitial')->nullable()->unique();
            $table->string('periodfrom')->nullable();
            $table->string('periodto')->nullable();
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
        Schema::dropIfExists('addposts');
    }
}
