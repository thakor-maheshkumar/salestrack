<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_item_id')->unsigned()->nullable();
            $table->bigInteger('grade_id')->unsigned()->nullable();
            $table->string('casr_no')->nullable();
            $table->string('molecular_formula')->nullable();
            $table->string('molecular_weight')->nullable();
            $table->string('spec_no')->nullable();
            $table->string('characters')->nullable();
            $table->string('storage_condition')->nullable();
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
        Schema::dropIfExists('qc');
    }
}
