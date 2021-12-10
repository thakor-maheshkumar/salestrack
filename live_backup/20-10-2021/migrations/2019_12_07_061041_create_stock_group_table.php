<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_name')->nullable();
            $table->bigInteger('under')->comment('0:Primary')->nullable();
            $table->integer('is_gst_detail')->default(0)->nullable();
            $table->string('taxability')->nullable();
            $table->integer('is_reverse_charge')->nullable();
            $table->string('gst_rate')->nullable();
            $table->string('gst_applicable_date')->nullable();
            $table->string('cess_rate')->nullable();
            $table->string('cess_applicable_date')->nullable();
            $table->integer('active')->default(1)->nullable();
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
        Schema::dropIfExists('stock_group');
    }
}
