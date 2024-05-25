@extends('layouts.frontend')

@section('content')

<div class="col-md-8">
    <div class="job-info job-widget">
        <h3 class="job-title">{{ $job->title }}</h3>
        <span class="job-dept">{{ $job->department->name }}</span>
        <ul class="job-post-det">
            <li><i class="fa fa-calendar"></i> Ngày đầu thông báo: <span class="text-blue">{{ \Carbon\Carbon::parse($job->start_date)->locale('vi')->diffForHumans() }}</span></li>
            <li><i class="fa fa-calendar"></i> Ngày kết thúc thông báo: <span class="text-blue">{{ \Carbon\Carbon::parse($job->expire_date)->locale('vi')->diffForHumans() }}</span></li>
            <li><i class="fa fa-user-o"></i> Số lượng ứng tuyển: <span class="text-blue">{{ $job->JobApplicants->count() }}</span></li>
        </ul>
    </div>
    <div class="job-content job-widget">
        Mô tả công việc: 
        {!! $job->description !!}
    </div>
</div>
<div class="col-md-4">
    <div class="job-det-info job-widget">
        @if($job->status == 'Đang mở')
            <a class="btn job-btn" href="#" data-toggle="modal" data-target="#apply_job">Nộp đơn ứng tuyển</a>
        @endif
        <div class="info-list">
            <span><i class="fa fa-bar-chart"></i></span>
            <h5>Loại công việc</h5>
            <p>{{ $job->type }}</p>
        </div>
        <div class="info-list">
            <span><i class="fa fa-money"></i></span>
            <h5>Lương</h5>
            <p>{{ $job->salary_from }}.trd - {{ $job->salary_to }}.trd</p>
        </div>
        <div class="info-list">
            <span><i class="fa fa-suitcase"></i></span>
            <h5>Kinh nghiệm</h5>
            <p>{{ $job->experience }}</p>
        </div>
        <div class="info-list">
            <span><i class="fa fa-bullhorn"></i></span>
            <h5>Trạng thái thông báo</h5>
            <p>{{ $job->status }}</p>
        </div>
        <div class="info-list">
            <span><i class="fa fa-map-marker"></i></span>
            <h5>Địa điểm</h5>
            <p>{{ $job->location }}</p>
        </div>
        
        <div class="info-list text-center">
            <a class="app-ends" href="#">Ứng tuyển kết thúc sau {{ \Carbon\Carbon::parse($job->expire_date)->locale('vi')->diffForHumans() }}</a>
        </div>
    </div>
</div>

<!-- Apply Job Modal -->
<div class="modal custom-modal fade" id="apply_job" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nội dung ứng tuyển</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{ route('apply-job') }}">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">
                    <div class="form-group">
                        <label>Tên</label>
                        <input class="form-control" name="name" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ email</label>
                        <input class="form-control" name="email" type="email" required>
                    </div>
                    <div class="form-group">
                        <label>Mô tả sơ lược về bản thân</label>
                        <textarea class="form-control" name="message" placeholder="Giới thiệu bản thân ít nhất 10 kí tự" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Thêm đơn xin việc</label>
                        <div class="custom-file">
                            <input type="file" name="cv" class="custom-file-input" id="cv_upload" required>
                            <label class="custom-file-label" for="cv_upload">Vui lòng chọn file để upload</label>
                        </div>
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-primary submit-btn">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /Apply Job Modal -->
@if (session('notification'))
    <div class="alert alert-success">
        {{ session('notification') }}
    </div>
@endif
@endsection

