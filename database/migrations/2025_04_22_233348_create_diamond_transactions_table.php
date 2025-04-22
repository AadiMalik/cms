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
        Schema::create('diamond_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable()->comment('0 for purchase, 1 for other sale');
            $table->date('date')->nullable();
            $table->integer('diamond_type_id')->nullable();
            $table->integer('diamond_cut_id')->nullable();
            $table->integer('diamond_color_id')->nullable();
            $table->integer('diamond_clarity_id')->nullable();
            $table->decimal('carat', 18, 3)->nullable();
            $table->decimal('qty', 18, 3)->nullable();
            $table->decimal('carat_price', 18, 3)->nullable();
            $table->integer('diamond_purchase_id')->nullable();
            $table->integer('diamond_sale_id')->nullable();
            $table->integer('diamond_stock_taking_id')->nullable();
            $table->integer('diamond_stock_taking_link_id')->nullable();
            $table->integer('warehouse_id')->nullable();
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
        Schema::dropIfExists('diamond_transactions');
    }
};
