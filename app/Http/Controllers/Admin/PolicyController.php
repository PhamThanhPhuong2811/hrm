<?php

namespace App\Http\Controllers\Admin;

use App\Models\Policy;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Chính sách";
        $departments = Department::get();
        $policies = Policy::with('department')->get();
        return view('backend.policies',compact('title','departments','policies'));
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
        'name' => 'required',
        'description' => 'required|max:255',
        'department' => 'required',
        'policy_files' => 'nullable|array',
        'policy_files.*' => 'file|mimes:pdf,doc,docx|max:2048' // Ensure each file is of a valid type and size
    ]);

    $fileNames = [];
    if ($request->hasFile('policy_files')) {
        foreach ($request->file('policy_files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/policies/'), $fileName);
            $fileNames[] = $fileName;
        }
    }

    Policy::create([
        'name' => $request->name,
        'description' => $request->description,
        'department_id' => $request->department,
        'file' => json_encode($fileNames),
    ]);

    $notification = notify('Thêm chính sách thành công');
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
        'name' => 'required',
        'description' => 'required',
        'department' => 'required',
        'policy_files' => 'nullable|array',
        'policy_files.*' => 'file|mimes:pdf,doc,docx|max:2048'
    ]);

    $policy = Policy::findOrFail($request->id);

    $fileNames = json_decode($policy->file, true) ?? [];
    if ($request->hasFile('policy_files')) {
        foreach ($request->file('policy_files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/policies/'), $fileName);
            $fileNames[] = $fileName;
        }
    }

    $policy->update([
        'name' => $request->name,
        'description' => $request->description,
        'department_id' => $request->department,
        'file' => json_encode($fileNames),
    ]);

    $notification = notify('Cập nhật chính sách thành công');
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
        $policy = Policy::find($request->id);
        $policy->delete();
        $notification = notify('Xóa chính sách thành công');
        return back()->with($notification);
    }
}
