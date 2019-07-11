<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //调用和驱动 UsersTableSeeder类中的 run方法 来 实现 填充  操作 。
        Model::unguard();//因为我们 在  Model 中  设置了 fillable 允许那些数据进行 数据的批量操作 。有些字段 没有在 fillable中定义 ，所以如果我们需要进行批量操作，那么就需要将Model模型批量操作的保护机制关闭掉。 
        $this->call(UsersTableSeeder::class); //驱动 run()执行。
        //当执行完毕 数据库 数据 填充 操作 的之后，就开启 Model 字段 批量操作的 保护机制 。
        Model::reguard();
    }
}
