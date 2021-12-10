<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpeningBalanceToSalesLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_ledgers', function (Blueprint $table) {
            $table->string('opening_balance')->nullable()->after('active_interest_calculation');
        });

        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->string('opening_balance')->nullable()->after('active_interest_calculation');
        });

        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->string('status')->nullable()->after('edited_by');
        });

        Schema::table('sales_invoice', function (Blueprint $table) {
            // $table->string('payment_status')->nullable()->after('edited_by');
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
            $table->dropColumn(['opening_balance']);
        });

        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->dropColumn(['opening_balance']);
        });

        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });

        Schema::table('sales_invoice', function (Blueprint $table) {
            // $table->dropColumn(['payment_status']);
        });
    }
}
