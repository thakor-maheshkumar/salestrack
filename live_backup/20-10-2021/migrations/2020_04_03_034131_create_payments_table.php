<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_type')->nullable();
            $table->string('party_type')->nullable();
            $table->string('party')->nullable();
            $table->string('against')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('amount')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('cheque_no')->nullable();
            $table->datetime('cheque_date')->nullable();
            $table->string('contact')->nullable();
            $table->text('remarks')->nullable();
            $table->tinyInteger('active')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
