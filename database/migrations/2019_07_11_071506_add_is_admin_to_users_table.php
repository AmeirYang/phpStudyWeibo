<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAdminToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->boolean('is_admin')->default('默认值'); 在table表中创建一个boolean类型的字段，名成为 is_admin。并可以使用default()来设置字段的默认值。
            $table->boolean('is_admin')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //逆操作 就是 将 is_admin  字段删除。 
            $table->dropColumn('is_admin');
        });
    }
}
