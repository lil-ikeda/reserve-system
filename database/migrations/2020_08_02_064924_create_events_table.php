<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('名前');
            $table->text('description')->comment('詳細');
            $table->date('date')->comment('日程');
            $table->time('open_time')->comment('開始時間');
            $table->time('close_time')->comment('終了時間');
            $table->string('place')->comment('場所');
            $table->integer('price')->comment('料金');
            $table->string('image')->nullable()->comment('サムネイル画像');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
