@extends('includes.NhanVien.backend')


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
			<li class="breadcrumb-item">Nhân viên</li>
			<li class="breadcrumb-item active">Danh sách mục tiêu</li>
		</ul>
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
						{{-- <th class="text-right">Hành động</th> --}}
					</tr>
				</thead>
				<tbody>
					@foreach ($goals as $goal)
						@if(!empty($goal->goal_type))
							<tr>
								<td>{{$goal->goal_type->type}}</td>
								{{-- <td>{{$goal->subject}}</td> --}}
								<td>{{$goal->target}}</td>
								<td>
									{{$goal->start_date}}
								</td>
								<td>{{$goal->end_date}}</td>
								<td>{{$goal->description}}</td>
								<td>
									<i class="fa fa-dot-circle-o @if($goal->status == "Đang thực hiện") text-success @else text-danger @endif"></i> {{$goal->status}}
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

<x-modals.delete :route="'goal-tracking'" :title="'Goal Track'" />

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
				var progress = $(this).data('progress');

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
				$('#customRange').val(progress);

			});

			// Read value on change
			$("#customRange").change(function(){
				$("#result b").html($(this).val());
			});
		});
	</script>
@endsection
