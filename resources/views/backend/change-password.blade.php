@extends('layouts.backend-settings')
@section('content')
<form method="post" action="{{route('change-password')}}">
    @csrf
    <div class="form-group">
        <label>Mật khẩu cũ</label>
        <input name="old_password"type="password" class="form-control">
    </div>
    <div class="form-group">
        <label>Mật khẩu mới</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>Xác nhận lại mật khẩu mới</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
    <div class="submit-section">
        <button class="btn btn-primary submit-btn">Lưu</button>
    </div>
</form>
@endsection
