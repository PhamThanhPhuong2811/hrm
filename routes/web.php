<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\Admin\GoalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AssetController;

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PolicyController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Frontend\JobController;
use App\Http\Controllers\Admin\BackupsController;
use App\Http\Controllers\Admin\ContactController;

use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\GoalTypeController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeaveTypeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\EmployeeLeaveController;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Frontend\JobApplicationController;
use App\Http\Controllers\Admin\EmployeeAttendanceController;

use App\Http\Controllers\Admin\JobController as BackendJobController;
use App\Http\Controllers\NhanVien\Xemngayle;
use App\Http\Controllers\NhanVien\Xemloainghiphep;
use App\Http\Controllers\NhanVien\Xemduan;
use App\Http\Controllers\NhanVien\Xemchamcong;
use App\Http\Controllers\NhanVien\Xemmuctieu;
use App\Http\Controllers\NhanVien\Xemthongtincanhan;
use App\Http\Controllers\NhanVien\Thaydoimatkhau;
use App\Http\Controllers\NhanVien\Nhanviennghiphep;
use App\Http\Controllers\NhanVien\Xemnhiemvu;
use App\Http\Controllers\NhanVien\Guimail;
use App\Http\Controllers\NhanVien\Xemluong;
use App\Http\Controllers\NhanVien\Xemchinhsach;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\PHPMailerController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['guest']], function (){
    Route::get('register',[RegisterController::class,'index'])->name('register');
    Route::post('register',[RegisterController::class,'store']);
//Đăng nhập
    Route::get('login',[LoginController::class,'index'])->name('login');
    Route::post('login',[LoginController::class,'login']);

//Người dùng đăng nhập bằng GG
    Route::get('auth/google',[LoginController::class,'redirect'])->name('google-auth');
    Route::get('auth/google/call-back',[LoginController::class,'callbackGoogle']);

//Quên mật khẩu   
    Route::get('forgot-password',[ForgotPasswordController::class,'index'])->name('forgot-password');
    Route::post('forgot-password',[ForgotPasswordController::class,'reset']);

});
//Role ứng viên xem thông báo tuyển dụng
Route::get('job-list',[JobController::class,'index'])->name('job-list');
Route::get('job-view/{job}',[JobController::class,'show'])->name('job-view');
Route::post('apply',[JobApplicationController::class,'store'])->name('apply-job');

//Role ứng viên
Route::put('applicant/update-status', [JobApplicationController::class, 'updateStatus'])->name('applicant.update-status');
Route::delete('applicant',[JobApplicationController::class,'xoa'])->name('applicant.destroy');


