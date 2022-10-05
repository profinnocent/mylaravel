<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->string('slug');
            $table->string('tour_code')->unique();
            $table->string('description');
            $table->string('city');
            $table->string('country');
            $table->decimal('price', 5, 2, true);
            $table->integer('visits', false, true)->nullable();
            $table->decimal('rating', 5, 2, true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}
