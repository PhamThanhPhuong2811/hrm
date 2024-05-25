@extends('includes.NhanVien.backend')

@section('styles')
<!-- Select2 CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">

<!-- Summernote CSS -->
<link rel="stylesheet" href="{{asset('assets/plugins/summernote/dist/summernote-bs4.css')}}">
@endsection

@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Danh sách dự án</h3>
	</div>
    <div class="col-auto float-right ml-auto">
		
		
	</div>
</div>
@endsection


@section('content')
<div class="row">
    @foreach ($projects as $project)
    <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h4 class="project-title">Tên dự án: <a href="{{route('Xemduan.show',$project->id)}}">{{$project->name}}</a></h4>
                <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                       Chi phí:
                    </div>
                    <span class="text-muted">
                         {{$project->rate}} triệu đồng
                         
                    </span>
                </div>
                {{-- <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                       Mô tả:
                    </div>
                    <span class="text-muted">
                         {!! substr($project->description,0,120)!!}
                    </span>
                </div> --}}
                <div class="pro-deadline m-b-15">
                    <div class="sub-title">
                        Thời hạn:
                    </div>
                    <div class="text-muted">
                        {{date_format(date_create($project->end_date),"d/m/Y")}}
                    </div>
                </div>
                <div class="project-members m-b-15">
                    <div>Lãnh đạo dư án :</div>
                    @php
                        $leader = $project->employee($project->leader);
                    @endphp
                    <ul class="team-members">
                        <li>
                            <a href="#" data-bs-toggle="tooltip" title="{{$leader->firstname.' '.$leader->lastname}}">
                                <img alt="avatar"  src="{{ !empty($leader->avatar) ? asset('storage/employees/'.$leader->avatar): asset('assets/img/user.jpg')}}">
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="project-members m-b-15">
                    <div>Nhóm :</div>
                   
                    <ul class="team-members">
                        @foreach ($project->team as $team_member)
                        @php
                            $member = $project->employee($team_member);
                        @endphp
                        <li>
                            <a href="#" data-bs-toggle="tooltip" title="{{$member->firstname.' '.$member->lastname}}"><img  src="{{ !empty($member->avatar) ? asset('storage/employees/'.$member->avatar): asset('assets/img/user.jpg')}}"></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <p class="m-b-5">Tiến triển <span class="text-success float-end">{{$project->progress}}%</span></p>
                <div class="progress progress-xs mb-0">
                    <div class="progress-bar bg-success" role="progressbar" data-bs-toggle="tooltip" title="{{$project->progress}}%" style="width: {{$project->progress}}%"></div>
                </div><br>
                @php
                $qrcode_url = url('Xemduan/show/'.$project->id);
                @endphp
                <p class="qrcode_style">{{QrCode::size(50)->generate($qrcode_url)}}</p>
            </div>
        </div>
    </div>
    @endforeach            
</div>
</div>
<!-- /Page Content -->  

<x-modals.popup />
<x-modals.delete route="projects" title="Project" />
@endsection


@section('scripts')
<!-- summernote JS -->
<script src="{{asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
<!-- Select2 JS -->
<script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
<!-- Datatable JS -->
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.card').on('click','.editbtn',(function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var client = $(this).data('client');
            var startdate = $(this).data('start');
            var enddate = $(this).data('end');
            var rate = $(this).data('rate');
            var rate_type = $(this).data('rtype');
            var priority = $(this).data('priority');
            var leader = $(this).data('leader');
            var team  = $(this).data('team');
            var description = $(this).data('description');
            var progress = $(this).data('progress');
            $('#edit_project').modal('show');
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_client').val(client).trigger('change');
            $('#edit_startdate').val(startdate);
            $('#edit_enddate').val(enddate);
            $('#edit_rate').val(rate);
            $('#edit_priority').val(priority);
            $('#edit_leader').val(leader).trigger('change');
            $('#edit_team').val(team).trigger('change');
            $('#edit_description').summernote('code', description);
            $('#edit_progress').val(progress);
            $('#progress_result').html("Progress Value: " + progress);
            $('#edit_progress').change(function(){
                $('#progress_result').html("Progress Value: " + $(this).val());
            });
        }));
    });
</script>
@endsection