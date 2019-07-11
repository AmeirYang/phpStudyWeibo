<div class="list-group-item">
    <img class="mr-3" src="{{ $user->gravatar() }}" alt="{{ $user->name }}" width=32>
    <a href="{{ route('users.show', $user) }}">
      {{ $user->name }}
    </a>
    <!--
        如果当前用户不是 管理员 或者  currentUserdID===userID 那么 后面的  删除 图标就不会显示，所以说  UserPolicy中的destroy是用来授权 有没有这个删除图标，有了这个删除图标才能进行删除操作的。
    -->
    @can('destroy', $user)  
    <form action="{{ route('users.destroy', $user->id) }}" method="post" class="float-right">
      {{ csrf_field() }}
      {{ method_field('DELETE') }}
      <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
    </form>
  @endcan
</div>