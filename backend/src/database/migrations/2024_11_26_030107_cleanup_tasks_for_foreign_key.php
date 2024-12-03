<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 既存のタスクデータを削除
        DB::table('tasks')->truncate();

        // user_idカラムを一旦削除
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        // 外部キー制約付きでuser_idカラムを追加
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->after('id')
                ->constrained()
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeignId('tasks_user_id_foreign');
            $table->unsignedBigInteger('user_id')->after('id');
        });
    }
};
