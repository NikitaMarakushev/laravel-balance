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
        Schema::create('user_balance_operations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_balance_id');
            $table->foreign('user_balance_id')->references('id')->on('user_balance');
            $table->timestamp('date')->nullable(false);
            $table->string('type')->nullable(false);
            $table->string('value')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_balance_operations');
    }
};
