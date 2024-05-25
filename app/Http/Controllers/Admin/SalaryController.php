<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $title = "Thông tin lương";
    $salarys = Salary::with('employee')->get();
    $employees = Employee::get();
    $designations = Designation::get();
    $departments = Department::get();
    $salary_basic= 5000000;
    $lateCounts = session()->get('lateCounts', []);
  
    return view('backend.Salary', compact('title', 'salarys', 'employees','designations','salary_basic','lateCounts'));
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $salary = Salary::find($request->id);
        $salary->delete();
        $notification = notify('Xóa lương nhân viên thành công');
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
    // Validate the incoming request data
    $this->validate($request, [
        'employee' => 'required',
        'phucap' => 'required|numeric',
        'ditre' => 'required|numeric',
        'ngaynghi' => 'required|numeric',
        'status' => 'required'
    ]);

    // Retrieve the employee's designation based on the provided employee ID
    $employee = Employee::with('designation')->find($request->employee);
    if(!$employee){
        // Handle case where employee is not found
        // For example, return with an error message
        $notification = notify("Không tìm thấy thông tin nhân viên", 'error');
        return back()->with($notification);
    }
    
    Salary::create([
        'employee_id' => $employee->id,
        'designation_id' => $employee->designation->id, // Retrieve designation ID from employee
        'phucap' => $request->phucap,
        'tre' => $request->ditre,
        'nghi' => $request->ngaynghi,
        'status' => $request->status,
        // You might want to adjust these values according to your database schema
        'salary_basic' => 0, // Example: default to 0 or retrieve from somewhere
        'phat' => 0, // Example: default to 0 or retrieve from somewhere
        'total' => 0 // Example: default to 0 or retrieve from somewhere
    ]);

    // Create a notification message
    $notification = notify("Thêm lương thành công");

    // Redirect back with the notification message
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
        'id' => 'required',
        'employee' => 'required',
        'designation' => 'required',
        'phucap' => 'required|numeric',
        'ditre' => 'required|numeric',
        'ngaynghi' => 'required|numeric',
        'status' => 'required'
    ]);

    $salary = Salary::findOrFail($request->id);
    $salary->update([
        'employee_id' => $request->employee,
        'designation_id' => $request->designation,
        'phucap' => $request->phucap,
        'tre' => $request->ditre,
        'nghi' => $request->ngaynghi,
        'status' => $request->status,
        // Adjust salary_basic, phat, and total as necessary
    ]);

    $notification = notify("Cập nhật thông tin lương thành công");
    return back()->with($notification);
}

public function updateStatus(Request $request)
{
    $salary = Salary::find($request->id);
    $salary->update([
        'status' => $request->status,
    ]);
    $notification = notify("Cập nhật trạng thái lương của nhân viên thành công");
    return back()->with($notification);
}
}