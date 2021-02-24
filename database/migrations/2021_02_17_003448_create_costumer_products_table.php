<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostumerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costumer_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('c_id');
            $table->string('products_id');
            $table->string('price');
            $table->string('interval')->nullable();
            $table->string('exact_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costumer_products');
    }
}
