<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_sells', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('c_id');
            $table->string('invoice_option');
            $table->string('status');
            $table->string('zone');
            $table->string('delivery_period');
            $table->string('delivery_address');
            $table->date('delivery_date');
            $table->string('invoice_obs')->nullable();
            $table->string('driver_obs')->nullable();
            $table->string('pay_code');
            $table->string('pay_term');
            $table->string('pay_contract')->nullable();
            $table->string('pay_commitment_number')->nullable();
            $table->string('authorization');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_sells');
    }
}
