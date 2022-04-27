<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomReceiversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_receivers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
        });
        Schema::table('room_receivers',function(Blueprint $table){
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('receiver_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_receivers');
    }
}
