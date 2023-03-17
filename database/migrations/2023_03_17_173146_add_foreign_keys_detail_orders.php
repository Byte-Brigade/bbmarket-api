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
        Schema::table('detail_orders', function (Blueprint $table) {
            $table->foreign('order_id', 'fk_detail_orders_to_orders')->references('id')
                ->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('product_id', 'fk_detail_orders_to_detail_products')->references('id')
                ->on('detail_products')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_orders', function (Blueprint $table) {
            $table->dropForeign('fk_detail_orders_to_orders');
            $table->dropForeign('fk_detail_orders_to_detail_products');
        });
    }
};
