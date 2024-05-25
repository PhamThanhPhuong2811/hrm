<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(){
        $title = 'Danh sách các hoạt động';
        return view('backend.activity',compact(
            'title'
        ));
    }

    public function markAsRead(){
        foreach (auth()->user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        $notification = notify('Đã xóa tất cả thông báo');
        return back()->with($notification);
    }
}
