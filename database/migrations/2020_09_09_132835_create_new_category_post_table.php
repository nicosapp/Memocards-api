<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('category_post');
        Schema::create('category_post', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned()->index();
            $table->integer('post_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('category_id')->references('categories')->on('id')->onDelete('cascade');
            $table->foreign('post_id')->references('posts')->on('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_post');
    }
}
