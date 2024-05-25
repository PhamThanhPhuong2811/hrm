<?php

namespace App\Http\Controllers\NhanVien;

use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Xemchamcong extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Danh sách nhân viên chấm công';
        $employeeId = auth()->user()->employee_id;

        // Get current month and year if no filter is applied
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $attendances = EmployeeAttendance::where('employee_id', $employeeId)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->get();

        $lateCounts = $this->getLateCountsOfMonth($month, $year);

        return view('NhanVien.attendance', compact(
            'title', 'attendances', 'lateCounts', 'month', 'year'
        ));
    }

    public function filter(Request $request)
    {
        $title = 'Danh sách nhân viên chấm công';
        $employeeId = auth()->user()->employee_id;

        $month = $request->input('month');
        $year = $request->input('year');

        $attendances = EmployeeAttendance::where('employee_id', $employeeId)
                                        ->whereMonth('created_at', $month)
                                        ->whereYear('created_at', $year)
                                        ->get();

        $lateCounts = $this->getLateCountsOfMonth($month, $year);

        return view('Nhanvien.attendance', compact(
            'title', 'attendances', 'lateCounts', 'month', 'year'
        ));
    }

    public function getLateCountsOfMonth($month, $year)
    {
        $employeeId = auth()->user()->employee_id;

        $lateCounts = DB::table('late_counts')
            ->select('employee_id', 'late_count')
            ->where('employee_id', $employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->get()
            ->keyBy('employee_id')
            ->toArray();

        return $lateCounts;
    }
}
