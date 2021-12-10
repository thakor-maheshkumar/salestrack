<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wo_id')->nullable();
            $table->bigInteger('stock_item_id')->nullable();
            $table->bigInteger('batch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('work_order_items');
    }
}
