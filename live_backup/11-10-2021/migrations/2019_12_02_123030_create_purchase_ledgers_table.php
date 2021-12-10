<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ledger_name');
            $table->unsignedInteger('under');
            $table->string('gst_reg_type', 50)->default(0)->comment('0: Not Applicable, 1: Regular, 2: Consumer, 3: Unregistered, 4: composition');
            $table->string('gstin_uin')->nullable();
            $table->string('gstin_applicable_date')->nullable();
            $table->string('party_type', 50)->default(0)->comment('0: Not Applicable, 1: deemed, 2: export, 3: embassy, 4: government entity, 5: SEZ');
            $table->string('pan_it_no')->nullable();
            $table->string('uid_no')->nullable();
            $table->boolean('is_tds_deductable')->comment('0: No, 1: Yes');
            $table->string('include_assessable_value', 50)->default(0)->comment('0: Not Applicable, 1: GST');
            $table->string('applicable', 50)->default(0)->comment('0: Both, 1: Good, 2: service');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('location')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('landline_no')->nullable();
            $table->string('fax_no')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('cc_email')->nullable();
            $table->boolean('consignee_address')->comment('0: No, 1: Yes');
            $table->boolean('maintain_balance_bill_by_bill')->comment('0: No, 1: Yes');
            $table->string('default_credit_period')->nullable();
            $table->string('default_credit_amount')->nullable();
            $table->boolean('credit_days_during_voucher_entry')->comment('0: No, 1: Yes');
            $table->boolean('credit_amount_during_voucher_entry')->comment('0: No, 1: Yes');
            $table->boolean('active_interest_calculation')->comment('0: No, 1: Yes');
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
        Schema::dropIfExists('purchase_ledgers');
    }
}
