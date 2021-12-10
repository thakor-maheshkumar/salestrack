<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatchIsToPurchaseReceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_receipt_items', function (Blueprint $table) {
            $table->bigInteger('batch_id')->nullable()->after('no_of_container');
        });

        Schema::table('production_plan', function (Blueprint $table) {
            $table->timestamp('production_date')->nullable()->after('bom_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_receipt_items', function (Blueprint $table) {
            $table->dropColumn(['batch_id']);
        });

        Schema::table('production_plan', function (Blueprint $table) {
            $table->dropColumn(['production_date']);
        });
    }
}
