<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->comment('イベントID');
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->comment('ユーザーID');
            $table->boolean('paid')->default(false)->comment('支払済');
            $table->boolean('cancellation_request')->default(false)->comment('キャンセル希望');
            $table->unsignedInteger('payment_method')->comment('支払方法');
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
        Schema::dropIfExists('entries');
    }
}
