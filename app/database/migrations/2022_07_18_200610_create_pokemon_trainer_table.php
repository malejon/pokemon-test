<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon_trainer', function (Blueprint $table) {
            $table->id();
            $table->integer('dirt')->default(10);
            $table->foreignId('trainer_id')->constrained();
            $table->foreignId('pokemon_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon_trainer');
    }
};
