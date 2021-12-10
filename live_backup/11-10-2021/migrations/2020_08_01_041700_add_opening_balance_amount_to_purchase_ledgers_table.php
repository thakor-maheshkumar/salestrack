<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOpeningBalanceAmountToPurchaseLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->string('opening_balance_amount')->nullable()->after('opening_balance');
        });

        Schema::table('sales_ledgers', function (Blueprint $table) {
            $table->string('opening_balance_amount')->nullable()->after('opening_balance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_ledgers', function (Blueprint $table) {
            $table->dropColumn(['opening_balance_amount']);
        });
        
        Schema::table('sales_ledgers', function (Blueprint $table) {
            $table->dropColumn(['opening_balance_amount']);
        });
    }
}
