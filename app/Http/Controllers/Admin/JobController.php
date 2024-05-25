<?php

namespace App\Http\Controllers\Admin;

use App\Models\Job;
use App\Models\Department;
use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Thông báo tuyển dụng";
        $jobs = Job::with('department')->get();
        $departments = Department::get();
        return view('backend.jobs',compact(
            'title','departments','jobs'
        ));
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
            'title'=>'required',
            'department_id'=>'required',
            'location'=>'required',
            
            'experience'=>'required',
            
            'salary_from'=>'nullable',
            'salary_to'=>'nullable',
            'type'=>'required',
            'status'=>'required',
            'start_date'=>'required',
            'expire_date'=>'required',
            'description'=>'required',
        ]);
        
        Job::create($request->all());
        $notification = notify('Đăng thông báo tuyển dụng thành công');
        return back()->with($notification);
    }

    public function applicants(){
        $title = 'Thực tập sinh';
        $applicants = JobApplicant::with('Job')->latest()->get();
        return view('backend.job-applicants',compact(
            'title','applicants'
        ));
    }

    

    public function downloadCv(Request $request){
        $pathToFile = public_path('storage/cv/'. $request->cv);
        $response = response()->download($pathToFile);
        Session::flash("Đơn xin việc của ứng viên đã được tải về");
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return view('frontend.job-view', compact('job'));
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
        $request->validate([
            'title'=>'required',
            'department'=>'required',
            'location'=>'required',
            
            'experience'=>'required',
           
            'salary_from'=>'nullable',
            'salary_to'=>'nullable',
            'type'=>'required',
            'status'=>'required',
            'start_date'=>'required',
            'expire_date'=>'required',
            'description'=>'required',
        ]);
        $job = Job::findOrFail($request->id);
        $job->update([
            'title' => $request->title ?? $job->title,
            'department_id' => $request->department ?? $job->department_id,
            'location' => $request->location ?? $job->location,
            
            'experience' => $request->experience ?? $job->experience,
            
            'salary_from' => $request->salary_from ?? $job->salary_from,
            'salary_to' => $request->salary_to ?? $job->salary_to,
            'type' => $request->type ?? $job->type,
            'status' => $request->status ?? $job->status,
            'start_date' => $request->start_date ?? $job->start_date,
            'expire_date' => $request->expire_date ?? $job->expire_date,
            'description' => $request->description ?? $job->description,
        ]);
        $notification = notify('Cập nhật thông báo tuyển dụng thành công');
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
        Job::findOrFail($request->id)->delete();
        $notification = notify('Xóa thông báo tuyển dụng thành công');
        return back()->with($notification);
    }
    public function updateStatus(Request $request)
    {
        $job = Job::find($request->id);
        $job->update([
            'status' => $request->status,
        ]);
        $notification = notify("Cập nhật trạng thái thông báo tuyển dụng thành công");
        return back()->with($notification);
    }
}
