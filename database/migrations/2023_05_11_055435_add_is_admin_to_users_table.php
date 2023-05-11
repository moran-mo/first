<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //  迁移  在迁移时创建 is_admin,并且赋予 is_admin 默认值为false
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    // 回滚  在回滚时 删除/移除 is_admin
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //  使用 dropColumn 方法来对指定字段进行移除
            $table->dropColumn('is_admin');
        });
    }
};
