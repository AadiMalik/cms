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
        Schema::create('retainers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->tinyInteger('day_of_month')->default(1);
            $table->integer('journal_id')->nullable();
            $table->integer('debit_account_id')->nullable();
            $table->integer('credit_account_id')->nullable();
            $table->tinyInteger('currency')->default(0)->comment('0 for PKR, 1 for AU and 2 for Dollar');
            $table->decimal('amount', 18, 3)->default(0);
            $table->string('status')->default('pending');
            $table->string('confirmed_by')->nullable();
            $table->boolean('is_active')->default(1);
            $table->dateTime('notification_at')->nullable();
            $table->dateTime('confirmed_at')->nullable();
            $table->integer('jv_id')->nullable();
            $table->integer('createdby_id')->nullable();
            $table->integer('updatedby_id')->nullable();
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
        Schema::dropIfExists('retainers');
    }
};