Route::group(['middleware' => 'checkRole:1'], function (){
  //NHÂN VIÊN
//Đăng xuất    
    Route::post('Dangxuat',[LogoutController::class,'index'])->name('Dangxuat');

//Xem ngày lễ
    Route::get('Xemngayle',[Xemngayle::class,'index'])->name('Xemngayle');

//Xem chấm công
    Route::get('Xemchamcong',[Xemchamcong::class,'index'])->name('Xemchamcong');
    Route::post('Xemchamcong/filter', [Xemchamcong::class, 'filter'])->name('Xemchamcong.filter');

//Xem mục tiêu
    Route::get('Xemmuctieu',[Xemmuctieu::class,'index'])->name('Xemmuctieu');

//Thông tin cá nhân
    Route::get('Xemthongtincanhan',[Xemthongtincanhan::class,'index'])->name('Xemthongtincanhan');
    Route::post('Xemthongtincanhan',[Xemthongtincanhan::class,'update']);

//Xem dự án
    Route::get('Xemduan',[Xemduan::class,'index'])->name('Xemduan');
    Route::get('Xemduan/show/{id}',[Xemduan::class,'show'])->name('Xemduan.show');
    
//Xem lương
    Route::get('Xemluong',[Xemluong::class,'index'])->name('Xemluong');
    Route::post('Xemluong/filter', [Xemluong::class, 'filter'])->name('Xemluong.filter');

//Xem nhiệm vụ
    Route::get('Xemnhiemvu',[Xemnhiemvu::class,'index'])->name('Xemnhiemvu');
    Route::get('Xemnhiemvu/show/{id}',[Xemnhiemvu::class,'show'])->name('Xemnhiemvu.show');
    
//Đơn nghỉ phép   
    Route::get('Nhanviennghiphep',[Nhanviennghiphep::class,'index'])->name('Nhanviennghiphep');
    Route::post('Nhanviennghiphep',[Nhanviennghiphep::class,'store']);
    Route::put('Nhanviennghiphep',[Nhanviennghiphep::class,'update']);
    Route::delete('Nhanviennghiphep',[Nhanviennghiphep::class,'destroy'])->name('Nhanviennghiphep.destroy');

//Xem loại nghỉ phép
    Route::get('Xemloainghiphep',[Xemloainghiphep::class,'index'])->name('Xemloainghiphep');

//Gửi mail
    Route::get('guimail', [Guimail::class, 'index'])->name('guimail.index');
    Route::post('guimail', [Guimail::class, 'store'])->name('guimail.store');

//Xem chính sách
    Route::get('Xemchinhsach',[Xemchinhsach::class,'index'])->name('Xemchinhsach');
 
//Đổi mật khẩu
    Route::get('Thaydoimatkhau',[Thaydoimatkhau::class,'index'])->name('Thaydoimatkhau');
    Route::post('Thaydoimatkhau',[Thaydoimatkhau::class,'update']);
});
Route::group(['middleware' => 'checkRole:0'], function (){

    //ADMIN
//Đăng nhập tự động dô trang thống kê
    Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
    
//Đăng xuất
    Route::post('logout',[LogoutController::class,'index'])->name('logout');
    //Route::get('lienhe',[ContactController::class,'contact'])->name('lienhe');

//Gửi mail
    Route::get('sendmail', [PHPMailerController::class, 'index'])->name('sendmail.index');
    Route::post('sendmail', [PHPMailerController::class, 'store'])->name('sendmail.store');

//apps routes
    Route::delete('contacts',[ContactController::class,'destroy'])->name('contact.destroy');
    Route::get('file-manager',[FileManagerController::class,'index'])->name('filemanager');

//Ngày lễ
    Route::get('holidays',[HolidayController::class,'index'])->name('holidays');
    Route::post('holidays',[HolidayController::class,'store']);
    Route::post('holidays/{holiday}',[HolidayController::class,'completed'])->name('completed');
    Route::put('holidays',[HolidayController::class,'update']);
    Route::delete('holidays',[HolidayController::class,'destroy'])->name('holiday.destroy');

//Phòng ban
    Route::get('departments',[DepartmentController::class,'index'])->name('departments');
    Route::post('departments',[DepartmentController::class,'store']);
    Route::put('departments',[DepartmentController::class,'update']);
    Route::delete('departments',[DepartmentController::class,'destroy'])->name('department.destroy');

//Chức vụ
    Route::get('designations',[DesignationController::class,'index'])->name('designations');
    Route::put('designations',[DesignationController::class,'update']);
    Route::post('designations',[DesignationController::class,'store']);
    Route::delete('designations',[DesignationController::class,'destroy'])->name('designation.destroy');

//Lương
    Route::get('salary',[SalaryController::class,'index'])->name('salary');
    Route::delete('salary',[SalaryController::class,'destroy'])->name('salary.destroy');
    Route::post('salary', [SalaryController::class, 'store']);
    Route::put('salary',[SalaryController::class,'update']);
    Route::put('salary/update-status/{id}', [SalaryController::class, 'updateStatus'])->name('salary.update-status');


//settings của ADMIN
    Route::get('settings/theme',[SettingsController::class,'index'])->name('settings.theme');
    Route::post('settings/theme',[SettingsController::class,'updateTheme']);
    Route::get('settings/company',[SettingsController::class,'company'])->name('settings.company');
    Route::post('settings/company',[SettingsController::class,'updateCompany']);
    Route::get('settings/invoice',[SettingsController::class,'invoice'])->name('settings.invoice');
    Route::post('settings/invoice',[SettingsController::class,'updateInvoice']);
    Route::get('settings/attendance',[SettingsController::class,'attendance'])->name('settings.attendance');
    Route::post('settings/attendance',[SettingsController::class,'updateAttendance']);

//Đổi mật khẩu
    Route::get('change-password',[ChangePasswordController::class,'index'])->name('change-password');
    Route::post('change-password',[ChangePasswordController::class,'update']);

//Loại nghỉ phép
    Route::get('leave-type',[LeaveTypeController::class,'index'])->name('leave-type');
    Route::post('leave-type',[LeaveTypeController::class,'store']);
    Route::delete('leave-type',[LeaveTypeController::class,'destroy'])->name('leave-type.destroy');
    Route::put('leave-type',[LeaveTypeController::class,'update']);

//Chính sách
    Route::get('policies',[PolicyController::class,'index'])->name('policies');
    Route::post('policies',[PolicyController::class,'store']);
    Route::put('policies',[PolicyController::class,'update']);
    Route::delete('policies',[PolicyController::class,'destroy'])->name('policy.destroy');

//Khách hàng
    Route::get('clients',[ClientController::class,'index'])->name('clients');
    Route::post('clients',[ClientController::class,'store'])->name('client.add');
    Route::put('clients',[ClientController::class,'update'])->name('client.update');
    Route::delete('clients',[ClientController::class,'destroy'])->name('client.destroy');
    Route::get('clients-list',[ClientController::class,'lists'])->name('clients-list');

//Nhân viên
    Route::get('employees',[EmployeeController::class,'index'])->name('employees');
    Route::post('employees',[EmployeeController::class,'store'])->name('employee.add');
    Route::get('employees-list',[EmployeeController::class,'list'])->name('employees-list');
    Route::put('employees',[EmployeeController::class,'update'])->name('employee.update');
    Route::delete('employees',[EmployeeController::class,'destroy'])->name('employee.destroy');

//Chấm công
    Route::get('employees/attendance',[EmployeeAttendanceController::class,'index'])->name('employees.attendance');
    Route::post('employees/attendance',[EmployeeAttendanceController::class,'store']);
    Route::put('employees/attendance',[EmployeeAttendanceController::class,'update']);
    Route::delete('employees/attendance',[EmployeeAttendanceController::class,'destroy']);
    // Route::post('employees/attendance/filter', [EmployeeAttendanceController::class, 'filter'])->name('employees.attendance.filter');

//Nhiệm vụ
    Route::get('tickets',[TicketController::class,'index'])->name('tickets');
    Route::get('tickets/show/{subject}',[TicketController::class,'show'])->name('ticket-view');
    Route::post('tickets',[TicketController::class,'store']);
    Route::put('tickets',[TicketController::class,'update']);
    Route::delete('tickets',[TicketController::class,'destroy']);

//Làm thêm
    Route::get('overtime',[OvertimeController::class,'index'])->name('overtime');
    Route::post('overtime/filter', [OvertimeController::class, 'filter'])->name('overtimes.filter');
    Route::post('overtime',[OvertimeController::class,'store']);
    Route::put('overtime',[OvertimeController::class,'update']);
    Route::delete('overtime',[OvertimeController::class,'destroy']);

//Dự án 
    Route::get('projects',[ProjectController::class,'index'])->name('projects');
    Route::get('projects/show/{id}',[ProjectController::class,'show'])->name('project.show');
    Route::post('projects',[ProjectController::class,'store']);
    Route::put('projects',[ProjectController::class,'update']);
    Route::delete('projects',[ProjectController::class,'destroy']);
    Route::get('project-list',[ProjectController::class,'list'])->name('project-list');
    
//Nhân viên xin nghỉ phép
    Route::get('employee-leave',[EmployeeLeaveController::class,'index'])->name('employee-leave');
    Route::post('employee-leave',[EmployeeLeaveController::class,'store']);
    Route::put('employee-leave',[EmployeeLeaveController::class,'update']);
    Route::delete('employee-leave',[EmployeeLeaveController::class,'destroy'])->name('leave.destroy');
    Route::put('employee-leave/update-status/{id}', [EmployeeLeaveController::class, 'updateStatus'])->name('employee-leave.update-status');

//Thông báo tuyển dụng + ứng viên
    Route::get('jobs',[BackendJobController::class,'index'])->name('jobs');
    Route::post('jobs',[BackendJobController::class,'store']);
    Route::put('jobs', [BackendJobController::class, 'update']);
    Route::delete('jobs', [BackendJobController::class, 'destroy'])->name('jobs.destroy');
    Route::get('job-applicants',[BackendJobController::class,'applicants'])->name('job-applicants');
    Route::post('download-cv',[BackendJobController::class,'downloadCv'])->name('download-cv');
    Route::put('jobs/update-status/{id}', [BackendJobController::class, 'updateStatus'])->name('jobs.update-status');
    
//Loại mục tiêu
    Route::get('goal-type',[GoalTypeController::class,'index'])->name('goal-type');
    Route::post('goal-type',[GoalTypeController::class,'store']);
    Route::put('goal-type',[GoalTypeController::class,'update']);
    Route::delete('goal-type',[GoalTypeController::class,'destroy']);

//Mục tiêu 
    Route::get('goal-tracking',[GoalController::class,'index'])->name('goal-tracking');
    Route::post('goal-tracking',[GoalController::class,'store']);
    Route::put('goal-tracking',[GoalController::class,'update']);
    Route::delete('goal-tracking',[GoalController::class,'destroy']);
    Route::put('goal-tracking/update-status/{id}', [GoalController::class, 'updateStatus'])->name('goal-tracking.update-status');

//Tài sản
    Route::get('asset',[AssetController::class,'index'])->name('assets');
    Route::post('asset',[AssetController::class,'store']);
    Route::put('asset',[AssetController::class,'update']);
    Route::delete('asset',[AssetController::class,'destroy']);

//Người dùng    
    Route::get('users',[UserController::class,'index'])->name("users");
    Route::post('users',[UserController::class,'store']);
    Route::put('users',[UserController::class,'update']);
    Route::delete('users',[UserController::class,'destroy']);

//Thông tin cá nhân
    Route::get('profile',[UserProfileController::class,'index'])->name('profile');
    Route::post('profile',[UserProfileController::class,'update']);

//Danh sách các hoạt động thêm bằng tay kh đụng đc CSDL
    Route::get('activity',[ActivityController::class,'index'])->name('activity');
    Route::get('clear-activity',[ActivityController::class,'markAsRead'])->name('clear-all');

//Sao lưu
    Route::get('backups',[BackupsController::class,'index'])->name('backups');

});

Route::get('',function (){
    return redirect()->route('dashboard');
});


