<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('text');
            $table->boolean('unread')->default(1);
            $table->boolean('isLiked')->default(0);
            $table->bigInteger('room_id')->unsigned();
            $table->bigInteger('sender_id')->unsigned();
        });
        Schema::table('messages',function(Blueprint $table){
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('sender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
