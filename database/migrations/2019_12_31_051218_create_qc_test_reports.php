<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcTestReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qc_test_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('qc_report_id')->nullable();
            $table->bigInteger('qc_test_id')->nullable();
            $table->string('test_result')->nullable();
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
        Schema::dropIfExists('qc_test_reports');
    }
}
