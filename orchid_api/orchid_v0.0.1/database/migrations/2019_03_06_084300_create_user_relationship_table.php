<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relationship', function (Blueprint $table) {
            $table->increments('relationship_id');
            $table->string('relationship');
            $table->timestamps();
        });
        
        /**
        * Default values populated during migrations.
        */
        DB::table('user_relationship')->insert([
            ['relationship' => 'OTHER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'FATHER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'MOTHER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'BROTHER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'SISTER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'SON', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'DAUGHTER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'GRANDFATHER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'GRANDMOTHER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'UNCLE', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'AUNT', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'COUSIN', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'FRIEND', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'COLLEAGUE', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'BROTHER-IN-LAW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'SISTER-IN-LAW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'FATHER-IN-LAW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'MOTHER-IN-LAW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'DAUGHTER-IN-LAW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'SON-IN-LAW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'GRANDSON', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'GRANDDAUGHTER', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'NEPHEW', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'NIECE', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'HUSBAND', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'WIFE', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'FIANCE', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'FIANCEE', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'GIRL FRIEND', 'created_at'=>now(),'updated_at'=>now()],
            ['relationship' => 'BOY FRIEND', 'created_at'=>now(),'updated_at'=>now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_relationship');
    }
}
