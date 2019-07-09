@extends('layouts.default')
@section('title','用户显示')
@section('content')
    <div class="row">
        <div class="offset-md-2 col-md-8">
        <div class="col-md-12">
            <div class="offset-md-2 col-md-8">
            <section class="user_info">
                <!--可以在该页面中获取到user实例，然后通过该实例获取到头像的地址-->
                @include('shared._user_info', ['user' => $user]) 
            </section>
            </div>
        </div>
        </div>
    </div>
@stop
    