<?php

namespace App\Http\Controllers\NhanVien;

use App\Models\Policy;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class Xemchinhsach extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Chính sách";

        // Lấy thông tin người dùng đang đăng nhập
        $user = Auth::user();

        // Lấy thông tin nhân viên tương ứng với người dùng
        $employee = Employee::where('id', $user->employee_id)->first();

        // Lấy các chính sách của phòng ban của nhân viên
        $policies = Policy::where('department_id', $employee->department_id)->get();

        return view('NhanVien.policies', compact('title', 'policies'));
    }
    
}