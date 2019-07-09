<a href="{{ route('users.show', $user->id) }}">
        <!--通过include来向该页面传递了一个user实例，然后从该页面中调用gravatar方法获取到该用户头像的地址-->
        <img src="{{ $user->gravatar('140') }}" alt="{{ $user->name }}" class="gravatar"/>
</a>
<h1>{{ $user->name }}</h1>