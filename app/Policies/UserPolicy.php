<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

//这里是用来定义 授权 的 逻辑的 。
class UserPolicy
{
    use HandlesAuthorization;

    //当 用户 操作 更新个人信息 的时候  会 有一个 授权的操作，只有 当前登录用户的id和修改信息用户的id相同时 才能 授权通过。 
   public function update(User $currentUser,User $user){
        //第一个currentUser参数为：当前登录用户。 第二个user参数为：需要进行修改的用户的id。 
        //授权验证 逻辑: 当 当前用户的id等于修改用户的id的时候 说明 修改的是自己的 数据信息 ，所以 授权通过。当id不相等的时候说明该用户在修改另一个用户的信息，所以授权不通过。
        return $currentUser->id === $user->id ;  //授权通过了 就会 接着代码往下执行，如果授权不通过，那么Laravel框架会为用户显示一个403禁止访问的错误。 
        /*
            "=" : 赋值时使用。 
            "==" ： 只会比较 值 是否相等。 
            "===" ： 全等，比较两个 变量的 类型是否相等，值是否相等 。 
        */
   }

   //当 管理员 删除 人员信息的时候后 授权 逻辑。 
   public function destroy(User $currentUser,User $user){
        return $currentUser->is_admin && $currentUser->id !== $user->id ; 
        //必须满足 当前用户是管理员 而且 操作的人员不是自己 。
   }

}
