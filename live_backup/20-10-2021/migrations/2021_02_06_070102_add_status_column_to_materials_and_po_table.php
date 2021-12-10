<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToMaterialsAndPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('status')->default('Pending')->nullable()->after('edited_by');
        });

        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->string('po_status')->default(0)->nullable()->after('edited_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn(['po_status']);
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
