<?php

namespace App\Http\Controllers\NhanVien;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Nhanviennghiphep extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    $title = "Nhân viên nghỉ phép";
    $leave_types = LeaveType::get();
    $employeeId = auth()->user()->employee_id;

    // Lấy tất cả đơn nghỉ phép của nhân viên
    $leaves = Leave::where('employee_id', $employeeId)->get();

    // Số ngày nghỉ tối đa (giả sử là 15 ngày)
    $maxLeaveDays = 15;

    // Tính tổng số ngày nghỉ đã sử dụng và số ngày nghỉ còn lại
    $usedLeaveDays = 0;
    foreach ($leaves as $leave) {
        $from = new \DateTime($leave->from);
        $to = new \DateTime($leave->to);
        $days = $from->diff($to)->days + 1;
        $usedLeaveDays += $days;
        $leave->usedLeaveDays = $days;
        $leave->remainingLeaveDays = $maxLeaveDays - $usedLeaveDays;
    }

    return view('NhanVien.Nghiphep.employee-leaves', compact('title', 'leaves', 'leave_types'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'leave_type' => 'required',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'reason' => 'required'
        ]);
    
        $employeeId = auth()->user()->employee_id;
        $from = new \DateTime($request->input('from'));
        $to = new \DateTime($request->input('to'));
    
        // Kiểm tra xem nhân viên có đang trong đợt nghỉ phép không
        $existingLeave = Leave::where('employee_id', $employeeId)
            ->where('to', '>=', now())
            ->first();
    
        if ($existingLeave) {
            $notification = notify("Nhân viên đang trong đợt nghỉ phép. Không thể tạo đơn mới.");
            return back()->with($notification);
        }
    
        // Tính số ngày nghỉ
        $daysRequested = $from->diff($to)->days + 1;
    
        // Tạo đơn nghỉ phép mới
        Leave::create([
            'employee_id' => $employeeId,
            'leave_type_id' => $request->leave_type,
            'from' => $request->from,
            'to' => $request->to,
            'reason' => $request->reason,
            'status' => 'Đang chờ'
        ]);
    
        // Cập nhật số ngày nghỉ đã sử dụng của nhân viên
        $employee = Employee::find($employeeId);
        $employee->used_leave_days += $daysRequested;
        $employee->save();
    
        $notification = notify("Thêm đơn nghỉ phép thành công");
        return back()->with($notification);
    }
      
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    $this->validate($request, [
        'leave_type' => 'required',
        'from' => 'required|date',
        'to' => 'required|date|after:from',
        'reason' => 'required'
    ]);

    $leave = Leave::find($request->id);
    $employee = Employee::find($leave->employee_id);

    // Tính số ngày nghỉ cũ
    $oldFrom = new \DateTime($leave->from);
    $oldTo = new \DateTime($leave->to);
    $oldDays = $oldFrom->diff($oldTo)->days + 1;

    // Tính số ngày nghỉ mới
    $newFrom = new \DateTime($request->input('from'));
    $newTo = new \DateTime($request->input('to'));
    $newDays = $newFrom->diff($newTo)->days + 1;

    // Cập nhật thông tin đơn nghỉ phép
    $leave->update([
        'leave_type_id' => $request->leave_type,
        'from' => $request->from,
        'to' => $request->to,
        'reason' => $request->reason,
        'status' => 'Đang chờ',
    ]);

    // Cập nhật số ngày nghỉ đã sử dụng của nhân viên
    $employee->used_leave_days = $employee->used_leave_days - $oldDays + $newDays;
    $employee->save();

    $notification = notify("Cập nhật thông tin đơn nghỉ phép thành công");
    return back()->with($notification);
}
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $leave = Leave::find($request->id);
        $leave->delete();
        $notification = notify('Xóa đơn nghỉ phép thành công');
        return back()->with($notification);
    }
}
