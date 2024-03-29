<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{

    //登录界面 只让 未登录的 用户 访问 。这里 是 设置 【只让未登录的用户访问登录界面】。
    public function __construct(){
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    //显示登录界面，此时发出的是get请求。
    public function create(){
        return view('sessions.create');   
    }

    //提交登录请求，如果登录成功了就创建一个会话 。
    public function store(Request $request){
        //数据 刚到 后台的 时候  我们 就对 数据 进行 不走数据库的 初步验证。 
        //邮箱 和  密码  检查 格式 是否正确  是否 为空。
        $validate = $this->validate($request,[
            'email'=>'required|email|max:255',  //这个email是用来验证email格式是否正确的
            'password'=>'required'
        ]);
        //通过 dd($validate); 可以看到 $validate是一个数组，是前台提交的数据组成的一个数组。

        //上面的 验证 检查不通过就自动重定向到登录页面了。
        //格式正确而且不为空，那么就进行 后台 数据库 比对。 
       if(Auth::attempt($validate,$request->has('remember'))){ //前端的表单中提交了一个 remember 的参数。如果有这个参数说明开启了‘记住我’，如果没有这个参数就没有开启这个参数
           
            //登录的时候 我们  需要 验证一下 该用户 是否成功激活 。
            if(Auth::user()->activated){ //账号激活成功了。
                //登录成功 之后的一系列操作。
                //信息提示页面添加内容。
                session()->flash("success", "欢迎回来！");
                //重定向到 指定的  用户信息显示页面的路由上。 并且给这个路由传递一个user用户的实例。通过 Auth::user()来获取当前登录的用户对象。
                    return redirect()->intended(route('users.show', [Auth::user()]));  //放回上一次尝试访问的页面，同时如果上次为null就访问里面的参数所代表的页面。
            }else{//没有激活
                //将 用户的 会话 记录 和 登录状态 全部销毁。
                Auth::logout();
                //显示 未激活的 提示信息
                session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/'); //未激活的用户重定向 到 首页面 。
            }

          
       }else{
            //登录失败 之后的一系列操作。
            //信息提示页面添加内容。
            session()->flash("danger","抱歉，您的邮箱和密码不匹配。");
            //回退到 上一个页面。 
            return redirect()->back()->withInput(); //将input数据存放在session中，然后重定向上一个界面中。 
       }
    }
 
    //用户退出，销毁当前的会话 。 
    public function destroy(){
        //销毁会话，而且在Auth门面调用logout()方法来说明：用户退出登录。
        //关键：实现用户的退出 。 
        Auth::logout();
        session()->flash("success","您已成功退出！");
        return redirect()->route('login'); //这是一个get请求，所以时显示登录页面
    }



}
