<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_receipt', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('po_id')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('date')->nullable();
            $table->string('qc_status')->default(0)->nullable();
            $table->string('address')->nullable();
            $table->string('approved_vendor_code')->nullable();
            $table->string('shortage_qty')->nullable();
            $table->string('good_condition_container')->nullable();
            $table->string('container_have_product')->nullable();
            $table->string('container_have_tare_weight')->nullable();
            $table->string('container_dedust_with')->nullable();
            $table->string('dedust_done_by')->nullable();
            $table->string('dedust_check_by')->nullable();
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
        Schema::dropIfExists('purchase_receipt');
    }
}
