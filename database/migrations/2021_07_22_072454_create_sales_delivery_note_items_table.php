<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDeliveryNoteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_delivery_note_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('delivery_note_id')->nullable();
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
            $table->string('discount')->nullable();
            $table->string('discount_in_per')->nullable();
            $table->integer('active')->default(1); 
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
        Schema::dropIfExists('sales_delivery_note_items');
    }
}
