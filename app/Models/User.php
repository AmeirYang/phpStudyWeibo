<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    //定义一下对应的数据库
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //获取 到 用户 在 gravatar 中存放的 头像地址。 
    public function gravatar($size = 'size'){
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/".$hash."?s=".$size;
    }

    //激活令牌 应该 在 User类 被 实例化 之前 生成，这样才能确保 每一个用户 对应 一个 激活令牌 。
    //Model 初始化 ----》 Model 实例化 ,所以我们需要在实例化之前也就是初始化的时候 将 激活令牌为 该用户也就是该modle模型生成出来。 
    //Laravel 框架用来 初始化 的  静态方法是：boot； 我们重写这个方法 使这个boot不仅能 初始化Model模型，而且还能 生成 激活令牌。
    public static function boot(){
        //我们调用父类Model类中的boot()方法 来完成Model模型的初始化工作。
        parent::boot();
        //我们使用 static门面中的creating()方法来监听  Model模型被创建，创建之后 获取到 当前的这个 $user实例。
        static::creating(function($user){
            $user->activation_token = Str::random(10); //先将这个实例对象 对应的 数据库中的activation_token字段赋值为  激活令牌的值。
        });
    }



}
