<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQcTests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qc_tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('qc_id')->unsigned()->nullable();
            $table->string('tests')->nullable();
            $table->string('acceptance_criteria')->nullable();
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
        Schema::dropIfExists('qc_tests');
    }
}
