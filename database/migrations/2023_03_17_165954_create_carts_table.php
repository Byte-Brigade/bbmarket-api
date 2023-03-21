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
        Schema::create('carts', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->index('fk_carts_to_users');
            $table->foreignId('order_id')->nullable()->index('fk_carts_to_orders');
            $table->foreign('user_id', 'fk_carts_to_users')->references('id')
                ->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('order_id', 'fk_carts_to_orders')->references('id')
                ->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
