<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_loads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vehicle_id');
            $table->string('category');
            $table->string('classification');
            $table->string('unity');
            $table->string('load_capacity');
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
        Schema::dropIfExists('vehicle_loads');
    }
}
