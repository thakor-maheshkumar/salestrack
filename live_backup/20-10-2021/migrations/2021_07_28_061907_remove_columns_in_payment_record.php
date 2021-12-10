<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsInPaymentRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_records', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable();
            $table->dropColumn(['against_voucher_type', 'against_voucher','supplier_invoice','remarks','voucher_no']);
            $table->dropColumn('against_account')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_records', function (Blueprint $table) {
            $table->string('against_voucher_type');
            $table->string('against_voucher');
            $table->string('supplier_invoice');
            $table->text('remarks');
            $table->string('voucher_no');
            //$table->string('against_account'))->nullable()->change();
        });
    }
}
