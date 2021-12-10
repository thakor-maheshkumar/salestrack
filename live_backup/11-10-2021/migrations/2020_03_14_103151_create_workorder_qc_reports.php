<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkorderQcReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorder_qc_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('work_order_id')->nullable();
            $table->bigInteger('grade_id')->nullable();
            $table->bigInteger('plan_id')->nullable();
            $table->bigInteger('qc_id')->nullable();
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
        Schema::dropIfExists('workorder_qc_reports');
    }
}
