<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('po_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('address')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('total_net_amount')->nullable();
            $table->string('other_net_amount')->nullable();
            $table->string('total_other_net_amount')->nullable();
            $table->string('discount_in_per')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('igst')->nullable();
            $table->string('sgst')->nullable();
            $table->string('cgst')->nullable();
            $table->string('transporter')->nullable();
            $table->string('reference')->nullable();
            $table->string('credit_days')->nullable();
            $table->string('item_pending')->nullable();
            $table->string('item_received')->nullable();            
            $table->integer('active')->default(1);
            $table->string('approved_vendor_code')->nullable();
            $table->string('debit_to')->nullable();
            $table->string('income_account')->nullable();
            $table->string('expense_account')->nullable();
            $table->string('asset')->nullable();
            $table->string('type')->nullable();
            $table->string('required_date')->nullable();
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
        Schema::dropIfExists('purchase_invoices');
    }
}
