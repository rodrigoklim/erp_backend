<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vehicle_id');
            $table->string('balance');
            $table->string('status');
            $table->string('source');
            $table->string('responsible')->nullable();
            $table->string('driver')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuel_records');
    }
}
