<?php
namespace App\Http\Controllers;

use App\Models\Overtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Nhân viên làm thêm';
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $overtimes = Overtime::whereMonth('overtime_date', $currentMonth)
                             ->whereYear('overtime_date', $currentYear)
                             ->get();

        $totalEarningsByEmployee = $overtimes->groupBy('employee_id')->map(function ($employeeOvertimes) {
            return $employeeOvertimes->sum('earnings');
        });

        return view('backend.employee-overtime', compact('title', 'overtimes', 'totalEarningsByEmployee', 'currentMonth', 'currentYear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'employee' => 'required',
            'hours' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        $ratePerHour = 30000; // Giá trị cố định cho mỗi giờ tăng ca
        $earnings = $ratePerHour * $request->hours;

        Overtime::create([
            'employee_id' => $request->employee,
            'overtime_date' => $request->date,
            'hours' => $request->hours,
            'description' => $request->description,
            'earnings' => $earnings,
        ]);

        $notification = notify('Thêm nhân viên làm thêm thành công!');
        return back()->with($notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    $this->validate($request, [
        'employee_id' => 'required',
        'hours' => 'required|integer',
        'date' => 'required|date',
        'description' => 'required|string',
    ]);

    $ratePerHour = 30000; // Giá trị cố định cho mỗi giờ tăng ca
    $earnings = $ratePerHour * $request->hours;

    $overtime = OverTime::findOrFail($request->id);
    $overtime->update([
        'employee_id' => $request->employee_id,
        'overtime_date' => $request->date,
        'hours' => $request->hours,
        'description' => $request->description,
        'earnings' => $earnings,
        'approved_by' => auth()->user()->id,
    ]);

    $notification = notify('Cập nhật thông tin nhân viên làm thêm thành công!');
    return back()->with($notification);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        OverTime::findOrFail($request->id)->delete();
        $notification = notify('Xóa nhân viên làm thêm thành công!');
        return back()->with($notification);
    }
    public function filter(Request $request)
    {
        $title = 'Nhân viên làm thêm';

        $month = $request->input('month');
        $year = $request->input('year');

        $overtimes = Overtime::whereMonth('overtime_date', $month)
                             ->whereYear('overtime_date', $year)
                             ->get();

        $totalEarningsByEmployee = $overtimes->groupBy('employee_id')->map(function ($employeeOvertimes) {
            return $employeeOvertimes->sum('earnings');
        });

        return view('backend.employee-overtime', compact('title', 'overtimes', 'totalEarningsByEmployee', 'month', 'year'));
    }
}

