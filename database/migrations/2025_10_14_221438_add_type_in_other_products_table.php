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
        Schema::table('other_products', function (Blueprint $table) {
            $table->string('type')->nullable()->default('Raw Material')->comment(
                'Raw Material, Consumable, Trading Goods, Packaging Material, Fixed Assets, Others'
            );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_products', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
