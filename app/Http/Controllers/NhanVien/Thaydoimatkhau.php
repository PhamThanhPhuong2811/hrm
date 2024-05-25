<?php

namespace App\Http\Controllers\NhanVien;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class Thaydoimatkhau extends Controller
{
    public function index(){
        $title = "Cập nhật mật khẩu mới";
        return view('NhanVien.change-password',compact('title'));
    }

    public function update(Request $request){
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);
        if(password_verify($request->old_password,auth()->user()->password)){
            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);
            $notification = notify('Thay đổi mật khẩu thành công');
            return back()->with($notification);
        }else{
            $notification = notify('Mật khẩu cũ không đúng!!!');
            return back()->with($notification);
        }
    }
}
