<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('alias')->comment('Short name');
            $table->string('table');
            $table->integer('is_default_module')->default(0);
            $table->integer('type')->nullable()->comment('1: Custom, 2: User');
            $table->integer('parent_module')->nullable();
            $table->integer('status')->default(1)->comment('0: Inactive, 1: Active');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
