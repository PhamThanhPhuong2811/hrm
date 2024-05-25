<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Leave;
use App\Models\Ticket;
use App\Models\Salary;
use App\Models\JobApplicant;


class DashboardController extends Controller
{
    public function index(){
        $title = 'Thống kê';
        $leaves = Leave::with('employee')->latest()->take(2)->get();
        // Thống kê số lượng các mục
        $clients_count = Client::count();
        $employee_count = Employee::count();
        $projects_count = Project::count();
        $leaves_count = Leave::count();
        $tickets_count = Ticket::count();
        $jobapplicant = JobApplicant::count();
        $salary= Salary::count();
 
        // Thống kê số lượng các mục theo điều kiện
        $currentDate = date('Y-m-d');
        $count_end = Project::whereDate('end_date', '<', $currentDate)->count();
        $count_high = Project::where('priority', 'Cao')->count();
        $count_medium = Project::where('priority', 'Trung bình')->count();
        $count_low = Project::where('priority', 'Thấp')->count();
        $count_new = Ticket::where('status', 'Mới')->count();
        $count_closed = Ticket::where('status', 'Kết thúc')->count();
        $count_inprogress = Ticket::where('status', 'Inprogress')->count();
        $count_reopen = Ticket::where('status', 'Reopen')->count();
//JobApplicant
        $count_job_new = JobApplicant::where('status', 'Hồ sơ mới')->count();
//Salary
        $count_salary_pending = Salary::where('status', 'Chưa thanh toán')->count();

        // Tính phần trăm các mục
        $percentage_salary_pending_count = ($count_salary_pending / $salary) * 100;
        $percentage_job_new_count = ($count_job_new / $jobapplicant) * 100;
        $percentage_task_new = ($count_new / $tickets_count) * 100;
        $percentage_leave_count = ($leaves_count / $employee_count) * 100;
        $percentage_reopen_count = ($count_reopen / $tickets_count) * 100;
        $percentage_inprogress_count = ($count_inprogress / $tickets_count) * 100;
        $percentage_closed_count = ($count_closed / $tickets_count) * 100;
        $percentage_high_count = ($count_high / $projects_count) * 100;
        $percentage_medium_count = ($count_medium / $projects_count) * 100;
        $percentage_low_count = ($count_low / $projects_count) * 100;
        
        return view('backend.dashboard',compact(
            'title','clients_count','employee_count','projects_count',
            'leaves_count','tickets_count','count_end','count_high',
            'count_medium','count_low','count_new','count_closed',
            'count_inprogress','percentage_task_new','count_reopen',
            'percentage_leave_count','percentage_reopen_count',
            'percentage_inprogress_count','percentage_closed_count',
            'percentage_high_count','percentage_medium_count',
            'percentage_low_count','jobapplicant','count_job_new',
            'percentage_job_new_count','salary','count_salary_pending',
            'percentage_salary_pending_count','leaves'));
    }
    
}
