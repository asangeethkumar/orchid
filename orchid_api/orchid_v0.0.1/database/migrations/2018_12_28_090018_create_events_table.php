<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('event_id');
            $table->string('event_name',255);
            $table->string('event_description',255)->nullable();
            $table->integer('event_type_id');
            $table->dateTime('event_start_time');
            $table->dateTime('event_response_by_time');
        /*    
            $table->dateTime('event_end_time')->nullable();
            $table->string('event_venue_name')->nullable();
            $table->string('event_venue_address_1')->nullable();
            $table->string('event_venue_address_2')->nullable();
            $table->string('event_venue_city', 100)->nullable();
            $table->string('event_venue_state', 100)->nullable();
            $table->string('event_venue_country', 100)->nullable();
            $table->integer('event_venue_zip_code')->nullable(); 
        */
            $table->integer('event_created_by');
            $table->foreign('event_created_by')->references('user_id')->on('users');
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
        Schema::dropIfExists('events');
    }
}
