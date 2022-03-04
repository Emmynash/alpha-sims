<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeForTotalsAssessmentTableTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessment_table_totals', function (Blueprint $table) {
            $table->decimal('totals', 5, 1)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessment_table_totals', function (Blueprint $table) {
            $table->decimal('totals', 5, 1)->nullable()->default(0)->change();
        });
    }
}
