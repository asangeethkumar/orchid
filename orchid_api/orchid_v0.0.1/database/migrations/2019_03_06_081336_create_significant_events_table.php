<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignificantEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('significant_events', function (Blueprint $table) {
            $table->increments('s_events_id');
            $table->integer('creator_user_id');
            $table->string('s_event_name');
            $table->integer('se_type_id');
            $table->integer('se_relationship_id');
            $table->integer('event_user_id');
            $table->date('se_date');
            $table->string('se_frequency')->nullable();
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
        Schema::dropIfExists('significant_events');
    }
}
