<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("animals", function (Blueprint $table){
            $table->id();
            $table->string("ANML_NAME");
        });
        
        Schema::create('breeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId("BRED_ANML_ID");
            $table->string("BRED_NAME");
            $table->foreign("BRED_ANML_ID")->references("id")->on("animals");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breeds');
        Schema::dropIfExists('animals');
    }
}
