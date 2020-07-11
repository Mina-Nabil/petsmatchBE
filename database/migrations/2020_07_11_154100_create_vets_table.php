<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vets', function (Blueprint $table) {
            $table->id();
            $table->string("VETS_NAME");
            $table->foreignId("VETS_CITY_ID")->constrained("cities");
            $table->string("VETS_UNAME")->unique();
            $table->string("VETS_PASS");
            $table->string("VETS_NTID")->nullable(); //segel togary
            $table->string("VETS_ADRS")->nullable();
            $table->string("VETS_MAIL");
            $table->string("VETS_PHNE");
            $table->string("VETS_LOCT_LONG")->nullable();
            $table->string("VETS_LOCT_LATT")->nullable();
            $table->tinyInteger("VETS_VRFD")->default(0);
            $table->string("VETS_STRT_HRS")->nullable();
            $table->string("VETS_END_HRS")->nullable();
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
        Schema::dropIfExists('vets');
    }
}
