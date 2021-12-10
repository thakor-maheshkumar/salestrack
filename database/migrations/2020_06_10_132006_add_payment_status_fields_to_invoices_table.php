<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusFieldsToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            Schema::table('purchase_invoices', function (Blueprint $table) {
                $table->string('payment_status')->nullable()->after('edited_by');
            });

            Schema::table('sales_invoice', function (Blueprint $table) {
                $table->string('payment_status')->nullable()->after('edited_by');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->dropColumn(['payment_status']);
        });

        Schema::table('sales_invoice', function (Blueprint $table) {
             $table->dropColumn(['payment_status']);
        });
    }
}
