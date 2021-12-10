<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiledsToLedgerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_ledgers', function (Blueprint $table) {
            $table->bigInteger('customer_group')->after('ledger_name')->nullable()->comment('customer_groups id');
        });

        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->bigInteger('supplier_group')->after('ledger_name')->nullable()->comment('supplier_group id');
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
            $table->dropColumn(['customer_group']);
        });

        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->dropColumn(['supplier_group']);
        });
    }
}
