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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string("SHOP_NAME");
            $table->foreignId("SHOP_CITY_ID")->constrained("cities");
            $table->string("SHOP_UNAME")->unique();
            $table->string("SHOP_PASS");
            $table->string("SHOP_NTID")->nullable(); //segel togary
            $table->string("SHOP_IMGE")->nullable(); //soraaaa
            $table->string("SHOP_ADRS")->nullable();
            $table->string("SHOP_STRT_HRS")->nullable();
            $table->string("SHOP_END_HRS")->nullable();
            $table->string("SHOP_MAIL");
            $table->string("SHOP_PHNE");
            $table->string("SHOP_LOCT_LONG")->nullable();
            $table->string("SHOP_LOCT_LATT")->nullable();
            $table->tinyInteger("SHOP_VRFD")->default(0);
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
        Schema::dropIfExists('shops');
    }
}
