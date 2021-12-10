<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PackCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_item_grades', function (Blueprint $table) {
            $table->bigInteger('unit_id')->unsigned()->nullable();
            $table->string('pack_code')->nullable();
            $table->integer('quantity')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_item_grades', function (Blueprint $table) {
            //
        });
    }
}
