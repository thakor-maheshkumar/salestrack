<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GrnAddRemarks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_receipt', function (Blueprint $table) {
            $table->string('good_condition_container_remark')->nullable();
            $table->string('container_have_product_remark')->nullable();
            $table->string('container_have_tare_weight_remark')->nullable();
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
