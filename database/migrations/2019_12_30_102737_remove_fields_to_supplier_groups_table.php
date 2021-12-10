<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsToSupplierGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supplier_groups', function (Blueprint $table) {
            $table->dropColumn(['group_type', 'group_details']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supplier_groups', function (Blueprint $table) {
            $table->integer('group_type')->nullable()->after('under');
            $table->string('group_details')->nullable()->after('group_type');
        });
    }
}
