<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('parent_unit')->nullable();
            $table->string('name');
            $table->string('firm_type')->nullable();
            $table->string('pan_no')->nullable();
            $table->dateTime('pan_applicable_date')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('gst_reg_type')->nullable();
            $table->dateTime('gst_applicable_date')->nullable();
            $table->string('dl_no')->nullable();
            $table->dateTime('dl_applicable_date')->nullable();
            $table->dateTime('dl_expiry_date')->nullable();
            $table->string('fssai')->nullable();
            $table->dateTime('fssai_applicable_date')->nullable();
            $table->dateTime('fssai_expiry_date')->nullable();
            $table->string('cin')->nullable();
            /*$table->string('reg_type')->nullable();*/
            $table->string('aadhar_no')->nullable();
            $table->text('address')->nullable();
            $table->text('street')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            /*$table->string('phone_3')->nullable();*/
            $table->string('mobile_no')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('email_1')->nullable();
            $table->string('website')->nullable();
            $table->string('iec_code')->nullable();
            $table->dateTime('iec_applicable_date')->nullable();
            $table->string('tan_no')->nullable();
            $table->dateTime('tan_date')->nullable();
            /*$table->string('cin_no')->nullable();*/
            $table->dateTime('fiscal_start_date')->nullable();
            $table->dateTime('fiscal_end_date')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->integer('active')->default(1)->comment('1:Active, 0:Not active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            /*$table->foreign('module_id')->references('id')->on('modules');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
