<?php

namespace App\Http\Controllers\Admin;

use App\Models\Leave;
use App\Models\Employee;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Nhân viên nghỉ phép";
        $leaves = Leave::with('leaveType','employee')->get();
        $leave_types = LeaveType::get();
        $employees = Employee::get();
        return view('backend.employee-leaves',compact(
            'title','leaves','leave_types','employees'
        ));
    }

    // Thêm vào ngày 20/4
    public function updateStatus(Request $request)
    {
        $leave = Leave::find($request->id);
        $leave->update([
            'status' => $request->status,
        ]);
        $notification = notify("Cập nhật trạng thái nhân viên nghỉ phép thành công");
        return back()->with($notification);
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
            'leave_type' => 'required',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'reason' => 'required'
        ]);

        $from = $request->input('from');
        $to = $request->input('to');

        // Tính số ngày nghỉ
        $num_leave_days = (new \DateTime($to))->diff(new \DateTime($from))->days + 1;

        $leave = Leave::create([
            'employee_id' => $request->employee,
            'leave_type_id' => $request->leave_type,
            'from' => $from,
            'to' => $to,
            'reason' => $request->reason,
            'status' => $request->status,
        ]);

        // Cập nhật số ngày nghỉ đã sử dụng của nhân viên
        $employee = Employee::find($request->employee);
        $employee->used_leave_days += $num_leave_days;
        $employee->save();

        $notification = notify("Thêm nhân viên nghỉ phép thành công");
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
            'employee' => 'required',
            'leave_type' => 'required',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'reason' => 'required'
        ]);
    
        $from = $request->input('from');
        $to = $request->input('to');
    
        // Tính số ngày nghỉ mới
        $new_num_leave_days = (new \DateTime($to))->diff(new \DateTime($from))->days + 1;
    
        $leave = Leave::find($request->id);
        
        // Tính số ngày nghỉ cũ
        $old_num_leave_days = (new \DateTime($leave->to))->diff(new \DateTime($leave->from))->days + 1;
    
        // Cập nhật số ngày nghỉ đã sử dụng của nhân viên
        $employee = Employee::find($request->input('employee'));
        $employee->used_leave_days = $employee->used_leave_days - $old_num_leave_days + $new_num_leave_days;
        $employee->save();
    
        $leave->update([
            'employee_id' => $request->input('employee'),
            'leave_type_id' => $request->input('leave_type'),
            'from' => $from,
            'to' => $to,
            'reason' => $request->input('reason'),
            'status' => $request->input('status'),
        ]);
    
        $notification = notify("Cập nhật thông tin nhân viên nghỉ phép thành công");
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

        // Cập nhật lại số ngày nghỉ đã sử dụng của nhân viên
        $num_leave_days = (new \DateTime($leave->to))->diff(new \DateTime($leave->from))->days + 1;
        $employee = Employee::find($leave->employee_id);
        $employee->used_leave_days -= $num_leave_days;
        $employee->save();

        $leave->delete();

        $notification = notify('Xóa nhân viên nghỉ phép thành công');
        return back()->with($notification);
    }
}
