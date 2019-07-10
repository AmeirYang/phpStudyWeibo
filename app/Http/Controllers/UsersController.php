<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    //添加用户
    public function store(Request $request){
         $this->validate($request,[
             'name'=>'required|max:50',
             'email'=>'required|email|unique:users|max:225',
             'password'=>'required|confirmed|min:6'
         ]);
         /*
         当上面的验证信息出现了错误的时候，会被一个web中间件自动将闪存session中的错误信息 存放在error中，
         然后将这个error绑定表单对应的视图中，然后可以使用$error来获取。
         当发生验证失败的时候，会自动的 重定向到 表单提交页面 。
        */
        //验证成功 之后 会 继续向下执行。 
        $user = User::create(
            [
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>bcrypt($request->password),
            ]
        );
        Auth::login($user);
        //我们向 session  中存放  一个键值对，_messages.blade.php页面会通过 key 来 获取对应的 style.css 然后显示 value；
        //这个信息 只显示一次，也就是刷新页面或者到了下一个页面中就没有了不显示了。保存一个一次性的数据。 
        session()->flash('success','欢迎，您将在这里开启一段新的旅程~');
        //验证成功，我们手动 将 页面 重定向到 用户信息显示界面。
        return redirect()->route('users.show',compact('user'));
    }
}
