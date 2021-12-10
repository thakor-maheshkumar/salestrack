<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ColumnsDeliveryNoteOtherCharge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_delivery_note', function (Blueprint $table) {
            //$table->string('voucher_no')->nullable();
            // $table->string('other_net_amount')->nullable();
            // $table->string('total_other_net_amount')->nullable();
            // $table->string('discount_in_per')->nullable();
            // $table->string('discount_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_delivery_note', function (Blueprint $table) {
            //
        });
    }
}
