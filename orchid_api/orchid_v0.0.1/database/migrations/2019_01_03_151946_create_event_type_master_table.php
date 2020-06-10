<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTypeMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_type_master', function (Blueprint $table) {
            $table->increments('event_type_id');
            $table->string('event_type_name',255);
            $table->string('event_type_description',255)->nullable();
            $table->timestamps();
        });
        
        
        /**
        * Default values populated during migrations.
        */
        DB::table('event_type_master')->insert([
            ['event_type_name' => 'OTHER', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'BIRTHDAY', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'ANNIVERSARY', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'CONDOLENSE', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'WEDDING', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'CONGRATULATIONS', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'GET WELL', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'THANK YOU', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'RETIREMENT', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'NEW BABY', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'FAREWELL', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['event_type_name' => 'GRADUATION', 'event_type_description' => '','created_at'=>now(),'updated_at'=>now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_type_master');
    }
}
