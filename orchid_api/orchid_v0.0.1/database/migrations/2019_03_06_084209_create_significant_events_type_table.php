<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignificantEventsTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('significant_events_type', function (Blueprint $table) {
            $table->increments('se_type_id');
            $table->string('se_type_name');
            $table->string('se_type_description',1024)->nullable();
            $table->timestamps();
        });
        
        /**
        * Default values populated during migrations.
        */
        DB::table('significant_events_type')->insert([
            ['se_type_name' => 'OTHER', 'se_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['se_type_name' => 'BIRTHDAY', 'se_type_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['se_type_name' => 'ANNIVERSARY', 'se_type_description' => '','created_at'=>now(),'updated_at'=>now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('significant_events_type');
    }
}
