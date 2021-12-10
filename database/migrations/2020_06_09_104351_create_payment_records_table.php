<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('posting_date')->nullable();
            /*$table->bigInteger('stock_item_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('pack_code')->nullable();*/
            $table->string('account')->nullable();
            $table->string('debit')->nullable();
            $table->string('credit')->nullable();
            $table->string('balance')->nullable();
            $table->morphs('recordable');
            $table->string('voucher_type')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('against_account')->nullable();
            $table->string('party_type')->nullable();
            $table->string('party')->nullable();
            $table->string('against_voucher_type')->nullable();
            $table->string('against_voucher')->nullable();
            $table->string('supplier_invoice')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('payment_records');
    }
}
