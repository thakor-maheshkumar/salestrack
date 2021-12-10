<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockGroupGstHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_group_gst_history', function (Blueprint $table) {
            $table->id();
            $table->integer('stock_group_id')->nullable();
            $table->string('gst_rate')->nullable();
            $table->string('cess_rate')->nullable();
            $table->string('gst_rate_applicable_date')->nullable();
            $table->string('cess_rate_applicable_date')->nullable();
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
        Schema::dropIfExists('stock_group_gst_history');
    }
}
