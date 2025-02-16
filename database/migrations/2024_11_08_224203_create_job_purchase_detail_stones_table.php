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
        Schema::create('job_purchase_detail_stones', function (Blueprint $table) {
            $table->id();
            $table->integer('job_purchase_detail_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->decimal('stones',18,3)->default(0.00);
            $table->decimal('gram',18,3)->default(0.00);
            $table->decimal('carat',18,3)->default(0.00);
            $table->decimal('gram_rate',18,3)->default(0.00);
            $table->decimal('carat_rate',18,3)->default(0.00);
            $table->decimal('total_amount',18,3)->default(0.00);
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
        Schema::dropIfExists('job_purchase_detail_stones');
    }
};
