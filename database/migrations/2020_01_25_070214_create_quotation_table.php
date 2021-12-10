<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('quotation_no')->nullable();
            $table->bigInteger('sales_ledger_id');
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('sales_person_id')->nullable();
            $table->string('valid_till')->nullable();
            $table->string('required_date')->nullable();
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
        Schema::dropIfExists('quotation');
    }
}
