<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventInvitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_invitation', function (Blueprint $table) {
            $table->increments('invitation_id');
            $table->integer('event_id');
            $table->string('invitation_message');
            $table->integer('invitation_sent_by');
            $table->integer('invitation_sent_to');
            $table->string('invitation_sent_via');
            $table->string('invitee_profile');
            $table->string('invitation_status');
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
        Schema::dropIfExists('event_invitation');
    }
}
