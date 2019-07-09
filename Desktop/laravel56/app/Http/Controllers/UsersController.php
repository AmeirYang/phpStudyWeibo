<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //用户注册功能模块
    public function create(){
        return view('users.create');
    }
}
