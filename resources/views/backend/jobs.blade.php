@extends('layouts.backend')

@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">
@endsection


@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Thông báo tuyển dụng</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Quản lý tuyển dụng</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_job"><i class="fa fa-plus"></i> Thêm tuyển dụng</a>
	</div>
</div>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-striped custom-table mb-0 datatable">
				<thead>
					<tr>
						<th>Tên công việc</th>
						<th>Phòng ban</th>
						<th>Ngày bắt đầu</th>
						<th>Ngày kết thúc</th>
						<th class="text-center">Loại công việc</th>
						<th class="text-center">Trạng thái</th>
						<th class="text-center">Số lượng ứng viên</th>
						<th class="text-right">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($jobs as $job)
					<tr>
						<td><a target="_blank" href="{{route('job-view',$job)}}">{{$job->title}}</a></td>
						<td>{{$job->department->name ?? ''}}</td>
						<td>{{date_format(date_create($job->start_date),"d/m/Y")}}</td>
						<td>{{date_format(date_create($job->expire_date),"d/m/Y")}}</td>
						<td class="text-center">
							{{$job->type}}
						</td>
						<td class="text-center">
							<div class="dropdown action-label">
								<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown"
									aria-expanded="false">
									<i class="fa fa-dot-circle-o @if ($job->status === 'Đang mở') text-success @elseif($job->status === 'Đã kết thúc') text-info @else text-danger @endif"></i>
									{{ $job->status }}
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<form action="{{ route('jobs.update-status', ['id' => $job->id]) }}" method="post">
										@csrf
										@method('PUT')
										<input type="hidden" name="id" value="{{ $job->id }}">
										<button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đang mở">
											<i class="fa fa-dot-circle-o text-success"></i> Đang mở
										</button>
										<button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đã hủy">
											<i class="fa fa-dot-circle-o text-danger"></i> Đã hủy
										</button>
										<button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đã kết thúc">
											<i class="fa fa-dot-circle-o text-info"></i> Đã kết thúc
										</button>
									</form>
									
								</div>
							</div>
						</td>
						<td class="text-center">
							{{$job->JobApplicants->count()}}
						</td>
						<td class="text-right">
							<div class="dropdown dropdown-action">
								<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a  data-id="{{$job->id}}"
                                        data-title="{{$job->title}}"
                                        data-department="{{$job->department->id}}"
                                        data-startdate="{{$job->start_date}}"
                                        data-expirydate="{{$job->expire_date}}"
                                        data-experience="{{$job->experience}}"
                                        data-type="{{$job->type}}"
                                        data-description="{{$job->description}}"
                                        data-age="{{$job->age}}"
                                        data-salaryfrom="{{$job->salary_from}}"
                                        data-salaryto="{{$job->salary_to}}"
                                        data-location="{{$job->location}}"
                                        data-status="{{$job->status}}" href="javscript:void(0)" class="dropdown-item editbtn" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
									<a data-id="{{$job->id}}" href="javascript:void(0)" class="dropdown-item deletebtn" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Add Job Modal -->
