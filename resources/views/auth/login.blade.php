@extends('layouts.auth')

@section('content')
@if(session('login_error'))
<div class="bg-danger p-3 rounded text-center mb-2 text-sm text-white">
    {{session('login_error')}}
</div>
@endif
<form action="{{route('login')}}" method="post">
    @csrf
    <div class="form-group">
        <label>Email</label>
        <input name="email" type="text" value="{{old('email') ?? ''}}" class="form-control @error('email') border-danger @enderror">
    </div>
    @error('email')
    <div class="bg-danger text-sm text-white p-3 rounded mb-2">
        {{$message}}
    </div>
    @enderror
    <div class="form-group">
        <div class="row">
            <div class="col">
                <label>Mật khẩu</label>
            </div>
            <div class="col-auto">
                <a class="text-muted" href="{{route('forgot-password')}}">
                    Quên mật khẩu?
                </a>
            </div>
        </div>
        <input name="password" class="form-control  @error('password') border-danger @enderror"  type="password">
        
    </div>
    @error('password')
    <div class="bg-danger text-sm text-white p-3 rounded mb-2">
        {{$message}}
    </div>
    @enderror
    <div class="form-group text-center">
        <button class="btn btn-primary account-btn" type="submit">Đăng nhập</button><br>
    </div>
    <div>
        <a href="{{route('google-auth')}}">
        <img src="{{ URL::asset('./assets/img/gglogin.png')}}" height="45px" style="margin-left: 50px">
        </a>
        
    </div>
</form>
@endsection