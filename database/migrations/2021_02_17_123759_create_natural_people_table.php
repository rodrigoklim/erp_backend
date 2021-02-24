<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNaturalPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('natural_people', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('c_id')->nullable();
            $table->string('cpf');
            $table->string('name');
            $table->string('company_name');
            $table->date('birthdate');
            $table->string('register_situation');
            $table->string('phone_1');
            $table->string('phone_1zap');
            $table->string('phone_2')->nullable();
            $table->string('phone_2zap')->nullable();
            $table->string('phone_3')->nullable();
            $table->string('phone_3zap')->nullable();
            $table->string('phone_4')->nullable();
            $table->string('phone_4zap')->nullable();
            $table->string('phone_5')->nullable();
            $table->string('phone_5zap')->nullable();
            $table->string('email');
            $table->string('main_activity');
            $table->string('contact')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('natural_people');
    }
}
