<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StockSourceItemsAddBatch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_source_items', function (Blueprint $table) {
            $table->bigInteger('batch_id')->after('stock_id')->nullable();
            $table->string('rate')->after('item_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_source_items', function (Blueprint $table) {
            //
        });
    }
}
