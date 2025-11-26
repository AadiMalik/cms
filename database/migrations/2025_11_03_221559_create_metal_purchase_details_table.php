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
        Schema::create('metal_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->integer('metal_purchase_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('metal')->nullable();
            $table->decimal('purity',18,2)->default(0);
            $table->text('description')->nullable();
            $table->decimal('scale_weight',18,3)->default(0);
            $table->decimal('bead_weight',18,3)->default(0);
            $table->decimal('stone_weight',18,3)->default(0);
            $table->decimal('diamond_weight',18,3)->default(0);
            $table->decimal('net_weight',18,3)->default(0);
            $table->decimal('metal_rate',18,3)->default(0);
            $table->decimal('metal_amount',18,3)->default(0);
            $table->decimal('bead_amount',18,3)->default(0);
            $table->decimal('stone_amount',18,3)->default(0);
            $table->decimal('diamond_amount',18,3)->default(0);
            $table->decimal('other_charges',18,3)->default(0);
            $table->decimal('total_dollar_amount',18,3)->default(0);
            $table->decimal('total_amount',18,3)->default(0);
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
        Schema::dropIfExists('metal_purchase_details');
    }
};
