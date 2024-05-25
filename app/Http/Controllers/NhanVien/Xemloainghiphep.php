<?php

namespace App\Http\Controllers\NhanVien;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Xemloainghiphep extends Controller
{
    public function index()
    {
        $title = "Loại nghỉ phép";
        $leave_types = LeaveType::get();
        
        return view('NhanVien.leave-type',compact('title','leave_types'));
    }
}


