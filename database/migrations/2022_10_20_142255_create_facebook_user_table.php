<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_users', function (Blueprint $table) {
            $table->id();
            $table->string('access_token');
            $table->integer('fb_user_id');
            $table->integer('data_access_expiration_time');
            $table->integer('expires_in');
            $table->bigInteger('user_id', false, true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facebook_user');
    }
}
