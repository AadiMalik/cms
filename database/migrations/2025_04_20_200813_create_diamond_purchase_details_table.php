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
        Schema::create('diamond_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->integer('diamond_purchase_id')->nullable();
            $table->integer('diamond_type_id')->nullable();
            $table->integer('diamond_cut_id')->nullable();
            $table->integer('diamond_color_id')->nullable();
            $table->integer('diamond_clarity_id')->nullable();
            $table->decimal('carat',18,3)->default(0);
            $table->decimal('carat_price',18,3)->default(0);
            $table->decimal('qty',18,3)->default(0);
            $table->decimal('total_amount',18,3)->default(0);
            $table->decimal('total_dollar',18,3)->default(0);
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
        Schema::dropIfExists('diamond_purchase_details');
    }
};
