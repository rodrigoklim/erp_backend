<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_values', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vehicle_id');
            $table->string('brand_id');
            $table->string('brand');
            $table->string('specific_model_id');
            $table->string('specific_model');
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_values');
    }
}
