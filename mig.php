<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB as DB;
use App\Models\StockItem;
class AddPreviousRateToStockItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->string('previous_rate')->after('rate')->nullable();
            $table->string('previous_applicabale_date')->after('applicable_date')->nullable();
            $table->string('previous_cess')->after('cess')->nullable();
            $table->string('previous_cess_applicable_date')->after('cess_applicable_date')->nullable();
        });
        StockItem::withTrashed()
            ->whereNull('previous_rate')
            ->update([
                "previous_rate" => DB::raw("`rate`"),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_items', function (Blueprint $table) {
            $table->dropColumn('previous_rate');
            $table->dropColumn('previous_applicabale_date');
            $table->dropColumn('previous_cess');
            $table->dropColumn('previous_cess_applicable_date');
        });
    }
}
