<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string("CNTR_NAME");
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId("CITY_CNTR_ID");
            $table->string("CITY_NAME");
            $table->foreign("CITY_CNTR_ID")->references("id")->on("countries");
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('countries');
    }
}
