<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('invoicenumber');
            $table->string('invoicefor')->nullable();
            $table->string('status')->nullable();
            $table->integer('schoolid');
            $table->integer('accountant_id');
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
        Schema::dropIfExists('invoices_inventories');
    }
}
