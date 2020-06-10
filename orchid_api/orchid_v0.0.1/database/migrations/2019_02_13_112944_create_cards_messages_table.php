<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_messages', function (Blueprint $table) {
            $table->increments('message_id');
            $table->integer('ce_mapping_id');
            $table->integer('user_id');
            $table->string('message',1024);
            $table->string('file_location',1024);
            $table->string('file_name',255);        
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
        Schema::dropIfExists('cards_messages');
    }
}
