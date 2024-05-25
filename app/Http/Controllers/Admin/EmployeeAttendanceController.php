<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EmployeeAttendance;
use App\Http\Controllers\Controller;
use App\Settings\AttendanceSettings;
use App\Models\LateCount;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $title = 'Chấm công nhân viên';
        $attendances = EmployeeAttendance::latest()->get();
        $lateCounts = $this->getLateCountsOfMonth();
        return view('backend.attendance', compact('title', 'attendances', 'lateCounts'));
    }

    public function store(Request $request)
{
    $this->validate($request, [
        'employee' => 'required',
        'checkin' => 'required',
    ]);

    $settings = new AttendanceSettings();
    $checkinTime = strtotime($request->checkin);
    $configuredCheckinTime = strtotime($settings->checkin_time);

    if ($checkinTime < $configuredCheckinTime) {
        $status = 'Sớm';
    } elseif ($checkinTime == $configuredCheckinTime) {
        $status = 'Đúng giờ';
    } else {
        $status = 'Trễ';
    }

    $attendance = EmployeeAttendance::create([
        'employee_id' => $request->employee,
        'checkin' => $request->checkin,
        'checkout' => $request->checkout,
        'status' => $status,
    ]);

    // Tăng số lần đi trễ nếu trạng thái là 'Trễ'
    if ($status == 'Trễ') {
        $this->incrementLateCount($request->employee);
    }

    $notification = notify('Thêm chấm công nhân viên thành công');
    return back()->with($notification);
}

private function incrementLateCount($employeeId)
{
    $lateCount = LateCount::firstOrNew(['employee_id' => $employeeId, 'month' => date('m'), 'year' => date('Y')]);
    $lateCount->late_count = $lateCount->late_count + 1;
    $lateCount->save();
}

public function update(Request $request)
{
    $this->validate($request, [
        'employee' => 'required',
        'checkin' => 'required',
    ]);

    $settings = new AttendanceSettings();
    $checkinTime = strtotime($request->checkin);
    $configuredCheckinTime = strtotime($settings->checkin_time);

    if ($checkinTime < $configuredCheckinTime) {
        $status = 'Sớm';
    } elseif ($checkinTime == $configuredCheckinTime) {
        $status = 'Đúng giờ';
    } else {
        $status = 'Trễ';
    }

    $attendance = EmployeeAttendance::findOrFail($request->id);
    $previousStatus = $attendance->status;
    $attendance->update([
        'employee_id' => $request->employee,
        'checkin' => $request->checkin,
        'checkout' => $request->checkout,
        'status' => $status,
    ]);

    // Nếu trạng thái trước đó không phải 'Trễ' nhưng trạng thái mới là 'Trễ'
    if ($status == 'Trễ' && $previousStatus != 'Trễ') {
        $this->incrementLateCount($request->employee);
    }

    $notification = notify('Cập nhật phiếu chấm công thành công');
    return back()->with($notification);
}

    protected function updateLateCount($employeeId, $status)
    {
        if ($status === 'Trễ') {
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            DB::table('late_counts')->updateOrInsert(
                ['employee_id' => $employeeId, 'year' => $currentYear, 'month' => $currentMonth],
                ['late_count' => DB::raw('late_count + 1')]
            );
        }
    }

    public function getLateCountsOfMonth()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $lateCounts = DB::table('late_counts')
            ->select('employee_id', 'late_count')
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->get()
            ->keyBy('employee_id')
            ->toArray();

        return $lateCounts;
    }
       /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        EmployeeAttendance::findOrFail($request->id)->delete();
        $notification = notify('Phiếu chấm công được xóa thành công');
        return back()->with($notification);
    }
}
