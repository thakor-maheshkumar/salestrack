<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeNullableFieldsToSalesLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_ledgers', function (Blueprint $table) {
            $table->boolean('is_tds_deductable')->comment('0: No, 1: Yes')->nullable()->change();
            $table->string('include_assessable_value', 50)->default(0)->comment('0: Not Applicable, 1: GST')->nullable()->change();
            $table->string('applicable', 50)->default(0)->comment('0: Both, 1: Good, 2: service')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_ledgers', function (Blueprint $table) {
            $table->boolean('is_tds_deductable')->comment('0: No, 1: Yes')->change();
            $table->string('include_assessable_value', 50)->default(0)->comment('0: Not Applicable, 1: GST')->change();
            $table->string('applicable', 50)->default(0)->comment('0: Both, 1: Good, 2: service')->change();
        });
    }
}
