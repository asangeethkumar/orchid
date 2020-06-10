<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventParticipantsRoleMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        
    public function up()
    {
        Schema::create('event_participants_role_master', function (Blueprint $table) {
            $table->increments('role_id');
            $table->string('role_name',255);
            $table->string('role_description',255)->nullable();
            $table->string('is_active',10);
            $table->timestamps();
        });
        
        /**
        * Default values populated during migrations.
        */
        DB::table('event_participants_role_master')->insert([
            ['role_name' => 'GUEST', 'role_description' => 'Part of the event with no organising role','is_active'=>'N','created_at'=>now(),'updated_at'=>now()],
            ['role_name' => 'SUPER ADMIN', 'role_description' => 'Event creator','is_active'=>'Y','created_at'=>now(),'updated_at'=>now()],
            ['role_name' => 'ADMIN', 'role_description' => 'Have all access except delete event','is_active'=>'Y','created_at'=>now(),'updated_at'=>now()],
            ['role_name' => 'MEMBER', 'role_description' => 'Have limited rights like being able to write message','is_active'=>'Y','created_at'=>now(),'updated_at'=>now()],
            ['role_name' => 'MODERATOR', 'role_description' => 'Can remove members messages','is_active'=>'N','created_at'=>now(),'updated_at'=>now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_participants_role_master');
    }
}
