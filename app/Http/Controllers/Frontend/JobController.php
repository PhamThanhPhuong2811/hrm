<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function index(){
        $title = "Thông báo tuyển dụng";
        $jobs = Job::with('department')->get();
        return view('frontend.job-list',compact(
            'title','jobs'
        ));
    }

    public function show(Job $job){
        $title = "Chi tiết thông báo tuyển dụng";
        return view('frontend.job-view',compact(
            'title','job'
        ));
    }
}
