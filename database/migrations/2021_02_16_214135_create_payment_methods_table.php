<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('c_id');
            $table->string('payment_code');
            $table->string('contract')->nullable();
            $table->string('account')->nullable();
            $table->string('close_date')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('term')->nullable();
            $table->string('payment_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
}
