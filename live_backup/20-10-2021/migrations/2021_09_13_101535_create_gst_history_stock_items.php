<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGstHistoryStockItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gst_history_stock_items', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_item_id')->nullable();
            $table->string('rate')->nullable();
            $table->string('old_rate')->nullable();
            $table->string('applicable_date')->nullable();
            $table->string('old_applicable_date')->nullable();
            $table->string('cess_rate')->nullable();
            $table->string('old_cess_rate')->nullable();
            $table->string('cess_applicable_date')->nullable();
            $table->string('old_cess_applicable_date')->nullable();
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
        Schema::dropIfExists('gst_history_stock_items');
    }
}
