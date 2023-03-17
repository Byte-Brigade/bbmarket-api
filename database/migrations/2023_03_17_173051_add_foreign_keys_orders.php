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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('buyer_id', 'fk_orders_buyer_to_users')->references('id')
                ->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('seller_id', 'fk_orders_seller_to_users')->references('id')
                ->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('courier_id', 'fk_orders_to_couries')->references('id')
                ->on('couriers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('fk_orders_buyer_to_users');
            $table->dropForeign('fk_orders_buyer_to_users');
            $table->dropForeign('fk_orders_to_couries');
        });
    }
};
