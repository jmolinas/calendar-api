<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleDatesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schedule_dates', function (Blueprint $table) {
      $table->uuid('schedule_id')->index();
      $table->date('date');
      $table
        ->foreign('schedule_id')
        ->references('id')
        ->on('schedule');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('schedule_dates');
  }
}
