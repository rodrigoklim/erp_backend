<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadRecordsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('load_records', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vehicle_id');
            $table->string('movement');
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
        Schema::dropIfExists('load_records');
    }
}
