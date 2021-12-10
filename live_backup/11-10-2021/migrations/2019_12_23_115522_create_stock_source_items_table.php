<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockSourceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_source_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_id')->comment('stocks,id');
            $table->bigInteger('source_warehouse')->nullable();
            $table->bigInteger('target_warehouse')->nullable();
            $table->string('item_id')->nullable()->comment('stock_items,id');
            $table->string('item_name')->nullable();
            $table->string('item_code')->nullable();
            $table->string('uom')->nullalbe();
            $table->string('quantity')->nullable();
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
        Schema::dropIfExists('stock_source_items');
    }
}
