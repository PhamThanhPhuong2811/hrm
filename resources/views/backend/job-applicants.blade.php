@extends('layouts.backend')

@section('styles')	
<!-- Datatable CSS -->
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap4.min.css')}}">
@endsection


@section('page-header')
<div class="page-header">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="page-title">Thực tập sinh</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Thống kê</a></li>
				<li class="breadcrumb-item active">Thực tập sinh</li>
			</ul>
		</div>
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
						<th>Họ và tên người ứng tuyển</th>
						<th>Email</th>
						<th>Ngày nộp hồ sơ ứng tuyển</th>
						<th>Tên công việc ứng tuyển</th>
						<th class="text-center">Trạng thái</th>
						<th class="text-center">Hồ sơ ứng tuyển</th>
						<th class="text-right">Hành động</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($applicants as $applicant)	
						<tr>
							
							<td>{{$applicant->name}}</td>
							<td>{{$applicant->email}}</td>

							
							<td>{{$applicant->created_at->locale('vi')->diffForHumans()}}</td>
							<td>
								@if ($applicant->job)
									{{$applicant->job->title}}
								@else
									Không có công việc
								@endif
							</td>
							
							<td class="text-center">
								<div class="dropdown action-label">
									<form action="{{ route('applicant.update-status', ['id' => $applicant->id]) }}" method="post">
										@csrf
										@method('PUT')
										<input type="hidden" name="id" value="{{ $applicant->id }}">
										<button class="btn btn-white btn-sm btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-dot-circle-o @if ($applicant->status === 'Hồ sơ mới') text-info @elseif($applicant->status === 'Đã tuyển') text-success @elseif($applicant->status === 'Từ chối') text-danger @else text-danger @endif"></i>
											{{ $applicant->status }}
										</button>
										<div class="dropdown-menu dropdown-menu-right">
											<button class="dropdown-item" style="font-size: 13.5px" type="submit" name="status" value="Hồ sơ mới">
												<i class="fa fa-dot-circle-o text-info"></i> Hồ sơ mới
											</button>
											<button class="dropdown-item" style="font-size: 13.5px" type="submit" name="status" value="Đã tuyển">
												<i class="fa fa-dot-circle-o text-success"></i> Đã tuyển
											</button>
											<button class="dropdown-item" style="font-size: 13.5px" type="submit" name="status" value="Từ chối">
												<i class="fa fa-dot-circle-o text-danger"></i> Từ chối
											</button>
											<button class="dropdown-item" style="font-size: 13.5px" type="submit" name="status" value="Đã phỏng vấn">
												<i class="fa fa-dot-circle-o text-danger"></i> Đã phỏng vấn
											</button>
										</div>
									</form>
								</div>
							</td>
							
							

							<td class="text-center">
								<form action="{{route('download-cv')}}" method="post">
									@csrf
									<input type="hidden" name="cv" value="{{$applicant->cv}}">
									<button class="btn btn-sm btn-primary" type="submit">
										<i class="fa fa-download"></i>
										 Tải về
									</button>	
									
								</form>
							</td>
							<td class="text-right">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a data-id="{{$applicant->id}}" class="dropdown-item deletebtn" href="javascript:void(0);" data-toggle="modal"><i class="fa fa-trash-o m-r-5"></i> Xóa</a>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
					<x-modals.delete :route="'applicant.destroy'" :title="'ứng viên'" />
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection


@section('scripts')
	<!-- Datatable JS -->
	<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

	<script>
		 $(document).ready(function (){
        // mark as complete 
        $('.mark_as_complete').on('click',function (){
            var id = $(this).data('id');
            console.log(id);
            $('#.complete_id').val(id);
        })
	});
	</script>
	
@endsection



