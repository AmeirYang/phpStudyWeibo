<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



class UsersController extends Controller
{


    //添加了这个中间件，用户从地址栏中输入http://localhost:8000/users/{user}/edit命令的时候就会被拦截跳转到login 用户1就不能修改用户2 的信息。
    //为UsersController这个控制器添加一个 中间件，并为这个中间件设置动作。
    public function __construct(){ //这个函数是PHP中的构造方法，在UsersController实例对象创建之前就会被调用执行。
        //在创建 UsersController\实例之前就 执行了 _construct构造方法了，然后就 将 中间件 绑定在了 该控制器上了。
        //当 有  请求 被 该控制器接受到之后，就会被中间件所捕获，进入中间件中做处理。
        //middleware('所使用的中间件名称','执行的动作');
        $this->middleware('auth',[
            'except'=>['show','create','store','index','confirmEmail'] // show/create/store这三个请求时 不被 中间件 auth 所捕获的 。
        ]);


        //这里是设置【只让 未登录的用户 访问 注册界面】
        $this->middleware('guest',[
            'only'=>['create']
        ]);

    }


    //destroy 管理员授权成功之后，就可以指定下面的删除操作。
    public function destroy(User $user){
        //删除操作 只能 是 登录成功的 管理员才能继续操作。 
        $this->authorize('destroy',$user);//如果 授权失败 返回 false ，页面显示的是：This action is unauthorized.
        $user->delete();
        session()->flash('success','用户删除成功!');
        return back();
    }



    //显示所有用户列表
    public function index(){
        //从数据库中将所有的 用户信息 全部检索 出来 。
        //分页显示，每页显示10条数据。 
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

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
        //调用邮件发送的方法来 发送邮件，邮件的内容已经被log 日志文件记录下来了。 
        $this->sendEmailConfirmationTo($user);
        session()->flash("success","激活右键已经发送至您的邮箱,请查收......");
        return redirect("/");
    }

    //更新用户信息
    public function edit(User $user){

        //对该用户进行授权判定。
        $this->authorize('update',$user);
        //接收到这个请求，就会请求转发到更新用户信息界面。
        return view('users.edit',compact('user'));

    }   

    public function update(User $user,Request $request){

        //将更新用户信息表单 提交的 数据 进行数据格式的验证。 
        //主要是验证 姓名 和  密码 ，因为我们不需要修改账号。所以我们不需要走数据库对比 。
        $this->validate($request,[
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6' //这里设置的密码时可以为空的。 
            //当我们的用户只想要修改用户名的时候，这时候用户就不用再次输入密码和确认密码了，直接点击更新就行了。然后这样就只修改用户名。
        ]);

         //授权验证。 
         $this->authorize('update',$user);


        //如果验证不同过，就将错误信息存放到 session中进行闪存了，然后 放进 $error 变量中，这个变量绑定了表单的视图。
        
        //因为 密码 可以为空 null，所以我们操作密码的时候需要进行判断一下了。
        $data=[];
        $data['name'] = $request->name ; 
        if($request->password!=null){
            $data['password'] = bcrypt($request->password) ; 
            User::find($user->id)->update($data);
            Auth::logout();
            session()->flash('success','用户信息修改成功!');
            return redirect()->route('login');
        }else{
            User::find($user->id)->update($data);
            //当页面跳转到了show用户信息显示界面的时候的提示语。 
            session()->flash('success','用户信息修改成功!');
            return redirect()->route('users.show',Auth::user());
        }

    }

    //邮箱信息的视图，邮箱信息相关的数据数组，然后就是一个闭包回调，会返回一个邮件详情message
    public function sendEmailConfirmationTo(User $user){
        $view = 'emails.confirm' ;
        $data = compact('user');
        $from = '1351617602@qq.com' ;
        $name = 'Ameir_Yang' ;
        $to = $user->email;
        $subject = '感谢注册 Weibo 应用！请确认你的邮箱。' ;   
        Mail::send($view,$data,function($message)use($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });  
    }

    //用户在 log文件中接收到 激活邮件，然后进行激活的操作。
    /*
        什么是激活？ 
        创建用户实例的时候，我们会给用户生成一个 activation_token .然后我们给用户发送一封邮件，里面有一个连接，这个连接的参数里有这个activation_token，然后如果用户点击了这个超链接，说明用户执行了激活操作，那么我们就直接修改数据库的激活状态就行了。 
    */
    public function confirmEmail($token){

        //找到对应 token 激活码 的  用户 修改用户 激活状态为true. 
        $user=User::where('activation_token',$token)->firstOrFail();
        $user->activated = true ; 
        //这个项目 生成 激活码 时使用的 random（10）生成的，
        $user->activation_token = null;
        $user->save();
        //修改用户 激活状态 为 true
        Auth::login($user);
        session()->flash('success','恭喜您，激活成功!');
        return redirect()->route('users.show',[$user]);
    }

}
