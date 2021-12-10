<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('product_descriptiopn')->nullable();
            $table->bigInteger('under')->nullable();
            $table->bigInteger('unit_id')->nullable();
            $table->string('shipper_pack_unit')->nullable();
            $table->string('shipper_pack_value')->nullable();
            $table->bigInteger('alternate_unit')->nullable();
            $table->string('shipper_pack_alternate_unit')->nullable();
            $table->string('shipper_pack_alternate_value')->nullable();
            $table->string('part_no')->nullable();
            $table->string('product_image')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->integer('is_allow_mrp')->nullable();
            $table->integer('is_allow_part_number')->nullable();
            $table->integer('is_maintain_in_batches')->nullable();
            $table->string('track_manufacture_date')->nullable();
            $table->string('use_expiry_dates')->nullable();
            $table->integer('is_gst_detail')->default(0)->nullable();
            $table->string('taxability')->nullable();
            $table->integer('is_reverse_charge')->nullable();
            $table->string('tax_type')->nullable();
            $table->string('rate')->nullable();
            $table->string('applicable_date')->nullable();
            $table->string('supply_type')->nullable();
            $table->string('hsn_code')->nullable();
            $table->string('default_warehouse')->nullable();
            $table->string('opening_stock')->nullable();
            $table->string('maintain_stock')->nullable();
            $table->integer('active')->default(1)->nullable();
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
        Schema::dropIfExists('stock_items');
    }
}
