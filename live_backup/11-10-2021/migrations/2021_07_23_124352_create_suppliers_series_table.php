<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers_series', function (Blueprint $table) {
            $table->id();
            $table->string('series_name');
            $table->string('request_type');
            $table->string('prefix')->nullable();
            $table->string('suffix')->nullable();
            $table->string('suffix_static_character')->nullable();
            $table->string('prefix_static_character')->nullable();
            $table->string('series_starting_digits')->nullable();
            $table->string('series_current_digit')->nullable();
            $table->string('status')->default('false')->nullable();
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
        Schema::dropIfExists('suppliers_series');
    }
}
