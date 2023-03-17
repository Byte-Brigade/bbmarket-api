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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('seller_id', 'fk_products_to_users')->references('id')
                ->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('category_id', 'fk_products_to_categories')->references('id')
                ->on('categories')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('fk_products_to_users');
            $table->dropForeign('fk_products_to_categories');
        });
    }
};
