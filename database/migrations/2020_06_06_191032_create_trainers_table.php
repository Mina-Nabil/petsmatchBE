<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId("TRNR_USER_ID")->constrained("users");
            $table->unsignedInteger("TRNR_XPYR")->default(0); //set starting experience year
            $table->string("TRNR_ORGN")->nullable();
            $table->string("TRNR_ABUT")->nullable();
        });

        Schema::create("trainer_breed", function (Blueprint $table) {
            $table->id();
            $table->foreignId("TRBR_TRNR_ID")->constrained("trainers");
            $table->foreignId("TRBR_BRED_ID")->constrained("breeds");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_breed');
        Schema::dropIfExists('trainers');
    }
}
