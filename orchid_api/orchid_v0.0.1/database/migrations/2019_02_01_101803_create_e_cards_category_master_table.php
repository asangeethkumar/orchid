<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateECardsCategoryMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_category_master', function (Blueprint $table) {
            $table->increments('cards_category_id');
            $table->string('cards_category_name',255);
            $table->string('cards_category_description',255)->nullable();
            $table->timestamps();
        });
        
        /**
        * Default values populated during migrations.
        */
        DB::table('cards_category_master')->insert([
            ['cards_category_name' => 'OTHER', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'BIRTHDAY', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'ANNIVERSARY', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'CONDOLENSE', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'WEDDING', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'CONGRATULATIONS', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'GET WELL', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'THANK YOU', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'RETIREMENT', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'NEW BABY', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'FAREWELL', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'GRADUATION', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()],
            ['cards_category_name' => 'USER_UPLOADED', 'cards_category_description' => '','created_at'=>now(),'updated_at'=>now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards_category_master');
    }
}
