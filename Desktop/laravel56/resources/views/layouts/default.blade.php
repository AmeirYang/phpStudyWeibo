<!DOCTYPE html>
<html>
    <head>  
        <title>@yield('title','weibo') - Laravel 新手入门教程</title>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="stylesheet" href="/css/home.css">
        <link rel="stylesheet" href="/css/flooter.css">
    </head>
    <body>  
          <!--引入顶部页面-->
           @include('layouts.header')
          <div class="container">
           @yield('content')
          <!--引入底部页面-->
           @include('layouts.flooter')
          </div>
    </body>
</html>
