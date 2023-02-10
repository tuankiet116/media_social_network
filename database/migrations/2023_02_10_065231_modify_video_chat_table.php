<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyVideoChattable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_chat', function(Blueprint $table) {
            $table->uuid('uuid')->unique();
            $table->boolean('is_answer')->nullable();
            $table->boolean('is_accepted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_chat', function(Blueprint $table) {
            $table->dropColumn('uuid');
            $table->dropColumn('is_answer');
            $table->dropColumn('is_accepted');
        });
    }
}
