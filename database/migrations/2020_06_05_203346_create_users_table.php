<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user_types", function (Blueprint $table){
            $table->id();
            $table->string("USTP_NAME");
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("USER_NAME")->unique();
            $table->string("USER_PASS");
            $table->string("USER_FLNM");
            $table->date("USER_BRDT");
            $table->string("USER_MAIL");
            $table->string("USER_MOBN");
            $table->foreignId("USER_CITY_ID")->constrained('cities');
            $table->foreignId("USER_USTP_ID")->constrained('user_types');
            $table->string("USER_IMGE")->nullable();
            $table->string("USER_HOME_LATT")->nullable();
            $table->string("USER_HOME_LONG")->nullable();
            $table->string("USER_PUSH_TOKN")->nullable();
            $table->string("USER_CHAT_TOKN")->nullable();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_types');
    }
}
