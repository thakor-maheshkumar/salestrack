<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelationshipTreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationship_tree', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('module');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('relationship_type')->nullable();
            $table->string('relationship_module')->nullable();
            $table->unsignedBigInteger('relationship_module_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('changed_on')->nullable();
            $table->unsignedBigInteger('acted_user');
            $table->timestamps();

            $table->foreign('module')->references('alias')->on('modules');
            $table->foreign('relationship_type')->references('id')->on('relationship_types');
            $table->foreign('relationship_module')->references('alias')->on('modules');
            $table->foreign('acted_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relationship_tree');
    }
}
