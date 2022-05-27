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
        Schema::create('farm_animal', function (Blueprint $table) {
            $table->id();

            $table->float('size')->default(1);
            $table->smallInteger('age')->default(0);

            $table->foreignId('farm_id')->references('id')->on('farms')->cascadeOnDelete();
            $table->foreignId('animal_id')->references('id')->on('animals')->cascadeOnDelete();

            $table->timestamps();
        });

        Schema::table('farm_animal', function (Blueprint $table) {
            $table->unique(['farm_id', 'animal_id'], 'farm_animal_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farm_animal');
    }
};
