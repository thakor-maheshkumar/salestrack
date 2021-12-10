<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_item_id')->nullable();
            $table->string('batch_id')->nullable();
            $table->string('batch_size')->nullable();
            $table->string('manufacturing_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('description')->nullable();
            $table->integer('is_enabled')->default(1);
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
        Schema::dropIfExists('batches');
    }
}
