<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditedByFieldsToAllTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });

        Schema::table('purchase_receipt', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });

        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('required_date');
        });

        Schema::table('purchase_returns', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('required_date');
        });

        Schema::table('quotation', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });

        Schema::table('sales_orders', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });

        Schema::table('sales_invoice', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });

        Schema::table('sales_return', function (Blueprint $table) {
            $table->integer('edited_by')->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('purchase_receipt', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('purchase_returns', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('quotation', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('sales_orders', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('sales_invoice', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });

        Schema::table('sales_return', function (Blueprint $table) {
            $table->dropColumn(['edited_by']);
        });
    }
}
