<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsEventsMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_events_mapping', function (Blueprint $table) {
            $table->increments('ce_mapping_id');
            $table->integer('event_id');
            $table->integer('cards_id');
            $table->integer('recipient_id')->nullable();
            $table->string('recipient_email',255)->nullable();
            $table->date('send_card_date');
            $table->string('recipient_social_media_id',1024)->nullable();
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
        Schema::dropIfExists('cards_events_mapping');
    }
}
