<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //用户注册功能模块
    public function create(){
        return view('users.create');
    }

    //显示用户界面
    public function show(User $user){  //当我们 发出 /user/{user}请求：/user/1 的时候，我们laravel会自动去数据库查询id为1的user，然后注入给$user。
        return view('users.show',compact('user')); //我们想show.blade.php页面中传递一个user实例。
    }
}
