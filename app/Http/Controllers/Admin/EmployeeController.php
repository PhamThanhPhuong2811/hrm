<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Storage; // Thêm dòng này

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Danh sách nhân viên";
        $designations = Designation::get();
        $departments = Department::get();
        $employees = Employee::with('department','designation')->get();
        return view('backend.employees',
        compact('title','designations','departments','employees'));
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function list()
   {
       $title="Danh sách nhân viên- ADMIN";
       $designations = Designation::get();
       $departments = Department::get();
       $employees = Employee::with('department','designation')->get();
       return view('backend.employees-list',
       compact('title','designations','departments','employees'));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|email',
            'phone'=>'nullable|max:15',
            'start_date'=>'required',
            'avatar'=>'file|image|mimes:jpg,jpeg,png,gif',
            'department'=>'required',
            'designation'=>'required',
            'gender' => 'required',
            'education' => 'required',
            
        ]);
        $imageName = Null;
        if ($request->hasFile('avatar')){
            $imageName = time().'.'.$request->avatar->extension();
            $request->avatar->move(public_path('storage/employees'), $imageName);
        }
        $uuid = IdGenerator::generate(['table' => 'employees','field'=>'uuid', 'length' => 6, 'prefix' =>'NV-']);
        Employee::create([
            'uuid' =>$uuid,
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'start_date'=>$request->start_date,
            'department_id'=>$request->department,
            'designation_id'=>$request->designation,
            'avatar'=>$imageName,
            'gender' => $request->gender,
            'education' => $request->education,
        ]);
        $notification = notify('Thêm nhân viên thành công');
        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
{
    $this->validate($request, [
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable|max:15',
        'start_date' => 'required',
        'avatar' => 'file|image|mimes:jpg,jpeg,png,gif',
        'department' => 'required',
        'designation' => 'required',
        'gender' => 'required',
        'education' => 'required',
    ]);

    $employee = Employee::find($request->id);

    // Kiểm tra nếu người dùng cập nhật ảnh đại diện mới
    if ($request->hasFile('avatar')) {
        // Xóa tệp cũ nếu có
        if ($employee->avatar && Storage::exists('storage/employees' . $employee->avatar)) {
            Storage::delete('public/employees/' . $employee->avatar);
        }

        // Lưu tệp mới
        $imageName = time() . '.' . $request->avatar->extension();
        $request->avatar->move(public_path('storage/employees'), $imageName);
    } else {
        // Giữ nguyên tệp ảnh đại diện cũ
        $imageName = $employee->avatar;
    }

    // Cập nhật thông tin nhân viên
    $employee->update([
        'uuid' => $employee->uuid,
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'email' => $request->email,
        'phone' => $request->phone,
        'start_date' => $request->start_date,
        'department_id' => $request->department,
        'designation_id' => $request->designation,
        'avatar' => $imageName,
        'gender' => $request->gender,
        'education' => $request->education,
    ]);

    $notification = notify('Cập nhật thông tin nhân viên thành công');
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
        $employee = Employee::find($request->id);
        $employee->delete();
        $notification = notify('Xóa nhân viên thành công');
        return back()->with($notification);
    }
}
