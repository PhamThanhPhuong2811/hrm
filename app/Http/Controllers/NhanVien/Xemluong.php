<?php

namespace App\Http\Controllers\NhanVien;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Salary;
use Carbon\Carbon;

class Xemluong extends Controller
{
    public function index(Request $request)
    {
        $title = "Thông tin lương";
        $employeeId = auth()->user()->employee_id;

        // Get current month and year if no filter is applied
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $salarys = Salary::where('employee_id', $employeeId)
                         ->whereMonth('created_at', $month)
                         ->whereYear('created_at', $year)
                         ->get();
        $salary_basic = 5000000;

        return view('NhanVien.Salary', compact('title', 'salarys', 'salary_basic', 'month', 'year'));
    }

    public function filter(Request $request)
    {
        $title = "Thông tin lương";
        $employeeId = auth()->user()->employee_id;

        $month = $request->input('month');
        $year = $request->input('year');

        $salarys = Salary::where('employee_id', $employeeId)
                         ->whereMonth('created_at', $month)
                         ->whereYear('created_at', $year)
                         ->get();
        $salary_basic = 5000000;

        return view('NhanVien.Salary', compact('title', 'salarys', 'salary_basic', 'month', 'year'));
    }
}
