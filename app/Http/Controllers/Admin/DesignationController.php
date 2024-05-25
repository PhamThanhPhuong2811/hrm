<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Chức vụ";
        $designations = Designation::with('department')->get();
        $departments = Department::get();
        return view('backend.designations',compact('title','designations','departments'));
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
            'designation'=>'required|max:200',
            'department'=>'required',
        ]);
        Designation::create([
            'name'=>$request->designation,
            'department_id'=>$request->department,
        ]);
        $notification = notify('Thêm chức vụ thành công!');
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
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'designation'=>'required|max:200',
            'department'=>'required',
        ]);
        $designation = Designation::findOrFail($request->id);
        $designation->update([
            'name'=>$request->designation,
            'department_id'=>$request->department,
        ]);
        $notification = notify('Cập nhật thông tin chức vụ thành công!');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $designation = Designation::findOrFail($request->id);
        $designation->delete();
        $notification = notify('Xóa chức vụ thành công!');
        return back()->with($notification);
    }
}
