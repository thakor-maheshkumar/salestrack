<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_relationship', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('module_id')->nullable();
            $table->string('table')->nullable();
            $table->string('table_column')->nullable();
            $table->string('related_table')->nullable();
            $table->string('related_table_column')->nullable();
            $table->integer('status')->default(1)->nullable();
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
        Schema::dropIfExists('module_relationship');
    }
}
