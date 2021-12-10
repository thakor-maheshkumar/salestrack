<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPurchaseReceiptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_receipt', function (Blueprint $table) {
            $table->string('suffix')->nullable();
            $table->string('prefix')->nullable();
            $table->string('number')->nullable();
            $table->string('series_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_receipt', function (Blueprint $table) {
            //
        });
    }
}
