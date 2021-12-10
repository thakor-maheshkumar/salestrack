<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qc_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('purchase_receipt_id')->nullable();
            $table->bigInteger('grade_id')->nullable();
            $table->bigInteger('batch_id')->nullable();
            $table->bigInteger('qc_id')->nullable();
            $table->bigInteger('stock_item_id')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('product_name')->nullable();
            $table->string('ar_no')->nullable();
            $table->string('reset_date')->nullable();
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
        Schema::dropIfExists('qc_reports');
    }
}
