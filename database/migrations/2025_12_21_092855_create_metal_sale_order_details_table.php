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
        Schema::create('metal_sale_order_details', function (Blueprint $table) {
            $table->id();
            $table->integer('metal_sale_order_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('metal')->nullable();
            $table->decimal('rate',18,3)->default(0);
            $table->decimal('purity',18,3)->default(0);
            $table->string('category')->nullable();
            $table->string('design_no')->nullable();
            $table->decimal('net_weight',18,3)->default(0);
            $table->decimal('waste',18,3)->default(0);
            $table->decimal('gross_weight',18,3)->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->integer('createdby_id')->nullable();
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
        Schema::dropIfExists('metal_sale_order_details');
    }
};
