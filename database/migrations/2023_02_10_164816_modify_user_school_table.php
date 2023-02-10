<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserSchoolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_schools', function (Blueprint $table) {
            $table->dropColumn('start_year');
            $table->dropColumn('end_year');
            $table->date('start');
            $table->date('end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_schools', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->year('start_year');
            $table->year('end_year');
        });
    }
}
