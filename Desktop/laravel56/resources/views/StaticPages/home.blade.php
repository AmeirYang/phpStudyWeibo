@extends('layouts.default')
<!--加入layouts.default页面中的代码片段-->
@section('content')
    <div class="jumbotron">
        <h1>AmeirYang博客</h1>
        <p class="lead">
            这是一个 博客 案例 。 
        </p>
        <p>
          一切，将从这里开始。
        </p>
        <p>
          <a class="btn btn-lg btn-success" href="{{route('signup')}}" role="button">现在注册</a>
        </p>
    </div>
@endsection