<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');

            $useBigInt = env('USER_ID_IS_BIGINT', version_compare(App::version(), '5.8.0', '>='));
            if ($useBigInt) {
                $table->bigInteger('user_id')->unsigned();
            } else {
                $table->integer('user_id')->unsigned();
            }

            $table->integer('person_id')->unsigned();
            $table->string('avatar_type')->nullable();
            $table->text('avatar_data')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('person_id')
                ->references('id')
                ->on('persons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }
}
