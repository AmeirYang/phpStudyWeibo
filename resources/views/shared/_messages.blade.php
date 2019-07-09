@foreach (['danger', 'warning', 'success', 'info'] as $msg) <!--这四个字符串对应app.css中对应的四个样式-->
    @if(session()->has($msg))<!--判断一下 session 中 含有 键为 $msg的 键值对-->
        <div class="flash-message">
            <p class="alert alert-{{ $msg }}">  <!--添加 对应的 样式-->
              {{ session()->get($msg) }}   <!--从session中获取到提示信息-->
            </p>
        </div>
    @endif
@endforeach

<!--
    session中包含键为:'danger', 'warning', 'success', 'info'的键值对。 
    而且 app.css中也有'danger', 'warning', 'success', 'info'对应的样式。
    不同的 key 对应不同的样式。 
-->