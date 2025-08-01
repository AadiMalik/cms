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
        Schema::create('sale_used_gold', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id')->nullable();
            $table->string('type')->nullable();
            $table->decimal('weight',18,3)->nullable();
            $table->decimal('kaat',18,3)->nullable();
            $table->decimal('pure_weight',18,3)->nullable();
            $table->decimal('karat',18,3)->nullable();
            $table->decimal('rate',18,3)->nullable();
            $table->decimal('amount',18,3)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('sale_used_gold');
    }
};
