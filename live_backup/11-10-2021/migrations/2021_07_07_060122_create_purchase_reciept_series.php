<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRecieptSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_reciept_series', function (Blueprint $table) {
            $table->id();
            $table->string('series_name');
            $table->string('request_type');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('suffix_static_character')->nullable();
            $table->string('prefix_static_character')->nullable();
            $table->string('series_starting_digits')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('purchase_reciept_series');
    }
}
