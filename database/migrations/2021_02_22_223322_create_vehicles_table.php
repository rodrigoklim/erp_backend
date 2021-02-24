<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('type');
            $table->string('nickname');
            $table->string('fuel');
            $table->string('license_plate');
            $table->string('autonomy')->nullable();
            $table->string('fuel_tank');
            $table->string('km_cost');
            $table->date('oil_change')->nullable();
            $table->date('filters_change')->nullable();
            $table->date('toothed_belt_change')->nullable();
            $table->date('civ')->nullable();
            $table->date('cipp')->nullable();
            $table->date('valvules')->nullable();
            $table->date('ctf')->nullable();
            $table->date('ibama')->nullable();
            $table->date('tachograph')->nullable();
            $table->string('km_zero');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
