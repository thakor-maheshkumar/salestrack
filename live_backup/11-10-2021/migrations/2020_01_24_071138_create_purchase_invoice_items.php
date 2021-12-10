<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoiceItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('purchase_invoice_id')->nullable();
            $table->bigInteger('stock_item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('rate')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('cess')->nullable();
            $table->string('cess_amount')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('item_pending')->nullable();
            $table->string('item_received')->nullable();
            $table->integer('active')->default(1);  
            $table->string('discount')->nullable();
            $table->string('discount_in_per')->nullable();
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
        Schema::dropIfExists('purchase_invoice_items');
    }
}
