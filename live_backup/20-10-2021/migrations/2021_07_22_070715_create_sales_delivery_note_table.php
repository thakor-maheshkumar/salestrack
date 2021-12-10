<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDeliveryNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sales_delivery_note', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('delivery_no')->nullable();
            $table->bigInteger('sales_order_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('required_date')->nullable();
            $table->string('approved_vendor_code')->nullable();
            $table->string('address')->nullable();
            $table->string('total_net_amount')->nullable();
            $table->string('total_grand_amount')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('other_net_amount')->nullable();
            $table->string('total_other_net_amount')->nullable();
            $table->string('discount_in_per')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('igst')->nullable();
            $table->string('sgst')->nullable();
            $table->string('cgst')->nullable();
            $table->string('credit_days')->nullable();
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
        Schema::dropIfExists('sales_delivery_note');
    }
}
