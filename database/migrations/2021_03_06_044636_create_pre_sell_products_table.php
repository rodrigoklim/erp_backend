<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSellProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_sell_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('presell_id');
            $table->string('product_id');
            $table->string('product_qty')->nullable();
            $table->string('product_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_sell_products');
    }
}
