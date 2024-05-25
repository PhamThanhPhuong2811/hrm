@extends('layouts.backend')


@section('styles')
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/select2/select2.min.css')}}">

@endsection


@section('page-header')
<div class="row align-items-center">
	<div class="col">
		<h3 class="page-title">Danh sách mục tiêu</h3>
		<ul class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
			<li class="breadcrumb-item active">Danh sách mục tiêu</li>
		</ul>
	</div>
	<div class="col-auto float-right ml-auto">
		<a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_goal"><i class="fa fa-plus"></i> Thêm mục tiêu</a>
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
						<th>Loại mục tiêu</th>
						<th>Mục tiêu đề ra</th>
						<th>Ngày bắt đầu</th>
						<th>Ngày kết thúc</th>
						<th>Mô tả </th>
						<th>Trạng thái </th>

						<th class="text-right">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($goals as $goal)
						@if(!empty($goal->goal_type))
							<tr>
								<td>{{$goal->goal_type->type}}</td>
								
								<td>{{$goal->target}}</td>
								<td>
									{{ \Carbon\Carbon::parse($goal->start_date)->format('d/m/Y') }}
								</td>
								<td>
									{{ \Carbon\Carbon::parse($goal->end_date)->format('d/m/Y') }}
								</td>
								<td>{{$goal->description}}</td>
								{{-- <td>
									<i class="fa fa-dot-circle-o @if($goal->status == "Đang thực hiện") text-success @else text-danger @endif"></i> {{$goal->status}}
								</td> --}}

								<td>
									<div class="dropdown action-label">
										<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown"
											aria-expanded="false">
											<i class="fa fa-dot-circle-o @if ($goal->status === 'Đang thực hiện') text-success @endif"></i>
											{{ $goal->status }}
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<form action="{{ route('goal-tracking.update-status', ['id' => $goal->id]) }}" method="post">
												@csrf
												@method('PUT')
												<input type="hidden" name="id" value="{{ $goal->id }}">
												<button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đang thực hiện">
													<i class="fa fa-dot-circle-o text-success"></i> Đang thực hiện
												</button>
												<button class="dropdown-item btn btn-small" style="font-size: 13.5px" type="submit" name="status" value="Đã ngưng">
													<i class="fa fa-dot-circle-o text-danger"></i> Đã ngưng
												</button>
											</form>
										</div>
									</div>
								</td>
								<td class="text-center">
									<div class="dropdown dropdown-action">
										<a href="javascript:void(0)" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
										<div class="dropdown-menu dropdown-menu-right">
											<a data-id="{{$goal->id}}" data-subject="{{$goal->subject}}" data-type="{{$goal->goal_type->id}}"
												data-target="{{$goal->target}}" data-start="{{$goal->start_date}}"
												 data-end="{{$goal->end_date}}" data-status="{{$goal->status}}"
												 data-description="{{$goal->description}}" class="dropdown-item editbtn" href="javascript:void(0)" data-toggle="modal"><i class="fa fa-pencil m-r-5"></i> Chỉnh sửa</a>
											<a data-id="{{$goal->id}}" class="dropdown-item deletebtn" href="javascript:void(0)" data-toggle="modal" ><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
										</div>
									</div>
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Add Goal Modal -->
<div id="add_goal" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Thêm mục tiêu mới</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('goal-tracking')}}">
					@csrf
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-form-label">Loại mục tiêu <span class="text-danger">*</span></label>
								<select name="goal_type" class="select">
									<option value="null" disabled selected>Vui lòng lựa chọn mục tiêu</option>
									@foreach ($goal_types as $type)
									
										<option value="{{$type->id}}">{{$type->type}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-form-label">Mục tiêu đề ra <span class="text-danger">*</span></label>
								<input name="target" class="form-control" type="text">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Ngày bắt đầu <span class="text-danger">*</span></label>
								<div class="cal-icon"><input name="start_date" class="form-control datetimepicker" type="text"></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Ngày kết thúc <span class="text-danger">*</span></label>
								<div class="cal-icon"><input name="end_date" class="form-control datetimepicker" type="text"></div>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label>Mô tả <span class="text-danger">*</span></label>
								<textarea class="form-control" name="description" rows="4"></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-form-label">Trạng thái</label>
								<select name="status" class="select">
									<option value="null" disabled selected>Vui lòng lựa chọn trạng thái</option>
									<option>Đang thực hiện</option>
									<option>Đã ngưng</option>
								</select>
							</div>
						</div>
					</div>
					<div class="submit-section">
						<button type="submit" class="btn btn-primary submit-btn">Thêm</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Add Goal Modal -->

<!-- Edit Goal Modal -->
<div id="edit_goal" class="modal custom-modal fade" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Chỉnh sửa thông tin mục tiêu</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('goal-tracking')}}">
					@csrf
					@method("PUT")
					<div class="row">
						<input type="hidden" id="edit_id" name="id">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-form-label">Loại mục tiêu</label>
								<select name="goal_type" class="select edit_type">
									@foreach ($goal_types as $type)
										<option value="{{$type->id}}">{{$type->type}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-form-label">Mục tiêu đề ra</label>
								<input class="form-control edit_target" name="target" type="text">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Ngày bắt đầu <span class="text-danger">*</span></label>
								<div class="cal-icon"><input class="form-control datetimepicker edit_start" name="start_date" type="text"></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Ngày kết thúc <span class="text-danger">*</span></label>
								<div class="cal-icon"><input class="form-control datetimepicker edit_end" name="end_date" type="text"></div>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Mô tả <span class="text-danger">*</span></label>
								<textarea class="form-control edit_description" name="description" rows="4"></textarea>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label class="col-form-label">Trạng thái</label>
								<select id="edit_status" class="select" name="status" selected="selected">
									<option>Đang thực hiện</option>
									<option>Đã ngưng</option>
								</select>
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
<!-- /Edit Goal Modal -->

<x-modals.delete :route="'goal-tracking'" :title="'Mục tiêu'" />

@endsection

@section('scripts')
	<!-- Datatable JS -->
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/select2.min.js')}}"></script>
	<script>
		$(document).ready(function(){
			$('.table').on('click','.editbtn',function(){
				$('#edit_goal').modal('show');
				var id = $(this).data('id');
				var type = $(this).data('type');
				var subject = $(this).data('subject');
				var target = $(this).data('target');
				var start = $(this).data('start');
				var end = $(this).data('end');
				var description = $(this).data('description');
				var status = $(this).data('status');

				$('#edit_id').val(id);
				$(".edit_type option[value='"+ type +"']").attr("selected", "selected");
				$('.edit_type').val(type).change();
				$('.edit_subject').val(subject);
				$('.edit_target').val(target);
				$('.edit_start').val(start);
				$('.edit_end').val(end);
				$("#edit_status option[value='"+ status +"']").attr("selected", "selected");
				$('#edit_status').val(status).change();
				$('.edit_description').val(description);


			});

			// Read value on change
			$("#customRange").change(function(){
				$("#result b").html($(this).val());
			});
		});
	</script>
@endsection
