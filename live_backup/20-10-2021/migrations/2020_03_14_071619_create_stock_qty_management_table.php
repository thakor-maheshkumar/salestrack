<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockQtyManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_qty_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_item_id')->nullable();
            $table->bigInteger('batch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('qty')->nullable();
            $table->string('balance_value')->nullable();
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
        Schema::dropIfExists('stock_qty_management');
    }
}
