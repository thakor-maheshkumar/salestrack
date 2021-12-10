<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->dropColumn(['shipper_pack_unit', 'shipper_pack_value', 'shipper_pack_alternate_unit', 'shipper_pack_alternate_value']);
            $table->string('convertion_rate')->after('unit_id')->nullable();
            $table->string('shipper_pack')->after('convertion_rate')->nullable();
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
            $table->string('shipper_pack_unit')->after('unit_id')->nullable();
            $table->string('shipper_pack_value')->after('shipper_pack_unit')->nullable();
            $table->string('shipper_pack_alternate_unit')->after('alternate_unit')->nullable();
            $table->string('shipper_pack_alternate_value')->after('shipper_pack_alternate_unit')->nullable();
            $table->dropColumn(['shipper_pack', 'shipper_pack_value']);
        });
    }
}
