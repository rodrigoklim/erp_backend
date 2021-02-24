<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('product');
            $table->string('classification');
            $table->string('category');
            $table->string('unity');
            $table->string('ean')->nullable();
            $table->string('max_price');
            $table->string('ncm');
            $table->string('cest')->nullable();
            $table->string('csosn');
            $table->string('operation');
            $table->string('weight');
            $table->string('load_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
