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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->nullable()->index('fk_orders_buyer_to_users');
            $table->foreignId('seller_id')->nullable()->index('fk_orders_seller_to_users');
            $table->foreignId('courier_id')->nullable()->index('fk_orders_to_couriers');
            $table->string('invoice_number');
            $table->string('type');
            $table->decimal('shipping_weight');
            $table->string('shipping_unit');
            $table->integer('shipping_cost');
            $table->string('receipt');
            $table->string('payment_method');
            $table->integer('total_pay');
            $table->string('status');
            $table->date('verified_at')->nullable();
            $table->date('processed_at')->nullable();
            $table->date('delivered_at')->nullable();
            $table->date('send_at')->nullable();
            $table->date('received_at')->nullable();
            $table->date('completed_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->date('cancelled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
