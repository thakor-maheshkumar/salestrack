<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_name')->nullable();
            $table->tinyInteger('under')->default(1)->comment('0:Parent 1:Primary, 2:Other');
            $table->integer('group_type');
            $table->string('group_details')->nullable();
            $table->tinyInteger('is_affect')->default(1)->comment('1:Yes, 0:No');
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
        Schema::dropIfExists('groups');
    }
}
