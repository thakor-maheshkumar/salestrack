<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationeOtherChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotatione_other_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('quotation_id')->nullable();
            $table->bigInteger('general_ledger_id')->nullable();
            $table->string('type')->nullable();
            $table->string('rate')->nullable();
            $table->string('amount')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('total_amount')->nullable();
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
        Schema::dropIfExists('quotatione_other_charges');
    }
}
