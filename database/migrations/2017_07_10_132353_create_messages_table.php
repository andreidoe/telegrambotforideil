<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('username');
            $table->dateTime('date');
            $table->text('text');
            $table->integer('chat_id');
            $table->integer('user_id');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('messages', function($table) {
            $table->foreign('chat_id')->references('id')->on('chats');
        });
    }

    /**
     * Reverse the migrations.
    
     * @return void
     */
    public function down()
    {
        //
    }
}
