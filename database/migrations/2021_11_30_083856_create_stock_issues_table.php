<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_issues', function (Blueprint $table) {
            $table->id();
            $table->string('stock_transfer_no')->nullable();
            $table->bigInteger('stock_item_id')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->string('document_no')->nullable();
            $table->string('remaining_qty')->nullable();
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
        Schema::dropIfExists('stock_issues');
    }
}
