<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeriesCurrentDigitToPurchaseReturnSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_return_series', function (Blueprint $table) {
            $table->string('series_current_digit')->after('series_starting_digits')->nullable();
            $table->string('status')->default('false')->after('series_current_digit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_return_series', function (Blueprint $table) {
            //
        });
    }
}
