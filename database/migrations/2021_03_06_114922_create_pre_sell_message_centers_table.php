<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSellMessageCentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_sell_message_centers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('presell_id');
            $table->string('user');
            $table->string('message')->nullable();
            $table->string('responsible')->nullable();
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_sell_message_centers');
    }
}
