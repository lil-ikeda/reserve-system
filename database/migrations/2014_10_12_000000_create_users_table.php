<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('名前');
            $table->string('email', 100)->unique()->comment('メールアドレス');
            $table->dateTime('email_verified_at')->nullable()->comment('メール認証日時');
            $table->string('password', 100)->comment('パスワード');
            $table->string('phone', 20)->comment('電話番号');
            $table->date('birthday')->comment('生年月日');
            $table->unsignedInteger('sex')->comment('性別');
            $table->string('avatar')->nullable()->comment('ユーザーアイコン');
            $table->unsignedInteger('circle_id')->comment('サークルID');
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
        Schema::dropIfExists('users');
    }
}
