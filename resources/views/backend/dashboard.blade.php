@extends('layouts.backend')

@section('styles')
    <!-- Chart CSS -->
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
@endsection

@section('page-header')
<div class="row">
    <div class="col-sm-12">
        <h3 class="page-title">Xin chào {{auth()->user()->username}}!</h3>
        <ul class="breadcrumb">
            <li class="breadcrumb-item active">Thống kê</li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-gitlab"></i></span>
                <div class="dash-widget-info">
                    <h3>{{$projects_count}}</h3>
                    <span><a href="{{ url('/projects') }}" style="color: black">Dự án</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-user-o"></i></span>
                <div class="dash-widget-info">
                    <h3>{{$clients_count}}</h3>
                    <span><a href="{{ url('/clients') }}" style="color: black">Khách hàng</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-user-times"></i></span>
                <div class="dash-widget-info">
                    <h3>{{$leaves_count}}</h3>
                    <span><a href="{{ url('/employee-leave') }}" style="color: black">Nghỉ phép</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
        <div class="card dash-widget">
            <div class="card-body">
                <span class="dash-widget-icon"><i class="fa fa-users"></i></span>
                <div class="dash-widget-info">
                    <h3>{{$employee_count}}</h3>
                    <span><a href="{{ url('/employees') }}" style="color: black">Nhân viên</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 
Thêm ngày 22/4/2024 --}}
<!-- Thêm một thẻ div để chứa biểu đồ -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Số lượng Nhân viên nam/nữ theo Phòng ban</h3>
                        <div id="bar-charts"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Số lượng tuyển dụng nhân viên theo từng năm</h3>
                        <div id="line-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-lg-12 col-xl-4 d-flex">
        <div class="card flex-fill dash-statistics">
            <div class="card-body">
                <h5 class="card-title">Số liệu thống kê</h5>
                <div class="stats-list">
                    <div class="stats-info">
                        <p>Nghỉ phép <strong>{{$leaves_count}} <small>/ {{$employee_count}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{$percentage_leave_count}}%" aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Nhiệm vụ mới <strong>{{$count_new}} <small>/ {{$tickets_count}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-warning" role="progressbar" style="width:{{$percentage_task_new}}% " aria-valuenow="31" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Nhiệm vụ hoàn thành <strong>{{$count_closed}} <small>/ {{$tickets_count}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{$percentage_closed_count}}%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Hồ sơ ứng viên mới <strong>{{$count_job_new}} <small>/ {{$jobapplicant}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{$percentage_job_new_count}}%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="stats-info">
                        <p>Lương chưa thanh toán cho nhân viên <strong>{{$count_salary_pending}} <small>/ {{$salary}}</small></strong></p>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 
                            {{$percentage_salary_pending_count}}%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Thống kê dự án</h4>
                <div class="statistics">
                    <div class="row">
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Tổng cộng:</p>
                                <h3>{{$projects_count}}</h3>
                            
                            </div>
                        </div>
                        <div class="col-md-6 col-6 text-center">
                            <div class="stats-box mb-4">
                                <p>Dự án quá hạn:</p>
                                <h3>{{$count_end}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mb-4">
                    <div class="progress-bar bg-purple" role="progressbar" style="width: {{$percentage_high_count}}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">{{$percentage_high_count}}%</div>
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{$percentage_medium_count}}%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">{{$percentage_medium_count}}%</div>
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{$percentage_low_count}}%" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100">{{$percentage_low_count}}%</div>
                </div>
                <div>
                    <p><i class="fa fa-dot-circle-o text-purple mr-2"></i>Ưu tiên: Cao <span class="float-right">{{$count_high}}</span></p>
                
                    <p><i class="fa fa-dot-circle-o text-danger mr-2"></i>Ưu tiên: Trung bình <span class="float-right">{{$count_medium}}</span></p>
                    <p class="mb-0"><i class="fa fa-dot-circle-o text-info mr-2"></i>Ưu tiên: Thấp <span class="float-right">{{$count_low}}</span></p>
                </div>
            </div>
        </div>
    </div>
    {{-- sửa đoạn này --}}
    <div class="col-md-12 col-lg-6 col-xl-4 d-flex">
        <div class="card flex-fill">
            <div class="card-body">
                <h4 class="card-title">Nhân viên xin nghỉ phép <span class="badge bg-inverse-danger ml-2">{{$leaves_count}}</span></h4>
                <div class="leave-info-box">  
                      
                    @if($leaves->isEmpty())
                    <div class="leave-info-box">
                        <p class="text-muted">Không có nhân viên nào nghỉ phép</p>
                    </div>
                @else
                    @foreach($leaves as $leave)
                    <div class="leave-info-box">
                        <div class="media align-items-center">
                            <a href="{{ route('employees', $leave->employee->id) }}" class="avatar">
                                <img alt="" src="{{ $leave->employee->avatar }}">
                            </a>
                            <div class="media-body">
                                <div class="text-sm my-0">{{ $leave->employee->firstname }} {{ $leave->employee->lastname }}</div>
                            </div>
                        </div>
                        <div class="row align-items-center mt-3">
                            <div class="col-6">
                                <span class="text-sm text-muted">Ngày nghỉ phép</span>
                                <h6 class="mb-0">{{ \Carbon\Carbon::parse($leave->from)->format('d m Y') }}</h6>
                            </div>
                            <div class="col-6 text-right">
                                <span class="text-sm text-muted">Trạng thái </span><br>
                                <span class="badge bg-inverse-{{ $leave->status == 'Chấp nhận' ? 'success' : 'danger' }}">{{ $leave->status }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                    
<span class="text-sm text-muted" style="margin-left: 350px">... </span>
                </div>
                
                <div class="load-more text-center">
                    <a class="text-dark" href="{{route('employee-leave')}}">Xem thêm</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Statistics Widget -->


@endsection
@section('scripts')
<!-- Chart JS -->
<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael.min.js"></script>
<script src="assets/js/chart.js"></script>
@endsection