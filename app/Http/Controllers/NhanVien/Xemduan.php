<?php

namespace App\Http\Controllers\NhanVien;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;

class Xemduan extends Controller
{
    public function index()
{
    $title = 'Danh sách dự án';
    $employeeId = auth()->user()->employee_id;

        $projects = Project::where(function ($query) use ($employeeId) {
            $query->where('team', 'like', '%"'.$employeeId.'"%')
                  ->orWhere('team', 'like', '%,'.$employeeId.']%')
                  ->orWhere('team', 'like', '%['.$employeeId.',%')
                  ->orWhere('team', 'like', '%['.$employeeId.']%');
        })->get();
    $count_new = Ticket::where('status', 'New')->count();
    return view('NhanVien.Duan.index',compact(
        'title','projects','count_new'
    ));
}
  
    public function show($project_id)
    {
        $title = 'Chi tiết dự án';
        $project = Project::where('id','=',$project_id)->firstOrFail();
        $tasks = Ticket::where('project_id', $project_id)->get();
        return view('NhanVien.Duan.show',compact(
            'title','project','tasks'
        ));
    }
    

}


