<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserInfosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('user_infos', function (Blueprint $table) {
      $table->string('lastname', 100)->nullable();
      $table->string('firstname', 100)->nullable();
      $table->string('phone_number', 100)->nullable();
    });
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('username');
      $table->dropColumn('locale');
      $table->dropColumn('firstname');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('user_infos', function (Blueprint $table) {
      //
    });
  }
}
