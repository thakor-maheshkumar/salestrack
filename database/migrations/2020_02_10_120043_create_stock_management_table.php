<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_management', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_item_id')->nullable();
            $table->bigInteger('batch_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->string('item_name')->nullable();
            $table->string('pack_code')->nullable();
            $table->string('uom')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('balance_qty')->nullable();
            $table->string('rate')->nullable();
            $table->string('balance_value')->nullable();
            $table->string('stock_type')->nullable();
            $table->string('description')->nullable();
            $table->dateTime('created')->nullable();
            $table->integer('status')->comment('1:purchase,2:sales'); 
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
        Schema::dropIfExists('stock_management');
    }
}
