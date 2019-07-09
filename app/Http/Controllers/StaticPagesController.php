<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
        //显示主页面
        public function forwardHomeView(){
            return view('StaticPages/home');
        }
        //显示帮助页面
        public function forwardHelpView(){
            return view('StaticPages/help');
        }
        //显示关于页面
        public function forwardAboutView(){
            return view('StaticPages/about');
        }


}
