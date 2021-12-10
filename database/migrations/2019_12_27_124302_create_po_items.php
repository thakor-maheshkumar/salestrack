<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('po_id')->nullable();
            $table->bigInteger('stock_item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('rate')->nullable();
            $table->string('net_amount')->nullable();
            $table->string('tax')->nullable();
            $table->string('tax_amount')->nullable();
            $table->string('cess')->nullable();
            $table->string('cess_amount')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('item_pending')->nullable();
            $table->string('item_received')->nullable();
            $table->integer('active')->default(1);
            $table->integer('status')->nullable()->comment('1:Open, 2:Partial, 3:Close');
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
        Schema::dropIfExists('po_items');
    }
}
