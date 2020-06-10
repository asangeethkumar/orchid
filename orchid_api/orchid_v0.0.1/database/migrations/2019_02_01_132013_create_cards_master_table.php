<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_master', function (Blueprint $table) {
            $table->increments('cards_id');
            $table->integer('cards_category_id');
            $table->string('cards_name',255);
            $table->string('cards_description',255);
            $table->string('cards_location_url',1024);
            $table->string('is_active',10);
            $table->string('is_user_uploaded',10);
            $table->integer('user_id_if_user_uploaded');
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
        Schema::dropIfExists('cards_master');
    }
}
