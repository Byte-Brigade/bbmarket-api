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
        Schema::create('detail_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->index('fk_detail_products_to_products');
            $table->string('variant');
            $table->string('sku');
            $table->integer('quantity');
            $table->integer('baseprice');
            $table->integer('het');
            $table->decimal('weight');
            $table->string('unit');
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
        Schema::dropIfExists('detail_products');
    }
};