<div id="add_job" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm tuyển dụng</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('jobs')}}">
					@csrf
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Tên công việc</label>
								<input class="form-control" name="title" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Phòng ban</label>
								<select class="select" name="department_id">
									<option value="null" disabled selected>Vui lòng lựa chọn phòng ban</option>
									@if(!empty($departments))
										@foreach ($departments as $department)
											<option value="{{$department->id}}">{{$department->name}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Địa điểm</label>
								<input class="form-control" name="location" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Yêu cầu kinh nghiệm</label>
								<input class="form-control" name="experience" type="text" placeholder="Ví dụ: từ 2 đến 3 năm kinh nghiệm">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Mức lương từ</label>
								<input type="text" name="salary_from" class="form-control" placeholder="Ví dụ: 3tr đồng">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Đến mức lương</label>
								<input type="text" name="salary_to" class="form-control" placeholder="Ví dụ: 4tr đồng">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Loại công việc</label>
								<select name="type" class="select">
									<option value="null" disabled selected>Vui lòng lựa chọn loại công việc</option>
									<option>Toàn thời gian</option>
									<option>Bán thời gian</option>
									<option>Thực tập sinh</option>
									<option>Từ xa</option>
									<option>Khác</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Trạng thái</label>
								<select name="status" class="select">
									<option value="null" disabled selected>Vui lòng lựa chọn trạng thái</option>
									<option>Đang mở</option>
									<option>Đã kết thúc</option>
									<option>Đã hủy</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày bắt đầu thông báo tuyển dụng</label>
								<input type="text" name="start_date" class="form-control datetimepicker">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày kết thúc thông báo tuyển dụng</label>
								<input type="text" name="expire_date" class="form-control datetimepicker">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Mô tả</label>
								<textarea id="description" name="description" class="form-control">{!! old('description', '') !!}</textarea>
							</div>
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
<!-- /Add Job Modal -->

<!-- Edit Job Modal -->
<div id="edit_job" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Chỉnh sửa thông báo tuyển dụng</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="{{route('jobs')}}" enctype="multipart/form-data">
					@csrf
					@method("PUT")
					<div class="row">
						<input type="hidden" name="id" id="edit_id">
						<div class="col-md-6">
							<div class="form-group">
								<label>Tên công việc</label>
								<input class="form-control edit_title" name="title" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Phòng ban</label>
								<select class="select edit_department" name="department">
									<option>-</option>
									@foreach ($departments as $department)
										<option value="{{$department->id}}">{{$department->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Địa điểm</label>
								<input class="form-control edit_location" name="location" type="text">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Kinh nghiệm</label>
								<input class="form-control edit_experience" name="experience" type="text">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Mức lương từ</label>
								<input type="text" name="salary_from" class="form-control edit_salary_from">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Đến mức lương</label>
								<input type="text" name="salary_to" class="form-control edit_salary_to">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Loại công việc</label>
								<select name="type" class="select2 form-control" id="edit_type">
									<option>Toàn thời gian</option>
									<option>Bán thời gian</option>
									<option>Thực tập sinh</option>
									<option>Từ xa</option>
									<option>Khác</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Trạng thái</label>
								<select name="status" class="select2 form-control" id="edit_status">
									<option value="null">Vui lòng lựa chọn</option>
									<option>Đang mở</option>
									<option>Đã kết thúc</option>
									<option>Đã hủy</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày bắt đầu thông báo tuyển dụng</label>
								<input type="text" name="start_date" class="form-control datetimepicker edit_start_date">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Ngày kết thúc thông báo tuyển dụng</label>
								<input type="text" name="expire_date" class="form-control datetimepicker edit_expire_date">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Mô tả</label>
								<textarea id="e_description" class="form-control edit_description" name="description"></textarea>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button class="btn btn-primary submit-btn">Lưu</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Edit Job Modal -->

<x-modals.delete :route="'jobs'" :title="'Thông báo tuyển dụng'" />
@endsection

@section('scripts')
	<!-- Datatable JS -->
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
	<script>
		$(document).ready(function (){
            var options = {
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };
            CKEDITOR.replace('description', options);
            var editDesc = CKEDITOR.replace('e_description', options);
			$('.datatable').on('click','.editbtn',function (){
				$('#edit_job').modal('show');
				var id = $(this).data('id');
				var title = $(this).data('title');
				var department = $(this).data('department');
				var startDate = $(this).data('startdate');
				var expiryDate = $(this).data('expirydate');
				var experience = $(this).data('experience');
				var status = $(this).data('status');
				var type = $(this).data('type');
                var age = $(this).data('age');
                var salary_from = $(this).data('salaryfrom');
                var salary_to = $(this).data('salaryto');
                var vacancies = $(this).data('vacancies');
                var location = $(this).data('location');
				var description = $(this).data('description');
				$('#edit_id').val(id);
				$('#edit_job .edit_title').val(title);
				$('#edit_job .edit_department').val(department).trigger('change');
                $('#edit_job .edit_start_date').data("DateTimePicker").date(startDate);
				$('#edit_job .edit_expire_date').data("DateTimePicker").date(expiryDate);
                $('#edit_job .edit_experience').val(experience);
                $('#edit_job .edit_age').val(age);
                $('#edit_job .edit_salary_from').val(salary_from);
                $('#edit_job .edit_salary_to').val(salary_to);
                $('#edit_job .edit_vacancies').val(vacancies);
                $('#edit_job .edit_location').val(location);
				$('#edit_status').val(status).trigger('change');
				$('#edit_type').val(type).trigger('change');
                editDesc.setData(description)
			});
		})
	</script>
@endsection
