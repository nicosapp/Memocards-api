<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCategoryPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_post', function (Blueprint $table) {
            $table->bigIncrements('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_post', function (Blueprint $table) {
            $table->dropColumn('id');
            //
        });
    }
}
