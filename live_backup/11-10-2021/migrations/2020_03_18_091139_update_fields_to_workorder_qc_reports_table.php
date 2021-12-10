<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFieldsToWorkorderQcReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workorder_qc_reports', function (Blueprint $table) {
            $table->string('work_order_id')->change();
            $table->bigInteger('stock_item_id')->nullable()->after('qc_id');
            $table->text('remarks')->nullable()->after('reset_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workorder_qc_reports', function (Blueprint $table) {
            $table->bigInteger('work_order_id')->change();
            $table->dropColumn(['stock_item_id', 'remarks']);
        });
    }
}
