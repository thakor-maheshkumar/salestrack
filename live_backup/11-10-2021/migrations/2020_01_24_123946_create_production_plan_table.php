<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plan_id')->nullable();
            $table->bigInteger('stock_item_id')->nullable();
            $table->bigInteger('bom_id')->nullable();
            $table->integer('status')->default(1)->comment('1:pending,2:Executed');
            $table->integer('active')->default(1);
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
        Schema::dropIfExists('production_plan');
    }
}
