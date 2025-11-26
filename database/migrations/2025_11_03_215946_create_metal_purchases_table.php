<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metal_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('metal_purchase_no')->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('purchase_account_id')->nullable();
            $table->integer('paid_account_id')->nullable();
            $table->integer('paid_account_dollar_id')->nullable();
            $table->integer('tax_account_id')->nullable();
            $table->decimal('paid',18,3)->default(0);
            $table->string('reference')->nullable();
            $table->text('pictures')->nullable();
            $table->decimal('tax_amount',18,3)->default(0);
            $table->decimal('sub_total',18,3)->default(0);
            $table->decimal('total',18,3)->default(0);
            $table->decimal('total_dollar',18,3)->default(0);
            $table->integer('jv_id')->nullable();
            $table->integer('paid_jv_id')->nullable();
            $table->integer('paid_dollar_jv_id')->nullable();
            $table->integer('supplier_payment_id')->nullable();
            $table->integer('supplier_dollar_payment_id')->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_posted')->default(0);
            $table->boolean('is_deleted')->default(0);
            $table->integer('createdby_id')->nullable();
            $table->integer('updatedby_id')->nullable();
            $table->integer('deletedby_id')->nullable();
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
        Schema::dropIfExists('metal_purchases');
    }
};
