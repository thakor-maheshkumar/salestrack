<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesDeliveryNoteOtherChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_delivery_note_other_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('delivery_note_id')->nullable();
            $table->bigInteger('general_ledger_id')->nullable();
            $table->string('type')->nullable();
            $table->string('rate')->nullable();
            $table->string('amount')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('total_amount')->nullable();
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
        Schema::dropIfExists('sales_delivery_note_other_charges');
    }
}
