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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('sick_leave');
            $table->dropColumn('casual_leave');
            $table->dropColumn('annual_leave');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->decimal('sick_leave',18,2)->default(0);
            $table->decimal('casual_leave',18,2)->default(0);
            $table->decimal('annual_leave',18,2)->default(0);
        });
    }
};
