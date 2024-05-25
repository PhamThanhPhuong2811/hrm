<?php

namespace App\Http\Controllers\Frontend;

use App\Models\JobApplicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|max:200',
            'email' => 'required|email',
            'cv' => 'required|file|mimes:pdf',
            'message' => 'nullable|max:255|min:10',
            'job_id' => 'required|exists:jobs,id',
        ]);
        if($request->hasFile('cv')){
            $cv = time().'.'.$request->cv->extension();
            $request->cv->move(public_path('storage/cv'), $cv);
        }
        JobApplicant::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'cv' => $cv,
            'job_id' => $request->job_id,
        ]);
        session()->flash('notification', 'Đơn xin việc của bạn đã được gửi!');
        return back();
       
    }  
    //thêm ngày 20/4
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:job_applicants,id',
            'status' => 'required|in:Hồ sơ mới,Đã tuyển,Từ chối,Đã phỏng vấn',
        ]);

        $applicant = JobApplicant::findOrFail($request->id);
        $applicant->update(['status' => $request->status]);

        $notification = notify('Cập nhật trạng thái ứng viên thành công');
        return back()->with($notification);
    }
    
    public function completed(Request $request,JobApplicant $applicant){
        //    $holiday = Holiday::find($request->id);
           $applicant->update([
               'completed'=>1,
           ]);
           $notification = notify('Đã phỏng vấn ứng viên');
            return back()->with($notification);
        }
        public function xoa(Request $request)
        {
            JobApplicant::findOrFail($request->id)->delete();
            $notification = notify('Xóa ứng viên thành công');
            return back()->with($notification);
        }
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
