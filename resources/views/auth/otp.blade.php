@extends('layouts.auth')

@section('content')
<form action="" method="POST">
    <div class="otp-wrap">
        <input type="text" placeholder="0" maxlength="1" class="otp-input">
        <input type="text" placeholder="0" maxlength="1" class="otp-input">
        <input type="text" placeholder="0" maxlength="1" class="otp-input">
        <input type="text" placeholder="0" maxlength="1" class="otp-input">
    </div>
    <div class="form-group text-center">
        <button class="btn btn-primary account-btn" type="submit">Đồng ý</button>
    </div>
    <div class="account-footer">
        <p>Không nhận được mã OTP? <a href="javascript:void(0);">Gửi lại OTP</a></p>
    </div>
</form>
@endsection