<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlternateUnitIdFieldToStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->bigInteger('alternate_unit_id')->nullable()->after('shipper_pack');
        });

        Schema::table('production_plan', function (Blueprint $table) {
            $table->integer('quantity')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->dropColumn(['alternate_unit_id']);
        });

        Schema::table('production_plan', function (Blueprint $table) {
            $table->dropColumn(['quantity']);
        });
    }
}
