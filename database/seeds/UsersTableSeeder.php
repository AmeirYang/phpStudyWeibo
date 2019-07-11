<?php

use Illuminate\Database\Seeder;
use App\Models\User ; 

//该run方法会调用工厂，实现数据的真正填充，但是 run必须有call方法来调用执行，因为call方法底层调用的run方法。 
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){ //这个方法必须有 call() 方法 来 调用 驱动 。 

        $users = factory(User::class)->times(50)->make();//调用 factory 工厂类 创建 50个 user对象 。
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
        /*
            $users->makeVisible(['password', 'remember_token'])  将User中的password 和 remember_token字段设置为批量操作，本来是被隐藏掉了。 
            $users->toArray(); 将users对象转换成数组的形式。 
        */
        //我们先将第一个设置为我们的  管理员账户。 
        $user = User::find(1);
        $user->name = "Ameir_Yang" ;
        $user->email = "1351617602@qq.com" ;
        $user->is_admin=true;
        $user->save();
    }
}
