<?php

namespace App\Http\Controllers\NhanVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Xemthongtincanhan extends Controller
{
    public function index(){
        $title= 'Thông tin cá nhân';
        return view('NhanVien.profile',compact(
            'title'
        ));
    }

    public function update(Request $request){
        $this->validate($request,[
            'name' => 'required|max:150|min:5',
            'username' => 'required|max:20|min:3',
            'email' => 'required|email',
            'avatar'=>'file|image|mimes:jpg,jpeg,png,gif',
        ]);
        $imageName = auth()->user()->avatar;
        if($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/users'), $imageName);
        }
        auth()->user()->update([
            'name' => $request->name,
            'username'=> $request->username,
            'email' => $request->email,
            'avatar' => $imageName,
        ]);
        $notification = notify('Thông tin cá nhân đã được cập nhật');
        return back()->with($notification);
    }
}
